<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    /**
     * Get settings for authenticated Admin / Super Admin
     */
    public function getSettings(Request $request): JsonResponse
    {
        $admin = $request->user();
        if (!$admin->isAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Admin access required.'], 403);
        }

        $setting = Setting::where('admin_id', $admin->id)->first();
        if (!$setting) {
            $setting = Setting::cloneFromSuperAdmin($admin->id);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'setting' => $setting,
            ]
        ]);
    }

    /**
     * Update settings (Branding, Website URL, SMTP, SMS) for authenticated Admin
     */
    public function updateSettings(Request $request): JsonResponse
    {
        $admin = $request->user();
        if (!$admin->isAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Admin access required.'], 403);
        }

        $setting = Setting::where('admin_id', $admin->id)->first();
        if (!$setting) {
            $setting = Setting::cloneFromSuperAdmin($admin->id);
        }

        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'app_name' => 'nullable|string|max:255',
            'logo_url' => 'nullable|string|max:500',
            'favicon_url' => 'nullable|string|max:500',
            'primary_color' => 'nullable|string|max:50',
            'secondary_color' => 'nullable|string|max:50',
            'tagline' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'website_url' => 'nullable|string|max:255',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|string|max:50',
            'smtp_from_email' => 'nullable|email|max:255',
            'smtp_from_name' => 'nullable|string|max:255',
            'sms_provider' => 'nullable|string|max:255',
            'sms_api_key' => 'nullable|string|max:255',
            'sms_api_secret' => 'nullable|string|max:255',
            'sms_sender_id' => 'nullable|string|max:50',
            'about_title' => 'nullable|string|max:500',
            'about_text' => 'nullable|string',
            'services_json' => 'nullable|array',
            'media_json' => 'nullable|array',
            'contact_address' => 'nullable|string|max:500',
            'contact_phone' => 'nullable|string|max:100',
            'social_links_json' => 'nullable|array',
        ]);

        $setting->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Admin settings & white-label branding updated successfully.',
            'data' => [
                'setting' => $setting->fresh(),
            ]
        ]);
    }
}
