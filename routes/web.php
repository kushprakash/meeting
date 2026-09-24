<?php

use Illuminate\Support\Facades\Route;

$handleDeploy = function () {
    $fileInPublic = public_path('deploy.php');
    $fileInRoot = base_path('deploy.php');
    if (file_exists($fileInPublic)) {
        require $fileInPublic;
        exit;
    } elseif (file_exists($fileInRoot)) {
        require $fileInRoot;
        exit;
    }
    abort(404);
};

Route::get('/', function () use ($handleDeploy) {
    if (request()->has('token')) {
        $handleDeploy();
    }
    return view('welcome');
});

Route::get('/deploy', $handleDeploy);
Route::get('/deploy.php', $handleDeploy);

Route::get('/meeting/{uuid}', function () {
    return view('welcome');
});

Route::get('/auth/{provider}/redirect', [App\Http\Controllers\Api\V1\SocialAuthController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [App\Http\Controllers\Api\V1\SocialAuthController::class, 'handleProviderCallback']);
