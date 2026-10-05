<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\FundRequest;
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
     * Initiate Payment Gateway Order Request
     * POST /api/v1/wallet/initiate-payment
     */
    public function initiatePayment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = $request->user();
        $amount = (float)$validated['amount'];
        $refId = 'ORD_PG_' . time() . rand(1000, 9999);

        // 1. Create PENDING FundRequest record in database
        $fundRequest = FundRequest::create([
            'user_id' => $user->id,
            'reference_id' => $refId,
            'amount' => $amount,
            'status' => 'PENDING',
        ]);

        // 2. Prepare Payment Gateway Request Data
        $url = "https://icchhamatidataservice.com/api/pg/request";

        $postData = [
            "reference_id"  => $refId,
            "amount"        => $amount,
            "name"          => $user->name ?? 'User',
            "email"         => $user->email ?? 'user@bestrecharge.com',
            "mobile_number" => $user->phone ?? ($user->mobile_number ?? '9876543210'),
            "success_url"   => "https://vidbez.com/api/v1/wallet/callback/success",
            "failure_url"   => "https://vidbez.com/api/v1/wallet/callback/failure"
        ];

        $headers = [
            "Content-Type: application/json",
            "Accept: application/json",
            "mid: AGENT1603",
            "mkey: F0DUe9k9TiouekW3rwuZIJkwN1fa6Lsx",
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($postData),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
        ]);

        $responseStr = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment Gateway cURL Error: ' . $curlError,
            ], 500);
        }

        $resJson = json_decode($responseStr, true);

        $paymentUrl = $resJson['payment_url'] ?? ($resJson['data']['payment_url'] ?? null);

        // Extract access_key from payment_url (e.g. https://icchhamatidataservice.com/pg/checkout/{access_key})
        $accessKey = null;
        if ($paymentUrl) {
            $parts = explode('/checkout/', $paymentUrl);
            if (count($parts) > 1) {
                $accessKey = trim($parts[1]);
            }
        }
        if (!$accessKey) {
            $accessKey = is_string($resJson['data'] ?? null) 
                ? $resJson['data'] 
                : ($resJson['data']['access_key'] ?? ($resJson['access_key'] ?? null));
        }

        $st = $resJson['status'] ?? null;
        $isSuccess = ($st === 1 || $st === '1' || $st === true || strtolower((string)$st) === 'success') 
            || (!empty($accessKey) || !empty($paymentUrl));

        if (!$isSuccess) {
            $fundRequest->update([
                'status' => 'FAILED',
                'response_json' => $resJson,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $resJson['message'] ?? 'Payment Gateway Error: Unable to initiate payment',
                'data' => $resJson,
            ], 400);
        }

        $fundRequest->update([
            'payment_url' => $paymentUrl,
            'response_json' => $resJson,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => $resJson['message'] ?? 'Payment order created successfully',
            'data' => [
                'reference_id' => $refId,
                'order_id' => $refId,
                'access_key' => $accessKey,
                'payment_url' => $paymentUrl,
                'amount' => $amount,
                'status' => 'PENDING',
                'env' => 'prod',
            ]
        ]);
    }

    /**
     * Verify Payment Gateway Transaction & Add Funds to Wallet Passbook
     * POST /api/v1/wallet/verify-payment
     */
    public function verifyPayment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'txnid' => 'required|string',
        ]);

        $txnid = $validated['txnid'];
        $user = $request->user();

        // 1. Check if FundRequest exists in database
        $fundRequest = FundRequest::where('reference_id', $txnid)->first();
        if (!$fundRequest) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction record not found for ID: ' . $txnid,
            ], 404);
        }

        // Check if already completed to prevent duplicate credit
        if ($fundRequest->status === 'SUCCESS') {
            $lastPassbook = Passbook::where('user_id', $fundRequest->user_id)->latest('id')->first();
            $currentBal = $lastPassbook ? (float)$lastPassbook->balance : 0.00;

            return response()->json([
                'status' => 'success',
                'message' => 'Payment already verified and credited to wallet!',
                'data' => [
                    'txnid' => $txnid,
                    'status' => 'SUCCESS',
                    'balance' => $currentBal,
                ]
            ]);
        }

        // 2. Call External Verify API
        $url = "https://icchhamatidataservice.com/api/pg/verify";
        $postData = [
            "txnid" => $txnid,
        ];

        $headers = [
            "Content-Type: application/json",
            "Accept: application/json",
            "mid: AGENT1603",
            "mkey: F0DUe9k9TiouekW3rwuZIJkwN1fa6Lsx",
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($postData),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
        ]);

        $responseStr = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment Verification cURL Error: ' . $curlError,
            ], 500);
        }

        $resJson = json_decode($responseStr, true);

        // Check if status is success / SUCCESS
        $pgStatus = strtolower($resJson['data']['status'] ?? ($resJson['status'] ?? ''));

        if ($pgStatus === 'success' || $pgStatus === '1') {
            // Update FundRequest status to SUCCESS
            $fundRequest->update([
                'status' => 'SUCCESS',
                'response_json' => $resJson,
            ]);

            // Add money to user wallet creating CR Passbook entry
            $targetUserId = $fundRequest->user_id;
            $amount = (float)$fundRequest->amount;

            $lastPassbook = Passbook::where('user_id', $targetUserId)->latest('id')->first();
            $preBalance = $lastPassbook ? (float)$lastPassbook->balance : 0.00;
            $newBalance = $preBalance + $amount;

            $passbook = Passbook::create([
                'user_id' => $targetUserId,
                'details' => 'Added Money to Wallet (PG Ref: ' . $txnid . ')',
                'type' => 'CR',
                'pre_balance' => $preBalance,
                'amount' => $amount,
                'balance' => $newBalance,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment verified successfully! ₹' . number_format($amount, 2) . ' credited to wallet.',
                'data' => [
                    'txnid' => $txnid,
                    'status' => 'SUCCESS',
                    'amount' => $amount,
                    'balance' => $newBalance,
                    'passbook' => $passbook,
                ]
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $resJson['message'] ?? 'Payment verification failed or payment is pending.',
            'data' => $resJson,
        ], 400);
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
