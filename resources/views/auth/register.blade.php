<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun - District Studio</title>
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
    .auth-left .perks { margin-top: 40px; }
    .auth-left .perk-item {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 15px;
    }
    .auth-left .perk-item i {
      color: var(--accent-color);
      font-size: 18px;
      flex-shrink: 0;
    }
    .auth-left .perk-item span { color: #c6c6c6; font-size: 0.95rem; }
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
      color: #666;
      margin-bottom: 30px;
    }
    .auth-right .subtitle a {
      color: var(--accent-color);
      text-decoration: none;
      font-weight: 600;
    }
    .form-group { margin-bottom: 18px; }
    .form-group label {
      display: block;
      font-family: 'Montserrat', sans-serif;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #fff;
      margin-bottom: 7px;
    }
    .form-group .input-wrapper { position: relative; }
    .form-group .input-wrapper i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #555;
      font-size: 15px;
    }
    .form-group input {
      width: 100%;
      background-color: #181818;
      border: 1px solid rgba(255,255,255,0.07);
      color: #fff;
      padding: 13px 15px 13px 45px;
      font-family: 'Outfit', sans-serif;
      font-size: 0.95rem;
      transition: border-color 0.3s;
      outline: none;
    }
    .form-group input:focus {
      border-color: var(--accent-color);
      background-color: #1e1e1e;
    }
    .form-group input::placeholder { color: #444; }
    .input-error { font-size: 0.78rem; color: #e74c3c; margin-top: 5px; }
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
    .terms-note {
      font-size: 0.78rem;
      color: #555;
      text-align: center;
      margin-top: 15px;
    }
    .divider {
      text-align: center;
      color: #444;
      font-size: 0.8rem;
      margin: 20px 0;
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
    .alert-error {
      background-color: rgba(220,53,69,0.1);
      border: 1px solid rgba(220,53,69,0.3);
      color: #f8d7da;
      padding: 12px 15px;
      font-size: 0.85rem;
      margin-bottom: 20px;
    }
    @media (max-width: 768px) {
      .auth-left { display: none; }
      .auth-right { width: 100%; padding: 40px 25px; }
    }
  </style>
</head>
<body>
<div class="auth-wrapper">
  <!-- Left: Branding Panel -->
  <div class="auth-left">
    <a href="/" class="brand">DISTRICT<span>STUDIO.</span></a>
    <h1>Buat Akun <span>Baru</span></h1>
    <p>Daftarkan diri Anda dan nikmati kemudahan reservasi potong rambut premium secara online.</p>
    <div class="perks">
      <div class="perk-item">
        <i class="bi bi-calendar2-check"></i>
        <span>Reservasi online kapanpun, dimanapun</span>
      </div>
      <div class="perk-item">
        <i class="bi bi-clock-history"></i>
        <span>Lihat riwayat booking dan layanan Anda</span>
      </div>
      <div class="perk-item">
        <i class="bi bi-person-check"></i>
        <span>Pilih hair artist favorit untuk setiap sesi</span>
      </div>
      <div class="perk-item">
        <i class="bi bi-star"></i>
        <span>Kumpulkan poin loyalitas setiap kunjungan</span>
      </div>
    </div>
  </div>

  <!-- Right: Register Form -->
  <div class="auth-right">
    <h2>Daftar Akun</h2>
    <p class="subtitle">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>

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

    <form action="{{ route('register') }}" method="POST" id="registerForm">
      @csrf

      <div class="form-group">
        <label>Nama Lengkap</label>
        <div class="input-wrapper">
          <i class="bi bi-person"></i>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda" required autofocus>
        </div>
        @error('name')<p class="input-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group">
        <label>Alamat Email</label>
        <div class="input-wrapper">
          <i class="bi bi-envelope"></i>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="email@anda.com" required>
        </div>
        @error('email')<p class="input-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group">
        <label>Nomor WhatsApp</label>
        <div class="input-wrapper">
          <i class="bi bi-whatsapp"></i>
          <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 08123456789" required>
        </div>
        @error('phone')<p class="input-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group">
        <label>Kata Sandi</label>
        <div class="input-wrapper">
          <i class="bi bi-lock"></i>
          <input type="password" name="password" placeholder="Minimal 6 karakter" required>
        </div>
        @error('password')<p class="input-error">{{ $message }}</p>@enderror
      </div>

      <div class="form-group">
        <label>Konfirmasi Kata Sandi</label>
        <div class="input-wrapper">
          <i class="bi bi-lock-fill"></i>
          <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi Anda" required>
        </div>
      </div>

      <button type="submit" id="btnSubmitRegister" class="btn-auth">Buat Akun Sekarang</button>
      <p class="terms-note">Dengan mendaftar, Anda menyetujui syarat & ketentuan layanan District Studio.</p>
    </form>

    <div class="divider">atau</div>
    <a href="/" class="btn-back"><i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Utama</a>
  </div>
</div>

<script>
  document.getElementById('registerForm')?.addEventListener('submit', function() {
    const btn = document.getElementById('btnSubmitRegister');
    if (btn) {
      btn.disabled = true;
      btn.style.opacity = '0.75';
      btn.style.cursor = 'not-allowed';
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Mendaftarkan & Mengirim OTP...';
    }
  });
</script>
</body>
</html>
