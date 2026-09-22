<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected string $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY', ''));
        $this->clientKey = config('services.midtrans.client_key', env('MIDTRANS_CLIENT_KEY', ''));
        $this->isProduction = (bool) config('services.midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));
        
        $this->baseUrl = $this->isProduction
            ? 'https://api.midtrans.com/v2'
            : 'https://api.sandbox.midtrans.com/v2';
    }

    /**
     * Generate QRIS Charge via Midtrans Core API
     */
    public function createQrisCharge(Transaction $transaction): array
    {
        $orderId = 'POS-' . $transaction->id . '-' . time();
        $grossAmount = (int) round($transaction->final_amount);

        $payload = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'qris' => [
                'acquirer' => 'gopay',
            ],
            'customer_details' => [
                'first_name' => $transaction->customer_name ?? 'Pelanggan',
            ],
        ];

        // Include item details if available
        if ($transaction->relationLoaded('items') && $transaction->items->count() > 0) {
            $itemDetails = [];
            foreach ($transaction->items as $item) {
                $itemDetails[] = [
                    'id' => (string) ($item->item_id ?? $item->id),
                    'price' => (int) round($item->price),
                    'quantity' => (int) $item->quantity,
                    'name' => mb_strimwidth($item->item_name, 0, 50, '...'),
                ];
            }
            // Add discount if any
            if ($transaction->discount_amount > 0) {
                $itemDetails[] = [
                    'id' => 'DISCOUNT',
                    'price' => -(int) round($transaction->discount_amount),
                    'quantity' => 1,
                    'name' => 'Diskon Promo',
                ];
            }
            $payload['item_details'] = $itemDetails;
        }

        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/charge", $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                $qrString = $data['qr_string'] ?? null;
                $qrUrl = null;

                // Extract QR image URL from actions array if present
                if (isset($data['actions']) && is_array($data['actions'])) {
                    foreach ($data['actions'] as $action) {
                        if ($action['name'] === 'generate-qr-code') {
                            $qrUrl = $action['url'];
                            break;
                        }
                    }
                }

                // If qr_url is not provided directly by Midtrans actions, build standard QR server URL from qr_string
                if (!$qrUrl && $qrString) {
                    $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&margin=10&data=' . urlencode($qrString);
                }

                $transaction->update([
                    'midtrans_order_id' => $orderId,
                    'qris_url' => $qrUrl,
                    'qris_string' => $qrString,
                ]);

                return [
                    'success' => true,
                    'order_id' => $orderId,
                    'qr_url' => $qrUrl,
                    'qr_string' => $qrString,
                    'raw_response' => $data,
                ];
            }

            Log::error('Midtrans QRIS Charge Failed: ' . $response->body());
            return [
                'success' => false,
                'message' => $response->json('status_message') ?? 'Gagal membuat kode QRIS dari Payment Gateway.',
                'raw_response' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans QRIS Charge Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan koneksi ke Payment Gateway: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Verify Midtrans Callback Webhook Signature Key
     */
    public function verifySignature(array $payload): bool
    {
        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $signatureKey = $payload['signature_key'] ?? '';

        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
            return false;
        }

        $mySignature = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);
        return hash_equals($mySignature, $signatureKey);
    }
}
