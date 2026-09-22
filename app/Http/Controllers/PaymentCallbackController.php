<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Booking;
use App\Models\SystemLog;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Handle Midtrans Payment Notification Callback
     */
    public function handleNotification(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans Webhook Notification Received:', $payload);

        // 1. Verify Signature Key
        if (!$this->midtransService->verifySignature($payload)) {
            Log::warning('Midtrans Webhook Invalid Signature Key!');
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Order ID missing'], 400);
        }

        // 2. Find Transaction by midtrans_order_id or ID
        $transaction = Transaction::where('midtrans_order_id', $orderId)->first();
        if (!$transaction) {
            // Try extracting numeric transaction ID from order_id format (e.g. POS-123-1723456789)
            if (preg_match('/POS-(\d+)-/i', $orderId, $matches)) {
                $transaction = Transaction::find($matches[1]);
            }
        }

        if (!$transaction) {
            Log::error("Transaction not found for Order ID: {$orderId}");
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // 3. Process Status Updates
        if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
            // Payment Successful
            $transaction->update([
                'payment_status' => 'paid',
            ]);

            // Update associated booking if exists
            if ($transaction->booking_id) {
                $booking = Booking::find($transaction->booking_id);
                if ($booking) {
                    $booking->update(['status' => 'completed']);
                    if ($booking->user) {
                        $newPoints = ($booking->user->loyalty_points ?? 0) + 10;
                        $newTier = $newPoints >= 100 ? 'VIP Black Member' : ($newPoints >= 50 ? 'Gold Member' : 'Silver');
                        $booking->user->update([
                            'loyalty_points' => $newPoints,
                            'member_tier' => $newTier,
                        ]);
                    }
                }
            }

            SystemLog::create([
                'user_id' => $transaction->cashier_id,
                'action' => 'QRIS Payment Settlement',
                'details' => "Pembayaran QRIS untuk transaksi #POS-{$transaction->id} (Order: {$orderId}) LUNAS via Midtrans Webhook.",
                'ip_address' => $request->ip(),
            ]);

            Log::info("Transaction #POS-{$transaction->id} successfully marked as PAID via QRIS webhook.");

        } elseif ($transactionStatus === 'pending') {
            $transaction->update([
                'payment_status' => 'pending',
            ]);
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $transaction->update([
                'payment_status' => $transactionStatus === 'expire' ? 'expire' : 'failed',
            ]);

            SystemLog::create([
                'user_id' => $transaction->cashier_id,
                'action' => 'QRIS Payment ' . ucfirst($transactionStatus),
                'details' => "Pembayaran QRIS #POS-{$transaction->id} (Order: {$orderId}) {$transactionStatus}.",
                'ip_address' => $request->ip(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Notification processed successfully',
        ], 200);
    }
}
