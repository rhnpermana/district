<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PettyCash;
use App\Models\SystemLog;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    // ======================================================================
    // PRIVATE HELPERS
    // ======================================================================

    /**
     * Validate voucher code and calculate discount against a given subtotal.
     * Returns ['voucher' => Voucher|null, 'discount' => float, 'error' => string|null]
     */
    private function validateAndApplyVoucher(?string $code, float $subtotal): array
    {
        if (empty($code)) {
            return ['voucher' => null, 'discount' => 0, 'error' => null];
        }

        $voucher = Voucher::where('code', strtoupper($code))
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhereDate('valid_until', '>=', now());
            })
            ->first();

        if (!$voucher) {
            return ['voucher' => null, 'discount' => 0, 'error' => "Voucher '{$code}' tidak valid atau sudah kadaluarsa."];
        }

        if ($subtotal < $voucher->min_spend) {
            return [
                'voucher'  => $voucher,
                'discount' => 0,
                'error'    => "Voucher '{$voucher->code}' memerlukan minimal belanja Rp " . number_format($voucher->min_spend, 0, ',', '.'),
            ];
        }

        $discount = $voucher->type === 'percent'
            ? ($subtotal * $voucher->discount_value) / 100
            : $voucher->discount_value;

        return ['voucher' => $voucher, 'discount' => $discount, 'error' => null];
    }

    /**
     * Calculate server-side subtotal from items array.
     */
    private function calculateSubtotal(array $items): float
    {
        return array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $items));
    }

    /**
     * Check stock availability for product items.
     * Returns null if OK, or an error string if insufficient.
     */
    private function checkStockAvailability(array $items): ?string
    {
        foreach ($items as $item) {
            if ($item['item_type'] === 'product' && !empty($item['item_id'])) {
                $prod = Product::find($item['item_id']);
                if (!$prod) {
                    return "Produk #{$item['item_id']} tidak ditemukan.";
                }
                if ($prod->stock < $item['quantity']) {
                    return "Stok produk '{$prod->name}' tidak mencukupi! (Tersisa: {$prod->stock}, Dipesan: {$item['quantity']}).";
                }
            }
        }
        return null;
    }

    /**
     * Persist transaction items and decrement product stock.
     */
    private function saveTransactionItems(Transaction $transaction, array $items): void
    {
        foreach ($items as $item) {
            $itemSubtotal = $item['price'] * $item['quantity'];
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'item_type'      => $item['item_type'],
                'item_id'        => $item['item_id'] ?? null,
                'item_name'      => $item['item_name'],
                'price'          => $item['price'],
                'quantity'       => $item['quantity'],
                'subtotal'       => $itemSubtotal,
            ]);

            if ($item['item_type'] === 'product' && !empty($item['item_id'])) {
                $prod = Product::find($item['item_id']);
                if ($prod) {
                    $prod->decrement('stock', $item['quantity']);
                }
            }
        }
    }

    /**
     * Mark booking as completed and award loyalty points to the customer.
     */
    private function completeBookingAndAwardPoints(?int $bookingId): void
    {
        if (!$bookingId) return;

        $booking = Booking::find($bookingId);
        if (!$booking) return;

        $booking->update(['status' => 'completed']);

        if ($booking->user) {
            $newPoints = ($booking->user->loyalty_points ?? 0) + 10;
            $newTier   = $newPoints >= 100 ? 'VIP Black Member' : ($newPoints >= 50 ? 'Gold Member' : 'Silver');
            $booking->user->update([
                'loyalty_points' => $newPoints,
                'member_tier'    => $newTier,
            ]);
        }
    }

    // ======================================================================
    // PUBLIC ACTIONS
    // ======================================================================

    /**
     * Process POS Transaction Checkout
     */
    public function checkout(Request $request)
    {
        // Flow: QRIS callback — transaction already created, just mark completed
        if ($request->filled('transaction_id')) {
            $transaction = Transaction::find($request->transaction_id);
            if ($transaction && $transaction->payment_status === 'paid') {
                foreach ($transaction->items as $item) {
                    if ($item->item_type === 'product' && !empty($item->item_id)) {
                        $prod = Product::find($item->item_id);
                        if ($prod) $prod->decrement('stock', $item->quantity);
                    }
                }

                return redirect()->route('dashboard')
                    ->with('success', 'Transaksi #POS-' . $transaction->id . ' Berhasil Diproses!')
                    ->with('receipt_id', $transaction->id)
                    ->with('active_tab', 'history');
            }
        }

        // Pre-sanitize items to prevent string 'null' or empty string validation failure
        $rawItems = $request->input('items', []);
        if (is_array($rawItems)) {
            foreach ($rawItems as $idx => $it) {
                if (isset($it['item_id'])) {
                    if ($it['item_id'] === 'null' || $it['item_id'] === 'undefined' || $it['item_id'] === '' || $it['item_id'] === null) {
                        $rawItems[$idx]['item_id'] = null;
                    } elseif (is_numeric($it['item_id'])) {
                        $rawItems[$idx]['item_id'] = (int) $it['item_id'];
                    }
                }
            }
            $request->merge(['items' => $rawItems]);
        }

        $request->validate([
            'customer_name'       => 'required|string|max:255',
            'payment_method'      => 'required|string|in:Cash,QRIS,E-Wallet,Debit/Credit Card',
            'subtotal'            => 'required|numeric|min:0',
            'voucher_code'        => 'nullable|string',
            'discount_amount'     => 'nullable|numeric|min:0',
            'final_amount'        => 'required|numeric|min:0',
            'booking_id'          => 'nullable|exists:bookings,id',
            'items'               => 'required|array|min:1',
            'items.*.item_type'   => 'required|string|in:service,product',
            'items.*.item_id'     => 'nullable|integer',
            'items.*.item_name'   => 'required|string',
            'items.*.price'       => 'required|numeric',
            'items.*.quantity'    => 'required|integer|min:1',
        ]);

        $cashier = Auth::user();

        // 1. Stock check
        $stockError = $this->checkStockAvailability($request->items);
        if ($stockError) {
            return back()->with('error', "Gagal Checkout: {$stockError}");
        }

        // 2. Server-side recalculation
        $calculatedSubtotal = $this->calculateSubtotal($request->items);

        // 3. Voucher validation
        $voucherResult = $this->validateAndApplyVoucher($request->voucher_code, $calculatedSubtotal);
        if ($voucherResult['error']) {
            return back()->with('error', $voucherResult['error']);
        }
        $discountAmount = $voucherResult['discount'];
        $finalAmount    = max(0, $calculatedSubtotal - $discountAmount);

        // Link customer_id from booking if available
        $customerId = null;
        if ($request->filled('booking_id')) {
            $linkedBooking = Booking::find($request->booking_id);
            if ($linkedBooking) {
                $customerId = $linkedBooking->user_id;
            }
        }

        // 4. Create transaction
        $transaction = Transaction::create([
            'booking_id'      => $request->booking_id,
            'cashier_id'      => $cashier->id,
            'customer_id'     => $customerId,
            'customer_name'   => $request->customer_name,
            'subtotal'        => $calculatedSubtotal,
            'discount_amount' => $discountAmount,
            'final_amount'    => $finalAmount,
            'payment_method'  => $request->payment_method,
            'payment_status'  => 'paid',
        ]);

        // 5. Save items & decrement stock
        $this->saveTransactionItems($transaction, $request->items);

        // 6. Complete booking & award points
        $this->completeBookingAndAwardPoints($request->booking_id);

        // 7. System log
        SystemLog::create([
            'user_id'    => $cashier->id,
            'action'     => 'POS Checkout',
            'details'    => "Kasir {$cashier->name} memproses transaksi #POS-{$transaction->id} (Total: Rp " . number_format($finalAmount, 0, ',', '.') . ") via {$request->payment_method}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Transaksi #POS-' . $transaction->id . ' Berhasil Diproses!')
            ->with('receipt_id', $transaction->id)
            ->with('active_tab', 'history');
    }

    /**
     * Generate Dynamic QRIS Charge for POS
     */
    public function generateQris(Request $request, MidtransService $midtransService)
    {
        // Pre-sanitize items
        $rawItems = $request->input('items', []);
        if (is_array($rawItems)) {
            foreach ($rawItems as $idx => $it) {
                if (isset($it['item_id'])) {
                    if ($it['item_id'] === 'null' || $it['item_id'] === 'undefined' || $it['item_id'] === '' || $it['item_id'] === null) {
                        $rawItems[$idx]['item_id'] = null;
                    } elseif (is_numeric($it['item_id'])) {
                        $rawItems[$idx]['item_id'] = (int) $it['item_id'];
                    }
                }
            }
            $request->merge(['items' => $rawItems]);
        }

        $request->validate([
            'customer_name'       => 'required|string|max:255',
            'subtotal'            => 'required|numeric|min:0',
            'voucher_code'        => 'nullable|string',
            'discount_amount'     => 'nullable|numeric|min:0',
            'final_amount'        => 'required|numeric|min:0',
            'booking_id'          => 'nullable|exists:bookings,id',
            'items'               => 'required|array|min:1',
            'items.*.item_type'   => 'required|string|in:service,product',
            'items.*.item_id'     => 'nullable|integer',
            'items.*.item_name'   => 'required|string',
            'items.*.price'       => 'required|numeric',
            'items.*.quantity'    => 'required|integer|min:1',
        ]);

        // 1. Stock check
        $stockError = $this->checkStockAvailability($request->items);
        if ($stockError) {
            return response()->json(['success' => false, 'message' => $stockError], 422);
        }

        $cashier = Auth::user();

        // 2. Server-side recalculation
        $calculatedSubtotal = $this->calculateSubtotal($request->items);

        // 3. Voucher validation
        $voucherResult = $this->validateAndApplyVoucher($request->voucher_code, $calculatedSubtotal);
        $discountAmount = $voucherResult['discount'];
        $finalAmount    = max(0, $calculatedSubtotal - $discountAmount);

        // 4. Create pending transaction
        $transaction = Transaction::create([
            'booking_id'      => $request->booking_id,
            'cashier_id'      => $cashier->id,
            'customer_name'   => $request->customer_name,
            'subtotal'        => $calculatedSubtotal,
            'discount_amount' => $discountAmount,
            'final_amount'    => $finalAmount,
            'payment_method'  => 'QRIS',
            'payment_status'  => 'pending',
        ]);

        foreach ($request->items as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'item_type'      => $item['item_type'],
                'item_id'        => $item['item_id'] ?? null,
                'item_name'      => $item['item_name'],
                'price'          => $item['price'],
                'quantity'       => $item['quantity'],
                'subtotal'       => $item['price'] * $item['quantity'],
            ]);
        }

        $transaction->load('items');

        // 5. Call Midtrans API
        $midtransResult = $midtransService->createQrisCharge($transaction);

        if (!$midtransResult['success']) {
            return response()->json([
                'success' => false,
                'message' => $midtransResult['message'] ?? 'Gagal membuat QRIS.',
            ], 422);
        }

        return response()->json([
            'success'        => true,
            'transaction_id' => $transaction->id,
            'order_id'       => $midtransResult['order_id'],
            'qr_url'         => $midtransResult['qr_url'],
            'qr_string'      => $midtransResult['qr_string'],
            'final_amount'   => $finalAmount,
        ]);
    }

    /**
     * Check transaction status for AJAX polling
     */
    public function checkStatus(Transaction $transaction)
    {
        return response()->json([
            'transaction_id' => $transaction->id,
            'payment_status' => $transaction->payment_status,
            'is_paid'        => $transaction->payment_status === 'paid',
        ]);
    }

    /**
     * AJAX: Search & filter transaction history
     */
    public function searchTransactions(Request $request)
    {
        $query  = Transaction::with(['items', 'cashier', 'booking'])->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('customer_name', 'like', "%{$q}%")
                    ->orWhere('id', 'like', "%{$q}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->limit(100)->get();

        return response()->json($transactions);
    }

    /**
     * Store Petty Cash Operational Expense
     */
    public function storePettyCash(Request $request)
    {
        $request->validate([
            'amount'       => 'required|numeric|min:1000',
            'category'     => 'required|string|max:255',
            'description'  => 'required|string',
            'expense_date' => 'required|date',
        ]);

        $cashier = Auth::user();

        PettyCash::create([
            'cashier_id'   => $cashier->id,
            'amount'       => $request->amount,
            'category'     => $request->category,
            'description'  => $request->description,
            'expense_date' => $request->expense_date,
        ]);

        SystemLog::create([
            'user_id'    => $cashier->id,
            'action'     => 'Petty Cash Record',
            'details'    => "Kasir {$cashier->name} mencatat kas kecil Rp " . number_format($request->amount, 0, ',', '.') . " untuk {$request->category}: {$request->description}",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Pengeluaran kas kecil berhasil dicatat!')->with('active_tab', 'pettycash');
    }

    /**
     * Void / Cancel a completed Transaction
     */
    public function voidTransaction(Request $request, Transaction $transaction)
    {
        $cashier = Auth::user();
        if (!in_array($cashier->role, ['kasir', 'admin', 'supervisor', 'owner'])) {
            abort(403, 'Akses ditolak.');
        }

        if ($transaction->payment_status === 'void') {
            return back()->with('error', "Transaksi #POS-{$transaction->id} sudah pernah dibatalkan (Void).");
        }

        // 1. Restore product stock
        foreach ($transaction->items as $item) {
            if ($item->item_type === 'product' && $item->item_id) {
                $product = Product::find($item->item_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
        }

        // 2. Restore booking status to 'approved' if this transaction was tied to a booking
        if ($transaction->booking_id) {
            $booking = Booking::find($transaction->booking_id);
            if ($booking && $booking->status === 'completed') {
                $booking->update(['status' => 'approved']);
            }
        }

        // 3. Mark transaction as void
        $transaction->update(['payment_status' => 'void']);

        SystemLog::create([
            'user_id'    => $cashier->id,
            'action'     => 'Void Transaction',
            'details'    => "Kasir {$cashier->name} membatalkan (Void) transaksi #POS-{$transaction->id} (Total: Rp " . number_format($transaction->final_amount, 0, ',', '.') . ")",
            'ip_address' => $request->ip(),
        ]);

        return back()
            ->with('success', "Transaksi #POS-{$transaction->id} berhasil dibatalkan (Void). Stok produk & status booking telah dipulihkan.")
            ->with('active_tab', 'history');
    }

    /**
     * Show Receipt Layout for Thermal Printing / WhatsApp sharing
     */
    public function receipt(Transaction $transaction)
    {
        $transaction->load(['items', 'cashier', 'booking']);
        return view('kasir.receipt', compact('transaction'));
    }
}
