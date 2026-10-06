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
     * Export executive financial report to Excel with Full Table Formatting (.xls)
     */
    public function exportExcel(Request $request)
    {
        $data = $this->gatherReportData($request);

        $filename = 'Laporan_Keuangan_District_Studio_' . Carbon::now()->format('Ymd_His') . '.xls';

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->view('reports.excel_owner', $data, 200, $headers);
    }

    /**
     * Internal helper to collect filtered report data (supports day, month, year, presets)
     */
    public function gatherReportData(Request $request): array
    {
        $preset = $request->input('preset');
        $month = $request->input('month');
        $year = $request->input('year');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $specificDate = $request->input('date');

        // Apply Date Filtering Logic
        if ($preset === 'today') {
            $startDate = Carbon::today()->format('Y-m-d');
            $endDate = Carbon::today()->format('Y-m-d');
            $periodLabel = 'Hari Ini (' . Carbon::today()->translatedFormat('d F Y') . ')';
        } elseif ($preset === 'yesterday') {
            $startDate = Carbon::yesterday()->format('Y-m-d');
            $endDate = Carbon::yesterday()->format('Y-m-d');
            $periodLabel = 'Kemarin (' . Carbon::yesterday()->translatedFormat('d F Y') . ')';
        } elseif ($preset === 'this_week') {
            $startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
            $endDate = Carbon::now()->endOfWeek()->format('Y-m-d');
            $periodLabel = 'Minggu Ini (' . Carbon::parse($startDate)->translatedFormat('d M') . ' - ' . Carbon::parse($endDate)->translatedFormat('d M Y') . ')';
        } elseif ($preset === 'this_month') {
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
            $periodLabel = 'Bulan Ini (' . Carbon::now()->translatedFormat('F Y') . ')';
        } elseif ($preset === 'last_month') {
            $startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
            $periodLabel = 'Bulan Lalu (' . Carbon::now()->subMonth()->translatedFormat('F Y') . ')';
        } elseif ($preset === 'this_year') {
            $startDate = Carbon::now()->startOfYear()->format('Y-m-d');
            $endDate = Carbon::now()->endOfYear()->format('Y-m-d');
            $periodLabel = 'Tahun Ini (' . Carbon::now()->format('Y') . ')';
        } elseif ($month && $year) {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->format('Y-m-d');
            $periodLabel = 'Bulan ' . Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');
        } elseif ($year && !$month) {
            $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear()->format('Y-m-d');
            $endDate = Carbon::createFromDate($year, 12, 31)->endOfYear()->format('Y-m-d');
            $periodLabel = 'Tahun ' . $year;
        } elseif ($specificDate) {
            $startDate = $specificDate;
            $endDate = $specificDate;
            $periodLabel = 'Tanggal ' . Carbon::parse($specificDate)->translatedFormat('d F Y');
        } elseif ($startDate && $endDate) {
            $periodLabel = Carbon::parse($startDate)->translatedFormat('d F Y') . ' s/d ' . Carbon::parse($endDate)->translatedFormat('d F Y');
        } else {
            $periodLabel = 'Seluruh Periode Operasional (All Time)';
        }

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
            'endDate',
            'month',
            'year',
            'preset',
            'specificDate'
        );
    }
}
