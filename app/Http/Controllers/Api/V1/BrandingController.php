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

            $setting = Setting::where('website_url', 'LIKE', "%{$cleanHost}%")->first();
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
                    'company_name' => $setting->company_name ?? 'MeetingPulse Enterprise',
                    'app_name' => $setting->app_name ?? 'MeetingPulse',
                    'logo_url' => $setting->logo_url ?? null,
                    'favicon_url' => $setting->favicon_url ?? null,
                    'primary_color' => $setting->primary_color ?? '#1a73e8',
                    'secondary_color' => $setting->secondary_color ?? '#0f172a',
                    'tagline' => $setting->tagline ?? 'Premium Video Meetings & Access Control',
                    'contact_email' => $setting->contact_email ?? 'support@meetingpulse.com',
                    'website_url' => $setting->website_url ?? null,
                    'about_title' => $setting->about_title ?? 'Empowering Global Collaboration & Enterprise Video Meetings',
                    'about_text' => $setting->about_text ?? 'MeetingPulse is engineered for global enterprises, executive boardrooms, and high-capacity public webinars.',
                    'services_json' => $setting->services_json ?? [],
                    'media_json' => $setting->media_json ?? [],
                    'contact_address' => $setting->contact_address ?? 'Enterprise World Tower, Tech Hub Center',
                    'contact_phone' => $setting->contact_phone ?? '+1 (800) 555-MEET',
                    'social_links_json' => $setting->social_links_json ?? [],
                ]
            ]
        ]);
    }
}
