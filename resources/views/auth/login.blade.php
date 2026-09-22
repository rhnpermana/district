<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - District Studio</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <style>
    :root {
      --accent-color: #dca53e;
    }
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
    .auth-wrapper {
      display: flex;
      width: 100%;
      min-height: 100vh;
    }
    .auth-left {
      flex: 1;
      background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.85)),
        url('{{ asset("assets/img/barber_hero.jpg") }}') center center/cover no-repeat;
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
    .auth-left p {
      font-size: 1.1rem;
      color: #a0a0a0;
      max-width: 400px;
    }
    .auth-right {
      width: 480px;
      background-color: #121212;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px 50px;
      border-left: 1px solid rgba(255,255,255,0.04);
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
      margin-bottom: 35px;
    }
    .auth-right .subtitle a {
      color: var(--accent-color);
      text-decoration: none;
      font-weight: 600;
    }
    .form-group { margin-bottom: 20px; }
    .form-group label {
      display: block;
      font-family: 'Montserrat', sans-serif;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #fff;
      margin-bottom: 8px;
    }
    .form-group .input-wrapper {
      position: relative;
    }
    .form-group .input-wrapper i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #555;
      font-size: 16px;
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
    .remember-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 25px;
    }
    .remember-row label {
      font-size: 0.85rem;
      color: #888;
      cursor: pointer;
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
    }
    .btn-auth:hover {
      background-color: #fff;
      transform: translateY(-2px);
    }
    .divider {
      text-align: center;
      color: #444;
      font-size: 0.8rem;
      margin: 25px 0;
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
      background-color: rgba(220, 53, 69, 0.1);
      border: 1px solid rgba(220, 53, 69, 0.3);
      color: #f8d7da;
      padding: 12px 15px;
      font-size: 0.85rem;
      margin-bottom: 20px;
    }
    .alert-success {
      background-color: rgba(220, 165, 62, 0.1);
      border: 1px solid var(--accent-color);
      color: #fff;
      padding: 12px 15px;
      font-size: 0.85rem;
      margin-bottom: 20px;
    }
    @media (max-width: 768px) {
      .auth-left { display: none; }
      .auth-right { width: 100%; padding: 40px 30px; }
    }
  </style>
</head>
<body>
<div class="auth-wrapper">
  <!-- Left: Branding Panel -->
  <div class="auth-left">
    <a href="/" class="brand">DISTRICT<span>STUDIO.</span></a>
    <h1>Selamat<br>Datang <span>Kembali</span></h1>
    <p>Masuk ke akun Anda untuk mengakses reservasi, riwayat potong rambut, dan layanan premium District Studio.</p>
  </div>

  <!-- Right: Login Form -->
  <div class="auth-right">
    <h2>Masuk Akun</h2>
    <p class="subtitle">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>

    @if(session('success'))
      <div class="alert-success"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert-error">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
      @csrf

      <div class="form-group">
        <label>Alamat Email</label>
        <div class="input-wrapper">
          <i class="bi bi-envelope"></i>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="email@anda.com" required autofocus>
        </div>
      </div>

      <div class="form-group">
        <label>Kata Sandi</label>
        <div class="input-wrapper">
          <i class="bi bi-lock"></i>
          <input type="password" name="password" placeholder="••••••••" required>
        </div>
      </div>

      <div class="remember-row">
        <label>
          <input type="checkbox" name="remember" style="accent-color: var(--accent-color);"> &nbsp;Ingat saya
        </label>
      </div>

      <button type="submit" class="btn-auth">Masuk</button>
    </form>

    <div class="divider">atau</div>
    <a href="/" class="btn-back"><i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Utama</a>
  </div>
</div>
</body>
</html>
