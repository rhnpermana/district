<?php

$storagePath = '/tmp/storage';
$viewsPath = '/tmp/storage/framework/views';

if (!is_dir($viewsPath)) {
    mkdir($storagePath . '/framework/sessions', 0755, true);
    mkdir($storagePath . '/framework/views', 0755, true);
    mkdir($storagePath . '/framework/cache', 0755, true);
    mkdir($storagePath . '/logs', 0755, true);
}

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Set path storage & view compiled ke /tmp
$app->useStoragePath($storagePath);
$app['config']->set('view.compiled', $viewsPath);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);