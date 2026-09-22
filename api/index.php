<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Buat direktori sementara /tmp untuk storage & views cache Vercel
$storagePath = '/tmp/storage';
if (!is_dir($storagePath . '/framework/views')) {
    mkdir($storagePath . '/framework/sessions', 0755, true);
    mkdir($storagePath . '/framework/views', 0755, true);
    mkdir($storagePath . '/framework/cache', 0755, true);
    mkdir($storagePath . '/logs', 0755, true);
}

// 2. Set environment variable compiled view path ke /tmp
putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");
$_ENV['VIEW_COMPILED_PATH'] = "{$storagePath}/framework/views";

// 3. Autoload & Inisialisasi Aplikasi Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Override path storage ke /tmp
$app->useStoragePath($storagePath);

// 5. Inisialisasi Kernel dan PAKSA Bootstrapping
$kernel = $app->make(Kernel::class);

// Panggilan bootstrap() ini kunci agar tidak muncul 'Target class view does not exist'
$kernel->bootstrap();

// 6. Tangani Request
$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);