<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Konfigurasi otomatis untuk Vercel Read-Only Filesystem
if (isset($_ENV['VERCEL_REGION']) || isset($_SERVER['VERCEL_REGION'])) {
    $storagePath = '/tmp/storage';
    if (!is_dir($storagePath . '/framework/views')) {
        mkdir($storagePath . '/framework/sessions', 0755, true);
        mkdir($storagePath . '/framework/views', 0755, true);
        mkdir($storagePath . '/framework/cache', 0755, true);
        mkdir($storagePath . '/logs', 0755, true);
    }
    putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");
}

// Check If The Application Is Under Maintenance...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register The Auto Loader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());