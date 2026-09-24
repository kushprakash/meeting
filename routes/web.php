<?php

use Illuminate\Support\Facades\Route;

function runDeploymentScript() {
    $fileInPublic = public_path('deploy.php');
    $fileInRoot = base_path('deploy.php');
    if (file_exists($fileInPublic)) {
        require $fileInPublic;
        exit;
    } elseif (file_exists($fileInRoot)) {
        require $fileInRoot;
        exit;
    }
}

Route::get('/', function () {
    if (request()->has('token')) {
        runDeploymentScript();
    }
    return view('welcome');
});

Route::get('/deploy', function () {
    runDeploymentScript();
    abort(404);
});

Route::get('/deploy.php', function () {
    runDeploymentScript();
    abort(404);
});

Route::get('/auth/{provider}/redirect', [App\Http\Controllers\Api\V1\SocialAuthController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [App\Http\Controllers\Api\V1\SocialAuthController::class, 'handleProviderCallback']);
