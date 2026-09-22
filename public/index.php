<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Override path storage dan view agar menggunakan /tmp yang bisa ditulisi di Vercel
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';

// Pastikan folder temp untuk view framework tersedia
if (!is_dir('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0777, true);
    mkdir('/tmp/storage/framework/cache', 0777, true);
    mkdir('/tmp/storage/framework/sessions', 0777, true);
}

// Bind path view laravel agar membaca dari /tmp
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
$app = require_once __DIR__.'/../bootstrap/app.php';

// Paksa instance app menggunakan path view ke /tmp
$appuseViewPath = $app->useViewPath('/tmp/storage/framework/views'); 
// Atau atur path storage framework
$app->useStoragePath('/tmp/storage');

$kernel = $app->make(Kernel::class);