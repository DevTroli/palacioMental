<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // On Vercel (serverless), only /tmp is writable.
        // Set config overrides early in the register phase.
        if (env('VERCEL') || env('APP_ENV') === 'production') {
            $tmp = env('APP_STORAGE_PATH', '/tmp/storage_palaciomental');

            // Ensure directories exist
            $dirs = [
                $tmp,
                $tmp . '/framework/cache/data',
                $tmp . '/framework/sessions',
                $tmp . '/framework/views',
                $tmp . '/logs',
                $tmp . '/bootstrap/cache',
            ];

            foreach ($dirs as $dir) {
                if (! is_dir($dir)) {
                    @mkdir($dir, 0755, true);
                }
            }

            // Update config paths before they are used
            config([
                'view.compiled' => $tmp . '/framework/views',
                'cache.stores.file.path' => $tmp . '/framework/cache/data',
                'session.files' => $tmp . '/framework/sessions',
                'logging.channels.single.path' => $tmp . '/logs/laravel.log',
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // On Vercel serverless, ensure Vite uses build assets (not dev server).
        // The vercel-php runtime may not find public/build/manifest.json
        // at the default public_path(), so we explicitly set the hotFile
        // to a non-existent path and configure the Vite build directory.
        if (env('VERCEL')) {
            Vite::hotFile('/non-existent-hot-file');
            Vite::useBuildDirectory('build');
        }
    }
}
