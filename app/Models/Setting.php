<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'website_url',
        'company_name',
        'app_name',
        'logo_url',
        'favicon_url',
        'primary_color',
        'secondary_color',
        'tagline',
        'contact_email',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_encryption',
        'smtp_from_email',
        'smtp_from_name',
        'sms_provider',
        'sms_api_key',
        'sms_api_secret',
        'sms_sender_id',
        'about_title',
        'about_text',
        'services_json',
        'media_json',
        'contact_address',
        'contact_phone',
        'social_links_json',
    ];

    protected $casts = [
        'services_json' => 'array',
        'media_json' => 'array',
        'social_links_json' => 'array',
    ];

    public function adminUser()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Helper to clone default setting parameters from Super Admin for a newly created Admin.
     */
    public static function cloneFromSuperAdmin(int $newAdminId, ?string $websiteUrl = null): self
    {
        $superAdminUser = User::where('role', 'super_admin')->first();
        $sourceSetting = $superAdminUser ? self::where('admin_id', $superAdminUser->id)->first() : null;

        $defaults = [
            'admin_id' => $newAdminId,
            'website_url' => $websiteUrl,
            'company_name' => $sourceSetting->company_name ?? 'MeetingPulse Enterprise',
            'app_name' => $sourceSetting->app_name ?? 'MeetingPulse',
            'logo_url' => $sourceSetting->logo_url ?? null,
            'favicon_url' => $sourceSetting->favicon_url ?? null,
            'primary_color' => $sourceSetting->primary_color ?? '#1a73e8',
            'secondary_color' => $sourceSetting->secondary_color ?? '#0f172a',
            'tagline' => $sourceSetting->tagline ?? 'Premium Video Meetings & Access Control',
            'contact_email' => $sourceSetting->contact_email ?? 'admin@meetingpulse.com',
            'smtp_host' => $sourceSetting->smtp_host ?? 'smtp.mailtrap.io',
            'smtp_port' => $sourceSetting->smtp_port ?? 2525,
            'smtp_username' => $sourceSetting->smtp_username ?? 'demo_user',
            'smtp_password' => $sourceSetting->smtp_password ?? 'demo_pass',
            'smtp_encryption' => $sourceSetting->smtp_encryption ?? 'tls',
            'smtp_from_email' => $sourceSetting->smtp_from_email ?? 'noreply@meetingpulse.com',
            'smtp_from_name' => $sourceSetting->smtp_from_name ?? 'MeetingPulse Support',
            'sms_provider' => $sourceSetting->sms_provider ?? 'Twilio',
            'sms_api_key' => $sourceSetting->sms_api_key ?? null,
            'sms_api_secret' => $sourceSetting->sms_api_secret ?? null,
            'sms_sender_id' => $sourceSetting->sms_sender_id ?? 'MPULSE',
            'about_title' => $sourceSetting->about_title ?? 'Empowering Global Collaboration & Enterprise Video Meetings',
            'about_text' => $sourceSetting->about_text ?? 'MeetingPulse is built for high-scale enterprise teams, public webinars, and confidential board meetings. Powered by Go LiveKit SFU server architecture, strict server-side authorization checks, and zero third-party data tracking.',
            'services_json' => $sourceSetting->services_json ?? [
                ['icon' => 'fa-solid fa-video', 'title' => 'Ultra HD Video Conferencing', 'desc' => '1080p WebRTC streaming powered by low-latency Go SFU engine with 0 packet loss.'],
                ['icon' => 'fa-solid fa-shield-halved', 'title' => '12-Step Access Control', 'desc' => 'Strict private email invitations and real-time host waiting room approval controls.'],
                ['icon' => 'fa-solid fa-desktop', 'title' => '4K Screen Sharing & Recording', 'desc' => 'High frame-rate display sharing with multi-participant canvas rendering.'],
                ['icon' => 'fa-solid fa-palette', 'title' => 'White-Label Multi-Tenancy', 'desc' => 'Complete corporate identity matching custom domain origins and theme palettes.']
            ],
            'media_json' => $sourceSetting->media_json ?? [
                ['title' => 'TechCrunch Coverage: Enterprise SFU Breakthrough', 'category' => 'Press', 'date' => 'Sep 2026', 'link' => '#', 'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&q=80'],
                ['title' => 'Global WebRTC Security & Access Control Report', 'category' => 'Whitepaper', 'date' => 'Aug 2026', 'link' => '#', 'image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=500&q=80'],
                ['title' => 'MeetingPulse Announces Multi-Region Infrastructure', 'category' => 'News', 'date' => 'Jul 2026', 'link' => '#', 'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=500&q=80']
            ],
            'contact_address' => $sourceSetting->contact_address ?? 'Enterprise World Tower, 8th Floor, Tech Hub Center',
            'contact_phone' => $sourceSetting->contact_phone ?? '+1 (800) 555-MEET / +91 98765 43210',
            'social_links_json' => $sourceSetting->social_links_json ?? [
                'twitter' => 'https://twitter.com',
                'linkedin' => 'https://linkedin.com',
                'youtube' => 'https://youtube.com',
                'facebook' => 'https://facebook.com'
            ],
        ];

        return self::updateOrCreate(['admin_id' => $newAdminId], $defaults);
    }
}
