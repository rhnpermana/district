<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi PIN Admin - District Studio</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <style>
    :root {
      --accent-color: #dca53e;
      --accent-hover: #f1b74d;
      --bg-dark: #0b0b0b;
      --card-dark: #121215;
      --input-bg: #18181c;
      --border-color: rgba(255, 255, 255, 0.08);
      --border-focus: #dca53e;
    }
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Outfit', sans-serif;
      background-color: var(--bg-dark);
      color: #c6c6c6;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-image: 
        radial-gradient(circle at 50% 20%, rgba(220, 165, 62, 0.08) 0%, transparent 60%),
        radial-gradient(circle at 90% 80%, rgba(220, 165, 62, 0.04) 0%, transparent 40%);
    }
    .auth-wrapper {
      display: flex;
      width: 100%;
      min-height: 100vh;
    }
    .auth-left {
      flex: 1;
      background: linear-gradient(rgba(0,0,0,0.78), rgba(0,0,0,0.92)),
        url('{{ asset("assets/img/barber_hero.jpg") }}') center center/cover no-repeat;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      padding: 70px;
      position: relative;
    }
    .auth-left::after {
      content: '';
      position: absolute;
      right: 0;
      top: 0;
      bottom: 0;
      width: 2px;
      background: linear-gradient(to bottom, transparent, var(--accent-color), transparent);
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
    .auth-left .brand span {
      color: var(--accent-color);
    }
    .security-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 16px;
      background: rgba(220, 165, 62, 0.12);
      border: 1px solid rgba(220, 165, 62, 0.3);
      border-radius: 50px;
      color: var(--accent-color);
      font-size: 0.8rem;
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 25px;
    }
    .security-badge i {
      font-size: 1rem;
    }
    .auth-left h1 {
      font-family: 'Montserrat', sans-serif;
      font-size: 2.8rem;
      font-weight: 900;
      color: #fff;
      text-transform: uppercase;
      line-height: 1.15;
      margin-bottom: 20px;
    }
    .auth-left h1 span {
      color: var(--accent-color);
    }
    .auth-left p {
      font-size: 1.05rem;
      color: #a0a0a0;
      max-width: 440px;
      line-height: 1.6;
    }

    .auth-right {
      width: 540px;
      background-color: var(--card-dark);
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px 50px;
      position: relative;
    }

    .admin-profile-card {
      display: flex;
      align-items: center;
      gap: 16px;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 30px;
    }
    .admin-avatar {
      width: 50px;
      height: 50px;
      border-radius: 10px;
      background: linear-gradient(135deg, #222, #333);
      border: 1px solid rgba(220, 165, 62, 0.4);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--accent-color);
      font-size: 1.4rem;
      flex-shrink: 0;
    }
    .admin-info {
      flex: 1;
      overflow: hidden;
    }
    .admin-info .admin-name {
      color: #fff;
      font-family: 'Montserrat', sans-serif;
      font-size: 0.95rem;
      font-weight: 700;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
    }
    .admin-info .admin-email {
      color: #888;
      font-size: 0.8rem;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
    }
    .admin-tag {
      background: rgba(220, 165, 62, 0.15);
      color: var(--accent-color);
      border: 1px solid rgba(220, 165, 62, 0.3);
      border-radius: 6px;
      padding: 3px 8px;
      font-family: 'Montserrat', sans-serif;
      font-size: 0.68rem;
      font-weight: 800;
      letter-spacing: 1px;
      text-transform: uppercase;
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
      margin-bottom: 25px;
      line-height: 1.5;
    }

    /* PIN Inputs */
    .pin-container {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-bottom: 25px;
    }
    .pin-input {
      width: 60px;
      height: 65px;
      background-color: var(--input-bg);
      border: 1.5px solid var(--border-color);
      border-radius: 10px;
      color: #fff;
      font-family: 'Montserrat', sans-serif;
      font-size: 1.6rem;
      font-weight: 800;
      text-align: center;
      transition: all 0.25s ease;
      outline: none;
      -webkit-appearance: none;
    }
    .pin-input:focus {
      border-color: var(--border-focus);
      background-color: #1f1f26;
      box-shadow: 0 0 16px rgba(220, 165, 62, 0.25);
      transform: translateY(-2px);
    }
    .pin-input.is-filled {
      border-color: rgba(220, 165, 62, 0.6);
      background-color: #1b1b22;
    }

    .pin-tools {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      font-size: 0.8rem;
    }
    .btn-toggle-pin {
      background: none;
      border: none;
      color: #888;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-family: 'Outfit', sans-serif;
      font-size: 0.8rem;
      padding: 0;
      transition: color 0.2s;
    }
    .btn-toggle-pin:hover {
      color: var(--accent-color);
    }

    .pin-hint {
      background: rgba(255, 255, 255, 0.02);
      border: 1px dashed rgba(220, 165, 62, 0.25);
      border-radius: 8px;
      padding: 10px 14px;
      color: #999;
      font-size: 0.78rem;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 25px;
    }
    .pin-hint code {
      background: rgba(220, 165, 62, 0.15);
      color: var(--accent-color);
      padding: 2px 6px;
      border-radius: 4px;
      font-weight: 700;
      font-family: monospace;
    }

    .btn-auth {
      width: 100%;
      background-color: var(--accent-color);
      color: #000;
      border: none;
      border-radius: 6px;
      padding: 15px;
      font-family: 'Montserrat', sans-serif;
      font-size: 0.88rem;
      font-weight: 800;
      letter-spacing: 2px;
      text-transform: uppercase;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .btn-auth:hover {
      background-color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(220, 165, 62, 0.2);
    }

    .btn-cancel {
      width: 100%;
      background: transparent;
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 6px;
      color: #888;
      padding: 12px;
      font-family: 'Montserrat', sans-serif;
      font-size: 0.78rem;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      cursor: pointer;
      transition: all 0.25s;
      margin-top: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      text-decoration: none;
    }
    .btn-cancel:hover {
      color: #fff;
      border-color: rgba(255, 255, 255, 0.2);
      background: rgba(255, 255, 255, 0.03);
    }

    .alert-error {
      background-color: rgba(220, 53, 69, 0.1);
      border: 1px solid rgba(220, 53, 69, 0.3);
      color: #f8d7da;
      padding: 12px 15px;
      border-radius: 8px;
      font-size: 0.85rem;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: shake 0.4s ease-in-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60% { transform: translateX(-6px); }
      40%, 80% { transform: translateX(6px); }
    }

    @media (max-width: 992px) {
      .auth-left { display: none; }
      .auth-right { width: 100%; max-width: 500px; margin: auto; padding: 40px 25px; }
      .pin-input { width: 48px; height: 55px; font-size: 1.3rem; }
    }
  </style>
</head>
<body>

<div class="auth-wrapper">
  <!-- Left: Branding & Security Info -->
  <div class="auth-left">
    <a href="/" class="brand">DISTRICT<span>STUDIO.</span></a>
    <div class="security-badge">
      <i class="bi bi-shield-lock-fill"></i> Multi-Factor Security
    </div>
    <h1>Verifikasi<br>Keamanan <span>Admin</span></h1>
    <p>Akses akun Administrator memerlukan otentikasi lapis kedua berupa kode PIN keamanan untuk melindungi integritas data studio.</p>
  </div>

  <!-- Right: PIN Input Panel -->
  <div class="auth-right">
    <h2>Kode PIN Admin</h2>
    <p class="subtitle">Masukkan 6-digit kode PIN verifikasi keamanan untuk menyelesaikan proses login akun Admin Anda.</p>

    <!-- Admin User Info Badge -->
    <div class="admin-profile-card">
      <div class="admin-avatar">
        <i class="bi bi-shield-check"></i>
      </div>
      <div class="admin-info">
        <div class="admin-name">{{ $user->name }}</div>
        <div class="admin-email">{{ $user->email }}</div>
      </div>
      <span class="admin-tag"><i class="bi bi-person-fill-gear me-1"></i>ADMIN</span>
    </div>

    @if(session('error'))
      <div class="alert-error">
        <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
        <span>{{ session('error') }}</span>
      </div>
    @endif

    @if($errors->any())
      <div class="alert-error">
        <i class="bi bi-exclamation-circle-fill text-danger fs-5"></i>
        <span>{{ $errors->first() }}</span>
      </div>
    @endif

    <!-- PIN Verification Form -->
    <form action="{{ route('admin.pin.verify') }}" method="POST" id="pinForm">
      @csrf

      <!-- Hidden Input that holds combined PIN -->
      <input type="hidden" name="pin" id="fullPin">

      <div class="pin-container" id="pinInputs">
        <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="pin-input" autofocus data-index="0" autocomplete="off" required>
        <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="pin-input" data-index="1" autocomplete="off" required>
        <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="pin-input" data-index="2" autocomplete="off" required>
        <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="pin-input" data-index="3" autocomplete="off" required>
        <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="pin-input" data-index="4" autocomplete="off" required>
        <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="pin-input" data-index="5" autocomplete="off" required>
      </div>

      <div class="pin-tools">
        <button type="button" class="btn-toggle-pin" id="toggleVisibility">
          <i class="bi bi-eye" id="toggleIcon"></i> <span id="toggleText">Tampilkan Angka PIN</span>
        </button>
        <span class="text-muted" style="font-size: 0.75rem;">6 Digit Angka</span>
      </div>

      <div class="pin-hint">
        <i class="bi bi-info-circle text-warning fs-5"></i>
        <div>
          PIN bawaan Administrator: <code>123456</code>. Anda dapat memperbarui PIN kapan saja di pengaturan profil akun.
        </div>
      </div>

      <button type="submit" class="btn-auth" id="btnSubmit">
        <i class="bi bi-shield-check"></i> Verifikasi & Masuk
      </button>
    </form>

    <!-- Cancel and Return to Login -->
    <form action="{{ route('admin.pin.cancel') }}" method="POST" class="mt-2">
      @csrf
      <button type="submit" class="btn-cancel">
        <i class="bi bi-arrow-left"></i> Batal / Masuk dengan Akun Lain
      </button>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.pin-input');
    const fullPinInput = document.getElementById('fullPin');
    const form = document.getElementById('pinForm');
    const toggleBtn = document.getElementById('toggleVisibility');
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleText = document.getElementById('toggleText');
    let isVisible = false;

    // Focus first input automatically
    if (inputs.length > 0) {
      inputs[0].focus();
    }

    // Handle Input & Navigation
    inputs.forEach((input, index) => {
      // Keydown handler
      input.addEventListener('keydown', function (e) {
        if (e.key === 'Backspace') {
          if (!this.value && index > 0) {
            inputs[index - 1].focus();
            inputs[index - 1].value = '';
            inputs[index - 1].classList.remove('is-filled');
          } else {
            this.value = '';
            this.classList.remove('is-filled');
          }
          updateFullPin();
        } else if (e.key === 'ArrowLeft' && index > 0) {
          inputs[index - 1].focus();
        } else if (e.key === 'ArrowRight' && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      });

      // Input event
      input.addEventListener('input', function (e) {
        // Only allow numbers
        const cleanVal = this.value.replace(/[^0-9]/g, '');
        this.value = cleanVal ? cleanVal.slice(-1) : '';

        if (this.value) {
          this.classList.add('is-filled');
          if (index < inputs.length - 1) {
            inputs[index + 1].focus();
          }
        } else {
          this.classList.remove('is-filled');
        }

        updateFullPin();

        // If all 6 digits entered, auto submit
        if (getFullPin().length === 6) {
          form.submit();
        }
      });

      // Paste handler
      input.addEventListener('paste', function (e) {
        e.preventDefault();
        const pasteData = (e.clipboardData || window.clipboardData).getData('text');
        const digits = pasteData.replace(/[^0-9]/g, '').slice(0, 6);

        if (digits.length > 0) {
          digits.split('').forEach((char, i) => {
            if (inputs[i]) {
              inputs[i].value = char;
              inputs[i].classList.add('is-filled');
            }
          });
          const nextIndex = Math.min(digits.length, inputs.length - 1);
          inputs[nextIndex].focus();
          updateFullPin();

          if (digits.length === 6) {
            form.submit();
          }
        }
      });
    });

    function getFullPin() {
      let pin = '';
      inputs.forEach(input => pin += input.value);
      return pin;
    }

    function updateFullPin() {
      fullPinInput.value = getFullPin();
    }

    // Toggle show/hide PIN
    toggleBtn.addEventListener('click', function () {
      isVisible = !isVisible;
      inputs.forEach(input => {
        input.type = isVisible ? 'text' : 'password';
      });
      if (isVisible) {
        toggleIcon.className = 'bi bi-eye-slash';
        toggleText.textContent = 'Sembunyikan Angka PIN';
      } else {
        toggleIcon.className = 'bi bi-eye';
        toggleText.textContent = 'Tampilkan Angka PIN';
      }
    });

    // Form submission validation
    form.addEventListener('submit', function (e) {
      updateFullPin();
      if (fullPinInput.value.length !== 6) {
        e.preventDefault();
        alert('Silakan masukkan 6 digit kode PIN lengkap.');
        const emptyIndex = Array.from(inputs).findIndex(input => !input.value);
        if (emptyIndex !== -1) {
          inputs[emptyIndex].focus();
        }
      }
    });
  });
</script>
</body>
</html>
