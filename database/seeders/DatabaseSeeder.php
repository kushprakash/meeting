<?php

namespace Database\Seeders;

use App\Models\Corporate;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Super Admin User
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@meetingpulse.com'],
            [
                'name' => 'System Super Admin',
                'password' => Hash::make('adminpassword123'),
                'role' => 'super_admin',
                'account_type' => 'corporate',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );

        // Super Admin Setting
        Setting::updateOrCreate(
            ['admin_id' => $superAdmin->id],
            [
                'website_url' => '127.0.0.1:8000',
                'company_name' => 'MeetingPulse Enterprise Global',
                'app_name' => 'MeetingPulse Enterprise',
                'logo_url' => null,
                'primary_color' => '#1a73e8',
                'secondary_color' => '#0f172a',
                'tagline' => 'Enterprise WebRTC Video Conferencing & White-Label Platform',
                'contact_email' => 'superadmin@meetingpulse.com',
                'smtp_host' => 'smtp.mailtrap.io',
                'smtp_port' => 2525,
                'smtp_username' => 'super_smtp_user',
                'smtp_password' => 'super_smtp_pass',
                'smtp_encryption' => 'tls',
                'smtp_from_email' => 'noreply@meetingpulse.com',
                'smtp_from_name' => 'MeetingPulse System',
                'sms_provider' => 'Twilio',
                'sms_api_key' => 'SK_SUPER_DEMO_KEY',
                'sms_api_secret' => 'SEC_SUPER_DEMO_SECRET',
                'sms_sender_id' => 'MPULSE',
                'about_title' => 'Empowering Global Collaboration & Enterprise Video Meetings',
                'about_text' => 'MeetingPulse is engineered for global enterprises, executive boardrooms, and high-capacity public webinars. Powered by ultra low-latency WebRTC Go SFU engine, 12 server-side security rules, and end-to-end token verification.',
                'services_json' => [
                    ['icon' => 'fa-solid fa-video', 'title' => 'Ultra HD Video Conferencing', 'desc' => '1080p WebRTC streaming powered by low-latency Go SFU engine with 0 packet loss.'],
                    ['icon' => 'fa-solid fa-shield-halved', 'title' => '12-Step Access Control', 'desc' => 'Strict private email invitations and real-time host waiting room approval controls.'],
                    ['icon' => 'fa-solid fa-desktop', 'title' => '4K Screen Sharing & Canvas', 'desc' => 'High frame-rate display sharing with multi-participant video canvas rendering.'],
                    ['icon' => 'fa-solid fa-palette', 'title' => 'White-Label Multi-Tenancy', 'desc' => 'Complete corporate identity matching custom domain origins and theme palettes.']
                ],
                'media_json' => [
                    ['title' => 'TechCrunch Coverage: Enterprise SFU WebRTC Breakthrough', 'category' => 'Press', 'date' => 'Sep 2026', 'link' => '#', 'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&q=80'],
                    ['title' => 'Global WebRTC Security & Access Control Whitepaper', 'category' => 'Whitepaper', 'date' => 'Aug 2026', 'link' => '#', 'image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=500&q=80'],
                    ['title' => 'MeetingPulse Announces Multi-Region Infrastructure Expansion', 'category' => 'News', 'date' => 'Jul 2026', 'link' => '#', 'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=500&q=80']
                ],
                'contact_address' => 'Enterprise World Tower, 8th Floor, Tech Hub Center',
                'contact_phone' => '+1 (800) 555-MEET / +91 98765 43210',
                'social_links_json' => [
                    'twitter' => 'https://twitter.com',
                    'linkedin' => 'https://linkedin.com',
                    'youtube' => 'https://youtube.com',
                    'facebook' => 'https://facebook.com'
                ],
            ]
        );

        // 2. Create System Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@meetingpulse.com'],
            [
                'name' => 'Corporate Admin Manager',
                'password' => Hash::make('adminpassword123'),
                'role' => 'admin',
                'account_type' => 'corporate',
                'admin_id' => $superAdmin->id,
                'is_verified' => true,
                'permissions' => ['manage_corporates', 'view_reports', 'manage_users'],
                'designation' => 'Regional System Administrator',
                'email_verified_at' => now(),
            ]
        );

        // Admin Setting (Auto-initialized from Super Admin)
        Setting::cloneFromSuperAdmin($admin->id, 'localhost:8000');

        // 3. Create Verified Corporate Organization
        $corporate = Corporate::updateOrCreate(
            ['name' => 'MeetingPulse Enterprise Corp'],
            [
                'domain' => 'meetingpulse.com',
                'tax_id' => 'CORP-TAX-998877',
                'verification_status' => 'verified',
                'created_by_admin_id' => $admin->id,
                'verified_at' => now(),
            ]
        );

        // 4. Create Verified Corporate Employee Host
        $host = User::updateOrCreate(
            ['email' => 'host@meetingpulse.com'],
            [
                'name' => 'Executive Corporate Host',
                'password' => Hash::make('hostpassword123'),
                'role' => 'corporate_employee',
                'corporate_id' => $corporate->id,
                'admin_id' => $admin->id,
                'account_type' => 'corporate',
                'designation' => 'Senior Vice President & Host',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
