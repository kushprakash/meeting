<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Passbook;
use App\Models\Recharge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RechargeController extends Controller
{
    private const BASE_URL = 'https://icchhamatidataservice.com/api/v2';

    private array $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
        'mid: AGENT1603',
        'mkey: F0DUe9k9TiouekW3rwuZIJkwN1fa6Lsx',
    ];

    /**
     * Private helper to execute cURL requests to API endpoints
     */
    private function callExternalApi(string $endpoint, array $postData = [], string $method = 'POST'): array
    {
        $url = rtrim(self::BASE_URL, '/').'/'.ltrim($endpoint, '/');

        $ch = curl_init($url);
        $options = [
            CURLOPT_HTTPHEADER => $this->headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 45,
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        if (strtoupper($method) === 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = json_encode($postData);
        } else {
            $options[CURLOPT_HTTPGET] = true;
        }

        curl_setopt_array($ch, $options);
        $responseStr = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return [
                'success' => false,
                'error' => 'cURL Error: '.$curlError,
                'data' => null,
            ];
        }

        $resJson = json_decode($responseStr, true);

        return [
            'success' => true,
            'error' => null,
            'data' => $resJson ?? [],
            'raw' => $responseStr,
        ];
    }

    /**
     * Helper to refund money to user passbook atomically
     */
    protected function refundUserWallet(int $userId, float $amount, string $details): ?Passbook
    {
        if ($amount <= 0) {
            return null;
        }

        return DB::transaction(function () use ($userId, $amount, $details) {
            $lastPassbook = Passbook::where('user_id', $userId)->latest('id')->lockForUpdate()->first();
            $preBalance = $lastPassbook ? (float) $lastPassbook->balance : 0.00;
            $newBalance = $preBalance + $amount;

            return Passbook::create([
                'user_id' => $userId,
                'details' => $details,
                'type' => 'CR',
                'pre_balance' => $preBalance,
                'amount' => $amount,
                'balance' => $newBalance,
            ]);
        });
    }

    /**
     * 1. Fetch Mobile Plans API
     * POST /api/v1/recharge/mobile-plans
     * Body: { "number": "9876543210" }
     */
    public function getMobilePlans(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'number' => 'required|string|min:10|max:12',
        ]);

        $apiResult = $this->callExternalApi('mobile-plan', [
            'number' => $validated['number'],
        ]);

        if (! $apiResult['success']) {
            return response()->json([
                'status' => 'error',
                'message' => $apiResult['error'],
            ], 500);
        }

        $resData = $apiResult['data'];

        return response()->json($resData);
    }

    /**
     * 2. Fetch Operators (For DTH or General Operators)
     * POST /api/v1/recharge/get-operator
     * Body: { "category": "DTH" }
     */
    public function getOperators(Request $request): JsonResponse
    {
        $category = $request->input('category', 'DTH');

        $apiResult = $this->callExternalApi('getOperator', [
            'category' => $category,
        ]);

        if (! $apiResult['success']) {
            return response()->json([
                'status' => 'error',
                'message' => $apiResult['error'],
            ], 500);
        }

        return response()->json($apiResult['data']);
    }

    /**
     * 3. Perform Mobile / DTH Recharge / Bill Payment
     * POST /api/v1/recharge/recharge
     * Request Body:
     * {
     *   "number": "9876543210",
     *   "operator": "AT",
     *   "circle": "2",
     *   "amount": 239,
     *   "type": 1  (1: Mobile, 2: DTH, 3: Bill Payment)
     * }
     */
    public function doRecharge(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'number' => 'nullable|string',
            'customer_id' => 'nullable|string',
            'operator' => 'nullable|string',
            'biller_code' => 'nullable|string',
            'circle' => 'nullable|string',
            'amount' => 'required|numeric|min:1',
            'type' => 'nullable|integer|in:1,2,3',
            'fetch_ref_id' => 'nullable|string',
            'bill_number' => 'nullable|string',
            'customer_name' => 'nullable|string',
            'due_date' => 'nullable|string',
        ]);

        $user = $request->user();
        $amount = (float) $validated['amount'];
        $type = (int) ($validated['type'] ?? 1);
        $orderId = 'REC'.date('YmdHis').rand(1000, 9999);
        // Map customer_id into number & biller_code into operator as per specification
        $number = $validated['number'] ?? ($validated['customer_id'] ?? null);
        $operator = $validated['operator'] ?? ($validated['biller_code'] ?? null);
        $circle = $validated['circle'] ?? '2';

        if (! $number || ! $operator) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please provide valid number/customer_id and operator/biller_code.',
            ], 422);
        }

        $typeLabel = $type === 2 ? 'DTH Recharge' : ($type === 3 ? 'Bill Payment' : 'Mobile Recharge');

        // Check wallet balance first
        $lastPassbook = Passbook::where('user_id', $user->id)->latest('id')->first();
        $currentBalance = $lastPassbook ? (float) $lastPassbook->balance : 0.00;

        if ($currentBalance < $amount) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient wallet balance! Please add money to your wallet.',
                'wallet_balance' => $currentBalance,
                'required_amount' => $amount,
            ], 400);
        }

        // Debit Wallet & Create Pending Recharge Record in DB Transaction
        try {
            $recharge = DB::transaction(function () use ($user, $amount, $type, $typeLabel, $number, $operator, $circle, $validated, $orderId) {
                $lastPassbook = Passbook::where('user_id', $user->id)->latest('id')->lockForUpdate()->first();
                $preBalance = $lastPassbook ? (float) $lastPassbook->balance : 0.00;

                if ($preBalance < $amount) {
                    throw new \Exception('Insufficient wallet balance during lock.');
                }

                $newBalance = $preBalance - $amount;

                // Create Passbook DR record
                Passbook::create([
                    'user_id' => $user->id,
                    'details' => "Debit for {$typeLabel} - {$number} ({$operator})",
                    'type' => 'DR',
                    'pre_balance' => $preBalance,
                    'amount' => $amount,
                    'balance' => $newBalance,
                ]);

                // Create Pending Recharge record
                return Recharge::create([
                    'user_id' => $user->id,
                    'order_id' => $orderId,
                    'number' => $number,
                    'operator' => $operator,
                    'circle' => $circle,
                    'amount' => $amount,
                    'type' => $type,
                    'status' => Recharge::STATUS_PENDING,
                    'status_text' => 'Pending',
                    'fetch_ref_id' => $validated['fetch_ref_id'] ?? null,
                    'bill_number' => $validated['bill_number'] ?? null,
                    'customer_name' => $validated['customer_name'] ?? null,
                    'due_date' => $validated['due_date'] ?? null,
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process transaction: '.$e->getMessage(),
            ], 400);
        }

        // Call Third-Party API (operator me biller_code jayega, number me customer_id jayega)
        $apiEndpoint = ($type === 3) ? 'bill-payment' : 'mobile-recharge';
        $postData = [
            'number' => $number,
            'operator' => $operator,
            'circle' => $circle,
            'amount' => $amount,
            'type' => $type,
            'transaction_id' => $orderId,
        ];

        $apiResult = $this->callExternalApi($apiEndpoint, $postData);

        if (! $apiResult['success']) {
            // API cURL failure -> Immediate Refund
            $recharge->update([
                'status' => Recharge::STATUS_FAILED,
                'status_text' => 'Failed',
                'res_text' => $apiResult['error'],
            ]);

            $refundPassbook = $this->refundUserWallet($user->id, $amount, "Refund for Failed {$typeLabel} #{$recharge->id} ({$number})");
            $latestBalance = $refundPassbook ? (float) $refundPassbook->balance : $currentBalance;

            return response()->json([
                'status' => 'error',
                'message' => 'Recharge API connection failed. Amount has been refunded to your wallet.',
                'error' => $apiResult['error'],
                'data' => [
                    'recharge' => $recharge->fresh(),
                    'wallet_balance' => $latestBalance,
                ],
            ], 500);
        }

        $resJson = $apiResult['data'];
        $resStatus = $resJson['status'] ?? null;
        $isSuccess = ($resStatus === 1 || $resStatus === '1' || strtolower((string) $resStatus) === 'success');

        if ($isSuccess) {
            $orderId = $resJson['data']['orderId'] ?? $recharge->order_id;
            $txnId = $resJson['data']['txnId'] ?? null;
            $resText = $resJson['data']['resText'] ?? $resJson['message'] ?? 'Recharge Successful';

            $recharge->update([
                'status' => Recharge::STATUS_SUCCESS,
                'status_text' => 'Success',
                'order_id' => $orderId,
                'txn_id' => $txnId,
                'res_text' => $resText,
                'response_json' => $resJson,
            ]);

            $lastPassbook = Passbook::where('user_id', $user->id)->latest('id')->first();
            $latestBalance = $lastPassbook ? (float) $lastPassbook->balance : 0.00;

            return response()->json([
                'status' => 'success',
                'message' => $resJson['message'] ?? "{$typeLabel} Successful",
                'data' => [
                    'recharge' => $recharge->fresh(),
                    'provider_response' => $resJson['data'] ?? $resJson,
                    'wallet_balance' => $latestBalance,
                ],
            ]);
        }

        // If status is failed (0) or error response -> Refund immediately in same function!
        $recharge->update([
            'status' => Recharge::STATUS_FAILED,
            'status_text' => 'Failed',
            'res_text' => $resJson['message'] ?? 'Recharge Failed',
            'response_json' => $resJson,
        ]);

        $refundPassbook = $this->refundUserWallet($user->id, $amount, "Refund for Failed {$typeLabel} #{$recharge->id} ({$number})");
        $latestBalance = $refundPassbook ? (float) $refundPassbook->balance : $currentBalance;

        return response()->json([
            'status' => 'error',
            'message' => $resJson['message'] ?? 'Recharge failed. Amount refunded to your wallet.',
            'data' => [
                'recharge' => $recharge->fresh(),
                'provider_response' => $resJson,
                'wallet_balance' => $latestBalance,
            ],
        ], 400);
    }

    /**
     * 4. Check Single Recharge Status
     * POST /api/v1/recharge/recharge-status
     * Body: { "txnid": "REC98172635" }
     */
    public function checkSingleStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'txnid' => 'required|string',
        ]);

        $txnid = $validated['txnid'];
        $recharge = Recharge::where('order_id', $txnid)
            ->orWhere('txn_id', $txnid)
            ->first();

        if (! $recharge) {
            return response()->json([
                'status' => 'error',
                'message' => 'Recharge record not found for transaction ID: '.$txnid,
            ], 404);
        }

        $endpoint = ($recharge->type === 3) ? 'bill-status' : 'recharge-status';
        $apiResult = $this->callExternalApi($endpoint, [
            'txnid' => $txnid,
        ]);

        if (! $apiResult['success']) {
            return response()->json([
                'status' => 'error',
                'message' => $apiResult['error'],
            ], 500);
        }

        $resJson = $apiResult['data'];
        $statusVal = $resJson['status'] ?? null;

        // Process status update logic: 0 = failed (refund), 1 = success (1% commission), 2 = pending
        $this->processStatusUpdate($recharge, $statusVal, $resJson);

        return response()->json([
            'status' => 'success',
            'message' => $resJson['message'] ?? 'Recharge status checked successfully',
            'data' => [
                'recharge' => $recharge->fresh(),
                'provider_response' => $resJson,
            ],
        ]);
    }

    /**
     * 5. Cron / Guest Function: Check All Pending Recharges & Process Refunds / Commissions
     * GET/POST /api/v1/recharge/cron-check-status
     * Guest / Cron executable route
     */
    public function checkPendingStatus(): JsonResponse
    {
        $pendingRecharges = Recharge::where('status', Recharge::STATUS_PENDING)->get();

        $processedCount = 0;
        $successCount = 0;
        $failedCount = 0;
        $pendingCount = 0;

        foreach ($pendingRecharges as $recharge) {
            $txnid = $recharge->order_id ?: $recharge->txn_id;
            if (! $txnid) {
                continue;
            }

            $endpoint = ($recharge->type === 3) ? 'bill-status' : 'recharge-status';
            $apiResult = $this->callExternalApi($endpoint, [
                'txnid' => $txnid,
            ]);

            if (! $apiResult['success']) {
                continue;
            }

            $resJson = $apiResult['data'];
            $statusVal = $resJson['status'] ?? null;

            $resultStatus = $this->processStatusUpdate($recharge, $statusVal, $resJson);
            $processedCount++;

            if ($resultStatus === Recharge::STATUS_SUCCESS) {
                $successCount++;
            } elseif ($resultStatus === Recharge::STATUS_FAILED) {
                $failedCount++;
            } else {
                $pendingCount++;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cron pending recharge status check completed',
            'data' => [
                'total_pending_found' => count($pendingRecharges),
                'processed' => $processedCount,
                'success' => $successCount,
                'failed' => $failedCount,
                'still_pending' => $pendingCount,
            ],
        ]);
    }

    /**
     * Helper to process status update for a recharge model:
     * status 0 => Failed & Refund
     * status 1 => Success & 1% Commission Credit
     * status 2 => Still Pending
     */
    private function processStatusUpdate(Recharge $recharge, mixed $statusVal, array $resJson): int
    {
        // Convert statusVal to integer if numeric
        $numericStatus = is_numeric($statusVal) ? (int) $statusVal : null;
        $strStatus = strtolower((string) $statusVal);

        if ($numericStatus === 0 || $strStatus === 'failed' || $strStatus === '0') {
            // Status 0: FAILED -> Refund if was not already failed
            if ($recharge->status !== Recharge::STATUS_FAILED) {
                $recharge->update([
                    'status' => Recharge::STATUS_FAILED,
                    'status_text' => 'Failed',
                    'res_text' => $resJson['message'] ?? 'Recharge Failed',
                    'response_json' => $resJson,
                ]);

                $typeLabel = $recharge->type === 2 ? 'DTH Recharge' : ($recharge->type === 3 ? 'Bill Payment' : 'Mobile Recharge');
                $this->refundUserWallet($recharge->user_id, $recharge->amount, "Refund for Failed {$typeLabel} #{$recharge->id} ({$recharge->number})");
            }

            return Recharge::STATUS_FAILED;
        }

        if ($numericStatus === 1 || $strStatus === 'success' || $strStatus === '1') {
            // Status 1: SUCCESS -> Update status and credit 1% commission
            $recharge->update([
                'status' => Recharge::STATUS_SUCCESS,
                'status_text' => 'Success',
                'res_text' => $resJson['message'] ?? 'Recharge Success',
                'response_json' => $resJson,
            ]);

            // Credit 1% commission if not credited yet
            if (! $recharge->commission_status && $recharge->amount > 0) {
                $commission = round($recharge->amount * 0.01, 2);

                if ($commission > 0) {
                    DB::transaction(function () use ($recharge, $commission) {
                        $lastPassbook = Passbook::where('user_id', $recharge->user_id)->latest('id')->lockForUpdate()->first();
                        $preBalance = $lastPassbook ? (float) $lastPassbook->balance : 0.00;
                        $newBalance = $preBalance + $commission;

                        Passbook::create([
                            'user_id' => $recharge->user_id,
                            'details' => "1% Commission Cashback for Recharge #{$recharge->id}",
                            'type' => 'CR',
                            'pre_balance' => $preBalance,
                            'amount' => $commission,
                            'balance' => $newBalance,
                        ]);

                        $recharge->update([
                            'commission_amount' => $commission,
                            'commission_status' => true,
                        ]);
                    });
                }
            }

            return Recharge::STATUS_SUCCESS;
        }

        // Status 2 or other: STILL PENDING
        $recharge->update([
            'response_json' => $resJson,
        ]);

        return Recharge::STATUS_PENDING;
    }

    /**
     * 6. Bill Categories API
     * GET /api/v1/recharge/bill-categories
     */
    public function getBillCategories(): JsonResponse
    {
        $apiResult = $this->callExternalApi('bill-categories', [], 'GET');

        if (! $apiResult['success']) {
            return response()->json([
                'status' => 'error',
                'message' => $apiResult['error'],
            ], 500);
        }

        return response()->json($apiResult['data']);
    }

    /**
     * 7. Billers By Category API
     * POST /api/v1/recharge/billers-by-category
     * Body: { "category": "Electric" }
     */
    public function getBillersByCategory(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category' => 'required|string',
        ]);

        $apiResult = $this->callExternalApi('billers-by-category', [
            'category' => $validated['category'],
        ]);

        if (! $apiResult['success']) {
            return response()->json([
                'status' => 'error',
                'message' => $apiResult['error'],
            ], 500);
        }

        return response()->json($apiResult['data']);
    }

    /**
     * 8. Fetch Bill API
     * POST /api/v1/recharge/fetch-bill
     * Body:
     * {
     *   "biller_code": "BSES0001",
     *   "customer_id": "100012345"
     * }
     */
    public function fetchBill(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'biller_code' => 'required|string',
            'customer_id' => 'required|string',
        ]);

        $apiResult = $this->callExternalApi('fetch-bill', [
            'biller_code' => $validated['biller_code'],
            'customer_id' => $validated['customer_id'],
        ]);

        if (! $apiResult['success']) {
            return response()->json([
                'status' => 'error',
                'message' => $apiResult['error'],
            ], 500);
        }

        return response()->json($apiResult['data']);
    }

    /**
     * 9. Bill Payment Status Check
     * POST /api/v1/recharge/bill-status
     * Body: { "txnid": "REC98172635" }
     */
    public function getBillStatus(Request $request): JsonResponse
    {
        return $this->checkSingleStatus($request);
    }

    /**
     * 10. User Recharge & Bill Payment History
     * GET /api/v1/recharge/history
     */
    public function history(Request $request): JsonResponse
    {
        $user = $request->user();

        $history = Recharge::where('user_id', $user->id)
            ->latest('id')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'recharges' => $history,
            ],
        ]);
    }
}
