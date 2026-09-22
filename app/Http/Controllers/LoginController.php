<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SystemLog;
use App\Mail\OtpVerificationMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login awal.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Verifikasi apakah email dan password valid
        if (!Auth::validate($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ])->onlyInput('email');
        }

        $user = User::where('email', $credentials['email'])->first();

        // Jika user adalah role ADMIN, alihkan ke tahap verifikasi kode PIN
        if ($user && $user->role === 'admin') {
            $request->session()->put('admin_auth_pending_user_id', $user->id);
            $request->session()->put('admin_auth_remember', $request->boolean('remember'));

            return redirect()->route('admin.pin.show');
        }

        // Cek jika akun customer belum diverifikasi via OTP
        if ($user && $user->role === 'customer' && is_null($user->email_verified_at) && !str_ends_with($user->email, '@district.com')) {
            $otpCode = (string) rand(100000, 999999);
            $user->update([
                'otp_code' => $otpCode,
                'otp_expires_at' => Carbon::now()->addMinutes(10),
            ]);

            $mailSent = false;
            try {
                Mail::to($user->email)->send(new OtpVerificationMail($user, $otpCode));
                $mailSent = true;
                Log::info("OTP mail successfully sent to {$user->email} on login");
            } catch (\Exception $e) {
                Log::error("Failed to send OTP mail on login to {$user->email}: " . $e->getMessage());
            }

            $request->session()->put('pending_user_id', $user->id);

            if ($mailSent) {
                return redirect()->route('auth.otp.show')
                    ->with('success', 'Email Anda belum diverifikasi. Kode OTP baru 6 digit telah dikirim ke email Anda (' . $user->email . ').');
            }

            return redirect()->route('auth.otp.show')
                ->with('error', 'Gagal mengirim email OTP ke ' . $user->email . '. Silakan klik "Kirim Ulang Kode".');
        }

        // Role selain admin dapat langsung masuk
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan form verifikasi PIN khusus Admin.
     */
    public function showPinVerification(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $userId = $request->session()->get('admin_auth_pending_user_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors([
                'email' => 'Sesi verifikasi telah berakhir atau tidak ditemukan. Silakan login kembali.',
            ]);
        }

        $user = User::find($userId);
        if (!$user || $user->role !== 'admin') {
            $request->session()->forget(['admin_auth_pending_user_id', 'admin_auth_remember']);
            return redirect()->route('login');
        }

        return view('auth.admin-pin', compact('user'));
    }

    /**
     * Proses verifikasi kode PIN Admin.
     */
    public function verifyPin(Request $request)
    {
        $request->validate([
            'pin' => ['required', 'digits:6'],
        ], [
            'pin.required' => 'Kode PIN keamanan wajib diisi.',
            'pin.digits' => 'Kode PIN harus berupa 6 digit angka.',
        ]);

        $userId = $request->session()->get('admin_auth_pending_user_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors([
                'email' => 'Sesi verifikasi telah berakhir. Silakan login kembali.',
            ]);
        }

        $user = User::find($userId);
        if (!$user || $user->role !== 'admin') {
            $request->session()->forget(['admin_auth_pending_user_id', 'admin_auth_remember']);
            return redirect()->route('login');
        }

        // Cek PIN (dengan fallback ke default '123456' jika PIN belum terisi)
        $isPinValid = false;
        if (!empty($user->security_pin)) {
            $isPinValid = Hash::check($request->pin, $user->security_pin);
        } else {
            $isPinValid = ($request->pin === '123456');
            if ($isPinValid) {
                $user->update(['security_pin' => Hash::make('123456')]);
            }
        }

        if (!$isPinValid) {
            return back()->with('error', 'Kode PIN keamanan verifikasi salah. Silakan coba lagi.');
        }

        // Login Admin
        $remember = $request->session()->get('admin_auth_remember', false);
        $request->session()->forget(['admin_auth_pending_user_id', 'admin_auth_remember']);

        Auth::login($user, $remember);
        $request->session()->regenerate();

        try {
            SystemLog::create([
                'user_id' => $user->id,
                'action' => 'Admin PIN Verified',
                'details' => "Admin {$user->name} berhasil login dengan verifikasi PIN keamanan 2-faktor.",
                'ip_address' => $request->ip(),
            ]);
        } catch (\Exception $e) {
            // Abaikan jika pencatatan log mengalami kendala
        }

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Verifikasi PIN berhasil! Selamat datang Administrator, ' . $user->name . '.');
    }

    /**
     * Batalkan verifikasi PIN dan kembali ke halaman login.
     */
    public function cancelPinVerification(Request $request)
    {
        $request->session()->forget(['admin_auth_pending_user_id', 'admin_auth_remember']);

        return redirect()->route('login')
            ->with('info', 'Verifikasi PIN dibatalkan. Silakan login kembali.');
    }
}
