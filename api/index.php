<?php

// 1. Buat folder temporary di /tmp untuk Vercel
$storagePath = '/tmp/storage';
$viewsPath = '/tmp/storage/framework/views';

if (!is_dir($viewsPath)) {
    mkdir($storagePath . '/framework/sessions', 0755, true);
    mkdir($storagePath . '/framework/views', 0755, true);
    mkdir($storagePath . '/framework/cache', 0755, true);
    mkdir($storagePath . '/logs', 0755, true);
}

// 2. Set environment variable compiled view path secara langsung
putenv("VIEW_COMPILED_PATH={$viewsPath}");
$_ENV['VIEW_COMPILED_PATH'] = $viewsPath;
$_SERVER['VIEW_COMPILED_PATH'] = $viewsPath;

// 3. Load Autoload Composer & Inisialisasi App
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Override path storage
$app->useStoragePath($storagePath);

// 5. Eksekusi Request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);    