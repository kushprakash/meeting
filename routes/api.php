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

        // Wallet Routes
        Route::get('/wallet', [\App\Http\Controllers\Api\V1\WalletController::class, 'index']);
        Route::post('/wallet/add-money', [\App\Http\Controllers\Api\V1\WalletController::class, 'addMoney']);
        Route::post('/wallet/initiate-payment', [\App\Http\Controllers\Api\V1\WalletController::class, 'initiatePayment']);
        Route::post('/wallet/verify-payment', [\App\Http\Controllers\Api\V1\WalletController::class, 'verifyPayment']);
        Route::get('/wallet/history', [\App\Http\Controllers\Api\V1\WalletController::class, 'history']);

        // Banner & Notification Routes
        Route::get('/banners', [\App\Http\Controllers\Api\V1\BannerNotificationController::class, 'getBanners']);
        Route::get('/notifications', [\App\Http\Controllers\Api\V1\BannerNotificationController::class, 'getNotifications']);
        Route::post('/notifications/{id}/read', [\App\Http\Controllers\Api\V1\BannerNotificationController::class, 'markRead']);

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
        // Recharge, DTH & Bill Payment Routes
        Route::post('/recharge/mobile-plans', [\App\Http\Controllers\Api\V1\RechargeController::class, 'getMobilePlans']);
        Route::post('/recharge/get-operator', [\App\Http\Controllers\Api\V1\RechargeController::class, 'getOperators']);
        Route::post('/recharge/mobile-recharge', [\App\Http\Controllers\Api\V1\RechargeController::class, 'doRecharge']);
        Route::post('/recharge/recharge', [\App\Http\Controllers\Api\V1\RechargeController::class, 'doRecharge']);
        Route::post('/recharge/recharge-status', [\App\Http\Controllers\Api\V1\RechargeController::class, 'checkSingleStatus']);

        // Bill Payment Routes
        Route::get('/recharge/bill-categories', [\App\Http\Controllers\Api\V1\RechargeController::class, 'getBillCategories']);
        Route::post('/recharge/billers-by-category', [\App\Http\Controllers\Api\V1\RechargeController::class, 'getBillersByCategory']);
        Route::post('/recharge/fetch-bill', [\App\Http\Controllers\Api\V1\RechargeController::class, 'fetchBill']);
        Route::post('/recharge/bill-payment', [\App\Http\Controllers\Api\V1\RechargeController::class, 'doRecharge']);
        Route::post('/recharge/bill-status', [\App\Http\Controllers\Api\V1\RechargeController::class, 'getBillStatus']);
        Route::get('/recharge/history', [\App\Http\Controllers\Api\V1\RechargeController::class, 'history']);
    });

    // Public / Cron Route for Pending Recharge Status Verification
    Route::match(['get', 'post'], '/recharge/cron-check-status', [\App\Http\Controllers\Api\V1\RechargeController::class, 'checkPendingStatus']);
});

