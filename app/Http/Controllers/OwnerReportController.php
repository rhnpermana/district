<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PettyCash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OwnerReportController extends Controller
{
    /**
     * Display formal printable/PDF executive report
     */
    public function printFormal(Request $request)
    {
        $data = $this->gatherReportData($request);
        return view('reports.executive_formal', $data);
    }

    /**
     * Export executive financial report to Excel (.csv format with UTF-8 BOM)
     */
    public function exportExcel(Request $request)
    {
        $data = $this->gatherReportData($request);

        $filename = 'Laporan_Keuangan_District_Studio_' . Carbon::now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return new StreamedResponse(function () use ($data) {
            $handle = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header Section
            fputcsv($handle, ['DISTRICT STUDIO BARBERSHOP & GROOMING']);
            fputcsv($handle, ['LAPORAN EKSEKUTIF KEUANGAN & OPERASIONAL']);
            fputcsv($handle, ['Alamat', 'District Studio Jakarta Barat (SMKN 17 Slipi)']);
            fputcsv($handle, ['Periode Laporan', $data['periodLabel']]);
            fputcsv($handle, ['Tanggal Cetak', Carbon::now()->translatedFormat('d F Y, H:i') . ' WIB']);
            fputcsv($handle, ['Dicetak Oleh', auth()->user()->name . ' (' . ucfirst(auth()->user()->role) . ')']);
            fputcsv($handle, []);

            // 1. Ringkasan Finansial
            fputcsv($handle, ['=== 1. RINGKASAN METRIK FINANSIAL ===']);
            fputcsv($handle, ['Indikator', 'Nominal (Rp)']);
            fputcsv($handle, ['Total Omzet Kotor (Gross Revenue)', number_format($data['grossOmzet'], 0, ',', '.')]);
            fputcsv($handle, ['  - Pendapatan Layanan Pangkas & Treatment', number_format($data['serviceRevenue'], 0, ',', '.')]);
            fputcsv($handle, ['  - Pendapatan Penjualan Produk Grooming', number_format($data['productRevenue'], 0, ',', '.')]);
            fputcsv($handle, ['Total Beban Operasional (Petty Cash)', number_format($data['totalPettyCash'], 0, ',', '.')]);
            fputcsv($handle, ['Total Beban Pembagian Komisi Hair Stylist', number_format($data['totalCommissions'], 0, ',', '.')]);
            fputcsv($handle, ['PROFIT BERSIH (NET PROFIT)', number_format($data['netProfit'], 0, ',', '.')]);
            fputcsv($handle, []);

            // 2. Laporan Komisi Hair Stylist
            fputcsv($handle, ['=== 2. LAPORAN PRODUKTIVITAS & KOMISI HAIR STYLIST ===']);
            fputcsv($handle, ['No', 'Nama Hair Stylist', 'Sesi Pangkas Selesai', 'Total Omzet Dikerjakan (Rp)', 'Rate Komisi (%)', 'Hak Komisi Bersih (Rp)']);
            $no = 1;
            foreach ($data['stylists'] as $s) {
                fputcsv($handle, [
                    $no++,
                    $s->name,
                    $s->completed_count . ' Sesi',
                    number_format($s->total_revenue, 0, ',', '.'),
                    ($s->commission_rate ?? 30) . '%',
                    number_format($s->total_commission, 0, ',', '.'),
                ]);
            }
            fputcsv($handle, ['TOTAL KOMISI KAPSTER', '', '', '', '', number_format($data['totalCommissions'], 0, ',', '.')]);
            fputcsv($handle, []);

            // 3. Rincian Pengeluaran Petty Cash
            fputcsv($handle, ['=== 3. RINCIAN PENGELUARAN PETTY CASH (KAS KECIL) ===']);
            fputcsv($handle, ['No', 'Tanggal', 'Kategori', 'Deskripsi Pengeluaran', 'Kasir / Petugas', 'Nominal (Rp)']);
            $noPc = 1;
            foreach ($data['pettyCashes'] as $pc) {
                fputcsv($handle, [
                    $noPc++,
                    $pc->expense_date ? Carbon::parse($pc->expense_date)->format('d/m/Y') : $pc->created_at->format('d/m/Y'),
                    $pc->category ?? 'Operasional',
                    $pc->description,
                    $pc->cashier->name ?? 'Kasir',
                    number_format($pc->amount, 0, ',', '.'),
                ]);
            }
            fputcsv($handle, ['TOTAL PENGELUARAN PETTY CASH', '', '', '', '', number_format($data['totalPettyCash'], 0, ',', '.')]);
            fputcsv($handle, []);

            // 4. Rincian Transaksi Pembayaran
            fputcsv($handle, ['=== 4. DAFTAR TRANSAKSI PEMBAYARAN & POS ===']);
            fputcsv($handle, ['No', 'ID Transaksi', 'Waktu Transaksi', 'Nama Pelanggan', 'Metode Pembayaran', 'Status Pembayaran', 'Total Nominal (Rp)']);
            $noTrx = 1;
            foreach ($data['transactions'] as $trx) {
                fputcsv($handle, [
                    $noTrx++,
                    'TRX-' . str_pad($trx->id, 5, '0', STR_PAD_LEFT),
                    $trx->created_at->format('d/m/Y H:i'),
                    $trx->customer_name ?? ($trx->customer->name ?? 'Pelanggan Walk-in'),
                    strtoupper($trx->payment_method ?? 'CASH'),
                    strtoupper($trx->payment_status ?? 'PAID'),
                    number_format($trx->final_amount, 0, ',', '.'),
                ]);
            }
            fputcsv($handle, ['TOTAL TRANSAKSI', '', '', '', '', '', number_format($data['transactions']->sum('final_amount'), 0, ',', '.')]);

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Internal helper to collect filtered report data
     */
    private function gatherReportData(Request $request): array
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $bookingQuery = Booking::with(['user', 'stylist']);
        $transactionQuery = Transaction::with(['items', 'cashier', 'customer']);
        $pettyCashQuery = PettyCash::with('cashier');

        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();

            $bookingQuery->whereBetween('booking_date', [$startDate, $endDate]);
            $transactionQuery->whereBetween('created_at', [$start, $end]);
            $pettyCashQuery->where(function ($q) use ($startDate, $endDate, $start, $end) {
                $q->whereBetween('expense_date', [$startDate, $endDate])
                  ->orWhereBetween('created_at', [$start, $end]);
            });

            $periodLabel = Carbon::parse($startDate)->translatedFormat('d F Y') . ' s/d ' . Carbon::parse($endDate)->translatedFormat('d F Y');
        } else {
            $periodLabel = 'Seluruh Periode Operasional (All Time)';
        }

        $bookings = $bookingQuery->orderBy('booking_date', 'desc')->get();
        $transactions = $transactionQuery->orderBy('created_at', 'desc')->get();
        $pettyCashes = $pettyCashQuery->orderBy('created_at', 'desc')->get();

        // Revenue calculations
        $serviceRevenue = $bookings->where('status', 'completed')->sum('price');
        $productRevenue = 0;
        foreach ($transactions as $t) {
            foreach ($t->items as $item) {
                if ($item->item_type === 'product') {
                    $productRevenue += ($item->price * $item->quantity);
                }
            }
        }
        $grossOmzet = $transactions->sum('final_amount') + $serviceRevenue;
        if ($grossOmzet == 0) {
            $grossOmzet = $serviceRevenue + $productRevenue;
        }

        $totalPettyCash = $pettyCashes->sum('amount');

        // Barber commissions
        $stylists = User::where('role', 'hair stylist')->get()->map(function ($stylist) use ($bookings) {
            $assignedCompleted = $bookings->where('stylist_id', $stylist->id)->where('status', 'completed');
            $stylist->completed_count = $assignedCompleted->count();
            $stylist->total_revenue = $assignedCompleted->sum('price');
            $rate = $stylist->commission_rate ?? 30;
            $stylist->total_commission = ($stylist->total_revenue * $rate) / 100;
            return $stylist;
        })->sortByDesc('completed_count');

        $totalCommissions = $stylists->sum('total_commission');
        $netProfit = max(0, $grossOmzet - $totalPettyCash - $totalCommissions);

        return compact(
            'bookings',
            'transactions',
            'pettyCashes',
            'stylists',
            'grossOmzet',
            'serviceRevenue',
            'productRevenue',
            'totalPettyCash',
            'totalCommissions',
            'netProfit',
            'periodLabel',
            'startDate',
            'endDate'
        );
    }
}
