<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CorporateEmployeeController extends Controller
{
    /**
     * List all employees under the Corporate Organization
     */
    public function listEmployees(Request $request): JsonResponse
    {
        $admin = $request->user();
        if (!$admin->isCorporateEmployee() && !$admin->isAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $corporateId = $admin->corporate_id;
        $query = User::where('role', 'corporate_employee');

        if ($corporateId) {
            $query->where('corporate_id', $corporateId);
        }

        $employees = $query->with('corporate')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'employees' => $employees,
            ]
        ]);
    }

    /**
     * Create a new Corporate Employee / Host under the Corporate Organization
     */
    public function createEmployee(Request $request): JsonResponse
    {
        $admin = $request->user();
        if (!$admin->isCorporateEmployee() && !$admin->isAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'designation' => 'nullable|string|max:255',
            'corporate_id' => 'nullable|exists:corporates,id',
        ]);

        $corporateId = $validated['corporate_id'] ?? $admin->corporate_id;

        $employee = User::create([
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role' => 'corporate_employee',
            'account_type' => 'corporate',
            'corporate_id' => $corporateId,
            'admin_id' => $admin->id,
            'designation' => $validated['designation'] ?? 'Corporate Host',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Corporate employee created successfully.',
            'data' => [
                'employee' => $employee->load('corporate'),
            ]
        ], 201);
    }

    /**
     * Toggle meeting hosting privileges for an employee
     */
    public function toggleHosting(Request $request, int $id): JsonResponse
    {
        $admin = $request->user();
        if (!$admin->isCorporateEmployee() && !$admin->isAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $employee = User::where('role', 'corporate_employee')->findOrFail($id);
        $employee->update([
            'is_verified' => !$employee->is_verified,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Employee hosting privilege updated successfully.',
            'data' => [
                'employee' => $employee->fresh(),
            ]
        ]);
    }
}
