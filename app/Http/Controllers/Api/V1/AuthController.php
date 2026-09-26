<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Send OTP email via matched Setting SMTP configuration
     */
    protected function sendOtpEmail(Request $request, User $user, string $otp): void
    {
        try {
            $setting = Setting::getForRequest($request);
            if ($setting) {
                $setting->applySmtpConfig();
            }

            $appName = $setting->app_name ?? 'VidBez';

            Mail::raw(
                "Your 6-digit OTP verification code for {$appName} is: {$otp}\n\nThis code will expire in 10 minutes.\n\nIf you did not request this verification code, please ignore this message.",
                function ($message) use ($user, $appName, $otp) {
                    $fromAddress = config('mail.from.address') ?: 'noreply@vidbez.com';
                    $fromName = config('mail.from.name') ?: "{$appName} Support";

                    $message->from($fromAddress, $fromName)
                        ->to($user->email)
                        ->subject("{$otp} is your {$appName} OTP Verification Code");
                }
            );
        } catch (\Exception $e) {
            Log::error("Failed to send OTP email to {$user->email}: " . $e->getMessage());
        }
    }

    /**
     * Register a new user account with OTP generation.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Generate 6-digit numeric OTP code
        $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        $userData = [
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
            'email_verified_at' => null,
        ];

        if (!empty($validated['phone'])) {
            $userData['phone'] = trim($validated['phone']);
        }

        $user = User::create($userData);

        // Send OTP via SMTP
        $this->sendOtpEmail($request, $user, $otp);

        return response()->json([
            'status' => 'pending_otp',
            'message' => 'Registration successful! 6-digit OTP code sent to your email.',
            'data' => [
                'email' => $user->email,
                'otp_demo' => $otp, // Exposed for UI testing demo convenience
            ]
        ], 201);
    }

    /**
     * Verify 6-digit OTP code and issue API Token.
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|string|size:6',
        ]);

        $user = User::where('email', strtolower(trim($validated['email'])))->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User account not found.'
            ], 404);
        }

        if ($user->otp_code !== $validated['otp_code']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP code. Please check and try again.'
            ], 400);
        }

        if ($user->otp_expires_at && now()->gt($user->otp_expires_at)) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP code has expired. Please click Resend OTP.'
            ], 400);
        }

        // Mark user as verified and clear OTP
        $user->update([
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Email verified and logged in successfully!',
            'data' => [
                'user' => $user->fresh(),
                'token' => $token,
            ]
        ]);
    }

    /**
     * Resend 6-digit OTP code.
     */
    public function resendOtp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', strtolower(trim($validated['email'])))->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User account not found.'
            ], 404);
        }

        $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Send OTP via SMTP
        $this->sendOtpEmail($request, $user, $otp);

        return response()->json([
            'status' => 'success',
            'message' => 'New 6-digit OTP code sent successfully to your email.',
            'data' => [
                'email' => $user->email,
                'otp_demo' => $otp,
            ]
        ]);
    }

    /**
     * Login user with Email & Password.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', strtolower(trim($validated['email'])))->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid email or password credentials.'],
            ]);
        }

        // If email not verified, generate fresh OTP and require verification
        if (!$user->email_verified_at) {
            $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
            ]);

            // Send OTP via SMTP
            $this->sendOtpEmail($request, $user, $otp);

            return response()->json([
                'status' => 'pending_otp',
                'message' => 'Email verification required. OTP sent.',
                'data' => [
                    'email' => $user->email,
                    'otp_demo' => $otp,
                ]
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Logged in successfully',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
    }

    /**
     * Get authenticated user details.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $request->user(),
            ]
        ]);
    }

    /**
     * Logout user (revoke token).
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Switch account type between free and corporate.
     */
    public function switchAccountType(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'account_type' => 'required|in:free,corporate',
        ]);

        $user = $request->user();
        $user->update(['account_type' => $validated['account_type']]);

        return response()->json([
            'status' => 'success',
            'message' => 'Account type updated to ' . ucfirst($validated['account_type']),
            'data' => [
                'user' => $user->fresh(),
            ]
        ]);
    }
}
