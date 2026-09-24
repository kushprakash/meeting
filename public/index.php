<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Auto-run deployment if token is provided, /deploy is hit, or vendor/autoload.php is not yet installed
if (isset($_GET['token']) || strpos($_SERVER['REQUEST_URI'] ?? '', '/deploy') !== false || !file_exists(__DIR__.'/../vendor/autoload.php')) {
    if (file_exists(__DIR__.'/deploy.php')) {
        require __DIR__.'/deploy.php';
        exit;
    } elseif (file_exists(__DIR__.'/../deploy.php')) {
        require __DIR__.'/../deploy.php';
        exit;
    }
}

define('LARAVEL_START', microtime(true));

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
