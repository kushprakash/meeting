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
        $balance = $lastPassbook ? (float) $lastPassbook->balance : 0.00;

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
            ],
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
        $amount = (float) $validated['amount'];
        $refId = 'ORD_PG_'.time().rand(1000, 9999);

        // 1. Create PENDING FundRequest record in database
        $fundRequest = FundRequest::create([
            'user_id' => $user->id,
            'reference_id' => $refId,
            'amount' => $amount,
            'status' => 'PENDING',
        ]);

        // 2. Prepare Payment Gateway Request Data
        $url = 'https://icchhamatidataservice.com/api/pg/request';

        $postData = [
            'reference_id' => $refId,
            'amount' => $amount,
            'name' => $user->name ?? 'User',
            'email' => $user->email ?? 'user@bestrecharge.com',
            'mobile_number' => $user->phone ?? ($user->mobile_number ?? '9876543210'),
            'success_url' => 'https://icchhamatidataservice.com/api/v1/wallet/callback/success',
            'failure_url' => 'https://icchhamatidataservice.com/api/v1/wallet/callback/failure',
        ];

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'mid: AGENT1603',
            'mkey: F0DUe9k9TiouekW3rwuZIJkwN1fa6Lsx',
        ];

        $initiateRequestData = [
            'url' => $url,
            'header' => $headers,
            'headers' => $headers,
            'request' => $postData,
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $responseStr = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            $fundRequest->update([
                'status' => 'FAILED',
                'iniciate_request_data' => $initiateRequestData,
                'iniciate_response_data' => ['curl_error' => $curlError],
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment Gateway cURL Error: '.$curlError,
            ], 500);
        }

        $resJson = json_decode($responseStr, true) ?? ['raw_response' => $responseStr];
        $initiateResponseData = $resJson;

        $paymentUrl = $resJson['payment_url'] ?? ($resJson['data']['payment_url'] ?? null);

        // Extract access_key from payment_url (e.g. https://icchhamatidataservice.com/pg/checkout/{access_key})
        $accessKey = $resJson['access_key'] ?? null;
        if ($accessKey == null) {
            $parts = explode('/checkout/', $paymentUrl);
            if (count($parts) > 1) {
                $accessKey = trim($parts[1]);
            }
        }
        if ($accessKey == null) {
            $accessKey = is_string($resJson['data'] ?? null)
                ? $resJson['data']
                : ($resJson['data']['access_key'] ?? ($resJson['access_key'] ?? null));
        }

        $st = $resJson['status'] ?? null;
        $isSuccess = ($st === 1 || $st === '1' || $st === true || strtolower((string) $st) === 'success')
            || (! empty($accessKey) || ! empty($paymentUrl));

        if (! $isSuccess) {
            $fundRequest->update([
                'status' => 'FAILED',
                'response_json' => $resJson,
                'iniciate_request_data' => $initiateRequestData,
                'iniciate_response_data' => $initiateResponseData,
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
            'iniciate_request_data' => $initiateRequestData,
            'iniciate_response_data' => $initiateResponseData,
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
                'row_data' => $resJson,
            ],
        ]);
    }

    /**
     * Verify Payment Gateway Transaction & Add Funds to Wallet Passbook
     * Supports both POST and GET methods via query param order_id/txnid/reference_id or route param order_id.
     * GET /api/v1/wallet/verify-payment?order_id={order_id}
     * GET /api/v1/wallet/verify-status/{order_id}
     * POST /api/v1/wallet/verify-payment
     */
    public function verifyPayment(Request $request, ?string $order_id = null): JsonResponse
    {
        $txnid = $order_id
            ?? $request->input('order_id')
            ?? $request->input('txnid')
            ?? $request->input('reference_id');

        if (! $txnid) {
            return response()->json([
                'status' => 'error',
                'message' => 'The order_id or txnid parameter is required.',
            ], 422);
        }

        // 1. Check if FundRequest exists in database
        $fundRequest = FundRequest::where('reference_id', $txnid)->first();
        if (! $fundRequest) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction record not found for ID: '.$txnid,
            ], 404);
        }

        // Check if already completed to prevent duplicate credit
        if ($fundRequest->status === 'SUCCESS') {
            $lastPassbook = Passbook::where('user_id', $fundRequest->user_id)->latest('id')->first();
            $currentBal = $lastPassbook ? (float) $lastPassbook->balance : 0.00;

            return response()->json([
                'status' => 'success',
                'message' => 'Payment already verified and credited to wallet!',
                'data' => [
                    'order_id' => $txnid,
                    'txnid' => $txnid,
                    'reference_id' => $txnid,
                    'status' => 'SUCCESS',
                    'balance' => $currentBal,
                    'verify_request_data' => $fundRequest->verify_request_data,
                    'verify_response_data' => $fundRequest->verify_response_data,
                ],
            ]);
        }

        // 2. Call External Verify API
        $url = 'https://icchhamatidataservice.com/api/pg-pending/'.$txnid;
        $postData = [
            'txnid' => $txnid,
        ];

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'mid: AGENT1603',
            'mkey: F0DUe9k9TiouekW3rwuZIJkwN1fa6Lsx',
        ];

        $verifyRequestData = [
            'url' => $url,
            'header' => $headers,
            'headers' => $headers,
            'request' => $postData,
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPGET => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $responseStr = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            $fundRequest->update([
                'verify_request_data' => $verifyRequestData,
                'verify_response_data' => ['curl_error' => $curlError],
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment Verification cURL Error: '.$curlError,
            ], 500);
        }

        $resJson = json_decode($responseStr, true) ?? ['raw_response' => $responseStr];
        $verifyResponseData = $resJson;

        // Check if status is success / SUCCESS
        $pgStatus = strtolower($resJson['data']['status'] ?? ($resJson['status'] ?? ''));

        if ($pgStatus === 'success' || $pgStatus === '1') {
            // Update FundRequest status to SUCCESS & save verify request/response data
            $fundRequest->update([
                'status' => 'SUCCESS',
                'response_json' => $resJson,
                'verify_request_data' => $verifyRequestData,
                'verify_response_data' => $verifyResponseData,
            ]);

            // Add money to user wallet creating CR Passbook entry
            $targetUserId = $fundRequest->user_id;
            $amount = (float) $fundRequest->amount;

            $lastPassbook = Passbook::where('user_id', $targetUserId)->latest('id')->first();
            $preBalance = $lastPassbook ? (float) $lastPassbook->balance : 0.00;
            $newBalance = $preBalance + $amount;

            $passbook = Passbook::create([
                'user_id' => $targetUserId,
                'details' => 'Added Money to Wallet (PG Ref: '.$txnid.')',
                'type' => 'CR',
                'pre_balance' => $preBalance,
                'amount' => $amount,
                'balance' => $newBalance,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment verified successfully! ₹'.number_format($amount, 2).' credited to wallet.',
                'data' => [
                    'order_id' => $txnid,
                    'txnid' => $txnid,
                    'reference_id' => $txnid,
                    'status' => 'SUCCESS',
                    'amount' => $amount,
                    'balance' => $newBalance,
                    'passbook' => $passbook,
                    'verify_request_data' => $verifyRequestData,
                    'verify_response_data' => $verifyResponseData,
                ],
            ]);
        }

        $newStatus = (str_contains($pgStatus, 'cancel') || str_contains(strtolower($resJson['message'] ?? ''), 'cancel'))
            ? 'CANCELLED'
            : 'FAILED';

        $fundRequest->update([
            'status' => $newStatus,
            'response_json' => $resJson,
            'verify_request_data' => $verifyRequestData,
            'verify_response_data' => $verifyResponseData,
        ]);

        return response()->json([
            'status' => 'error',
            'message' => $resJson['message'] ?? ($newStatus === 'CANCELLED' ? 'Payment was cancelled' : 'Payment verification failed'),
            'data' => $resJson,
            'verify_request_data' => $verifyRequestData,
            'verify_response_data' => $verifyResponseData,
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
        $amount = (float) $validated['amount'];

        // Get pre_balance from last passbook row
        $lastPassbook = Passbook::where('user_id', $user->id)->latest('id')->first();
        $preBalance = $lastPassbook ? (float) $lastPassbook->balance : 0.00;
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
            'message' => '₹'.number_format($amount, 2).' added to wallet successfully!',
            'data' => [
                'user' => $user->fresh(),
                'wallet_balance' => $newBalance,
                'balance' => $newBalance,
                'transaction' => $passbook,
                'passbook' => $passbook,
            ],
        ]);
    }

    /**
     * Passbook / Wallet transaction history
     */
    public function history(Request $request): JsonResponse
    {
        $user = $request->user();

        $lastPassbook = Passbook::where('user_id', $user->id)->latest('id')->first();
        $balance = $lastPassbook ? (float) $lastPassbook->balance : 0.00;

        $history = Passbook::where('user_id', $user->id)->latest('id')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'wallet_balance' => $balance,
                'balance' => $balance,
                'transactions' => $history,
                'passbook' => $history,
            ],
        ]);
    }
}
