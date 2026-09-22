<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Siapkan folder temporary /tmp untuk storage & views cache di Vercel
$storagePath = '/tmp/storage';
$viewsPath = '/tmp/storage/framework/views';

if (!is_dir($viewsPath)) {
    mkdir($storagePath . '/framework/sessions', 0755, true);
    mkdir($storagePath . '/framework/views', 0755, true);
    mkdir($storagePath . '/framework/cache', 0755, true);
    mkdir($storagePath . '/logs', 0755, true);
}

// 2. Set environment variable compiled view path ke /tmp
putenv("VIEW_COMPILED_PATH={$viewsPath}");
$_ENV['VIEW_COMPILED_PATH'] = $viewsPath;

// 3. Load Autoload Composer
require __DIR__ . '/../vendor/autoload.php';

// 4. Inisialisasi Aplikasi Laravel 11
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 5. Override Storage Path
$app->useStoragePath($storagePath);

// 6. PAKSA Registrasi Service Provider Penting (Khusus Laravel 11 Serverless)
$app->register(\Illuminate\View\ViewServiceProvider::class);
$app->register(\Illuminate\Filesystem\FilesystemServiceProvider::class);

// Set ulang path compiled views ke Service Container View
$app['config']->set('view.compiled', $viewsPath);

// 7. Jalankan HTTP Request
$request = Request::capture();
$response = $app->handle($request);

$response->send();

$app->terminate();