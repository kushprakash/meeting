<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HostApprovalController;
use App\Http\Controllers\Api\V1\MeetingController;
use App\Http\Controllers\Api\V1\MeetingJoinController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Version 1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    
    // Auth Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/auth/resend-otp', [AuthController::class, 'resendOtp']);

    // Public Branding Detection (Domain / URL matching)
    Route::get('/branding/public', [\App\Http\Controllers\Api\V1\BrandingController::class, 'detectBranding']);

    // Protected Routes (Sanctum Auth Required)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'me']);
        Route::post('/user/switch-account-type', [AuthController::class, 'switchAccountType']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Meeting Management
        Route::get('/meetings', [MeetingController::class, 'index']);
        Route::post('/meetings', [MeetingController::class, 'store']);
        Route::get('/meetings/{uuid}', [MeetingController::class, 'show']);
        Route::get('/meetings/{uuid}/room-activity', [MeetingController::class, 'roomActivity']);
        Route::post('/meetings/{uuid}/invite', [MeetingController::class, 'invite']);
        Route::delete('/meetings/{uuid}/invite/{participantId}', [MeetingController::class, 'revokeInvite']);

        // Join & Access Control (12 Security Validation Checks)
        Route::post('/meetings/{uuid}/join', [MeetingJoinController::class, 'join']);
        Route::post('/meetings/{uuid}/leave', [MeetingJoinController::class, 'leave']);

        // Host Controls & Approval Realtime
        Route::get('/meetings/{uuid}/pending', [HostApprovalController::class, 'pendingRequests']);
        Route::post('/meetings/{uuid}/approve/{participantId}', [HostApprovalController::class, 'approve']);
        Route::post('/meetings/{uuid}/reject/{participantId}', [HostApprovalController::class, 'reject']);
        Route::post('/meetings/{uuid}/remove/{participantId}', [HostApprovalController::class, 'remove']);
        Route::post('/meetings/{uuid}/block/{participantId}', [HostApprovalController::class, 'block']);

        // Super Admin Management Routes
        Route::get('/super-admin/reports', [\App\Http\Controllers\Api\V1\SuperAdminController::class, 'reports']);
        Route::get('/super-admin/admins', [\App\Http\Controllers\Api\V1\SuperAdminController::class, 'listAdmins']);
        Route::post('/super-admin/admins', [\App\Http\Controllers\Api\V1\SuperAdminController::class, 'createAdmin']);
        Route::post('/super-admin/admins/{id}/permissions', [\App\Http\Controllers\Api\V1\SuperAdminController::class, 'updatePermissions']);

        // Admin Multi-Tenant & Corporate Management Routes
        Route::get('/admin/corporates', [\App\Http\Controllers\Api\V1\AdminCorporateController::class, 'index']);
        Route::post('/admin/corporates', [\App\Http\Controllers\Api\V1\AdminCorporateController::class, 'store']);
        Route::post('/admin/corporates/{id}/verify', [\App\Http\Controllers\Api\V1\AdminCorporateController::class, 'verify']);
        Route::post('/admin/corporates/assign-employee', [\App\Http\Controllers\Api\V1\AdminCorporateController::class, 'assignEmployee']);

        // Admin Settings, Branding, SMTP, & SMS Gateway Routes
        Route::get('/admin/settings', [\App\Http\Controllers\Api\V1\AdminSettingController::class, 'getSettings']);
        Route::post('/admin/settings', [\App\Http\Controllers\Api\V1\AdminSettingController::class, 'updateSettings']);

        // Corporate Employee Management Routes
        Route::get('/corporate/employees', [\App\Http\Controllers\Api\V1\CorporateEmployeeController::class, 'listEmployees']);
        Route::post('/corporate/employees', [\App\Http\Controllers\Api\V1\CorporateEmployeeController::class, 'createEmployee']);
        Route::post('/corporate/employees/{id}/toggle-hosting', [\App\Http\Controllers\Api\V1\CorporateEmployeeController::class, 'toggleHosting']);
    });
});
