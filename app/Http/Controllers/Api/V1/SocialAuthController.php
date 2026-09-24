<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect user to Google or Meta (Facebook) OAuth consent screen.
     */
    public function redirectToProvider(string $provider)
    {
        $driver = $this->getDriverName($provider);
        if (!$driver) {
            return response()->json(['status' => 'error', 'message' => 'Invalid social provider. Only google and meta are supported.'], 400);
        }

        $clientId = config("services.{$driver}.client_id");
        if (empty($clientId)) {
            // Local Development Fallback if OAuth credentials are not set in .env yet
            $name = ucfirst($provider) . ' User';
            $email = strtolower($provider) . '_user@example.com';

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'provider' => $provider,
                    'provider_id' => $provider . '_dev_' . rand(100, 999),
                    'password' => null,
                ]
            );

            $token = $user->createToken('social_token')->plainTextToken;
            return redirect('/?social_token=' . urlencode($token) . '&user_name=' . urlencode($user->name));
        }

        return Socialite::driver($driver)->redirect();
    }

    /**
     * Handle OAuth callback from Google or Meta.
     */
    public function handleProviderCallback(Request $request, string $provider)
    {
        $driver = $this->getDriverName($provider);
        if (!$driver) {
            return redirect('/?error=invalid_provider');
        }

        try {
            $socialUser = Socialite::driver($driver)->user();
            $user = $this->findOrCreateUser($socialUser, $provider);

            $token = $user->createToken('social_auth_token')->plainTextToken;

            // Redirect back to frontend landing page with token
            return redirect('/?social_token=' . urlencode($token) . '&user_name=' . urlencode($user->name));
        } catch (\Exception $e) {
            return redirect('/?error=' . urlencode('Social auth failed: ' . $e->getMessage()));
        }
    }

    /**
     * One-Tap / SPA Social Login Endpoint (Instant Google & Meta Sign In)
     */
    public function socialLogin(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'provider' => 'required|in:google,meta,facebook,twitter,x,instagram,whatsapp',
            'name' => 'required|string',
            'email' => 'required|email',
            'provider_id' => 'nullable|string',
            'avatar' => 'nullable|string',
        ]);

        $user = User::where('email', strtolower(trim($validated['email'])))->first();

        if (!$user) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => strtolower(trim($validated['email'])),
                'provider' => $validated['provider'],
                'provider_id' => $validated['provider_id'] ?? ('social_' . uniqid()),
                'avatar' => $validated['avatar'] ?? null,
                'password' => null,
            ]);
        } else {
            $user->update([
                'provider' => $validated['provider'],
                'provider_id' => $validated['provider_id'] ?? $user->provider_id,
                'avatar' => $validated['avatar'] ?? $user->avatar,
            ]);
        }

        $token = $user->createToken('social_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Logged in successfully with ' . ucfirst($validated['provider']),
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
    }

    protected function getDriverName(string $provider): ?string
    {
        return match (strtolower($provider)) {
            'google' => 'google',
            'meta', 'facebook' => 'facebook',
            'twitter', 'x' => 'twitter',
            'instagram' => 'instagram',
            'whatsapp' => 'whatsapp',
            default => null,
        };
    }

    protected function findOrCreateUser($socialUser, string $provider): User
    {
        $user = User::where('email', strtolower($socialUser->getEmail()))->first();

        if (!$user) {
            return User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Social User',
                'email' => strtolower($socialUser->getEmail()),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'password' => null,
            ]);
        }

        $user->update([
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'avatar' => $socialUser->getAvatar() ?? $user->avatar,
        ]);

        return $user;
    }
}
