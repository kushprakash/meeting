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
    // 1. Users query
    $users = User::latest()->get();
    $totalUsers = $users->count();

    // 2. User Balances Aggregate
    $totalUserBalance = 0;
    foreach ($users as $u) {
        $totalUserBalance += $u->wallet_balance;
    }

    // 3. Meetings & Meeting Entry Fees
    $meetings = Meeting::with(['host', 'participants.user'])->latest()->get();
    $totalMeetings = $meetings->count();

    $totalMeetingEntryFee = (float) Passbook::where('type', 'DR')->where('details', 'like', '%Meeting Entry Fee%')->sum('amount');

    // 4. Recharges & Bill Payments Debit Aggregates
    $debitMobileRecharge = (float) Recharge::where('type', 1)->where('status', 1)->sum('amount');
    $debitDthRecharge = (float) Recharge::where('type', 2)->where('status', 1)->sum('amount');
    $debitBillPayment = (float) Recharge::where('type', 3)->where('status', 1)->sum('amount');

    // 5. Total Add Fund (Total CR in Passbooks)
    $totalAddFund = (float) Passbook::where('type', 'CR')->sum('amount');

    // 6. Recent Logs
    $recharges = Recharge::with('user')->latest()->take(100)->get();
    $passbooks = Passbook::with('user')->latest()->take(100)->get();

    return view('master', compact(
        'users',
        'totalUsers',
        'totalUserBalance',
        'totalMeetingEntryFee',
        'debitMobileRecharge',
        'debitDthRecharge',
        'debitBillPayment',
        'totalAddFund',
        'meetings',
        'totalMeetings',
        'recharges',
        'passbooks'
    ));
});

// Master AJAX Endpoint: Fetch Meeting Participants
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

// Master AJAX Endpoint: Fetch Specific User Passbook History
Route::get('/master/user-passbook/{user_id}', function ($userId) {
    $user = User::find($userId);
    if (! $user) {
        return response()->json(['status' => 'error', 'message' => 'User account not found'], 404);
    }

    $passbooks = Passbook::where('user_id', $user->id)->latest('id')->get();

    return response()->json([
        'status' => 'success',
        'data' => [
            'user' => $user,
            'passbooks' => $passbooks,
            'wallet_balance' => $user->wallet_balance,
        ],
    ]);
});

// Master AJAX Endpoint: Add Fund to User Wallet
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

// Master AJAX Endpoint: Create User
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

// Master AJAX Endpoint: Edit User
Route::post('/master/edit-user', function (Request $request) {
    $validated = $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$request->user_id,
        'phone' => 'nullable|string',
        'account_type' => 'required|in:free,corporate',
        'password' => 'nullable|string|min:6',
    ]);

    $user = User::findOrFail($validated['user_id']);
    $role = ($validated['account_type'] === 'corporate') ? 'corporate_employee' : 'free_user';

    $updateData = [
        'name' => $validated['name'],
        'email' => strtolower(trim($validated['email'])),
        'phone' => $validated['phone'] ?? null,
        'account_type' => $validated['account_type'],
        'role' => $role,
    ];

    if (! empty($validated['password'])) {
        $updateData['password'] = Hash::make($validated['password']);
    }

    $user->update($updateData);

    return response()->json([
        'status' => 'success',
        'message' => "User {$user->name} updated successfully!",
        'data' => ['user' => $user->fresh()],
    ]);
});

Route::get('/deploy', $handleDeploy);
Route::get('/deploy.php', $handleDeploy);

Route::get('/meeting/{uuid}', function () {
    return view('welcome');
});

Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);
