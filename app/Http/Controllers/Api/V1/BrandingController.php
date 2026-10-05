<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandingController extends Controller
{
    /**
     * Detect public or user branding by matching URL / Origin or Logged-in User admin_id
     */
    public function detectBranding(Request $request): JsonResponse
    {
        $user = $request->user('sanctum');
        $setting = null;

        // 1. If user is logged in, check user's setting or parent Admin's setting
        if ($user) {
            if ($user->setting) {
                $setting = $user->setting;
            } elseif ($user->admin_id) {
                $setting = Setting::where('admin_id', $user->admin_id)->first();
            }
        }

        // 2. If no user setting found, match by website_url Origin / Host URL
        if (!$setting) {
            $rawUrl = $request->query('url') ?: ($request->header('Origin') ?: $request->getHost());
            $cleanHost = parse_url($rawUrl, PHP_URL_HOST) ?: $rawUrl;
            $cleanHost = preg_replace('/^https?:\/\//i', '', $cleanHost);
            $cleanHost = preg_replace('/:\d+$/', '', $cleanHost);
            $cleanHost = trim($cleanHost, '/');

            if (!empty($cleanHost)) {
                $setting = Setting::where('website_url', 'LIKE', "%{$cleanHost}%")->first();
            }
        }

        // 3. Fallback to Super Admin setting or default setting
        if (!$setting) {
            $superAdmin = User::where('role', 'super_admin')->first();
            $setting = $superAdmin ? Setting::where('admin_id', $superAdmin->id)->first() : Setting::first();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'branding' => [
                    'company_name' => ($setting && !empty($setting->company_name) && !str_contains(strtolower($setting->company_name), 'vidbez')) ? $setting->company_name : 'Best Recharge Services',
                    'app_name' => ($setting && !empty($setting->app_name) && !str_contains(strtolower($setting->app_name), 'vidbez')) ? $setting->app_name : 'Best Recharge',
                    'logo_url' => $setting->logo_url ?? null,
                    'favicon_url' => $setting->favicon_url ?? null,
                    'primary_color' => $setting->primary_color ?? '#6C5CE7',
                    'secondary_color' => $setting->secondary_color ?? '#00CEC9',
                    'tagline' => ($setting && !empty($setting->tagline) && !str_contains(strtolower($setting->tagline), 'webrtc')) ? $setting->tagline : 'Instant Mobile, DTH & Utility Payment Services',
                    'contact_email' => $setting->contact_email ?? 'support@bestrecharge.com',
                    'website_url' => $setting->website_url ?? null,
                    'about_title' => $setting->about_title ?? 'Best Recharge - Fast & Reliable Recharge App',
                    'about_text' => $setting->about_text ?? 'Best Recharge provides instant mobile recharges, DTH recharges, fastag payments, utility bill payments, and audio room access with secure wallet passbook.',
                    'services_json' => $setting->services_json ?? [],
                    'media_json' => $setting->media_json ?? [],
                    'contact_address' => $setting->contact_address ?? 'Best Recharge Tower, Tech Park',
                    'contact_phone' => $setting->contact_phone ?? '+91 98765 43210',
                    'social_links_json' => $setting->social_links_json ?? [],
                ]
            ]
        ]);
    }
}
