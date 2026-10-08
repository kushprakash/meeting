<?php

use App\Http\Controllers\Api\V1\SocialAuthController;
use App\Models\Meeting;
use App\Models\MeetingParticipant;
use App\Models\Passbook;
use App\Models\Recharge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

$handleDeploy = function () {
    $fileInPublic = public_path('deploy.php');
    $fileInRoot = base_path('deploy.php');
    if (file_exists($fileInPublic)) {
        require $fileInPublic;
        exit;
    } elseif (file_exists($fileInRoot)) {
        require $fileInRoot;
        exit;
    }
    abort(404);
};

Route::get('/', function () use ($handleDeploy) {
    if (request()->has('token')) {
        $handleDeploy();
    }

    return view('welcome');
});

// Master Admin Panel Route with Real Database Integration
Route::get('/master', function () {
    // 1. Users real query
    $users = User::latest()->get();
    $totalUsers = $users->count();

    // 2. User Balances Aggregate
    $totalUserBalance = 0;
    foreach ($users as $u) {
        $totalUserBalance += $u->wallet_balance;
    }

    // 3. Meetings real query
    $meetings = Meeting::with(['host', 'participants.user'])->latest()->get();
    $totalMeetings = $meetings->count();
    $completedMeetings = Meeting::where('status', 'completed')->count();
    $scheduledMeetings = Meeting::where('status', 'scheduled')->count();
    $expiredMeetings = Meeting::whereIn('status', ['expired', 'cancelled'])->count();

    // 4. Recharges real query
    $recharges = Recharge::with('user')->latest()->take(100)->get();

    // 5. Passbooks real query
    $passbooks = Passbook::with('user')->latest()->take(100)->get();

    return view('master', compact(
        'users',
        'totalUsers',
        'totalUserBalance',
        'meetings',
        'totalMeetings',
        'completedMeetings',
        'scheduledMeetings',
        'expiredMeetings',
        'recharges',
        'passbooks'
    ));
});

// Master AJAX Endpoints for Real Admin Actions
Route::get('/master/meeting-participants/{id}', function ($id) {
    $meeting = Meeting::with(['participants.user', 'host'])->find($id);

    if (! $meeting) {
        return response()->json(['status' => 'error', 'message' => 'Meeting not found'], 404);
    }

    $participants = MeetingParticipant::where('meeting_id', $meeting->id)
        ->with('user')
        ->latest('id')
        ->get();

    return response()->json([
        'status' => 'success',
        'data' => [
            'meeting' => $meeting,
            'participants' => $participants,
            'total_joined' => $participants->count(),
            'total_revenue' => $participants->count() * (float) $meeting->price,
        ],
    ]);
});

Route::post('/master/add-fund', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|email',
        'amount' => 'required|numeric|min:1',
        'details' => 'nullable|string',
    ]);

    $user = User::where('email', strtolower(trim($validated['email'])))->first();
    if (! $user) {
        return response()->json(['status' => 'error', 'message' => 'User account not found'], 404);
    }

    $amount = (float) $validated['amount'];
    $details = $validated['details'] ?? 'Admin Manual Wallet Credit';

    $passbook = DB::transaction(function () use ($user, $amount, $details) {
        $lastPB = Passbook::where('user_id', $user->id)->latest('id')->lockForUpdate()->first();
        $preBalance = $lastPB ? (float) $lastPB->balance : 0.00;
        $newBalance = $preBalance + $amount;

        return Passbook::create([
            'user_id' => $user->id,
            'details' => $details,
            'type' => 'CR',
            'pre_balance' => $preBalance,
            'amount' => $amount,
            'balance' => $newBalance,
        ]);
    });

    return response()->json([
        'status' => 'success',
        'message' => "Successfully added ₹{$amount} to {$user->name}'s wallet.",
        'data' => ['passbook' => $passbook, 'new_balance' => $passbook->balance],
    ]);
});

Route::post('/master/create-user', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'phone' => 'nullable|string',
        'account_type' => 'required|in:free,corporate',
        'password' => 'required|string|min:6',
    ]);

    $role = ($validated['account_type'] === 'corporate') ? 'corporate_employee' : 'free_user';

    $user = User::create([
        'name' => $validated['name'],
        'email' => strtolower(trim($validated['email'])),
        'phone' => $validated['phone'] ?? null,
        'password' => Hash::make($validated['password']),
        'account_type' => $validated['account_type'],
        'role' => $role,
        'is_verified' => true,
        'email_verified_at' => now(),
    ]);

    return response()->json([
        'status' => 'success',
        'message' => "User {$user->name} created successfully!",
        'data' => ['user' => $user],
    ]);
});

Route::get('/deploy', $handleDeploy);
Route::get('/deploy.php', $handleDeploy);

Route::get('/meeting/{uuid}', function () {
    return view('welcome');
});

Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);
