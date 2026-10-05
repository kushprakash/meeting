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

            $appName = $setting->app_name ?? 'Best Recharge';

            Mail::raw(
                "Your 6-digit OTP verification code for {$appName} is: {$otp}\n\nThis code will expire in 10 minutes.\n\nIf you did not request this verification code, please ignore this message.",
                function ($message) use ($user, $appName, $otp) {
                    $fromAddress = config('mail.from.address') ?: 'noreply@bestrecharge.com';
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
            'account_type' => 'nullable|string|in:free,corporate',
        ]);

        $accountType = $validated['account_type'] ?? 'free';
        $role = ($accountType === 'corporate') ? 'corporate_employee' : 'free_user';

        $userData = [
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'account_type' => $accountType,
            'role' => $role,
            'is_verified' => 1,
            'email_verified_at' => now(),
        ];

        if (!empty($validated['phone'])) {
            $userData['phone'] = trim($validated['phone']);
        }

        $user = User::create($userData);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful! Welcome to Best Recharge.',
            'data' => [
                'user' => $user->fresh(),
                'token' => $token,
            ]
        ], 201);
    }

    /**
     * Verify 6-digit OTP code and issue API Token (Legacy Compatibility).
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'otp_code' => 'nullable|string',
        ]);

        $user = User::where('email', strtolower(trim($validated['email'])))->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User account not found.'
            ], 404);
        }

        $user->update([
            'email_verified_at' => now(),
            'is_verified' => 1,
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Account logged in successfully!',
            'data' => [
                'user' => $user->fresh(),
                'token' => $token,
            ]
        ]);
    }

    /**
     * Resend 6-digit OTP code (Legacy Compatibility).
     */
    public function resendOtp(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Direct login enabled. No OTP required.',
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

        if (!$user->email_verified_at) {
            $user->update([
                'email_verified_at' => now(),
                'is_verified' => 1,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Logged in successfully',
            'data' => [
                'user' => $user->fresh(),
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
