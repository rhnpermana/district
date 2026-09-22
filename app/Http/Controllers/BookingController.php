<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\ClientNote;
use App\Models\Transaction;
use App\Models\PettyCash;
use App\Models\WorkShift;
use App\Models\Complaint;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show the dashboard view based on user role.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'owner':
                return $this->ownerDashboard();

            case 'supervisor':
                return $this->supervisorDashboard($request);

            case 'admin':
                return $this->adminDashboard($request);

            case 'kasir':
                return $this->kasirDashboard();

            case 'receptionist':
                return $this->receptionistDashboard();

            case 'hair stylist':
                return $this->stylistDashboard();

            case 'customer':
            default:
                return $this->customerDashboard();
        }
    }

    /**
     * Owner Dashboard Data
     */
    private function ownerDashboard()
    {
        $bookings = Booking::with(['user', 'stylist'])->orderBy('booking_date', 'desc')->orderBy('booking_time', 'desc')->get();
        $users = User::all();
        $transactions = Transaction::with('items')->get();
        $pettyCashes = PettyCash::all();

        // Calculate financial metrics
        $grossOmzet = $transactions->sum('final_amount') + $bookings->where('status', 'completed')->sum('price');
        $totalPettyCash = $pettyCashes->sum('amount');
        
        // Calculate Barber Commissions
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

        // Branch performance comparison
        $branches = ['Jakarta Kebayoran Baru', 'Bandung Citarum'];
        $branchStats = [];
        foreach ($branches as $bName) {
            $bBookings = $bookings->where('branch', $bName);
            $bCompleted = $bBookings->where('status', 'completed');
            $bRevenue = $bCompleted->sum('price');
            $branchStats[$bName] = [
                'total' => $bBookings->count(),
                'completed' => $bCompleted->count(),
                'revenue' => $bRevenue,
            ];
        }

        // Peak hours analytics
        $peakHours = Booking::selectRaw('booking_time, count(*) as count')
            ->groupBy('booking_time')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $staffCounts = [
            'supervisor' => $users->where('role', 'supervisor')->count(),
            'admin' => $users->where('role', 'admin')->count(),
            'kasir' => $users->where('role', 'kasir')->count(),
            'receptionist' => $users->where('role', 'receptionist')->count(),
            'hair stylist' => $users->where('role', 'hair stylist')->count(),
            'customer' => $users->where('role', 'customer')->count(),
        ];

        return view('dashboards.owner', compact('bookings', 'users', 'grossOmzet', 'netProfit', 'totalPettyCash', 'totalCommissions', 'branchStats', 'stylists', 'peakHours', 'staffCounts'));
    }

    /**
     * Supervisor Dashboard Data
     */
    private function supervisorDashboard(Request $request)
    {
        $selectedBranch = $request->query('branch', 'all');

        $query = Booking::with(['user', 'stylist']);
        if ($selectedBranch !== 'all') {
            $query->where('branch', $selectedBranch);
        }
        $bookings = $query->orderBy('booking_date', 'desc')->orderBy('booking_time', 'desc')->get();

        $today = Carbon::today()->toDateString();
        $todayBookings = Booking::where('booking_date', $today)->get();

        $products = Product::orderBy('stock', 'asc')->get();
        $staffMembers = User::whereIn('role', ['receptionist', 'kasir', 'hair stylist'])->get();
        $workShifts = WorkShift::with('user')->where('shift_date', '>=', $today)->orderBy('shift_date', 'asc')->get();
        $complaints = Complaint::with(['customer', 'booking'])->orderBy('created_at', 'desc')->get();

        $stylists = User::where('role', 'hair stylist')->get()->map(function ($stylist) use ($todayBookings) {
            $stylist->today_count = $todayBookings->where('stylist_id', $stylist->id)->count();
            $stylist->today_completed = $todayBookings->where('stylist_id', $stylist->id)->where('status', 'completed')->count();
            return $stylist;
        });

        return view('dashboards.supervisor', compact('bookings', 'stylists', 'products', 'staffMembers', 'workShifts', 'complaints', 'selectedBranch', 'todayBookings'));
    }

    /**
     * Admin Dashboard Data
     */
    private function adminDashboard(Request $request)
    {
        $search = $request->query('search');
        $roleFilter = $request->query('role_filter');
        $statusFilter = $request->query('status_filter');

        $usersQuery = User::query();
        if ($roleFilter) {
            $usersQuery->where('role', $roleFilter);
        }
        if ($search) {
            $usersQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $users = $usersQuery->orderBy('created_at', 'desc')->get();

        $bookingsQuery = Booking::with(['user', 'stylist']);
        if ($statusFilter) {
            $bookingsQuery->where('status', $statusFilter);
        }
        $bookings = $bookingsQuery->orderBy('booking_date', 'desc')->orderBy('booking_time', 'desc')->get();

        $stylists = User::where('role', 'hair stylist')->get();
        $services = Service::orderBy('category')->orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $vouchers = Voucher::orderBy('created_at', 'desc')->get();
        $systemLogs = SystemLog::with('user')->orderBy('created_at', 'desc')->limit(50)->get();
        $complaints = Complaint::with(['customer', 'booking'])->orderBy('created_at', 'desc')->get();
        $workShifts = WorkShift::with('user')->orderBy('shift_date', 'desc')->limit(50)->get();
        $staffMembers = User::whereIn('role', ['owner', 'supervisor', 'admin', 'kasir', 'receptionist', 'hair stylist'])->get();

        // Summary KPI Metrics for Admin
        $kpiStats = [
            'total_users' => User::count(),
            'total_staff' => User::where('role', '!=', 'customer')->count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'low_stock_products' => Product::whereColumn('stock', '<=', 'min_stock')->count(),
            'active_vouchers' => Voucher::where('is_active', true)->count(),
            'pending_complaints' => Complaint::where('status', 'pending')->count(),
        ];

        return view('dashboards.admin', compact(
            'users', 'bookings', 'stylists', 'services', 'products', 'vouchers',
            'systemLogs', 'complaints', 'workShifts', 'staffMembers', 'kpiStats',
            'search', 'roleFilter', 'statusFilter'
        ));
    }

    /**
     * Kasir Dashboard Data — Optimized with direct DB queries
     */
    private function kasirDashboard()
    {
        $today     = Carbon::today();
        $yesterday = Carbon::yesterday();

        // ── Bookings yang sudah lunas dibayar ──
        $paidBookingIds = Transaction::whereNotNull('booking_id')
            ->where('payment_status', 'paid')
            ->pluck('booking_id')
            ->toArray();

        // ── Bookings (ambil hari ini & ke depan untuk kasir) ──
        $bookings = Booking::with(['user', 'stylist'])
            ->where('booking_date', '>=', $today->toDateString())
            ->orderBy('booking_date', 'asc')
            ->orderBy('booking_time', 'asc')
            ->get();

        // ── Antrean Booking Hari Ini untuk Tab Monitor & Kasir ──
        $todayQueue = Booking::with(['user', 'stylist'])
            ->where('booking_date', $today->toDateString())
            ->orderBy('booking_time', 'asc')
            ->get()
            ->map(function ($b) use ($paidBookingIds) {
                $b->is_paid = in_array($b->id, $paidBookingIds);
                return $b;
            });

        // Booking aktif (pending/approved/in_progress/completed) yang BELUM lunas untuk POS selector
        $allActiveBookings = Booking::with(['user', 'stylist'])
            ->whereIn('status', ['pending', 'approved', 'arrived', 'in_progress', 'completed'])
            ->whereNotIn('id', $paidBookingIds)
            ->where('booking_date', '>=', Carbon::now()->subDays(7)->toDateString())
            ->orderByRaw("booking_date = '{$today->toDateString()}' DESC")
            ->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'asc')
            ->get();

        $todayBookings = $bookings->where('booking_date', $today->toDateString());

        // ── Transaction breakdown hari ini ──
        $todayTransactions = Transaction::whereDate('created_at', $today)
            ->where('payment_status', 'paid')
            ->get();
        $todayIncome  = $todayTransactions->sum('final_amount');
        $cashToday    = $todayTransactions->where('payment_method', 'Cash')->sum('final_amount');
        $qrisToday    = $todayTransactions->where('payment_method', 'QRIS')->sum('final_amount');
        $ewalletToday = $todayTransactions->where('payment_method', 'E-Wallet')->sum('final_amount');
        $cardToday    = $todayTransactions->where('payment_method', 'Debit/Credit Card')->sum('final_amount');

        // ── Perbandingan dengan kemarin ──
        $yesterdayIncome = Transaction::whereDate('created_at', $yesterday)
            ->where('payment_status', 'paid')
            ->sum('final_amount');

        // ── Chart: Revenue 7 hari terakhir ──
        $weeklyRevenue = collect();
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $dayTrx = Transaction::whereDate('created_at', $day->toDateString())
                ->where('payment_status', 'paid');
            $weeklyRevenue->push([
                'date'        => $day->toDateString(),
                'label'       => $day->format('D, d M'),
                'short_label' => $day->format('d/m'),
                'amount'      => (float) $dayTrx->sum('final_amount'),
                'count'       => (int) $dayTrx->count(),
            ]);
        }

        // ── Pending checkout count (antrean hari ini yang belum lunas) ──
        $pendingPaymentCount = $todayQueue->where('is_paid', false)->count();

        $totalIncome = Transaction::where('payment_status', 'paid')->sum('final_amount');

        $stylists  = User::where('role', 'hair stylist')->get();
        $services  = Service::where('is_active', true)->get();
        $products  = Product::where('stock', '>', 0)->get();
        $vouchers  = Voucher::where('is_active', true)->get();

        // ── Petty Cash: semua catatan + summary per kategori ──
        $pettyCashes           = PettyCash::with('cashier')->orderBy('expense_date', 'desc')->get();
        $todayPettyCash        = PettyCash::whereDate('expense_date', $today)->sum('amount');
        $pettyCashByCategory   = PettyCash::selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // ── Riwayat Transaksi (50 terbaru) ──
        $recentTransactions = Transaction::with(['items', 'cashier', 'booking'])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('dashboards.kasir', compact(
            'bookings', 'allActiveBookings', 'todayBookings', 'todayQueue',
            'todayIncome', 'yesterdayIncome',
            'cashToday', 'qrisToday', 'ewalletToday', 'cardToday',
            'totalIncome', 'pendingPaymentCount',
            'stylists', 'services', 'products', 'vouchers',
            'pettyCashes', 'todayPettyCash', 'pettyCashByCategory',
            'recentTransactions', 'weeklyRevenue'
        ));
    }

    /**
     * Receptionist Dashboard Data
     */
    private function receptionistDashboard()
    {
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();

        $bookings = Booking::with(['user', 'stylist'])
            ->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'asc')
            ->get();

        $todayQueue = $bookings->where('booking_date', $today)->sortBy('booking_time');
        $tomorrowQueue = $bookings->where('booking_date', $tomorrow)->sortBy('booking_time');
        $pendingBookings = $bookings->where('status', 'pending');
        $stylists = User::where('role', 'hair stylist')->get();
        $services = Service::where('is_active', true)->get();

        return view('dashboards.receptionist', compact('bookings', 'todayQueue', 'tomorrowQueue', 'pendingBookings', 'stylists', 'services'));
    }

    /**
     * Hair Stylist Dashboard Data
     */
    private function stylistDashboard()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $bookings = Booking::where('stylist_id', $user->id)
            ->with('user')
            ->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'asc')
            ->get();

        $todaySchedule = $bookings->where('booking_date', $today);
        $upcomingSchedule = $bookings->where('booking_date', '>', $today);
        $completedCount = $bookings->where('status', 'completed')->count();

        // Calculate earnings & commissions
        $rate = $user->commission_rate ?? 30;
        $dailyEarnings = $todaySchedule->where('status', 'completed')->sum('price');
        $dailyCommission = ($dailyEarnings * $rate) / 100;

        $monthlyEarnings = $bookings->where('status', 'completed')->sum('price');
        $monthlyCommission = ($monthlyEarnings * $rate) / 100;

        $reviews = Review::where('stylist_id', $user->id)->with('customer')->orderBy('created_at', 'desc')->get();
        $avgRating = $reviews->avg('rating') ?: 5.0;
        $portfolios = Portfolio::where('stylist_id', $user->id)->get();

        $clients = User::where('role', 'customer')->get();
        $clientNotes = ClientNote::where('stylist_id', $user->id)->with('customer')->get();

        return view('dashboards.hair_stylist', compact('bookings', 'todaySchedule', 'upcomingSchedule', 'completedCount', 'dailyCommission', 'monthlyCommission', 'reviews', 'avgRating', 'portfolios', 'clients', 'clientNotes'));
    }

    /**
     * Customer Dashboard Data
     */
    private function customerDashboard()
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)
            ->with(['stylist', 'stylist.portfolios'])
            ->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'desc')
            ->get();

        $stylists = User::where('role', 'hair stylist')->with('portfolios')->get();
        $services = Service::where('is_active', true)->get();
        $vouchers = Voucher::where('is_active', true)->get();

        // Active booking for live queue
        $activeBooking = $bookings->whereIn('status', ['pending', 'approved', 'arrived'])->first();

        return view('dashboards.customer', compact('bookings', 'stylists', 'services', 'vouchers', 'activeBooking'));
    }

    /**
     * Store a newly created booking (Customer / Receptionist).
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch' => 'required|string',
            'service' => 'required|string',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|string',
            'stylist_id' => 'nullable|exists:users,id',
        ]);

        $bookingDate = $request->booking_date;
        $bookingTime = $request->booking_time;
        $stylistId = $request->stylist_id;

        // Smart Slot Validation / Collision check
        if ($stylistId) {
            $existing = Booking::where('booking_date', $bookingDate)
                ->where('booking_time', $bookingTime)
                ->where('stylist_id', $stylistId)
                ->whereIn('status', ['pending', 'approved'])
                ->first();

            if ($existing) {
                return back()->withErrors(['booking_time' => "Kapster yang dipilih sudah memiliki jadwal pada jam {$bookingTime}. Silakan pilih waktu/kapster lain."])->withInput();
            }
        }

        // Generate Queue Number (e.g. A-004)
        $todayCount = Booking::where('booking_date', $bookingDate)->count() + 1;
        $queueNumber = 'A-' . str_pad($todayCount, 3, '0', STR_PAD_LEFT);

        // Handle haircut model chosen by customer
        $serviceText = $request->service;
        if ($request->filled('haircut_model') && $request->haircut_model !== 'none' && $request->haircut_model !== '') {
            $serviceText = "[Model: " . trim($request->haircut_model) . "] " . $request->service;
        }

        // Extract numeric price
        $price = 75000;
        if (preg_match('/IDR\s*([\d\.]+)/i', $serviceText, $m)) {
            $price = (float) str_replace('.', '', $m[1]);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'branch' => $request->branch,
            'service' => $serviceText,
            'booking_date' => $bookingDate,
            'booking_time' => $bookingTime,
            'status' => 'pending',
            'stylist_id' => $stylistId,
            'queue_number' => $queueNumber,
            'type' => 'online',
            'price' => $price,
        ]);

        $waText = "Halo District Studio, saya ingin membuat reservasi jadwal potong rambut:\n\n*Nama:* " . Auth::user()->name . "\n*No. Antrean:* " . $queueNumber . "\n*Cabang:* " . $booking->branch . "\n*Layanan:* " . $booking->service . "\n*Tanggal & Waktu:* " . $booking->booking_date . " pada " . $booking->booking_time . "\n\nTerima kasih!";
        $waUrl = "https://api.whatsapp.com/send?phone=6281234567890&text=" . urlencode($waText);

        return redirect()->route('dashboard')
            ->with('success', "Reservasi Berhasil Dibuat! Nomor Antrean Anda: {$queueNumber}")
            ->with('wa_url', $waUrl)
            ->with('booking_summary', "Cabang: {$booking->branch} | Layanan: {$booking->service} | Jadwal: {$booking->booking_date} pada {$booking->booking_time}");
    }

    /**
     * Receptionist Store Walk-in Customer into Queue
     */
    public function storeWalkin(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'branch' => 'required|string',
            'service' => 'required|string',
            'booking_time' => 'required|string',
            'stylist_id' => 'nullable|exists:users,id',
        ]);

        $today = Carbon::today()->toDateString();
        $bookingTime = $request->booking_time;
        $stylistId = $request->stylist_id;

        // Smart Slot Check against online bookings
        if ($stylistId) {
            $conflict = Booking::where('booking_date', $today)
                ->where('booking_time', $bookingTime)
                ->where('stylist_id', $stylistId)
                ->whereIn('status', ['pending', 'approved'])
                ->first();

            if ($conflict) {
                return back()->withErrors(['booking_time' => "BENTROK! Slot {$bookingTime} untuk Kapster ini sudah dipesan oleh booking online (#{$conflict->queue_number}). Pilih slot jam lain."])->withInput();
            }
        }

        // Find or create customer user record
        $customerUser = User::where('name', $request->customer_name)->first();
        if (!$customerUser) {
            $customerUser = User::create([
                'name' => $request->customer_name,
                'email' => 'walkin_' . time() . '@district.com',
                'phone' => $request->customer_phone,
                'password' => bcrypt('walkin123'),
                'role' => 'customer',
            ]);
        }

        // Queue number
        $todayCount = Booking::where('booking_date', $today)->count() + 1;
        $queueNumber = 'W-' . str_pad($todayCount, 3, '0', STR_PAD_LEFT);

        // Handle haircut model chosen if available
        $serviceText = $request->service;
        if ($request->filled('haircut_model') && $request->haircut_model !== 'none' && $request->haircut_model !== '') {
            $serviceText = "[Model: " . trim($request->haircut_model) . "] " . $request->service;
        }

        $price = 75000;
        if (preg_match('/IDR\s*([\d\.]+)/i', $serviceText, $m)) {
            $price = (float) str_replace('.', '', $m[1]);
        }

        $booking = Booking::create([
            'user_id' => $customerUser->id,
            'branch' => $request->branch,
            'service' => $serviceText,
            'booking_date' => $today,
            'booking_time' => $bookingTime,
            'status' => 'pending',
            'stylist_id' => $stylistId,
            'queue_number' => $queueNumber,
            'type' => 'walkin',
            'arrived_at' => now(),
            'price' => $price,
        ]);

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Walk-in Queue Added',
            'details' => "Receptionist menginput antrean walk-in '{$request->customer_name}' (Antrean #{$queueNumber})",
            'ip_address' => $request->ip(),
        ]);

        $waUrl = null;
        if ($request->customer_phone) {
            $phone = preg_replace('/[^0-9]/', '', $request->customer_phone);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }
            $waMsg = "Halo Kak {$request->customer_name}, selamat datang di District Studio!\n\n"
                   . "Nomor antrean Anda telah terdaftar: *{$queueNumber}*\n"
                   . "• Cabang: {$booking->branch}\n"
                   . "• Layanan: {$booking->service}\n"
                   . "• Waktu: {$bookingTime} WIB\n"
                   . "• Stylist: " . ($stylistId ? User::find($stylistId)?->name : 'Sesuai Giliran') . "\n\n"
                   . "Silakan menunggu sejenak di ruang tunggu. Kami akan memanggil Anda ketika giliran tiba. Terima kasih!";
            $waUrl = "https://wa.me/{$phone}?text=" . urlencode($waMsg);
        }

        return back()
            ->with('success', "Antrean Walk-in #{$queueNumber} atas nama {$request->customer_name} berhasil didaftarkan ke antrean!")
            ->with('wa_url', $waUrl);
    }

    /**
     * Receptionist Confirm Arrival (Check-in)
     */
    public function markArrival(Booking $booking)
    {
        $booking->update([
            'arrived_at' => now(),
            'status' => 'approved',
        ]);

        return back()->with('success', "Kedatangan Pelanggan #{$booking->queue_number} ({$booking->user->name}) Telah Dikonfirmasi!");
    }

    /**
     * Update Booking status and assign stylist
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $user = Auth::user();

        if ($user->role === 'hair stylist') {
            if ($booking->stylist_id && $booking->stylist_id !== $user->id) {
                abort(403, 'Akses ditolak.');
            }
            $request->validate(['status' => 'required|string|in:approved,in_progress,completed']);
            
            // Auto update stylist work_status if in_progress
            if ($request->status === 'in_progress') {
                $user->update(['work_status' => 'On Duty']);
            } elseif ($request->status === 'completed') {
                $user->update(['work_status' => 'Available']);
            }

            $booking->update([
                'status' => $request->status,
                'stylist_id' => $user->id,
            ]);

            $statusText = match($request->status) {
                'in_progress' => 'SEDANG DI CUKUR',
                'completed' => 'SELESAI DIPOTONG',
                default => strtoupper($request->status)
            };

            return back()->with('success', "Status antrean #{$booking->queue_number} diperbarui ke {$statusText}!");
        }

        if (!in_array($user->role, ['owner', 'supervisor', 'admin', 'kasir', 'receptionist'])) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'status' => 'required|string|in:pending,approved,in_progress,completed,cancelled',
            'stylist_id' => 'nullable|exists:users,id',
        ]);

        $booking->update([
            'status' => $request->status,
            'stylist_id' => $request->stylist_id ?? $booking->stylist_id,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Detail reservasi pelanggan #' . $booking->id . ' berhasil diperbarui.');
    }

    /**
     * Customer 1-Click Rebook
     */
    public function rebook(Booking $booking)
    {
        $user = Auth::user();
        if ($booking->user_id !== $user->id) {
            abort(403);
        }

        $today = Carbon::today()->toDateString();
        $todayCount = Booking::where('booking_date', $today)->count() + 1;
        $queueNumber = 'R-' . str_pad($todayCount, 3, '0', STR_PAD_LEFT);

        $newBooking = Booking::create([
            'user_id' => $user->id,
            'branch' => $booking->branch,
            'service' => $booking->service,
            'booking_date' => $today,
            'booking_time' => '14:00',
            'status' => 'pending',
            'stylist_id' => $booking->stylist_id,
            'queue_number' => $queueNumber,
            'type' => 'online',
            'price' => $booking->price,
        ]);

        return redirect()->route('dashboard')->with('success', "1-Click Rebook Berhasil! Reservasi baru dibuat dengan nomor antrean {$queueNumber}.");
    }

    /**
     * Customer Submit Rating & Review
     */
    public function storeReview(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $user = Auth::user();
        $booking = Booking::findOrFail($request->booking_id);

        Review::create([
            'booking_id' => $booking->id,
            'customer_id' => $user->id,
            'stylist_id' => $booking->stylist_id ?? 1,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih atas rating dan ulasan yang Anda berikan!');
    }

    /**
     * Customer Live Queue Tracker
     */
    public function liveQueue(Booking $booking = null)
    {
        $user = Auth::user();
        if (!$booking && $user) {
            $booking = Booking::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        }

        if (!$booking) {
            $booking = Booking::orderBy('created_at', 'desc')->first();
        }

        $today = $booking->booking_date;
        $aheadCount = Booking::where('booking_date', $today)
            ->where('branch', $booking->branch)
            ->where('id', '<', $booking->id)
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        return view('queue.live_tracker', compact('booking', 'aheadCount'));
    }

    /**
     * Store new User (Admin / Owner)
     */
    public function storeUser(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'owner'])) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:owner,supervisor,admin,kasir,receptionist,hair stylist,customer',
            'password' => 'required|string|min:4',
            'security_pin' => 'nullable|digits:6',
            'commission_rate' => 'nullable|integer|min:0|max:100',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'commission_rate' => $request->commission_rate ?? 30,
            'work_status' => 'Available',
        ];

        if ($request->role === 'admin') {
            $userData['security_pin'] = Hash::make($request->security_pin ?? '123456');
        }

        User::create($userData);

        return redirect()->route('dashboard')->with('success', 'Pengguna/Staff baru (' . ucfirst($request->role) . ') berhasil ditambahkan!');
    }

    /**
     * Update existing user (Admin / Owner).
     */
    public function updateUser(Request $request, User $user)
    {
        if (!in_array(Auth::user()->role, ['admin', 'owner'])) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:owner,supervisor,admin,kasir,receptionist,hair stylist,customer',
            'commission_rate' => 'nullable|integer|min:0|max:100',
            'work_status' => 'nullable|string|in:Available,On Duty,Break,Off',
            'password' => 'nullable|string|min:4',
            'security_pin' => 'nullable|digits:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'commission_rate' => $request->commission_rate ?? $user->commission_rate,
            'work_status' => $request->work_status ?? $user->work_status ?? 'Available',
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->role === 'admin') {
            if ($request->filled('security_pin')) {
                $data['security_pin'] = Hash::make($request->security_pin);
            } elseif (empty($user->security_pin)) {
                $data['security_pin'] = Hash::make('123456');
            }
        }

        $user->update($data);

        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update User',
            'details' => "Admin memperbarui data pengguna: {$user->name} (#{$user->id}) role {$user->role}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('dashboard')->with('success', "Data pengguna '{$user->name}' berhasil diperbarui!");
    }

    /**
     * Delete user (Admin / Owner).
     */
    public function deleteUser(User $user)
    {
        if (!in_array(Auth::user()->role, ['admin', 'owner'])) {
            abort(403, 'Akses ditolak.');
        }

        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'Anda tidak bisa menghapus akun Anda sendiri!']);
        }

        $user->delete();
        return redirect()->route('dashboard')->with('success', 'Pengguna ' . $user->name . ' telah dihapus dari sistem.');
    }
}
