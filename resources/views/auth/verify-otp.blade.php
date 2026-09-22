<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi Kode OTP - District Studio</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <style>
    :root { --accent-color: #dca53e; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Outfit', sans-serif;
      background-color: #0b0b0b;
      color: #c6c6c6;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .auth-wrapper { display: flex; width: 100%; min-height: 100vh; }
    .auth-left {
      flex: 1;
      background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.85)),
        url('{{ asset("assets/img/barber_cut.jpg") }}') center center/cover no-repeat;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      padding: 60px;
    }
    .auth-left .brand {
      font-family: 'Montserrat', sans-serif;
      font-size: 28px;
      font-weight: 900;
      color: #fff;
      letter-spacing: 2px;
      margin-bottom: 40px;
      text-decoration: none;
    }
    .auth-left .brand span { color: var(--accent-color); }
    .auth-left h1 {
      font-family: 'Montserrat', sans-serif;
      font-size: 3rem;
      font-weight: 900;
      color: #fff;
      text-transform: uppercase;
      line-height: 1.1;
      margin-bottom: 20px;
    }
    .auth-left h1 span { color: var(--accent-color); }
    .auth-left p { font-size: 1.05rem; color: #a0a0a0; max-width: 400px; }
    
    .auth-right {
      width: 520px;
      background-color: #121212;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 50px;
      border-left: 1px solid rgba(255,255,255,0.04);
      overflow-y: auto;
    }
    .auth-right h2 {
      font-family: 'Montserrat', sans-serif;
      font-size: 1.8rem;
      font-weight: 800;
      color: #fff;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 8px;
    }
    .auth-right .subtitle {
      font-size: 0.9rem;
      color: #888;
      margin-bottom: 30px;
      line-height: 1.5;
    }
    .auth-right .email-highlight {
      color: var(--accent-color);
      font-weight: 600;
    }

    .otp-inputs {
      display: flex;
      gap: 10px;
      justify-content: space-between;
      margin-bottom: 25px;
    }
    .otp-digit {
      width: 55px;
      height: 60px;
      background-color: #181818;
      border: 1px solid rgba(255,255,255,0.1);
      color: var(--accent-color);
      font-family: 'Montserrat', sans-serif;
      font-size: 1.5rem;
      font-weight: 800;
      text-align: center;
      border-radius: 6px;
      outline: none;
      transition: all 0.3s;
    }
    .otp-digit:focus {
      border-color: var(--accent-color);
      background-color: #1e1e1e;
      box-shadow: 0 0 10px rgba(220,165,62,0.2);
    }

    .btn-auth {
      width: 100%;
      background-color: var(--accent-color);
      color: #000;
      border: none;
      padding: 14px;
      font-family: 'Montserrat', sans-serif;
      font-size: 0.85rem;
      font-weight: 800;
      letter-spacing: 2px;
      text-transform: uppercase;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 8px;
    }
    .btn-auth:hover { background-color: #fff; transform: translateY(-2px); }

    .resend-box {
      margin-top: 25px;
      text-align: center;
      font-size: 0.85rem;
      color: #666;
    }
    .btn-resend {
      background: none;
      border: none;
      color: var(--accent-color);
      font-weight: 700;
      cursor: pointer;
      text-decoration: underline;
      padding: 0;
      font-size: 0.85rem;
    }
    .btn-resend:hover { color: #fff; }

    .divider {
      text-align: center;
      color: #444;
      font-size: 0.8rem;
      margin: 25px 0 20px;
      position: relative;
    }
    .divider::before, .divider::after {
      content: '';
      position: absolute;
      top: 50%;
      width: 42%;
      height: 1px;
      background-color: rgba(255,255,255,0.05);
    }
    .divider::before { left: 0; }
    .divider::after { right: 0; }

    .btn-back {
      display: block;
      text-align: center;
      color: #666;
      font-size: 0.85rem;
      text-decoration: none;
      transition: color 0.3s;
    }
    .btn-back:hover { color: var(--accent-color); }

    .alert-success {
      background-color: rgba(25, 135, 84, 0.15);
      border: 1px solid rgba(25, 135, 84, 0.3);
      color: #75b798;
      padding: 12px 15px;
      font-size: 0.85rem;
      margin-bottom: 20px;
      border-radius: 4px;
    }
    .alert-error {
      background-color: rgba(220,53,69,0.15);
      border: 1px solid rgba(220,53,69,0.3);
      color: #f8d7da;
      padding: 12px 15px;
      font-size: 0.85rem;
      margin-bottom: 20px;
      border-radius: 4px;
    }
    @media (max-width: 768px) {
      .auth-left { display: none; }
      .auth-right { width: 100%; padding: 40px 25px; }
      .otp-digit { width: 42px; height: 50px; font-size: 1.2rem; }
    }
  </style>
</head>
<body>
<div class="auth-wrapper">
  <!-- Left: Branding Panel -->
  <div class="auth-left">
    <a href="/" class="brand">DISTRICT<span>STUDIO.</span></a>
    <h1>Verifikasi <span>Keamanan</span></h1>
    <p>Kami telah mengirimkan kode verifikasi 6-digit ke alamat email Anda untuk memastikan keamanan akun Anda.</p>
  </div>

  <!-- Right: OTP Verification Form -->
  <div class="auth-right">
    <h2>Verifikasi OTP</h2>
    <p class="subtitle">Masukkan 6 digit kode OTP yang dikirimkan ke email <span class="email-highlight">{{ $email ?? 'Anda' }}</span></p>

    @if(session('success'))
      <div class="alert-success">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="alert-error">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ session('error') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert-error">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('auth.otp.verify') }}" method="POST" id="otpForm">
      @csrf
      <input type="hidden" name="otp" id="fullOtpInput">

      <div class="otp-inputs">
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]*" inputmode="numeric" autofocus required>
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]*" inputmode="numeric" required>
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]*" inputmode="numeric" required>
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]*" inputmode="numeric" required>
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]*" inputmode="numeric" required>
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]*" inputmode="numeric" required>
      </div>

      <button type="submit" id="btnSubmitOtp" class="btn-auth">Verifikasi & Masuk</button>
    </form>

    <div class="resend-box">
      Tidak menerima kode OTP?
      <form action="{{ route('auth.otp.resend') }}" method="POST" class="d-inline" id="resendForm">
        @csrf
        <button type="submit" id="btnResendOtp" class="btn-resend">Kirim Ulang Kode</button>
      </form>
    </div>

    <div class="divider">atau</div>
    <a href="{{ route('register') }}" class="btn-back"><i class="bi bi-arrow-left me-1"></i> Kembali ke Pendaftaran</a>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const digits = document.querySelectorAll('.otp-digit');
    const fullOtpInput = document.getElementById('fullOtpInput');
    const otpForm = document.getElementById('otpForm');
    const resendForm = document.getElementById('resendForm');
    const btnSubmitOtp = document.getElementById('btnSubmitOtp');
    const btnResendOtp = document.getElementById('btnResendOtp');

    function updateFullOtp() {
      let code = '';
      digits.forEach(d => code += d.value);
      fullOtpInput.value = code;
    }

    digits.forEach((input, index) => {
      input.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length >= 1) {
          this.value = this.value.charAt(0);
          if (index < digits.length - 1) {
            digits[index + 1].focus();
          }
        }
        updateFullOtp();
      });

      input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && index > 0) {
          digits[index - 1].focus();
        }
      });

      input.addEventListener('paste', function(e) {
        e.preventDefault();
        const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
        if (/^\d{6}$/.test(pasteData)) {
          pasteData.split('').forEach((char, i) => {
            if (digits[i]) digits[i].value = char;
          });
          updateFullOtp();
          digits[digits.length - 1].focus();
        }
      });
    });

    otpForm?.addEventListener('submit', function(e) {
      updateFullOtp();
      if (btnSubmitOtp) {
        btnSubmitOtp.disabled = true;
        btnSubmitOtp.style.opacity = '0.75';
        btnSubmitOtp.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memverifikasi...';
      }
    });

    resendForm?.addEventListener('submit', function(e) {
      if (btnResendOtp) {
        btnResendOtp.disabled = true;
        btnResendOtp.style.opacity = '0.75';
        btnResendOtp.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Mengirim ulang OTP...';
      }
    });
  });
</script>
</body>
</html>
