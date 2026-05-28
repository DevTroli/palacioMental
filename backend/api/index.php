<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$isServerless = getenv('VERCEL') || getenv('APP_ENV') === 'production';

// On Vercel (serverless), only /tmp is writable.
// Set up writable directories and redirect all cache paths BEFORE Laravel boots.
if ($isServerless) {
    $tmp = '/tmp/storage_palaciomental';
    $tmpBootstrap = $tmp . '/bootstrap/cache';

    // Create all required directories
    $dirs = [
        $tmp,
        $tmp . '/framework/cache/data',
        $tmp . '/framework/sessions',
        $tmp . '/framework/views',
        $tmp . '/logs',
        $tmpBootstrap,
    ];

    foreach ($dirs as $dir) {
        if (! is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    // DO NOT copy pre-compiled bootstrap cache from local — they may contain
    // dev-only providers (like Pail) that don't exist in production.
    // Laravel will regenerate them fresh in /tmp on first request.

    // Set all Laravel cache paths to /tmp
    // These are read by Application::normalizeCachePath()
    putenv("APP_SERVICES_CACHE=$tmpBootstrap/services.php");
    putenv("APP_PACKAGES_CACHE=$tmpBootstrap/packages.php");
    putenv("APP_CONFIG_CACHE=$tmpBootstrap/config.php");
    putenv("APP_EVENTS_CACHE=$tmpBootstrap/events.php");
    putenv("APP_STORAGE_PATH=$tmp");

    $_ENV['APP_SERVICES_CACHE'] = "$tmpBootstrap/services.php";
    $_ENV['APP_PACKAGES_CACHE'] = "$tmpBootstrap/packages.php";
    $_ENV['APP_CONFIG_CACHE'] = "$tmpBootstrap/config.php";
    $_ENV['APP_EVENTS_CACHE'] = "$tmpBootstrap/events.php";
    $_ENV['APP_STORAGE_PATH'] = $tmp;

    $_SERVER['APP_SERVICES_CACHE'] = "$tmpBootstrap/services.php";
    $_SERVER['APP_PACKAGES_CACHE'] = "$tmpBootstrap/packages.php";
    $_SERVER['APP_CONFIG_CACHE'] = "$tmpBootstrap/config.php";
    $_SERVER['APP_EVENTS_CACHE'] = "$tmpBootstrap/events.php";
    $_SERVER['APP_STORAGE_PATH'] = $tmp;
}

// Determine if the application is in maintenance mode...
if (!$isServerless && file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// On Vercel serverless, suppress tempnam() warnings
if ($isServerless) {
    set_error_handler(function ($severity, $message) {
        if (str_contains($message, 'tempnam') || str_contains($message, 'sys_get_temp_dir')) {
            return true;
        }
        return false;
    }, E_WARNING);
}

// Bootstrap Laravel and handle the request...
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Override storage path for Vercel serverless
if (getenv('APP_STORAGE_PATH')) {
    $app->useStoragePath(getenv('APP_STORAGE_PATH'));
}

$app->handleRequest(Request::capture());
