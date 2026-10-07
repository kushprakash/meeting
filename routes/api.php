<?php

use App\Http\Controllers\Api\V1\AdminCorporateController;
use App\Http\Controllers\Api\V1\AdminSettingController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BannerNotificationController;
use App\Http\Controllers\Api\V1\BrandingController;
use App\Http\Controllers\Api\V1\CorporateEmployeeController;
use App\Http\Controllers\Api\V1\HostApprovalController;
use App\Http\Controllers\Api\V1\MeetingController;
use App\Http\Controllers\Api\V1\MeetingJoinController;
use App\Http\Controllers\Api\V1\RechargeController;
use App\Http\Controllers\Api\V1\SuperAdminController;
use App\Http\Controllers\Api\V1\WalletController;
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

    // Public Branding & Payment Direct Verification Routes
    Route::get('/branding/public', [BrandingController::class, 'detectBranding']);
    Route::match(['get', 'post'], '/wallet/verify-payment-direct', [WalletController::class, 'verifyPayment']);
    Route::get('/wallet/verify-status/{order_id}', [WalletController::class, 'verifyPayment']);

    // Protected Routes (Sanctum Auth Required)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'me']);
        Route::post('/user/switch-account-type', [AuthController::class, 'switchAccountType']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Wallet Routes
        Route::get('/wallet', [WalletController::class, 'index']);
        Route::post('/wallet/add-money', [WalletController::class, 'addMoney']);
        Route::post('/wallet/initiate-payment', [WalletController::class, 'initiatePayment']);
        Route::match(['get', 'post'], '/wallet/verify-payment', [WalletController::class, 'verifyPayment']);
        Route::get('/wallet/verify-payment/{order_id}', [WalletController::class, 'verifyPayment']);
        Route::get('/wallet/history', [WalletController::class, 'history']);

        // Banner & Notification Routes
        Route::get('/banners', [BannerNotificationController::class, 'getBanners']);
        Route::get('/notifications', [BannerNotificationController::class, 'getNotifications']);
        Route::post('/notifications/{id}/read', [BannerNotificationController::class, 'markRead']);

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
        Route::get('/super-admin/reports', [SuperAdminController::class, 'reports']);
        Route::get('/super-admin/admins', [SuperAdminController::class, 'listAdmins']);
        Route::post('/super-admin/admins', [SuperAdminController::class, 'createAdmin']);
        Route::post('/super-admin/admins/{id}/permissions', [SuperAdminController::class, 'updatePermissions']);

        // Admin Multi-Tenant & Corporate Management Routes
        Route::get('/admin/corporates', [AdminCorporateController::class, 'index']);
        Route::post('/admin/corporates', [AdminCorporateController::class, 'store']);
        Route::post('/admin/corporates/{id}/verify', [AdminCorporateController::class, 'verify']);
        Route::post('/admin/corporates/assign-employee', [AdminCorporateController::class, 'assignEmployee']);

        // Admin Settings, Branding, SMTP, & SMS Gateway Routes
        Route::get('/admin/settings', [AdminSettingController::class, 'getSettings']);
        Route::post('/admin/settings', [AdminSettingController::class, 'updateSettings']);

        // Corporate Employee Management Routes
        Route::get('/corporate/employees', [CorporateEmployeeController::class, 'listEmployees']);
        Route::post('/corporate/employees', [CorporateEmployeeController::class, 'createEmployee']);
        // Recharge, DTH & Bill Payment Routes
        Route::post('/recharge/mobile-plans', [RechargeController::class, 'getMobilePlans']);
        Route::post('/recharge/get-operator', [RechargeController::class, 'getOperators']);
        Route::post('/recharge/mobile-recharge', [RechargeController::class, 'doRecharge']);
        Route::post('/recharge/recharge', [RechargeController::class, 'doRecharge']);
        Route::post('/recharge/recharge-status', [RechargeController::class, 'checkSingleStatus']);

        // Bill Payment Routes
        Route::get('/recharge/bill-categories', [RechargeController::class, 'getBillCategories']);
        Route::post('/recharge/billers-by-category', [RechargeController::class, 'getBillersByCategory']);
        Route::post('/recharge/fetch-bill', [RechargeController::class, 'fetchBill']);
        Route::post('/recharge/bill-payment', [RechargeController::class, 'doRecharge']);
        Route::post('/recharge/bill-status', [RechargeController::class, 'getBillStatus']);
        Route::get('/recharge/history', [RechargeController::class, 'history']);
    });

    // Public / Cron Route for Pending Recharge Status Verification
    Route::match(['get', 'post'], '/recharge/cron-check-status', [RechargeController::class, 'checkPendingStatus']);
});
