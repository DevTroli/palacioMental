<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HealthCheckController extends Controller
{
    /**
     * Comprehensive health check endpoint.
     * Returns the status of all critical system components.
     *
     * GET /api/health
     */
    public function __invoke(): JsonResponse
    {
        $checks = [];
        $overallStatus = 'healthy';
        $startTime = microtime(true);
        $isServerless = getenv('VERCEL') || getenv('APP_ENV') === 'production';

        // ── Application ──────────────────────────────────────────
        $checks['app'] = [
            'name'      => config('app.name'),
            'env'       => config('app.env'),
            'debug'     => config('app.debug'),
            'timezone'  => config('app.timezone'),
            'locale'    => config('app.locale'),
            'php'       => PHP_VERSION,
            'laravel'   => app()->version(),
        ];

        // ── Database ─────────────────────────────────────────────
        try {
            $dbStart = microtime(true);
            DB::connection()->getPdo();
            $dbLatency = round((microtime(true) - $dbStart) * 1000, 2);

            $dbDriver = DB::connection()->getDriverName();
            $dbName   = DB::connection()->getDatabaseName();

            // Run a lightweight query to confirm read capability
            $result = DB::select('SELECT 1 AS alive');
            $canRead = ($result[0]->alive ?? 0) === 1;

            $checks['database'] = [
                'status'   => 'ok',
                'driver'   => $dbDriver,
                'database' => $dbName,
                'latency'  => $dbLatency . 'ms',
                'can_read' => $canRead,
            ];
        } catch (\Throwable $e) {
            $overallStatus = 'unhealthy';
            $checks['database'] = [
                'status' => 'error',
                'error'  => $e->getMessage(),
            ];
        }

        // ── Cache ────────────────────────────────────────────────
        try {
            $cacheStart = microtime(true);
            $cacheKey   = 'health_check_' . uniqid();
            Cache::put($cacheKey, 'ok', 10);
            $cacheRead  = Cache::get($cacheKey);
            Cache::forget($cacheKey);
            $cacheLatency = round((microtime(true) - $cacheStart) * 1000, 2);

            $checks['cache'] = [
                'status'            => 'ok',
                'driver'            => config('cache.default'),
                'latency'           => $cacheLatency . 'ms',
                'can_write_and_read' => $cacheRead === 'ok',
            ];
        } catch (\Throwable $e) {
            $overallStatus = 'unhealthy';
            $checks['cache'] = [
                'status' => 'error',
                'driver' => config('cache.default'),
                'error'  => $e->getMessage(),
            ];
        }

        // ── Storage ──────────────────────────────────────────────
        try {
            $storagePath  = storage_path();
            $writableDirs = [];

            if ($isServerless) {
                $tmp = getenv('APP_STORAGE_PATH') ?: '/tmp/storage_palaciomental';
                $dirs = [
                    'root'             => $tmp,
                    'cache'            => $tmp . '/framework/cache/data',
                    'sessions'         => $tmp . '/framework/sessions',
                    'views'            => $tmp . '/framework/views',
                    'logs'             => $tmp . '/logs',
                    'bootstrap_cache'  => $tmp . '/bootstrap/cache',
                ];
                foreach ($dirs as $label => $dir) {
                    $writableDirs[$label] = [
                        'path'     => $dir,
                        'exists'   => is_dir($dir),
                        'writable' => is_dir($dir) && is_writable($dir),
                    ];
                }
                // Try writing a test file
                $testFile = $tmp . '/health_check_test';
                @file_put_contents($testFile, 'ok');
                $canWrite = @file_get_contents($testFile) === 'ok';
                @unlink($testFile);
            } else {
                $dirs = [
                    'cache'    => storage_path('framework/cache'),
                    'sessions' => storage_path('framework/sessions'),
                    'views'    => storage_path('framework/views'),
                    'logs'     => storage_path('logs'),
                ];
                foreach ($dirs as $label => $dir) {
                    $writableDirs[$label] = [
                        'path'     => $dir,
                        'exists'   => is_dir($dir),
                        'writable' => is_dir($dir) && is_writable($dir),
                    ];
                }
                $canWrite = is_writable(storage_path());
            }

            $checks['storage'] = [
                'status'        => 'ok',
                'path'          => $storagePath,
                'is_serverless' => $isServerless,
                'can_write'     => $canWrite,
                'writable_dirs' => $writableDirs,
            ];
        } catch (\Throwable $e) {
            $overallStatus = 'degraded';
            $checks['storage'] = [
                'status' => 'error',
                'error'  => $e->getMessage(),
            ];
        }

        // ── Session ──────────────────────────────────────────────
        $checks['session'] = [
            'driver'  => config('session.driver'),
            'table'   => config('session.table'),
            'encrypt' => config('session.encrypt'),
        ];

        // ── Queue ────────────────────────────────────────────────
        $checks['queue'] = [
            'default_connection' => config('queue.default'),
        ];

        // ── Frontend Assets ──────────────────────────────────────
        $manifestPath = public_path('build/.vite/manifest.json');
        $hotFilePath  = public_path('hot');

        $checks['assets'] = [
            'manifest_exists' => file_exists($manifestPath),
            'hot_file_exists' => file_exists($hotFilePath),
            'build_dir'       => is_dir(public_path('build')),
        ];

        // ── Serverless Environment ───────────────────────────────
        $isVercel = (bool) getenv('VERCEL');
        $checks['serverless'] = [
            'is_vercel'         => $isVercel,
            'vercel_region'     => getenv('VERCEL_REGION') ?: 'N/A',
            'vercel_url'        => getenv('VERCEL_URL') ?: 'N/A',
            'runtime'           => $isVercel ? 'vercel-php' : 'traditional',
            'temp_dir_writable' => is_writable(sys_get_temp_dir()),
        ];

        // ── Bootstrap Cache ─────────────────────────────────────
        $bootstrapCache = $isServerless
            ? (getenv('APP_STORAGE_PATH') ?: '/tmp/storage_palaciomental') . '/bootstrap/cache'
            : base_path('bootstrap/cache');

        $servicesCachePath = getenv('APP_SERVICES_CACHE') ?: $bootstrapCache . '/services.php';
        $configCachePath   = getenv('APP_CONFIG_CACHE')   ?: $bootstrapCache . '/config.php';

        $checks['bootstrap_cache'] = [
            'services_cache' => [
                'path'   => $servicesCachePath,
                'exists' => file_exists($servicesCachePath),
            ],
            'config_cache' => [
                'path'   => $configCachePath,
                'exists' => file_exists($configCachePath),
            ],
        ];

        // ── Response ─────────────────────────────────────────────
        $totalLatency = round((microtime(true) - $startTime) * 1000, 2);

        $checks['meta'] = [
            'total_latency' => $totalLatency . 'ms',
            'timestamp'     => now()->toIso8601String(),
        ];

        return response()->json([
            'status'  => $overallStatus,
            'checks'  => $checks,
        ], $overallStatus === 'healthy' ? 200 : 503);
    }
}
