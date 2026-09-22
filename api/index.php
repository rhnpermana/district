<?php

// 1. Buat direktori temporary di /tmp milik Vercel
$storagePath = '/tmp/storage';
$viewsPath = '/tmp/storage/framework/views';

if (!is_dir($viewsPath)) {
    mkdir($storagePath . '/framework/sessions', 0755, true);
    mkdir($storagePath . '/framework/views', 0755, true);
    mkdir($storagePath . '/framework/cache', 0755, true);
    mkdir($storagePath . '/logs', 0755, true);
}

// 2. Load Autoload Composer
require __DIR__ . '/../vendor/autoload.php';

// 3. Inisialisasi Aplikasi Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Override path storage ke /tmp
$app->useStoragePath($storagePath);

// 5. Jalankan Kernel & Tangani HTTP Request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Atur compiled view path melalui helper config setelah Kernel dibuat
config(['view.compiled' => $viewsPath]);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);