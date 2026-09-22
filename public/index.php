<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Konfigurasi otomatis direktori temporary di Vercel (Read-Only Fix)
if (isset($_ENV['VERCEL_REGION']) || isset($_SERVER['VERCEL_REGION'])) {
    $storagePath = '/tmp/storage';
    if (!is_dir($storagePath . '/framework/views')) {
        mkdir($storagePath . '/framework/sessions', 0755, true);
        mkdir($storagePath . '/framework/views', 0755, true);
        mkdir($storagePath . '/framework/cache', 0755, true);
        mkdir($storagePath . '/logs', 0755, true);
    }
    putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");
    $_ENV['VIEW_COMPILED_PATH'] = "{$storagePath}/framework/views";
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());