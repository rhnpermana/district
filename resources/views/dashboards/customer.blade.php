@extends('admin_layout.app')

@section('title', 'Dashboard Member & Booking - District Studio')

@section('content')
<main class="main" style="padding-top: 80px; min-height: 100vh; background-color: #09090b;">

  <!-- Customer Header Banner -->
  <section style="background: linear-gradient(135deg, #1f1a10 0%, #120e08 100%); border-bottom: 1px solid rgba(255,152,0,0.25); padding: 35px 0;">
    <div class="container-fluid container-xl">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <span style="background: rgba(255,152,0,0.15); color: #ff9800; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; padding: 5px 14px; border: 1px solid rgba(255,152,0,0.3); border-radius: 4px; font-family: 'Montserrat', sans-serif;">
            <i class="bi bi-person-badge-fill me-1"></i> Member Workstation
          </span>
          <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.9rem; font-weight: 900; color: #fff; text-transform: uppercase; margin-top: 10px; margin-bottom: 0;">
            Selamat Datang, {{ auth()->user()->name }} <span style="color: #ff9800;">.</span>
          </h2>
          <p style="font-size: 0.85rem; color: #a1a1aa; margin: 4px 0 0;">Pesan slot potong rambut, pilih kapster favorit, lacak antrean live di HP, dan re-book 1-klik.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
          @if($activeBooking)
            <a href="{{ route('queue.live', $activeBooking->id) }}" class="btn btn-warning text-dark btn-sm fw-bold px-3 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px;">
              <i class="bi bi-broadcast me-1"></i> Tracker HP ({{ $activeBooking->queue_number ?? 'A-00' . $activeBooking->id }})
            </a>
          @endif
          <button class="btn btn-outline-warning btn-sm fw-bold px-3 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px;" data-bs-toggle="modal" data-bs-target="#newBookingModal">
            <i class="bi bi-calendar-plus me-1"></i> + Buat Booking Baru
          </button>
        </div>
      </div>
    </div>
  </section>

  <div class="container-fluid container-xl" style="padding: 35px 15px 60px;">

    @if(session('success'))
      <div class="alert alert-dismissible fade show d-flex align-items-center justify-content-between mb-4" role="alert" style="background: rgba(255,152,0,0.15); border: 1px solid rgba(255,152,0,0.4); color: #fff; border-radius: 8px; padding: 16px 20px;">
        <div class="d-flex align-items-center">
          <i class="bi bi-check-circle-fill me-2" style="color: #ff9800; font-size: 1.2rem;"></i>
          <div>{{ session('success') }}</div>
        </div>
        <div class="d-flex align-items-center gap-2">
          @if(session('wa_url'))
            <a href="{{ session('wa_url') }}" target="_blank" class="btn btn-sm btn-success fw-bold px-3">
              <i class="bi bi-whatsapp me-1"></i> Konfirmasi via WA
            </a>
          @endif
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
      </div>
    @endif

    <!-- LIVE QUEUE TRACKER BANNER -->
    @if($activeBooking)
      <div style="background: linear-gradient(145deg, #1e170c 0%, #110d06 100%); border: 2px solid #ff9800; padding: 25px; border-radius: 12px;" class="mb-4 shadow-lg">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
          <div>
            <span class="badge bg-warning text-dark fw-bold mb-2 font-monospace">LIVE ANTREAN AKTIF</span>
            <h3 style="font-family: 'Montserrat', sans-serif; font-weight: 900; color: #ff9800; margin: 0; font-size: 2.2rem;">
              {{ $activeBooking->queue_number ?? 'A-00' . $activeBooking->id }}
            </h3>
            <p style="color: #fff; margin: 4px 0 0; font-size: 0.95rem;">
              Layanan: <strong>{{ $activeBooking->service }}</strong> di {{ $activeBooking->branch }}
            </p>
            <div style="font-size: 0.82rem; color: #a1a1aa;" class="mt-1">
              Stylist: <strong>{{ $activeBooking->stylist ? $activeBooking->stylist->name : 'Auto Assign' }}</strong> | Jam: <strong>{{ $activeBooking->booking_time }} WIB</strong>
            </div>
          </div>
          <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('queue.live', $activeBooking->id) }}" class="btn btn-warning text-dark fw-bold px-3 py-3" style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
              <i class="bi bi-phone-vibrate me-1"></i> Buka Tracker di HP
            </a>
            @php
              $branchWa = str_contains($activeBooking->branch, 'Bandung') ? '6281398765432' : '6281234567890';
              $waLiveMsg = "Halo District Studio, saya pemilik antrean *" . ($activeBooking->queue_number ?? 'A-00' . $activeBooking->id) . "* (Layanan: " . $activeBooking->service . "). Saya ingin menanyakan estimasi waktu panggilan antrean saya. Terima kasih!";
            @endphp
            <a href="https://wa.me/{{ $branchWa }}?text={{ urlencode($waLiveMsg) }}" target="_blank" class="btn btn-success fw-bold px-3 py-3" style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
              <i class="bi bi-whatsapp me-1"></i> Tanya Antrean via WA
            </a>
          </div>
        </div>
      </div>
    @endif

    <!-- VOUCHER PROMO BANNER -->
    @if(isset($vouchers) && $vouchers->count() > 0)
      <div style="background: #121215; border: 1px solid rgba(255,193,7,0.25); border-radius: 12px; padding: 20px;" class="mb-4">
        <div class="d-flex align-items-center gap-2 mb-2">
          <i class="bi bi-ticket-perforated-fill text-warning" style="font-size: 1.2rem;"></i>
          <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.88rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0;">
            Voucher Promo Diskon Aktif Untuk Anda
          </h5>
        </div>
        <div class="d-flex gap-2 flex-wrap">
          @foreach($vouchers as $v)
            <div style="background: rgba(255,193,7,0.1); border: 1px dashed #ffc107; padding: 8px 14px; border-radius: 6px;" class="d-flex align-items-center gap-2">
              <span class="font-monospace fw-bold text-warning" style="font-size: 0.9rem;">{{ $v->code }}</span>
              <small class="text-white-50" style="font-size: 0.75rem;">(Diskon {{ $v->type === 'percent' ? $v->discount_value.'%' : 'Rp '.number_format($v->discount_value, 0, ',', '.') }})</small>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <!-- ======= DIGITAL MEMBER LOYALTY CARD ======= -->
    @php
      $user = auth()->user();
      $pts  = $user->loyalty_points ?? 0;
      $tier = $user->member_tier ?? 'Silver';
      $tierColor = match($tier) {
        'VIP Black Member' => ['from'=>'#1a1a1a','to'=>'#3d3d3d','accent'=>'#c0c0c0','label'=>'VIP BLACK MEMBER','icon'=>'bi-gem'],
        'Gold Member'      => ['from'=>'#2b2000','to'=>'#4d3800','accent'=>'#ffc107','label'=>'GOLD MEMBER','icon'=>'bi-trophy-fill'],
        default            => ['from'=>'#121520','to'=>'#1e2336','accent'=>'#6ea8fe','label'=>'SILVER MEMBER','icon'=>'bi-shield-fill'],
      };
      $nextTierPts = $pts >= 100 ? 100 : ($pts >= 50 ? 100 : 50);
      $prevTierPts = $pts >= 100 ? 100 : ($pts >= 50 ? 50 : 0);
      $progress    = $nextTierPts > $prevTierPts ? min(100, round(($pts - $prevTierPts) / ($nextTierPts - $prevTierPts) * 100)) : 100;
      $nextLabel   = $pts >= 100 ? 'VIP Black Member' : ($pts >= 50 ? 'VIP Black Member' : 'Gold Member');
    @endphp

    <div style="margin-bottom: 24px;">
      <div style="background: linear-gradient(135deg, {{ $tierColor['from'] }} 0%, {{ $tierColor['to'] }} 100%); border: 1px solid {{ $tierColor['accent'] }}40; border-radius: 16px; padding: 28px 30px; position: relative; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.5);">
        <!-- Background Decoration -->
        <div style="position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; border-radius: 50%; background: {{ $tierColor['accent'] }}08; pointer-events: none;"></div>
        <div style="position: absolute; bottom: -60px; left: -20px; width: 180px; height: 180px; border-radius: 50%; background: {{ $tierColor['accent'] }}05; pointer-events: none;"></div>

        <div class="row g-4 align-items-center">
          <!-- Left: Identity -->
          <div class="col-12 col-md-7">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div style="width: 52px; height: 52px; border-radius: 50%; background: {{ $tierColor['accent'] }}20; border: 2px solid {{ $tierColor['accent'] }}60; display:flex; align-items:center; justify-content:center;">
                <i class="bi {{ $tierColor['icon'] }}" style="font-size: 1.5rem; color: {{ $tierColor['accent'] }};"></i>
              </div>
              <div>
                <div style="font-size: 0.65rem; font-weight: 800; letter-spacing: 3px; color: {{ $tierColor['accent'] }}; text-transform: uppercase; font-family: 'Montserrat', sans-serif;">{{ $tierColor['label'] }}</div>
                <h4 style="font-family: 'Montserrat', sans-serif; font-weight: 900; color: #fff; margin: 0; font-size: 1.25rem; letter-spacing: 1px;">{{ strtoupper($user->name) }}</h4>
              </div>
            </div>

            <!-- Member ID Barcode Display -->
            <div style="background: #fff; border-radius: 8px; padding: 10px 16px; display: inline-flex; align-items: center; gap: 12px; margin-bottom: 16px;">
              <div>
                <!-- SVG Barcode Simulation -->
                <svg width="140" height="30" xmlns="http://www.w3.org/2000/svg">
                  @php
                    $barcode = str_pad($user->id * 137 + 100000, 8, '0', STR_PAD_LEFT);
                    $bars = [3,1,2,1,3,2,1,2,1,3,1,2,3,1,2,1,3,2,1,1,2,3,2,1,3,2,1,2,3,1];
                    $x = 0;
                  @endphp
                  @foreach($bars as $i => $w)
                    @if($i % 2 === 0)
                      <rect x="{{ $x }}" y="0" width="{{ $w * 3 }}" height="28" fill="#111"/>
                    @endif
                    @php $x += $w * 3; @endphp
                  @endforeach
                </svg>
                <div style="font-size: 0.65rem; font-family: 'Courier New', monospace; color: #333; text-align: center; margin-top: 2px; letter-spacing: 3px;">DS-{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}-MBR</div>
              </div>
            </div>

            <!-- Points Progress -->
            <div>
              <div class="d-flex justify-content-between mb-1" style="font-size: 0.75rem;">
                <span style="color: {{ $tierColor['accent'] }}; font-weight: 700;"><i class="bi bi-star-fill me-1"></i>{{ $pts }} Poin</span>
                @if($pts < 100)
                  <span style="color: #888;">{{ $nextTierPts - $pts }} poin lagi → {{ $nextLabel }}</span>
                @else
                  <span style="color: {{ $tierColor['accent'] }}; font-weight: 700;">Tier Tertinggi ✓</span>
                @endif
              </div>
              <div style="height: 6px; background: rgba(255,255,255,0.1); border-radius: 999px; overflow: hidden;">
                <div style="height: 100%; width: {{ $progress }}%; background: linear-gradient(90deg, {{ $tierColor['accent'] }}, {{ $tierColor['accent'] }}cc); border-radius: 999px; transition: width 1s ease;"></div>
              </div>
            </div>
          </div>

          <!-- Right: Stats -->
          <div class="col-12 col-md-5">
            <div class="row g-3">
              <div class="col-6">
                <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 14px; text-align: center;">
                  <div style="font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 1.8rem; color: {{ $tierColor['accent'] }}; line-height: 1;">{{ $pts }}</div>
                  <div style="font-size: 0.65rem; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Total Poin</div>
                </div>
              </div>
              <div class="col-6">
                <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 14px; text-align: center;">
                  <div style="font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 1.8rem; color: #fff; line-height: 1;">{{ $bookings->count() }}</div>
                  <div style="font-size: 0.65rem; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Total Visit</div>
                </div>
              </div>
              <div class="col-12">
                <div style="background: {{ $tierColor['accent'] }}15; border: 1px solid {{ $tierColor['accent'] }}30; border-radius: 10px; padding: 12px 16px; font-size: 0.78rem; color: #ccc; line-height: 1.5;">
                  <i class="bi bi-info-circle me-1" style="color: {{ $tierColor['accent'] }};"></i>
                  Setiap kunjungan = <strong style="color: {{ $tierColor['accent'] }};">+10 poin</strong>. Kumpulkan 50 poin → Gold. 100 poin → VIP Black Member.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ======= FACE-SHAPE HAIRCUT STYLE FINDER ======= -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;" class="mb-4">
      <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
        <div>
          <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #a78bfa; padding-left: 12px; margin: 0;">
            <i class="bi bi-magic me-2" style="color: #a78bfa;"></i>Panduan Gaya Rambut Sesuai Bentuk Wajah
          </h3>
          <p style="font-size: 0.78rem; color: #71717a; margin: 6px 0 0 15px;">Filter berdasarkan bentuk wajah untuk rekomendasi gaya terbaik</p>
        </div>
      </div>

      <!-- Face Shape Filter Buttons -->
      <div class="d-flex gap-2 flex-wrap mb-4" id="faceShapeFilter">
        @php
          $shapes = [
            ['key'=>'all',    'label'=>'Semua Gaya',  'icon'=>'bi-grid-3x3-gap'],
            ['key'=>'oval',   'label'=>'Oval',         'icon'=>'bi-egg'],
            ['key'=>'square', 'label'=>'Kotak',        'icon'=>'bi-square'],
            ['key'=>'round',  'label'=>'Bulat',        'icon'=>'bi-circle'],
            ['key'=>'heart',  'label'=>'Hati',         'icon'=>'bi-suit-heart'],
          ];
        @endphp
        @foreach($shapes as $sh)
          <button type="button" class="btn btn-sm face-filter-btn {{ $sh['key'] === 'all' ? 'active' : '' }}"
            onclick="filterFace('{{ $sh['key'] }}')"
            id="facebtn-{{ $sh['key'] }}"
            style="font-size: 0.75rem; font-family: 'Montserrat', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border: 1px solid rgba(167,139,250,0.4); color: #a78bfa; background: rgba(167,139,250,0.08); border-radius: 6px; padding: 6px 14px; transition: all 0.2s;">
            <i class="bi {{ $sh['icon'] }} me-1"></i>{{ $sh['label'] }}
          </button>
        @endforeach
      </div>

      <!-- Catalog Cards -->
      @php
        $getServicePrice = function($name, $default) use ($services) {
            if (isset($services)) {
                $found = $services->firstWhere('name', $name);
                if ($found) return 'Rp ' . number_format($found->price, 0, ',', '.');
            }
            return 'Rp ' . number_format($default, 0, ',', '.');
        };

        $haircutCatalog = [
          ['name'=>'Pompadour Classic','shape'=>'oval','desc'=>'Volume tinggi di atas, sisi tapering rapi. Cocok untuk wajah oval yang proporsional.','time'=>'45 min','svc'=>'Gentleman Haircut & Wash','price'=>$getServicePrice('Gentleman Haircut & Wash', 75000),'tags'=>['Classic','Volume'],'gradient'=>'135deg, #ff9800, #f44336'],
          ['name'=>'Undercut Modern','shape'=>'square','desc'=>'Sisi dicukur pendek, bagian atas lebih panjang. Melembutkan sudut rahang kotak.','time'=>'40 min','svc'=>'Senior Stylist Haircut & Wash','price'=>$getServicePrice('Senior Stylist Haircut & Wash', 90000),'tags'=>['Trendy','Clean'],'gradient'=>'135deg, #6ea8fe, #0d6efd'],
          ['name'=>'Buzz Cut','shape'=>'round','desc'=>'Pendek merata dengan fade tipis. Membuat wajah bulat terlihat lebih tegas dan berisi.','time'=>'25 min','svc'=>'Junior Stylist Haircut & Wash','price'=>$getServicePrice('Junior Stylist Haircut & Wash', 50000),'tags'=>['Low Maint.','Clean'],'gradient'=>'135deg, #20c997, #0dcaf0'],
          ['name'=>'French Crop','shape'=>'heart','desc'=>'Fringe pendek rata di depan, sisi clean fade. Mengisi bagian dahi yang lebih lebar.','time'=>'35 min','svc'=>'Executive Beard Trim & Hot Towel','price'=>$getServicePrice('Executive Beard Trim & Hot Towel', 60000),'tags'=>['Fringe','Natural'],'gradient'=>'135deg, #e75480, #c44569'],
          ['name'=>'Slick Back','shape'=>'oval','desc'=>'Rambut disisir ke belakang dengan pomade. Memberikan kesan profesional dan elegan.','time'=>'30 min','svc'=>'Gentleman Haircut & Wash','price'=>$getServicePrice('Gentleman Haircut & Wash', 75000),'tags'=>['Formal','Sleek'],'gradient'=>'135deg, #c0c0c0, #808080'],
          ['name'=>'Textured Quiff','shape'=>'square','desc'=>'Quiff bervolume dengan tekstur acak. Mengalihkan fokus dari rahang kotak yang kuat.','time'=>'50 min','svc'=>'Hair Spa & Creambath Premium','price'=>$getServicePrice('Hair Spa & Creambath Premium', 85000),'tags'=>['Textured','Volume'],'gradient'=>'135deg, #fd7e14, #dc3545'],
          ['name'=>'Caesar Cut','shape'=>'round','desc'=>'Poni rata ke depan dengan panjang seragam. Menambah ketinggian visual pada wajah bulat.','time'=>'30 min','svc'=>'Junior Stylist Haircut & Wash','price'=>$getServicePrice('Junior Stylist Haircut & Wash', 50000),'tags'=>['Roman','Classic'],'gradient'=>'135deg, #6f42c1, #6610f2'],
          ['name'=>'Ivy League','shape'=>'heart','desc'=>'Panjang di atas, sisi pendek rapi. Menambah keseimbangan proporsi pada wajah berbentuk hati.','time'=>'40 min','svc'=>'Gentleman Haircut & Wash','price'=>$getServicePrice('Gentleman Haircut & Wash', 75000),'tags'=>['Preppy','Smart'],'gradient'=>'135deg, #198754, #20c997'],
        ];
      @endphp

      <div class="row g-3" id="haircutCatalogGrid">
        @foreach($haircutCatalog as $idx => $hc)
          <div class="col-12 col-sm-6 col-xl-3 haircut-card" data-shape="{{ $hc['shape'] }}">
            <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; overflow: hidden; height: 100%; transition: transform 0.2s, box-shadow 0.2s;" class="haircut-item">
              <!-- Visual Header -->
              <div style="height: 90px; background: linear-gradient({{ $hc['gradient'] }}); position: relative; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-scissors" style="font-size: 2.5rem; color: rgba(255,255,255,0.3);"></i>
                <div style="position: absolute; top: 10px; right: 10px; display: flex; flex-direction: column; gap: 4px;">
                  @foreach($hc['tags'] as $tag)
                    <span style="background: rgba(0,0,0,0.4); color: #fff; font-size: 0.6rem; font-weight: 700; padding: 2px 7px; border-radius: 4px; letter-spacing: 0.5px; text-transform: uppercase; font-family: 'Montserrat', sans-serif;">{{ $tag }}</span>
                  @endforeach
                </div>
                <div style="position: absolute; bottom: 8px; left: 10px;">
                  <span style="background: rgba(0,0,0,0.5); color: #fff; font-size: 0.62rem; padding: 2px 8px; border-radius: 999px; text-transform: capitalize; font-weight: 600;">
                    <i class="bi bi-egg-fill me-1" style="font-size: 0.55rem;"></i>Wajah {{ ucfirst($hc['shape']) === 'Oval' ? 'Oval' : (ucfirst($hc['shape']) === 'Square' ? 'Kotak' : (ucfirst($hc['shape']) === 'Round' ? 'Bulat' : 'Hati')) }}
                  </span>
                </div>
              </div>
              <!-- Content -->
              <div style="padding: 14px 16px;">
                <h6 style="font-family: 'Montserrat', sans-serif; font-weight: 800; color: #fff; margin: 0 0 6px; font-size: 0.88rem;">{{ $hc['name'] }}</h6>
                <p style="font-size: 0.75rem; color: #888; line-height: 1.5; margin: 0 0 12px;">{{ $hc['desc'] }}</p>
                <div class="d-flex justify-content-between align-items-center" style="font-size: 0.75rem; margin-bottom: 10px;">
                  <span style="color: #a1a1aa;"><i class="bi bi-clock me-1"></i>{{ $hc['time'] }}</span>
                  <span style="color: #ff9800; font-weight: 700; font-family: 'Montserrat', sans-serif;">{{ $hc['price'] }}</span>
                </div>
                <button type="button" class="btn btn-sm w-100 fw-bold" style="background: rgba(167,139,250,0.12); border: 1px solid rgba(167,139,250,0.35); color: #a78bfa; font-size: 0.72rem; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;" onclick="selectHaircutStyle('{{ $hc['name'] }}', '{{ $hc['svc'] }}')">
                  <i class="bi bi-calendar-check me-1"></i>Booking Gaya Ini
                </button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- KATALOG PORTFOLIO BARBER & STYLIST FAVORIT -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;" class="mb-4">
      <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #ff9800; padding-left: 12px;" class="mb-4">
        Pilih Kapster Favorit & Portofolio Karya
      </h3>
      
      <div class="row g-3">
        @foreach($stylists as $st)
          @php
            $statusColor = match($st->work_status ?? 'Available') {
              'Available'  => '#28a745',
              'On Duty'    => '#ff9800',
              'Break'      => '#ffc107',
              default      => '#6c757d',
            };
          @endphp
          <div class="col-12 col-md-6 col-xl-4">
            <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.07); padding: 20px; border-radius: 10px;">

              <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width: 46px; height: 46px; border-radius: 50%; background: linear-gradient(135deg, #ff9800, #f44336); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.1rem; color: #fff; flex-shrink: 0;">
                  {{ strtoupper(substr($st->name, 0, 1)) }}
                </div>
                <div>
                  <h5 style="font-weight: 800; color: #fff; margin: 0; font-size: 0.95rem;">{{ $st->name }}</h5>
                  <p style="font-size: 0.72rem; color: #a1a1aa; margin: 2px 0 0;">Art Director & Hair Stylist</p>
                </div>
                <span class="badge ms-auto" style="background: {{ $statusColor }}20; color: {{ $statusColor }}; font-size: 0.68rem; font-weight: 700; border: 1px solid {{ $statusColor }}40;">
                  {{ $st->work_status ?? 'Available' }}
                </span>
              </div>

              @if($st->portfolios->count() > 0)
                <div class="d-flex gap-2 mb-3">
                  @foreach($st->portfolios->take(2) as $pf)
                    <div style="width: 50%; position: relative; overflow: hidden; border-radius: 6px;">
                      <img src="{{ asset($pf->image_path) }}"
                           style="width: 100%; height: 95px; object-fit: cover; display: block;"
                           onerror="this.src='https://ui-avatars.com/api/?name=Style&background=ff9800&color=fff'"
                           alt="{{ $pf->title }}">
                      <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 4px 6px;">
                        <span style="font-size: 0.65rem; color: #ddd; line-height: 1.2; display: block;" class="font-monospace">{{ $pf->title }}</span>
                      </div>
                    </div>
                  @endforeach
                </div>
              @else
                <div style="background: #111; border: 1px dashed rgba(255,255,255,0.1); border-radius: 6px; height: 95px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">
                  <span style="font-size: 0.75rem; color: #71717a;"><i class="bi bi-camera me-1"></i> Portofolio Segera Hadir</span>
                </div>
              @endif

              <button class="btn btn-sm btn-outline-warning w-100 fw-bold py-2" style="font-size: 0.75rem; font-family: 'Montserrat', sans-serif; text-transform: uppercase;" data-bs-toggle="modal" data-bs-target="#newBookingModal" onclick="selectStylistInModal({{ $st->id }})">
                <i class="bi bi-scissors me-1"></i> Pilih {{ $st->name }}
              </button>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- RIWAYAT BOOKING & 1-CLICK REBOOK -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;">
      <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #00c8c8; padding-left: 12px;" class="mb-4">
        Riwayat Pemotongan & 1-Click Rebooking
      </h3>

      @if($bookings->isEmpty())
        <div class="text-center py-5 text-muted">
          <i class="bi bi-journal-x" style="font-size: 40px; display: block; margin-bottom: 8px;"></i>
          <p class="mb-0">Anda belum memiliki riwayat booking pemotongan.</p>
        </div>
      @else
        <div class="table-responsive">
          <table class="table table-dark table-hover align-middle mb-0" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
            <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; color: #a1a1aa;">
              <tr>
                <th>No. Antrean</th>
                <th>Cabang</th>
                <th>Layanan</th>
                <th>Jadwal Potong</th>
                <th>Stylist</th>
                <th>Status</th>
                <th class="text-end">Aksi Rebook</th>
              </tr>
            </thead>
            <tbody>
              @foreach($bookings as $b)
                <tr>
                  <td><span class="badge bg-warning text-dark font-monospace fw-bold fs-6">{{ $b->queue_number ?? 'A-00' . $b->id }}</span></td>
                  <td>{{ $b->branch }}</td>
                  <td><strong class="text-white">{{ $b->service }}</strong></td>
                  <td><span class="font-monospace">{{ $b->booking_date }} jam {{ $b->booking_time }}</span></td>
                  <td><span class="badge bg-dark border border-secondary">{{ $b->stylist ? $b->stylist->name : 'Auto Assign' }}</span></td>
                  <td>
                    <span class="badge 
                      @if($b->status === 'completed') bg-success
                      @elseif($b->status === 'approved') bg-warning text-dark
                      @else bg-secondary @endif font-monospace">
                      {{ strtoupper($b->status) }}
                    </span>
                  </td>
                  <td class="text-end">
                    <div class="btn-group">
                      @if(in_array($b->status, ['pending', 'approved']))
                        @php
                          $bWa = str_contains($b->branch, 'Bandung') ? '6281398765432' : '6281234567890';
                          $bWaMsg = "Halo District Studio, saya ingin konfirmasi reservasi saya:\n\n"
                                  . "• No. Antrean: " . ($b->queue_number ?? 'A-00' . $b->id) . "\n"
                                  . "• Layanan: " . $b->service . "\n"
                                  . "• Cabang: " . $b->branch . "\n"
                                  . "• Jadwal: " . $b->booking_date . " jam " . $b->booking_time . " WIB\n\n"
                                  . "Mohon konfirmasinya ya. Terima kasih!";
                        @endphp
                        <a href="https://wa.me/{{ $bWa }}?text={{ urlencode($bWaMsg) }}" target="_blank" class="btn btn-sm btn-outline-success fw-semibold" style="font-size: 0.72rem;" title="Konfirmasi via WhatsApp">
                          <i class="bi bi-whatsapp"></i> Konfirmasi WA
                        </a>
                      @endif

                      <form action="{{ route('customer.rebook', $b->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold" style="font-size: 0.72rem;">
                          ⚡ 1-Click Rebook
                        </button>
                      </form>

                      @if($b->status === 'completed')
                        <button class="btn btn-sm btn-outline-light" style="font-size: 0.72rem;" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $b->id }}">
                          ⭐ Beri Ulasan
                        </button>
                      @endif
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

  </div>
</main>

<!-- MODAL NEW BOOKING -->
<div class="modal fade" id="newBookingModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-warning"><i class="bi bi-calendar-plus me-2"></i>Form Pemesanan Slot Potong Rambut</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          {{-- Banner Model Rambut Terpilih --}}
          <div id="selectedHaircutBanner" style="display: none; background: rgba(167,139,250,0.15); border: 1px solid rgba(167,139,250,0.4); border-radius: 8px; padding: 10px 14px;" class="mb-3">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <span style="font-size: 0.68rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a78bfa; text-transform: uppercase; letter-spacing: 1px; display: block;">
                  <i class="bi bi-scissors me-1"></i> Model Gaya Rambut Terpilih:
                </span>
                <strong id="selectedHaircutName" style="color: #fff; font-size: 0.95rem;"></strong>
              </div>
              <button type="button" class="btn btn-sm btn-link text-white-50 p-0" onclick="clearSelectedHaircut()" title="Hapus Pilihan Model">
                <i class="bi bi-x-circle" style="font-size: 1.1rem;"></i>
              </button>
            </div>
          </div>
          <input type="hidden" name="haircut_model" id="inputHaircutModel" value="">

          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Pilih Cabang District Studio:</label>
            <select name="branch" class="form-select bg-secondary text-white border-0" required>
              <option value="Jakarta Kebayoran Baru">Jakarta Kebayoran Baru</option>
              <option value="Bandung Citarum">Bandung Citarum</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Model Gaya Rambut (Opsional):</label>
            <select id="modalHaircutSelect" class="form-select bg-secondary text-white border-0" onchange="onManualModelChange(this)">
              <option value="">-- Bebas / Konsultasi Gaya di Tempat --</option>
              <option value="Pompadour Classic">Pompadour Classic (Wajah Oval)</option>
              <option value="Undercut Modern">Undercut Modern (Wajah Kotak)</option>
              <option value="Buzz Cut">Buzz Cut (Wajah Bulat)</option>
              <option value="French Crop">French Crop (Wajah Hati)</option>
              <option value="Slick Back">Slick Back (Wajah Oval)</option>
              <option value="Textured Quiff">Textured Quiff (Wajah Kotak)</option>
              <option value="Caesar Cut">Caesar Cut (Wajah Bulat)</option>
              <option value="Ivy League">Ivy League (Wajah Hati)</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Pilih Layanan Cukur / Styling:</label>
            <select name="service" id="modalServiceSelect" class="form-select bg-secondary text-white border-0" required>
              @foreach($services as $s)
                <option value="{{ $s->name }} (IDR {{ number_format($s->price, 0, ',', '.') }})">{{ $s->name }} - Rp {{ number_format($s->price, 0, ',', '.') }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Tanggal Booking:</label>
            <input type="date" name="booking_date" class="form-control bg-secondary text-white border-0" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Waktu / Slot Jam Dipilih:</label>
            <select name="booking_time" class="form-select bg-secondary text-white border-0" required>
              <option value="10:00">10:00 WIB</option>
              <option value="11:00">11:00 WIB</option>
              <option value="13:00">13:00 WIB</option>
              <option value="14:00">14:00 WIB</option>
              <option value="15:00">15:00 WIB</option>
              <option value="16:00">16:00 WIB</option>
              <option value="17:00">17:00 WIB</option>
              <option value="19:00">19:00 WIB</option>
              <option value="20:00">20:00 WIB</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Pilih Hair Stylist / Barber:</label>
            <select name="stylist_id" id="modalStylistSelect" class="form-select bg-secondary text-white border-0">
              <option value="">-- Bebas / Mana Saja --</option>
              @foreach($stylists as $st)
                <option value="{{ $st->id }}">{{ $st->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold">Konfirmasi Booking</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODALS REVIEW PELANGGAN -->
@foreach($bookings as $b)
  @if($b->status === 'completed')
    <div class="modal fade" id="reviewModal{{ $b->id }}" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
          <div class="modal-header border-secondary">
            <h5 class="modal-title font-monospace text-warning"><i class="bi bi-star-fill me-2"></i>Ulasan Sesi Potong #{{ $b->id }}</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <form action="{{ route('customer.review') }}" method="POST">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $b->id }}">
            <input type="hidden" name="stylist_id" value="{{ $b->stylist_id }}">
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label" style="font-size: 0.8rem;">Berikan Rating Bintang (1 - 5):</label>
                <select name="rating" class="form-select bg-secondary text-white border-0" required>
                  <option value="5">⭐⭐⭐⭐⭐ 5/5 - Sangat Puas</option>
                  <option value="4">⭐⭐⭐⭐ 4/5 - Bagus</option>
                  <option value="3">⭐⭐⭐ 3/5 - Cukup</option>
                  <option value="2">⭐⭐ 2/5 - Kurang</option>
                  <option value="1">⭐ 1/5 - Kecewa</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label" style="font-size: 0.8rem;">Komentar / Masukan:</label>
                <textarea name="comment" class="form-control bg-secondary text-white border-0" rows="3" placeholder="Potongan rapi, kapster ramah..."></textarea>
              </div>
            </div>
            <div class="modal-footer border-secondary">
              <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold">Kirim Ulasan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif
@endforeach

<script>
  function selectHaircutStyle(modelName, targetSvcName) {
    const inputModel = document.getElementById('inputHaircutModel');
    const selectModel = document.getElementById('modalHaircutSelect');
    const banner = document.getElementById('selectedHaircutBanner');
    const label = document.getElementById('selectedHaircutName');
    const serviceSelect = document.getElementById('modalServiceSelect');

    if (inputModel) inputModel.value = modelName;
    if (selectModel) selectModel.value = modelName;
    if (label) label.textContent = modelName;
    if (banner) banner.style.display = 'block';

    // Auto select target service in dropdown if matching
    if (serviceSelect && targetSvcName) {
      for (let i = 0; i < serviceSelect.options.length; i++) {
        if (serviceSelect.options[i].value.toLowerCase().includes(targetSvcName.toLowerCase())) {
          serviceSelect.selectedIndex = i;
          break;
        }
      }
    }

    const modalEl = document.getElementById('newBookingModal');
    if (modalEl) {
      const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
      modal.show();
    }
  }

  function onManualModelChange(sel) {
    const val = sel.value;
    const inputModel = document.getElementById('inputHaircutModel');
    const banner = document.getElementById('selectedHaircutBanner');
    const label = document.getElementById('selectedHaircutName');

    if (inputModel) inputModel.value = val;
    if (val) {
      if (label) label.textContent = val;
      if (banner) banner.style.display = 'block';
    } else {
      if (banner) banner.style.display = 'none';
    }
  }

  function clearSelectedHaircut() {
    const inputModel = document.getElementById('inputHaircutModel');
    const selectModel = document.getElementById('modalHaircutSelect');
    const banner = document.getElementById('selectedHaircutBanner');

    if (inputModel) inputModel.value = '';
    if (selectModel) selectModel.value = '';
    if (banner) banner.style.display = 'none';
  }

  function selectStylistInModal(stylistId) {
    const sel = document.getElementById('modalStylistSelect');
    if (sel) {
      sel.value = stylistId;
    }
  }

  function filterFace(shape) {
    // Update active button style
    document.querySelectorAll('.face-filter-btn').forEach(btn => {
      btn.style.background = 'rgba(167,139,250,0.08)';
      btn.style.color = '#a78bfa';
      btn.style.borderColor = 'rgba(167,139,250,0.4)';
    });
    const activeBtn = document.getElementById('facebtn-' + shape);
    if (activeBtn) {
      activeBtn.style.background = 'rgba(167,139,250,0.3)';
      activeBtn.style.color = '#fff';
      activeBtn.style.borderColor = '#a78bfa';
    }

    // Filter cards
    document.querySelectorAll('.haircut-card').forEach(card => {
      if (shape === 'all' || card.dataset.shape === shape) {
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });
  }

  // Hover effect for haircut cards
  document.querySelectorAll('.haircut-item').forEach(card => {
    card.addEventListener('mouseenter', () => {
      card.style.transform = 'translateY(-4px)';
      card.style.boxShadow = '0 12px 30px rgba(167,139,250,0.15)';
      card.style.borderColor = 'rgba(167,139,250,0.3)';
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
      card.style.boxShadow = '';
      card.style.borderColor = 'rgba(255,255,255,0.07)';
    });
  });
</script>
@endsection
