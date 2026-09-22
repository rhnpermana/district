<?php

namespace App\Http\Controllers;

use App\Mail\OtpVerificationMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if (is_null($user->email_verified_at)) {
                // Generate OTP if user email is not yet verified
                $otpCode = (string) rand(100000, 999999);
                $user->update([
                    'otp_code' => $otpCode,
                    'otp_expires_at' => Carbon::now()->addMinutes(10),
                ]);

                $mailSent = false;
                try {
                    Mail::to($user->email)->send(new OtpVerificationMail($user, $otpCode));
                    $mailSent = true;
                    \Log::info("OTP mail successfully sent to {$user->email} on login");
                } catch (\Exception $e) {
                    \Log::error("Failed to send OTP mail on login to {$user->email}: " . $e->getMessage());
                }

                Auth::logout();
                $request->session()->put('pending_user_id', $user->id);

                if ($mailSent) {
                    return redirect()->route('auth.otp.show')
                        ->with('success', 'Email Anda belum diverifikasi. Kode OTP baru telah dikirim ke email Anda.');
                }

                return redirect()->route('auth.otp.show')
                    ->with('error', 'Gagal mengirim email OTP ke ' . $user->email . '. Silakan klik "Kirim Ulang Kode".');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Show registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $existingUser = User::where('email', $request->email)->first();

        // Jika email sudah pernah didaftarkan tapi belum diverifikasi, perbarui data dan kirim OTP baru
        if ($existingUser && is_null($existingUser->email_verified_at)) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => 'required|string|max:20',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $otpCode = (string) rand(100000, 999999);

            $existingUser->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'otp_code' => $otpCode,
                'otp_expires_at' => Carbon::now()->addMinutes(10),
            ]);

            $mailSent = false;
            try {
                Mail::to($existingUser->email)->send(new OtpVerificationMail($existingUser, $otpCode));
                $mailSent = true;
                \Log::info("OTP mail successfully sent to {$existingUser->email} on re-registration");
            } catch (\Exception $e) {
                \Log::error("Failed to send OTP mail on re-registration to {$existingUser->email}: " . $e->getMessage());
            }

            $request->session()->put('pending_user_id', $existingUser->id);

            if ($mailSent) {
                return redirect()->route('auth.otp.show')
                    ->with('success', 'Akun dengan email ini belum diverifikasi. Kode OTP baru 6 digit telah dikirim ke ' . $existingUser->email . '.');
            }

            return redirect()->route('auth.otp.show')
                ->with('error', 'Gagal mengirim email OTP ke ' . $existingUser->email . '. Silakan klik "Kirim Ulang Kode".');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $otpCode = (string) rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role is customer
            'otp_code' => $otpCode,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP via Email
        $mailSent = false;
        try {
            Mail::to($user->email)->send(new OtpVerificationMail($user, $otpCode));
            $mailSent = true;
            \Log::info("OTP mail successfully sent to {$user->email} on register");
        } catch (\Exception $e) {
            \Log::error("Failed to send OTP mail on register to {$user->email}: " . $e->getMessage());
        }

        // Store user id in session for verification process
        $request->session()->put('pending_user_id', $user->id);

        if ($mailSent) {
            return redirect()->route('auth.otp.show')
                ->with('success', 'Registrasi berhasil! Silakan masukkan kode OTP 6 digit yang telah dikirim ke email Anda (' . $user->email . ').');
        }

        return redirect()->route('auth.otp.show')
            ->with('error', 'Registrasi berhasil, tetapi pengiriman email OTP ke ' . $user->email . ' mengalami gangguan jaringan. Silakan klik "Kirim Ulang Kode".');
    }

    /**
     * Show OTP verification form.
     */
    public function showVerifyOtp(Request $request)
    {
        $userId = $request->session()->get('pending_user_id');
        if (!$userId) {
            return redirect()->route('register')->withErrors(['email' => 'Sesi verifikasi tidak ditemukan. Silakan mendaftar ulang.']);
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('register');
        }

        if ($user->email_verified_at) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }

        return view('auth.verify-otp', [
            'email' => $user->email,
        ]);
    }

    /**
     * Handle OTP verification.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $userId = $request->session()->get('pending_user_id');
        if (!$userId) {
            return redirect()->route('register')->withErrors(['email' => 'Sesi verifikasi telah berakhir. Silakan mendaftar ulang.']);
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('register');
        }

        if ($user->otp_code !== $request->otp) {
            return back()->with('error', 'Kode OTP yang Anda masukkan tidak sesuai.');
        }

        if (Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'Kode OTP sudah kadaluarsa. Silakan klik "Kirim Ulang Kode".');
        }

        // Verify user
        $user->update([
            'email_verified_at' => Carbon::now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        $request->session()->forget('pending_user_id');
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Email berhasil diverifikasi! Selamat datang di District Studio.');
    }

    /**
     * Resend OTP code.
     */
    public function resendOtp(Request $request)
    {
        $userId = $request->session()->get('pending_user_id');
        if (!$userId) {
            return redirect()->route('register')->withErrors(['email' => 'Sesi verifikasi telah berakhir. Silakan mendaftar ulang.']);
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('register');
        }

        $otpCode = (string) rand(100000, 999999);
        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        $mailSent = false;
        try {
            Mail::to($user->email)->send(new OtpVerificationMail($user, $otpCode));
            $mailSent = true;
            \Log::info("OTP mail resent successfully to {$user->email}");
        } catch (\Exception $e) {
            \Log::error("Failed to resend OTP mail to {$user->email}: " . $e->getMessage());
        }

        if ($mailSent) {
            return back()->with('success', 'Kode OTP baru telah berhasil dikirim ke email Anda (' . $user->email . ').');
        }

        return back()->with('error', 'Gagal mengirim ulang email OTP. Silakan periksa koneksi internet atau coba beberapa saat lagi.');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Anda telah berhasil keluar dari akun.');
    }
}
