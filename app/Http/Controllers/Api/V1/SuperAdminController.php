<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Corporate;
use App\Models\Meeting;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /**
     * Platform Analytics & System Reports (Super Admin only)
     */
    public function reports(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->isSuperAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Super Admin access required.'], 403);
        }

        $totalAdmins = User::where('role', 'admin')->count();
        $totalCorporates = Corporate::count();
        $totalEmployees = User::where('role', 'corporate_employee')->count();
        $totalMeetings = Meeting::count();
        $activeLiveRooms = Meeting::where('status', 'active')->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'analytics' => [
                    'total_admins' => $totalAdmins,
                    'total_corporates' => $totalCorporates,
                    'total_employees' => $totalEmployees,
                    'total_meetings' => $totalMeetings,
                    'active_live_rooms' => $activeLiveRooms,
                ]
            ]
        ]);
    }

    /**
     * List all System Admins with custom permissions & settings
     */
    public function listAdmins(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user->isSuperAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Super Admin access required.'], 403);
        }

        $admins = User::where('role', 'admin')
            ->with(['setting', 'corporate'])
            ->withCount('subUsers')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'admins' => $admins,
            ]
        ]);
    }

    /**
     * Create a new System Admin with auto-initialized settings
     */
    public function createAdmin(Request $request): JsonResponse
    {
        $superAdmin = $request->user();
        if (!$superAdmin->isSuperAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. Super Admin access required.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'designation' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'website_url' => 'nullable|string|max:255',
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'account_type' => 'corporate',
            'admin_id' => $superAdmin->id,
            'is_verified' => true,
            'permissions' => $validated['permissions'] ?? ['manage_corporates', 'view_reports', 'manage_users'],
            'designation' => $validated['designation'] ?? 'System Administrator',
            'email_verified_at' => now(),
        ]);

        // Auto-initialize Setting with cloned Super Admin data and custom website_url
        $setting = Setting::cloneFromSuperAdmin($admin->id, $validated['website_url'] ?? null);

        return response()->json([
            'status' => 'success',
            'message' => 'System Admin created successfully with auto-initialized settings.',
            'data' => [
                'admin' => $admin->load('setting'),
            ]
        ], 201);
    }

    /**
     * Update permissions for a System Admin
     */
    public function updatePermissions(Request $request, int $id): JsonResponse
    {
        $superAdmin = $request->user();
        if (!$superAdmin->isSuperAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $admin = User::where('role', 'admin')->findOrFail($id);
        $validated = $request->validate([
            'permissions' => 'required|array',
            'designation' => 'nullable|string|max:255',
        ]);

        $admin->update([
            'permissions' => $validated['permissions'],
            'designation' => $validated['designation'] ?? $admin->designation,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Admin permissions updated successfully.',
            'data' => [
                'admin' => $admin->fresh(),
            ]
        ]);
    }
}
