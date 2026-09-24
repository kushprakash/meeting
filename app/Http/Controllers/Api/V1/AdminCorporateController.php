<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Corporate;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminCorporateController extends Controller
{
    /**
     * List all corporate organizations (Admin only)
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->isAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Admin access required.'], 403);
        }

        $corporates = Corporate::withCount('employees')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'corporates' => $corporates,
            ]
        ]);
    }

    /**
     * Create a new Corporate Organization WITH Corporate Admin User Credentials (Admin only)
     */
    public function store(Request $request): JsonResponse
    {
        $admin = $request->user();
        if (!$admin->isAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Admin access required.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:255',
            'admin_name' => 'nullable|string|max:255',
            'admin_email' => 'nullable|string|email|max:255|unique:users,email',
            'admin_password' => 'nullable|string|min:6',
        ]);

        $corporate = Corporate::create([
            'name' => $validated['name'],
            'domain' => $validated['domain'] ?? null,
            'tax_id' => $validated['tax_id'] ?? null,
            'verification_status' => 'verified',
            'created_by_admin_id' => $admin->id,
            'verified_at' => now(),
        ]);

        $corporateAdminUser = null;
        if (!empty($validated['admin_email']) && !empty($validated['admin_password'])) {
            $corporateAdminUser = User::create([
                'name' => $validated['admin_name'] ?? ($validated['name'] . ' Admin'),
                'email' => strtolower(trim($validated['admin_email'])),
                'password' => Hash::make($validated['admin_password']),
                'role' => 'corporate_employee',
                'account_type' => 'corporate',
                'corporate_id' => $corporate->id,
                'admin_id' => $admin->id,
                'designation' => 'Corporate Administrator',
                'is_verified' => true,
                'email_verified_at' => now(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Corporate organization & primary Admin created successfully.',
            'data' => [
                'corporate' => $corporate->load('employees'),
                'corporate_admin' => $corporateAdminUser,
            ]
        ], 201);
    }

    /**
     * Verify a Corporate Organization
     */
    public function verify(Request $request, int $id): JsonResponse
    {
        $user = $request->user();
        if (!$user->isAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $corporate = Corporate::findOrFail($id);
        $corporate->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Corporate verified successfully',
            'data' => [
                'corporate' => $corporate,
            ]
        ]);
    }

    /**
     * Assign User to Corporate as Employee
     */
    public function assignEmployee(Request $request): JsonResponse
    {
        $admin = $request->user();
        if (!$admin->isAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'corporate_id' => 'required|exists:corporates,id',
        ]);

        $targetUser = User::findOrFail($validated['user_id']);
        $targetUser->update([
            'corporate_id' => $validated['corporate_id'],
            'admin_id' => $admin->id,
            'role' => 'corporate_employee',
            'account_type' => 'corporate',
            'is_verified' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User assigned to verified corporate successfully.',
            'data' => [
                'user' => $targetUser->fresh(['corporate']),
            ]
        ]);
    }
}
