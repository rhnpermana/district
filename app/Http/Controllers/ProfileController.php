<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the profile page for the authenticated user (all roles share same view)
     */
    public function show()
    {
        $user = Auth::user();
        $user->load(['portfolios', 'workShifts']);

        // Role-specific stats to show on profile
        $stats = $this->buildProfileStats($user);

        return view('profile.show', compact('user', 'stats'));
    }

    /**
     * Update profile details (name, phone, bio, address, dob, gender, avatar)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'bio'           => 'nullable|string|max:1000',
            'address'       => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'gender'        => 'nullable|in:Laki-laki,Perempuan',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'phone', 'bio', 'address', 'date_of_birth', 'gender']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it's a local stored file
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $user->update($data);

        SystemLog::create([
            'user_id'    => $user->id,
            'action'     => 'Profile Update',
            'details'    => "User {$user->name} ({$user->role}) memperbarui profil akunnya.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password'      => 'required|string',
            'new_password'          => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        SystemLog::create([
            'user_id'    => $user->id,
            'action'     => 'Password Changed',
            'details'    => "User {$user->name} ({$user->role}) mengganti password akun.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Update security PIN for Admin
     */
    public function updatePin(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak: Fitur PIN keamanan hanya berlaku untuk Administrator.');
        }

        $request->validate([
            'current_password'     => 'required|string',
            'new_pin'              => 'required|digits:6|confirmed',
            'new_pin_confirmation' => 'required|digits:6',
        ], [
            'new_pin.required'     => 'Kode PIN baru wajib diisi.',
            'new_pin.digits'       => 'Kode PIN harus berupa 6 digit angka.',
            'new_pin.confirmed'    => 'Konfirmasi kode PIN tidak sesuai.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
        }

        $user->update(['security_pin' => Hash::make($request->new_pin)]);

        SystemLog::create([
            'user_id'    => $user->id,
            'action'     => 'Admin PIN Changed',
            'details'    => "Admin {$user->name} memperbarui kode PIN keamanan verifikasi akun.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Kode PIN keamanan Admin berhasil diperbarui!');
    }

    /**
     * Build role-specific statistics shown on the profile card
     */
    private function buildProfileStats(User $user): array
    {
        $stats = [];

        switch ($user->role) {
            case 'hair stylist':
                $bookings = Booking::where('stylist_id', $user->id)->get();
                $completed = $bookings->where('status', 'completed');
                $stats = [
                    ['label' => 'Total Sesi Ditangani',   'value' => $bookings->count(),   'icon' => 'scissors', 'color' => '#28a745'],
                    ['label' => 'Sesi Selesai (Completed)','value' => $completed->count(),  'icon' => 'check-circle', 'color' => '#00c8c8'],
                    ['label' => 'Total Omzet Dikerjakan',  'value' => 'Rp ' . number_format($completed->sum('price'), 0, ',', '.'), 'icon' => 'cash-coin', 'color' => '#ffc107'],
                    ['label' => 'Rating / Ulasan',         'value' => $user->reviews()->count() . ' ulasan',  'icon' => 'star-fill', 'color' => '#ff9800'],
                ];
                break;

            case 'kasir':
                $transactions = Transaction::where('cashier_id', $user->id)->get();
                $stats = [
                    ['label' => 'Total Transaksi Kasir',   'value' => $transactions->count(),  'icon' => 'receipt', 'color' => '#28a745'],
                    ['label' => 'Total Pendapatan (Lunas)','value' => 'Rp ' . number_format($transactions->where('payment_status','paid')->sum('final_amount'), 0, ',', '.'), 'icon' => 'currency-dollar', 'color' => '#00c8c8'],
                    ['label' => 'Transaksi Cash',          'value' => $transactions->where('payment_method','Cash')->count() . ' trx', 'icon' => 'cash-stack', 'color' => '#ffc107'],
                    ['label' => 'Transaksi QRIS',          'value' => $transactions->where('payment_method','QRIS')->count() . ' trx', 'icon' => 'qr-code', 'color' => '#ff9800'],
                ];
                break;

            case 'receptionist':
                $walkins = Booking::where('handled_by', $user->id)->orWhere('type', 'walkin')->count();
                $stats = [
                    ['label' => 'Tamu Walk-in Ditangani',  'value' => $walkins,       'icon' => 'person-check', 'color' => '#28a745'],
                    ['label' => 'Total Booking di Sistem', 'value' => Booking::count(),'icon' => 'calendar-check', 'color' => '#00c8c8'],
                ];
                break;

            case 'admin':
                $stats = [
                    ['label' => 'Total Pengguna',   'value' => User::count(),    'icon' => 'people-fill', 'color' => '#28a745'],
                    ['label' => 'Total Booking',    'value' => Booking::count(), 'icon' => 'calendar2-check', 'color' => '#00c8c8'],
                    ['label' => 'Total Transaksi',  'value' => Transaction::count(), 'icon' => 'receipt-cutoff', 'color' => '#ffc107'],
                ];
                break;

            case 'owner':
            case 'supervisor':
                $totalRev = Transaction::where('payment_status','paid')->sum('final_amount');
                $totalTrx = Transaction::count();
                $stats = [
                    ['label' => 'Total Revenue Bisnis',  'value' => 'Rp ' . number_format($totalRev, 0, ',', '.'), 'icon' => 'graph-up-arrow', 'color' => '#28a745'],
                    ['label' => 'Total Transaksi POS',   'value' => $totalTrx . ' trx', 'icon' => 'receipt', 'color' => '#ffc107'],
                    ['label' => 'Total Staff Aktif',     'value' => User::where('role','!=','customer')->count() . ' staf', 'icon' => 'people', 'color' => '#00c8c8'],
                ];
                break;

            case 'customer':
            default:
                $myBookings = Booking::where('user_id', $user->id)->get();
                $stats = [
                    ['label' => 'Total Kunjungan',        'value' => $myBookings->count(),                           'icon' => 'scissors', 'color' => '#28a745'],
                    ['label' => 'Sesi Selesai',           'value' => $myBookings->where('status','completed')->count(),'icon' => 'check-circle-fill', 'color' => '#00c8c8'],
                    ['label' => 'Booking Mendatang',      'value' => $myBookings->whereIn('status',['pending','approved'])->count(), 'icon' => 'calendar-event', 'color' => '#ffc107'],
                ];
                break;
        }

        return $stats;
    }
}
