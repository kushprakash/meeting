<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Passbook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Get user wallet details & balance from Passbook
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        // Get balance from last passbook row where user_id order by id desc
        $lastPassbook = Passbook::where('user_id', $user->id)->latest('id')->first();
        $balance = $lastPassbook ? (float)$lastPassbook->balance : 0.00;

        $history = Passbook::where('user_id', $user->id)
            ->latest('id')
            ->take(30)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'wallet_balance' => $balance,
                'balance' => $balance,
                'transactions' => $history,
                'passbook' => $history,
            ]
        ]);
    }

    /**
     * Add money to user wallet creating a CR entry in Passbook
     */
    public function addMoney(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:100000',
            'details' => 'nullable|string',
        ]);

        $user = $request->user();
        $amount = (float)$validated['amount'];

        // Get pre_balance from last passbook row
        $lastPassbook = Passbook::where('user_id', $user->id)->latest('id')->first();
        $preBalance = $lastPassbook ? (float)$lastPassbook->balance : 0.00;
        $newBalance = $preBalance + $amount;

        $passbook = Passbook::create([
            'user_id' => $user->id,
            'details' => $validated['details'] ?? 'Added Money to Wallet',
            'type' => 'CR',
            'pre_balance' => $preBalance,
            'amount' => $amount,
            'balance' => $newBalance,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '₹' . number_format($amount, 2) . ' added to wallet successfully!',
            'data' => [
                'user' => $user->fresh(),
                'wallet_balance' => $newBalance,
                'balance' => $newBalance,
                'transaction' => $passbook,
                'passbook' => $passbook,
            ]
        ]);
    }

    /**
     * Passbook / Wallet transaction history
     */
    public function history(Request $request): JsonResponse
    {
        $user = $request->user();

        $lastPassbook = Passbook::where('user_id', $user->id)->latest('id')->first();
        $balance = $lastPassbook ? (float)$lastPassbook->balance : 0.00;

        $history = Passbook::where('user_id', $user->id)->latest('id')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'wallet_balance' => $balance,
                'balance' => $balance,
                'transactions' => $history,
                'passbook' => $history,
            ]
        ]);
    }
}
