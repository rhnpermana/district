@extends('admin_layout.app')

@section('title', 'Profil Saya - ' . auth()->user()->name . ' - District Studio')

@section('content')
<main class="main" style="padding-top: 80px; min-height: 100vh; background-color: #09090b;">

  {{-- ===== PROFILE HEADER HERO SECTION ===== --}}
  <section style="background: linear-gradient(135deg, #0d1a0f 0%, #070d09 100%); border-bottom: 1px solid rgba(40,167,69,0.2); padding: 50px 0 0;">
    <div class="container-fluid container-xl">

      @if(session('success'))
        <div class="alert alert-dismissible fade show d-flex align-items-center gap-3 mb-4" role="alert" style="background: rgba(40,167,69,0.12); border: 1px solid rgba(40,167,69,0.4); color: #fff; border-radius: 8px; padding: 14px 18px;">
          <i class="bi bi-check-circle-fill" style="color: #28a745; font-size: 1.2rem;"></i>
          <span>{{ session('success') }}</span>
          <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="row align-items-end g-4 pb-4">
        <!-- Left: Avatar & Identity -->
        <div class="col-12 col-lg-8">
          <div class="d-flex align-items-center gap-4 flex-wrap">
            <!-- Avatar Circle -->
            <div class="position-relative" style="flex-shrink: 0;">
              @php
                $avatarUrl = $user->avatar
                  ? (str_starts_with($user->avatar, 'http') ? $user->avatar : asset('storage/' . $user->avatar))
                  : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=28a745&color=fff&size=128&bold=true';
                $roleColors = [
                  'owner'       => '#dca53e',
                  'supervisor'  => '#00c8c8',
                  'admin'       => '#28a745',
                  'kasir'       => '#ff9800',
                  'receptionist'=> '#64c8ff',
                  'hair stylist'=> '#c8a0ff',
                  'customer'    => '#a0a0a0',
                ];
                $roleColor = $roleColors[$user->role] ?? '#28a745';
                $roleLabels = [
                  'owner'       => 'Owner',
                  'supervisor'  => 'Supervisor Cabang',
                  'admin'       => 'Admin Sistem',
                  'kasir'       => 'Kasir / POS Operator',
                  'receptionist'=> 'Resepsionis',
                  'hair stylist'=> 'Hair Stylist Barber',
                  'customer'    => 'Pelanggan',
                ];
                $roleLabel = $roleLabels[$user->role] ?? ucfirst($user->role);
                $roleIcons = [
                  'owner'       => 'bi-shield-star-fill',
                  'supervisor'  => 'bi-binoculars-fill',
                  'admin'       => 'bi-gear-wide-connected',
                  'kasir'       => 'bi-calculator-fill',
                  'receptionist'=> 'bi-person-lines-fill',
                  'hair stylist'=> 'bi-scissors',
                  'customer'    => 'bi-person-circle',
                ];
                $roleIcon = $roleIcons[$user->role] ?? 'bi-person-fill';
              @endphp
              <img src="{{ $avatarUrl }}" alt="{{ $user->name }}"
                style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid {{ $roleColor }}; box-shadow: 0 0 0 5px rgba(255,255,255,0.05), 0 8px 30px rgba(0,0,0,0.5);">
              <!-- Role badge on avatar -->
              <div style="position: absolute; bottom: -4px; right: -4px; width: 32px; height: 32px; border-radius: 50%; background: {{ $roleColor }}; border: 2px solid #09090b; display: flex; align-items: center; justify-content: center;">
                <i class="bi {{ $roleIcon }}" style="font-size: 0.8rem; color: #000;"></i>
              </div>
            </div>

            <!-- Name & Info -->
            <div>
              <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                <h1 style="font-family: 'Montserrat', sans-serif; font-size: 1.8rem; font-weight: 900; color: #fff; margin: 0;">{{ $user->name }}</h1>
                <span class="badge" style="background: {{ $roleColor }}20; color: {{ $roleColor }}; border: 1px solid {{ $roleColor }}40; font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; padding: 4px 10px;">
                  <i class="bi {{ $roleIcon }} me-1"></i> {{ $roleLabel }}
                </span>
              </div>
              <p style="font-size: 0.85rem; color: #a1a1aa; margin: 3px 0;">
                <i class="bi bi-envelope me-1" style="color: {{ $roleColor }};"></i> {{ $user->email }}
                @if($user->phone)
                  &nbsp;&bull;&nbsp; <i class="bi bi-telephone me-1" style="color: {{ $roleColor }};"></i> {{ $user->phone }}
                @endif
              </p>
              @if($user->bio)
                <p style="font-size: 0.82rem; color: #71717a; margin: 5px 0 0; max-width: 500px; font-style: italic;">"{{ $user->bio }}"</p>
              @else
                <p style="font-size: 0.82rem; color: #52525b; margin: 5px 0 0; font-style: italic;">Belum ada bio profil. Tambahkan deskripsi singkat tentang diri Anda.</p>
              @endif
              <p style="font-size: 0.75rem; color: #52525b; margin: 6px 0 0;">
                <i class="bi bi-calendar-check me-1"></i> Bergabung sejak {{ $user->created_at->format('d F Y') }}
              </p>
            </div>
          </div>
        </div>

        <!-- Right: Profile Actions -->
        <div class="col-12 col-lg-4 text-lg-end">
          <div class="d-flex gap-2 justify-content-lg-end flex-wrap">
            <button class="btn btn-sm fw-bold px-3" style="background: {{ $roleColor }}; color: #000; font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px;" data-bs-toggle="modal" data-bs-target="#editProfileModal">
              <i class="bi bi-pencil-square me-1"></i> Edit Profil Saya
            </button>
            <button class="btn btn-sm btn-outline-secondary fw-bold px-3" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px;" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
              <i class="bi bi-key me-1"></i> Ganti Password
            </button>
          </div>
        </div>
      </div>

      <!-- Tabs Nav inside Hero -->
      <div class="d-flex gap-1 flex-wrap pt-2" style="border-top: 1px solid rgba(255,255,255,0.06);">
        <button class="btn px-4 py-3 fw-bold profile-tab-btn active" data-tab="tab-overview" style="border: none; border-bottom: 2px solid {{ $roleColor }}; border-radius: 0; font-family: 'Montserrat', sans-serif; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; background: transparent; color: #fff;">
          <i class="bi bi-person-fill me-1"></i> Overview Profil
        </button>
        <button class="btn px-4 py-3 fw-bold profile-tab-btn" data-tab="tab-activity" style="border: none; border-bottom: 2px solid transparent; border-radius: 0; font-family: 'Montserrat', sans-serif; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; background: transparent; color: #71717a;">
          <i class="bi bi-activity me-1"></i> Aktivitas & Statistik
        </button>
        <button class="btn px-4 py-3 fw-bold profile-tab-btn" data-tab="tab-security" style="border: none; border-bottom: 2px solid transparent; border-radius: 0; font-family: 'Montserrat', sans-serif; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; background: transparent; color: #71717a;">
          <i class="bi bi-shield-lock me-1"></i> Keamanan Akun
        </button>
      </div>
    </div>
  </section>

  {{-- ===== PROFILE CONTENT BODY ===== --}}
  <div class="container-fluid container-xl" style="padding: 35px 15px 60px;">

    {{-- TAB 1: OVERVIEW PROFIL --}}
    <div id="tab-overview" class="profile-tab-content">
      <div class="row g-4">

        <!-- Profile Detail Card -->
        <div class="col-12 col-lg-5">
          <div style="background: #121215; border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; padding: 28px;">
            <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid {{ $roleColor }}; padding-left: 12px; letter-spacing: 0.5px; margin-bottom: 20px;">
              Informasi Profil Lengkap
            </h5>

            <div class="d-flex flex-column gap-3">
              @php
                $infoItems = [
                  ['icon' => 'bi-person-fill',    'label' => 'Nama Lengkap',   'value' => $user->name],
                  ['icon' => 'bi-envelope-fill',  'label' => 'Alamat Email',   'value' => $user->email],
                  ['icon' => 'bi-telephone-fill', 'label' => 'Nomor HP',       'value' => $user->phone ?? '— Belum diisi'],
                  ['icon' => 'bi-geo-alt-fill',   'label' => 'Alamat Domisili','value' => $user->address ?? '— Belum diisi'],
                  ['icon' => 'bi-cake-fill',      'label' => 'Tanggal Lahir',  'value' => $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d F Y') : '— Belum diisi'],
                  ['icon' => 'bi-gender-ambiguous','label' => 'Jenis Kelamin',  'value' => $user->gender ?? '— Belum diisi'],
                ];
              @endphp

              @foreach($infoItems as $item)
                <div class="d-flex align-items-start gap-3">
                  <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.04); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="bi {{ $item['icon'] }}" style="font-size: 0.85rem; color: {{ $roleColor }};"></i>
                  </div>
                  <div>
                    <div style="font-size: 0.68rem; color: #71717a; font-family: 'Montserrat', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">{{ $item['label'] }}</div>
                    <div style="font-size: 0.88rem; color: {{ str_contains($item['value'], '— Belum') ? '#52525b' : '#e4e4e7' }}; font-style: {{ str_contains($item['value'], '— Belum') ? 'italic' : 'normal' }}; margin-top: 1px;">{{ $item['value'] }}</div>
                  </div>
                </div>
              @endforeach

              <!-- Bio -->
              @if($user->bio)
                <div class="d-flex align-items-start gap-3 pt-2" style="border-top: 1px solid rgba(255,255,255,0.06);">
                  <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.04); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="bi bi-chat-quote-fill" style="font-size: 0.85rem; color: {{ $roleColor }};"></i>
                  </div>
                  <div>
                    <div style="font-size: 0.68rem; color: #71717a; font-family: 'Montserrat', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Bio / Deskripsi</div>
                    <div style="font-size: 0.85rem; color: #a1a1aa; margin-top: 3px; line-height: 1.6; font-style: italic;">"{{ $user->bio }}"</div>
                  </div>
                </div>
              @endif
            </div>

            <!-- Edit Profile Button inside card -->
            <div class="mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.06);">
              <button class="btn btn-sm w-100 fw-bold" style="background: {{ $roleColor }}18; color: {{ $roleColor }}; border: 1px solid {{ $roleColor }}30; font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px; padding: 10px;" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="bi bi-pencil-fill me-1"></i> Edit Informasi Profil
              </button>
            </div>
          </div>
        </div>

        <!-- Right: Role-Specific Info + Stats -->
        <div class="col-12 col-lg-7">

          <!-- Role Info Banner -->
          <div style="background: linear-gradient(135deg, {{ $roleColor }}12, {{ $roleColor }}06); border: 1px solid {{ $roleColor }}30; border-radius: 12px; padding: 22px 24px; margin-bottom: 20px;">
            <div class="d-flex align-items-center gap-3 mb-2">
              <div style="width: 44px; height: 44px; border-radius: 10px; background: {{ $roleColor }}20; display: flex; align-items: center; justify-content: center;">
                <i class="bi {{ $roleIcon }}" style="font-size: 1.4rem; color: {{ $roleColor }};"></i>
              </div>
              <div>
                <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 900; color: #fff; margin: 0;">{{ $roleLabel }}</h4>
                <small style="color: #71717a; font-size: 0.78rem;">District Studio Barbershop</small>
              </div>
            </div>

            @php
              $roleDescriptions = [
                'owner'       => 'Sebagai Owner, Anda memiliki akses penuh ke seluruh sistem. Pantau performa bisnis secara real-time, analisis revenue, kelola semua cabang, dan buat keputusan strategis berdasarkan data.',
                'supervisor'  => 'Sebagai Supervisor Cabang, Anda mengawasi operasional barbershop harian, mengelola jadwal shift staf, memastikan kualitas layanan terjaga, dan memonitor performa setiap hair stylist.',
                'admin'       => 'Sebagai Admin Sistem, Anda mengelola data master barbershop: pengguna, layanan cukur, produk retail, voucher promo, dan memantau seluruh log aktivitas sistem.',
                'kasir'       => 'Sebagai Kasir POS, Anda memproses transaksi pembayaran pelanggan melalui terminal POS, menerima pembayaran Cash & QRIS Dynamic, mencetak nota thermal, dan mencatat kas kecil operasional harian.',
                'receptionist'=> 'Sebagai Resepsionis, Anda menjadi garda terdepan District Studio: menyambut pelanggan, mendaftarkan walk-in, mengelola antrean, dan memastikan pelanggan mendapat nomor antrian yang tepat.',
                'hair stylist'=> 'Sebagai Hair Stylist, Anda adalah inti layanan District Studio. Berikan potongan premium terbaik, bangun kepercayaan pelanggan setia, dan tingkatkan reputasi melalui portofolio karya Anda.',
                'customer'    => 'Terima kasih telah menjadi pelanggan setia District Studio! Nikmati kemudahan booking online, lacak antrean real-time, dan berikan ulasan untuk membantu kami terus berkembang.',
              ];
            @endphp
            <p style="font-size: 0.83rem; color: #a1a1aa; margin: 0; line-height: 1.65;">
              {{ $roleDescriptions[$user->role] ?? 'Selamat datang di District Studio.' }}
            </p>

            @if($user->work_status && in_array($user->role, ['hair stylist', 'kasir', 'receptionist']))
              <div class="mt-3">
                <span style="font-size: 0.72rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase;">Status Kerja Saat Ini:</span>
                <span class="badge ms-2" style="background: {{ $user->work_status === 'Available' ? '#28a745' : ($user->work_status === 'On Duty' ? '#00c8c8' : '#ffc107') }}20; color: {{ $user->work_status === 'Available' ? '#28a745' : ($user->work_status === 'On Duty' ? '#00c8c8' : '#ffc107') }}; border: 1px solid currentColor; font-size: 0.75rem; padding: 4px 10px;">
                  <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> {{ $user->work_status }}
                </span>
              </div>
            @endif
          </div>

          <!-- Stats Grid -->
          @if(count($stats) > 0)
            <div class="row g-3">
              @foreach($stats as $stat)
                <div class="{{ count($stats) <= 2 ? 'col-12 col-sm-6' : 'col-6 col-md-4' }}">
                  <div style="background: #121215; border: 1px solid {{ $stat['color'] }}25; border-radius: 10px; padding: 18px 15px;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: {{ $stat['color'] }}15; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                      <i class="bi bi-{{ $stat['icon'] }}" style="font-size: 1rem; color: {{ $stat['color'] }};"></i>
                    </div>
                    <div style="font-size: 1.2rem; font-weight: 900; color: #fff; font-family: 'Montserrat', sans-serif; line-height: 1.2;">{{ $stat['value'] }}</div>
                    <div style="font-size: 0.68rem; color: #71717a; font-family: 'Montserrat', sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-top: 4px;">{{ $stat['label'] }}</div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif

        </div>
      </div>
    </div>

    {{-- TAB 2: AKTIVITAS & STATISTIK --}}
    <div id="tab-activity" class="profile-tab-content" style="display: none;">
      <div style="background: #121215; border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; padding: 28px;">
        <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid {{ $roleColor }}; padding-left: 12px; margin-bottom: 20px;">
          Ringkasan Statistik & Kontribusi
        </h5>

        @if(count($stats) > 0)
          <div class="row g-3 mb-4">
            @foreach($stats as $stat)
              <div class="col-12 col-md-6 col-xl-4">
                <div class="d-flex align-items-center gap-3" style="background: #18181b; border: 1px solid rgba(255,255,255,0.05); border-radius: 10px; padding: 18px;">
                  <div style="width: 44px; height: 44px; border-radius: 10px; background: {{ $stat['color'] }}18; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="bi bi-{{ $stat['icon'] }}" style="font-size: 1.3rem; color: {{ $stat['color'] }};"></i>
                  </div>
                  <div>
                    <div style="font-size: 1.35rem; font-weight: 900; color: #fff; font-family: 'Montserrat', sans-serif; line-height: 1.2;">{{ $stat['value'] }}</div>
                    <div style="font-size: 0.72rem; color: #71717a; font-family: 'Montserrat', sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-top: 2px;">{{ $stat['label'] }}</div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        <div style="padding: 20px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px dashed rgba(255,255,255,0.06); text-align: center;">
          <i class="bi bi-bar-chart-line-fill" style="font-size: 2.5rem; color: #3f3f46; margin-bottom: 10px; display: block;"></i>
          <p style="color: #52525b; font-size: 0.85rem; margin: 0;">Grafik histori aktivitas akan tersedia di pembaruan sistem mendatang.</p>
        </div>
      </div>
    </div>

    {{-- TAB 3: KEAMANAN AKUN --}}
    <div id="tab-security" class="profile-tab-content" style="display: none;">
      <div class="row g-4">
        <div class="col-12 col-lg-6">
          <div style="background: #121215; border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; padding: 28px;">
            <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #dc3545; padding-left: 12px; margin-bottom: 20px;">
              <i class="bi bi-shield-lock me-2" style="color: #dc3545;"></i>Keamanan & Akses Akun
            </h5>

            <div class="d-flex flex-column gap-4">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <div style="font-size: 0.85rem; color: #e4e4e7; font-weight: 600;">Password Akun</div>
                  <div style="font-size: 0.75rem; color: #71717a;">Terakhir diubah: Tidak diketahui</div>
                </div>
                <button class="btn btn-sm btn-outline-warning fw-bold" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                  <i class="bi bi-key me-1"></i> Ganti Password
                </button>
              </div>

              <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: 1px solid rgba(255,255,255,0.06);">
                <div>
                  <div style="font-size: 0.85rem; color: #e4e4e7; font-weight: 600;">Email Terdaftar</div>
                  <div style="font-size: 0.75rem; color: #71717a;">{{ $user->email }}</div>
                </div>
                <span class="badge bg-success">Terverifikasi</span>
              </div>

              <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: 1px solid rgba(255,255,255,0.06);">
                <div>
                  <div style="font-size: 0.85rem; color: #e4e4e7; font-weight: 600;">Role / Hak Akses</div>
                  <div style="font-size: 0.75rem; color: #71717a;">{{ $roleLabel }} — Ditetapkan oleh Admin</div>
                </div>
                <span class="badge" style="background: {{ $roleColor }}20; color: {{ $roleColor }}; border: 1px solid {{ $roleColor }}40;">{{ strtoupper($user->role) }}</span>
              </div>

              @if($user->role === 'admin')
                <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: 1px solid rgba(255,255,255,0.06);">
                  <div>
                    <div style="font-size: 0.85rem; color: #e4e4e7; font-weight: 600;">PIN Verifikasi Keamanan</div>
                    <div style="font-size: 0.75rem; color: #71717a;">Wajib saat login Admin (6-digit angka)</div>
                  </div>
                  <span class="badge" style="background: rgba(220,165,62,0.15); color: #dca53e; border: 1px solid rgba(220,165,62,0.3);">
                    <i class="bi bi-shield-lock-fill me-1"></i>AKTIF (6-DIGIT)
                  </span>
                </div>
              @endif

              <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: 1px solid rgba(255,255,255,0.06);">
                <div>
                  <div style="font-size: 0.85rem; color: #e4e4e7; font-weight: 600;">Akun Dibuat</div>
                  <div style="font-size: 0.75rem; color: #71717a;">{{ $user->created_at->format('d F Y, H:i') }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Change Password Card -->
        <div class="col-12 col-lg-6">
          <div style="background: #121215; border: 1px solid rgba(255,193,7,0.2); border-radius: 12px; padding: 28px;">
            <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #ffc107; padding-left: 12px; margin-bottom: 20px;">
              <i class="bi bi-key-fill me-2" style="color: #ffc107;"></i>Ubah Password Akun
            </h5>
            <form action="{{ route('profile.password') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Password Saat Ini:</label>
                <input type="password" name="current_password" class="form-control bg-dark text-white border-secondary" placeholder="••••••••" required>
                @error('current_password')
                  <div class="text-danger" style="font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Password Baru:</label>
                <input type="password" name="new_password" class="form-control bg-dark text-white border-secondary" placeholder="Min. 8 karakter" required>
              </div>
              <div class="mb-4">
                <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Konfirmasi Password Baru:</label>
                <input type="password" name="new_password_confirmation" class="form-control bg-dark text-white border-secondary" placeholder="Ulangi password baru" required>
              </div>
              <button type="submit" class="btn btn-warning text-dark fw-bold w-100" style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 10px;">
                <i class="bi bi-shield-check me-2"></i>Perbarui Password
              </button>
            </form>
          </div>
        </div>

        @if($user->role === 'admin')
          <!-- Change Security PIN Card for Admin -->
          <div class="col-12 col-lg-6">
            <div style="background: #121215; border: 1px solid rgba(220,165,62,0.25); border-radius: 12px; padding: 28px;">
              <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #dca53e; padding-left: 12px; margin-bottom: 20px;">
                <i class="bi bi-shield-lock-fill me-2" style="color: #dca53e;"></i>Ubah PIN Keamanan Admin
              </h5>
              <p style="font-size: 0.8rem; color: #888; margin-bottom: 20px;">
                PIN verifikasi 6 digit angka digunakan sebagai autentikasi lapis kedua khusus saat Anda melakukan login akun Administrator.
              </p>
              <form action="{{ route('profile.pin') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Password Akun Saat Ini:</label>
                  <input type="password" name="current_password" class="form-control bg-dark text-white border-secondary" placeholder="••••••••" required>
                  @error('current_password')
                    <div class="text-danger" style="font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">PIN Baru (6 Digit Angka):</label>
                  <input type="password" name="new_pin" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: 123456" required>
                  @error('new_pin')
                    <div class="text-danger" style="font-size: 0.75rem; margin-top: 4px;">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-4">
                  <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Konfirmasi PIN Baru:</label>
                  <input type="password" name="new_pin_confirmation" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" class="form-control bg-dark text-white border-secondary" placeholder="Ulangi 6 digit PIN baru" required>
                </div>
                <button type="submit" class="btn fw-bold w-100" style="background-color: #dca53e; color: #000; font-family: 'Montserrat', sans-serif; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 10px;">
                  <i class="bi bi-shield-check me-2"></i>Perbarui PIN Keamanan
                </button>
              </form>
            </div>
          </div>
        @endif
      </div>
    </div>

  </div>
</main>

{{-- ===== MODAL EDIT PROFIL ===== --}}
<div class="modal fade" id="editProfileModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="background: #18181b; border: 1px solid rgba(255,255,255,0.08); color: #fff;">
      <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.08); background: linear-gradient(135deg, #0d1a0f, #09090b);">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-pencil-square" style="font-size: 1.2rem; color: {{ $roleColor }};"></i>
          <h5 class="modal-title font-monospace fw-bold" style="margin: 0; font-size: 0.95rem; text-transform: uppercase;">Edit Profil Saya</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body p-4">

          <!-- Avatar Upload Preview -->
          <div class="text-center mb-4">
            <div class="position-relative d-inline-block">
              <img id="avatarPreview" src="{{ $avatarUrl }}" alt="Avatar Preview"
                style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid {{ $roleColor }};">
              <label for="avatarInput" style="position: absolute; bottom: -2px; right: -2px; width: 28px; height: 28px; border-radius: 50%; background: {{ $roleColor }}; border: 2px solid #18181b; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                <i class="bi bi-camera-fill" style="font-size: 0.65rem; color: #000;"></i>
              </label>
              <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;" onchange="previewAvatar(event)">
            </div>
            <div style="font-size: 0.72rem; color: #71717a; margin-top: 8px;">Klik ikon kamera untuk ganti foto profil (maks. 2MB)</div>
          </div>

          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Nama Lengkap *</label>
              <input type="text" name="name" class="form-control bg-dark text-white border-secondary" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-12 col-md-6">
              <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Nomor HP / WA</label>
              <input type="text" name="phone" class="form-control bg-dark text-white border-secondary" value="{{ old('phone', $user->phone) }}" placeholder="0812xxxx">
            </div>
            <div class="col-12 col-md-6">
              <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Tanggal Lahir</label>
              <input type="date" name="date_of_birth" class="form-control bg-dark text-white border-secondary" value="{{ old('date_of_birth', $user->date_of_birth) }}">
            </div>
            <div class="col-12 col-md-6">
              <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Jenis Kelamin</label>
              <select name="gender" class="form-select bg-dark text-white border-secondary">
                <option value="">— Pilih Jenis Kelamin —</option>
                <option value="Laki-laki" {{ old('gender', $user->gender) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('gender', $user->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>
            <div class="col-12">
              <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Alamat Domisili</label>
              <input type="text" name="address" class="form-control bg-dark text-white border-secondary" value="{{ old('address', $user->address) }}" placeholder="Contoh: Jl. Kebayoran Lama No. 12, Jakarta Selatan">
            </div>
            <div class="col-12">
              <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Bio / Deskripsi Singkat</label>
              <textarea name="bio" class="form-control bg-dark text-white border-secondary" rows="3" placeholder="Ceritakan sedikit tentang diri Anda di sini...">{{ old('bio', $user->bio) }}</textarea>
              <div style="font-size: 0.72rem; color: #52525b; margin-top: 3px;">Maks. 1000 karakter. Akan tampil di profil Anda.</div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.08);">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm fw-bold px-4" style="background: {{ $roleColor }}; color: #000; font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px;">
            <i class="bi bi-check-lg me-1"></i>Simpan Perubahan Profil
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ===== MODAL GANTI PASSWORD ===== --}}
<div class="modal fade" id="changePasswordModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: #18181b; border: 1px solid rgba(255,193,7,0.25); color: #fff;">
      <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
        <h5 class="modal-title font-monospace fw-bold text-warning" style="font-size: 0.9rem; text-transform: uppercase;">
          <i class="bi bi-key-fill me-2"></i>Ganti Password Akun
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('profile.password') }}" method="POST">
        @csrf
        <div class="modal-body p-4">
          <div class="mb-3">
            <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Password Saat Ini:</label>
            <input type="password" name="current_password" class="form-control bg-dark text-white border-secondary" placeholder="••••••••" required>
          </div>
          <div class="mb-3">
            <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Password Baru (min. 8 karakter):</label>
            <input type="password" name="new_password" class="form-control bg-dark text-white border-secondary" placeholder="Password baru..." required>
          </div>
          <div class="mb-3">
            <label style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase;">Konfirmasi Password Baru:</label>
            <input type="password" name="new_password_confirmation" class="form-control bg-dark text-white border-secondary" placeholder="Ulangi password baru..." required>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.08);">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold px-4" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase;">
            <i class="bi bi-shield-check me-1"></i>Perbarui Password
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  .profile-tab-btn.active {
    color: #fff !important;
    border-bottom-color: currentColor !important;
  }
  .profile-tab-btn:not(.active):hover {
    color: #e4e4e7 !important;
  }
</style>

<script>
  // Profile Tab Switcher
  const tabBtns = document.querySelectorAll('.profile-tab-btn');
  const tabContents = document.querySelectorAll('.profile-tab-content');

  tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.getAttribute('data-tab');

      tabBtns.forEach(b => {
        b.classList.remove('active');
        b.style.color = '#71717a';
        b.style.borderBottomColor = 'transparent';
      });
      btn.classList.add('active');
      btn.style.color = '#fff';
      btn.style.borderBottomColor = btn.style.borderBottomColor || '#28a745';

      tabContents.forEach(tc => {
        tc.style.display = tc.id === targetId ? 'block' : 'none';
      });
    });
  });

  // Avatar preview before upload
  function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        document.getElementById('avatarPreview').src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  }
</script>
@endsection
