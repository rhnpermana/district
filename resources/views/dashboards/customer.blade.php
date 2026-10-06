@extends('admin_layout.app')

@section('title', 'Dashboard Member & Booking - District Studio')

@section('content')
<main class="main" style="padding-top: 56px; min-height: 100vh; background-color: #09090b;">

  <!-- Customer Header Banner -->
  <section style="background: linear-gradient(135deg, #1f1a10 0%, #120e08 100%); border-bottom: 1px solid rgba(255,152,0,0.25);" class="py-3 py-md-4">
    <div class="container-fluid container-xl">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
          <span style="background: rgba(255,152,0,0.15); color: #ff9800; font-size: 0.68rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; padding: 4px 10px; border: 1px solid rgba(255,152,0,0.3); border-radius: 4px; font-family: 'Montserrat', sans-serif;">
            <i class="bi bi-person-badge-fill me-1"></i> Member Workstation
          </span>
          <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.4rem; font-weight: 900; color: #fff; text-transform: uppercase; margin-top: 8px; margin-bottom: 0;" class="fs-md-2">
            Halo, {{ auth()->user()->name }} <span style="color: #ff9800;">.</span>
          </h2>
          <p class="d-none d-md-block" style="font-size: 0.85rem; color: #a1a1aa; margin: 4px 0 0;">Pesan slot potong rambut, pilih kapster favorit, lacak antrean live di HP, dan re-book 1-klik.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
          @if($activeBooking)
            <a href="{{ route('queue.live', $activeBooking->id) }}" class="btn btn-warning text-dark btn-sm fw-bold px-3 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="bi bi-broadcast me-1"></i> Tracker ({{ $activeBooking->queue_number ?? 'A-00' . $activeBooking->id }})
            </a>
          @endif
          <button class="btn btn-outline-warning btn-sm fw-bold px-3 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;" data-bs-toggle="modal" data-bs-target="#newBookingModal">
            <i class="bi bi-calendar-plus me-1"></i> + Buat Booking
          </button>
        </div>
      </div>
    </div>
  </section>

  <div class="container-fluid container-xl" style="padding: 20px 15px 70px;">

    @if(session('success'))
      <div class="alert alert-dismissible fade show d-flex align-items-center justify-content-between mb-3" role="alert" style="background: rgba(255,152,0,0.15); border: 1px solid rgba(255,152,0,0.4); color: #fff; border-radius: 8px; padding: 12px 16px;">
        <div class="d-flex align-items-center">
          <i class="bi bi-check-circle-fill me-2" style="color: #ff9800; font-size: 1.1rem;"></i>
          <div style="font-size: 0.85rem;">{{ session('success') }}</div>
        </div>
        <div class="d-flex align-items-center gap-2">
          @if(session('wa_url'))
            <a href="{{ session('wa_url') }}" target="_blank" class="btn btn-sm btn-success fw-bold px-2 py-1" style="font-size: 0.75rem;">
              <i class="bi bi-whatsapp me-1"></i> WA
            </a>
          @endif
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
      </div>
    @endif

    <!-- LIVE QUEUE TRACKER BANNER -->
    @if($activeBooking)
      <div style="background: linear-gradient(145deg, #1e170c 0%, #110d06 100%); border: 2px solid #ff9800; padding: 18px 20px; border-radius: 12px;" class="mb-4 shadow-lg">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
          <div>
            <span class="badge bg-warning text-dark fw-bold mb-1 font-monospace" style="font-size: 0.65rem;">LIVE ANTREAN AKTIF</span>
            <h3 style="font-family: 'Montserrat', sans-serif; font-weight: 900; color: #ff9800; margin: 0; font-size: 1.8rem;">
              {{ $activeBooking->queue_number ?? 'A-00' . $activeBooking->id }}
            </h3>
            <p style="color: #fff; margin: 2px 0 0; font-size: 0.88rem;">
              Layanan: <strong>{{ $activeBooking->service }}</strong>
            </p>
            <div style="font-size: 0.78rem; color: #a1a1aa;" class="mt-1">
              {{ $activeBooking->branch }} | Stylist: <strong>{{ $activeBooking->stylist ? $activeBooking->stylist->name : 'Auto Assign' }}</strong> | Jam: <strong>{{ $activeBooking->booking_time }} WIB</strong>
            </div>
          </div>
          <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('queue.live', $activeBooking->id) }}" class="btn btn-warning text-dark fw-bold px-3 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="bi bi-phone-vibrate me-1"></i> Buka Tracker
            </a>
            @php
              $branchWa = str_contains($activeBooking->branch, 'Bandung') ? '6281398765432' : '6281234567890';
              $waLiveMsg = "Halo District Studio, saya pemilik antrean *" . ($activeBooking->queue_number ?? 'A-00' . $activeBooking->id) . "* (Layanan: " . $activeBooking->service . "). Saya ingin menanyakan estimasi waktu panggilan antrean saya. Terima kasih!";
            @endphp
            <a href="https://wa.me/{{ $branchWa }}?text={{ urlencode($waLiveMsg) }}" target="_blank" class="btn btn-success fw-bold px-3 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
              <i class="bi bi-whatsapp me-1"></i> Tanya WA
            </a>
          </div>
        </div>
      </div>
    @endif

    <!-- VOUCHER PROMO BANNER -->
    @if(isset($vouchers) && $vouchers->count() > 0)
      <div style="background: #121215; border: 1px solid rgba(255,193,7,0.25); border-radius: 12px; padding: 14px 18px;" class="mb-4">
        <div class="d-flex align-items-center gap-2 mb-2">
          <i class="bi bi-ticket-perforated-fill text-warning" style="font-size: 1.1rem;"></i>
          <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.8rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0;">
            Voucher Promo Diskon Aktif
          </h5>
        </div>
        <div class="d-flex gap-2 overflow-x-auto pb-1 flex-nowrap flex-md-wrap">
          @foreach($vouchers as $v)
            <div style="background: rgba(255,193,7,0.1); border: 1px dashed #ffc107; padding: 5px 10px; border-radius: 6px; white-space: nowrap;" class="d-flex align-items-center gap-2">
              <span class="font-monospace fw-bold text-warning" style="font-size: 0.82rem;">{{ $v->code }}</span>
              <small class="text-white-50" style="font-size: 0.7rem;">(Diskon {{ $v->type === 'percent' ? $v->discount_value.'%' : 'Rp '.number_format($v->discount_value, 0, ',', '.') }})</small>
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
      <div style="background: linear-gradient(135deg, {{ $tierColor['from'] }} 0%, {{ $tierColor['to'] }} 100%); border: 1px solid {{ $tierColor['accent'] }}40; border-radius: 16px; padding: 22px 24px; position: relative; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.5);">
        <!-- Background Decoration -->
        <div style="position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; border-radius: 50%; background: {{ $tierColor['accent'] }}08; pointer-events: none;"></div>
        <div style="position: absolute; bottom: -60px; left: -20px; width: 180px; height: 180px; border-radius: 50%; background: {{ $tierColor['accent'] }}05; pointer-events: none;"></div>

        <div class="row g-3 align-items-center">
          <!-- Left: Identity -->
          <div class="col-12 col-md-7">
            <div class="d-flex align-items-center gap-3 mb-2">
              <div style="width: 44px; height: 44px; border-radius: 50%; background: {{ $tierColor['accent'] }}20; border: 2px solid {{ $tierColor['accent'] }}60; display:flex; align-items:center; justify-content:center; flex-shrink: 0;">
                <i class="bi {{ $tierColor['icon'] }}" style="font-size: 1.3rem; color: {{ $tierColor['accent'] }};"></i>
              </div>
              <div>
                <div style="font-size: 0.62rem; font-weight: 800; letter-spacing: 2px; color: {{ $tierColor['accent'] }}; text-transform: uppercase; font-family: 'Montserrat', sans-serif;">{{ $tierColor['label'] }}</div>
                <h4 style="font-family: 'Montserrat', sans-serif; font-weight: 900; color: #fff; margin: 0; font-size: 1.15rem; letter-spacing: 0.5px;">{{ strtoupper($user->name) }}</h4>
              </div>
            </div>

            <!-- Member ID Barcode Display -->
            <div style="background: #fff; border-radius: 6px; padding: 6px 12px; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 12px;">
              <div style="font-size: 0.65rem; font-family: 'Courier New', monospace; color: #111; font-weight: 800; letter-spacing: 2px;">
                <i class="bi bi-upc-scan me-1"></i>DS-{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}-MBR
              </div>
            </div>

            <!-- Points Progress -->
            <div>
              <div class="d-flex justify-content-between mb-1" style="font-size: 0.72rem;">
                <span style="color: {{ $tierColor['accent'] }}; font-weight: 700;"><i class="bi bi-star-fill me-1"></i>{{ $pts }} Poin</span>
                @if($pts < 100)
                  <span style="color: #aaa;">{{ $nextTierPts - $pts }} poin lagi → {{ $nextLabel }}</span>
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
            <div class="row g-2">
              <div class="col-6">
                <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 10px; text-align: center;">
                  <div style="font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 1.5rem; color: {{ $tierColor['accent'] }}; line-height: 1;">{{ $pts }}</div>
                  <div style="font-size: 0.62rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 3px;">Total Poin</div>
                </div>
              </div>
              <div class="col-6">
                <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 10px; text-align: center;">
                  <div style="font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 1.5rem; color: #fff; line-height: 1;">{{ $bookings->count() }}</div>
                  <div style="font-size: 0.62rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 3px;">Total Visit</div>
                </div>
              </div>
              <div class="col-12 d-none d-md-block">
                <div style="background: {{ $tierColor['accent'] }}15; border: 1px solid {{ $tierColor['accent'] }}30; border-radius: 8px; padding: 10px 14px; font-size: 0.75rem; color: #ccc; line-height: 1.4;">
                  <i class="bi bi-info-circle me-1" style="color: {{ $tierColor['accent'] }};"></i>
                  Setiap kunjungan = <strong style="color: {{ $tierColor['accent'] }};">+10 poin</strong>. 50 poin → Gold. 100 poin → VIP Black.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ======= KATALOG & PEMBELIAN PRODUK GROOMING RESMI ======= -->
    <div style="background: #121215; border: 1px solid rgba(255,152,0,0.25); border-radius: 12px; padding: 18px 20px;" class="mb-4">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
        <div>
          <span class="badge bg-warning text-dark fw-bold mb-1" style="font-size: 0.65rem;">PRODUK GROOMING RESMI</span>
          <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #ff9800; padding-left: 10px; margin: 0;">
            <i class="bi bi-bag-check-fill me-2" style="color: #ff9800;"></i>Pembelian Produk Grooming
          </h3>
          <p class="d-none d-md-block" style="font-size: 0.75rem; color: #a1a1aa; margin: 4px 0 0 13px;">Dapatkan produk perawatan dan penataan rambut resmi dari District Studio untuk penggunaan di rumah</p>
        </div>
      </div>

      <div class="row g-3">
        @if(isset($products) && $products->count() > 0)
          @foreach($products as $prod)
            <div class="col-6 col-md-4 col-xl-3">
              <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; overflow: hidden; height: 100%; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;" class="product-item">
                <div>
                  <div style="height: 140px; background: #222; position: relative; overflow: hidden;">
                    @if(!empty($prod->image))
                      <img src="{{ asset($prod->image) }}" alt="{{ $prod->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                      <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark">
                        <i class="bi bi-box-seam text-white-50" style="font-size: 2.5rem;"></i>
                      </div>
                    @endif
                    <span class="badge position-absolute top-0 start-0 m-2" style="background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); color: #ff9800; font-size: 0.62rem; font-weight: 700; border: 1px solid rgba(255,152,0,0.4);">
                      {{ $prod->category }}
                    </span>
                    <span class="badge position-absolute bottom-0 end-0 m-2 bg-dark text-success border border-success" style="font-size: 0.6rem;">
                      Stok: {{ $prod->stock }}
                    </span>
                  </div>
                  <div style="padding: 10px 12px;">
                    <h6 style="font-family: 'Montserrat', sans-serif; font-weight: 800; color: #fff; margin: 0 0 4px; font-size: 0.82rem; line-height: 1.3;">{{ $prod->name }}</h6>
                    <p class="d-none d-sm-block text-muted small mb-2" style="font-size: 0.7rem; line-height: 1.3; min-height: 28px;">{{ Str::limit($prod->description, 60) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                      <span style="color: #ff9800; font-weight: 800; font-size: 0.92rem; font-family: 'Montserrat', sans-serif;">
                        Rp {{ number_format($prod->price, 0, ',', '.') }}
                      </span>
                    </div>
                  </div>
                </div>
                <div style="padding: 0 12px 12px;">
                  @php
                    $prodWaMsg = "Halo District Studio, saya " . auth()->user()->name . " ingin memesan produk: *" . $prod->name . "* (Harga: Rp " . number_format($prod->price, 0, ',', '.') . "). Mohon konfirmasi ketersediaan stoknya. Terima kasih!";
                  @endphp
                  <a href="https://wa.me/6285770394148?text={{ urlencode($prodWaMsg) }}" target="_blank" class="btn btn-sm w-100 fw-bold py-1 text-dark" style="background-color: #ff9800; font-size: 0.68rem; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 4px;">
                    <i class="bi bi-cart-plus-fill me-1"></i> Pesan Produk
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>

    <!-- ======= INSPIRASI & CONTOH GAYA RAMBUT (GAMBARAN VISUAL SAJA) ======= -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 18px 20px;" class="mb-4">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
        <div>
          <h3 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #a78bfa; padding-left: 10px; margin: 0;">
            <i class="bi bi-images me-2" style="color: #a78bfa;"></i>Inspirasi & Contoh Gaya Rambut
          </h3>
          <p style="font-size: 0.75rem; color: #a1a1aa; margin: 4px 0 0 13px;">
            Gambar di bawah adalah <strong>contoh gambaran model rambut</strong>. Anda cukup membooking tempat & menceritakan detail cukur yang diinginkan pada form booking.
          </p>
        </div>
      </div>

      <!-- Info Alert: Gaya Rambut Sebagai Gambaran -->
      <div style="background: rgba(167,139,250,0.08); border: 1px dashed rgba(167,139,250,0.35); border-radius: 8px; padding: 10px 14px;" class="mb-3 d-flex align-items-center gap-2">
        <i class="bi bi-info-circle-fill text-warning" style="font-size: 1.1rem; flex-shrink: 0;"></i>
        <div style="font-size: 0.75rem; color: #d4d4d8;">
          <strong>Catatan:</strong> Gaya rambut di website hanya sebagai contoh referensi visual. Saat melakukan booking tempat, Anda dapat menuliskan detail model yang diinginkan di kolom catatan request cukur.
        </div>
      </div>

      <!-- Face Shape Filter Buttons -->
      <div class="d-flex gap-2 overflow-x-auto pb-2 mb-3 text-nowrap" id="faceShapeFilter" style="scrollbar-width: none;">
        @php
          $shapes = [
            ['key'=>'all',    'label'=>'Semua Contoh', 'icon'=>'bi-grid-3x3-gap'],
            ['key'=>'oval',   'label'=>'Wajah Oval',   'icon'=>'bi-egg'],
            ['key'=>'square', 'label'=>'Wajah Kotak',  'icon'=>'bi-square'],
            ['key'=>'round',  'label'=>'Wajah Bulat',  'icon'=>'bi-circle'],
            ['key'=>'heart',  'label'=>'Wajah Hati',   'icon'=>'bi-suit-heart'],
          ];
        @endphp
        @foreach($shapes as $sh)
          <button type="button" class="btn btn-sm face-filter-btn {{ $sh['key'] === 'all' ? 'active' : '' }}"
            onclick="filterFace('{{ $sh['key'] }}')"
            id="facebtn-{{ $sh['key'] }}"
            style="font-size: 0.72rem; font-family: 'Montserrat', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid rgba(167,139,250,0.4); color: #a78bfa; background: rgba(167,139,250,0.08); border-radius: 6px; padding: 5px 12px; transition: all 0.2s; white-space: nowrap; flex-shrink: 0;">
            <i class="bi {{ $sh['icon'] }} me-1"></i>{{ $sh['label'] }}
          </button>
        @endforeach
      </div>

      <!-- Catalog Cards (Visual Inspiration Only) -->
      @php
        $haircutCatalog = [
          ['name'=>'Pompadour Classic','shape'=>'oval','desc'=>'Volume tinggi di atas, sisi tapering rapi. Cocok untuk wajah oval yang proporsional.','tags'=>['Classic','Volume'],'gradient'=>'135deg, #ff9800, #f44336'],
          ['name'=>'Undercut Modern','shape'=>'square','desc'=>'Sisi dicukur pendek, bagian atas lebih panjang. Melembutkan sudut rahang kotak.','tags'=>['Trendy','Clean'],'gradient'=>'135deg, #6ea8fe, #0d6efd'],
          ['name'=>'Buzz Cut Fade','shape'=>'round','desc'=>'Pendek merata dengan skin fade bersih. Membuat wajah bulat terlihat lebih tegas.','tags'=>['Low Maint.','Clean'],'gradient'=>'135deg, #20c997, #0dcaf0'],
          ['name'=>'French Crop','shape'=>'heart','desc'=>'Fringe pendek rata di depan, sisi clean fade. Menyeimbangkan bagian dahi yang lebar.','tags'=>['Fringe','Natural'],'gradient'=>'135deg, #e75480, #c44569'],
          ['name'=>'Slick Back Undercut','shape'=>'oval','desc'=>'Rambut disisir rapi ke belakang dengan pomade untuk kesan elegan & formal.','tags'=>['Formal','Sleek'],'gradient'=>'135deg, #c0c0c0, #808080'],
          ['name'=>'Textured Quiff','shape'=>'square','desc'=>'Quiff bervolume dengan tekstur acak natural untuk gaya modern kasual.','tags'=>['Textured','Volume'],'gradient'=>'135deg, #fd7e14, #dc3545'],
          ['name'=>'Caesar Cut','shape'=>'round','desc'=>'Poni rata ke depan dengan panjang seragam, menambah ketegasan visual wajah.','tags'=>['Roman','Classic'],'gradient'=>'135deg, #6f42c1, #6610f2'],
          ['name'=>'Korean Two Block Cut','shape'=>'heart','desc'=>'Gaya rambut layer K-pop modern dengan down perm samping yang rapi.','tags'=>['K-Pop','Trendy'],'gradient'=>'135deg, #198754, #20c997'],
        ];
      @endphp

      <div class="row g-3" id="haircutCatalogGrid">
        @foreach($haircutCatalog as $idx => $hc)
          <div class="col-6 col-md-4 col-xl-3 haircut-card" data-shape="{{ $hc['shape'] }}">
            <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; overflow: hidden; height: 100%; display: flex; flex-direction: column; justify-content: space-between;" class="haircut-item">
              <div>
                <div style="height: 85px; background: linear-gradient({{ $hc['gradient'] }}); position: relative; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-scissors" style="font-size: 2.2rem; color: rgba(255,255,255,0.35);"></i>
                  <div style="position: absolute; top: 6px; right: 6px; display: flex; flex-direction: column; gap: 2px;">
                    @foreach($hc['tags'] as $tag)
                      <span style="background: rgba(0,0,0,0.6); color: #fff; font-size: 0.55rem; font-weight: 700; padding: 1px 5px; border-radius: 3px; text-transform: uppercase; font-family: 'Montserrat', sans-serif;">{{ $tag }}</span>
                    @endforeach
                  </div>
                  <div style="position: absolute; bottom: 6px; left: 8px;">
                    <span style="background: rgba(0,0,0,0.6); color: #fff; font-size: 0.58rem; padding: 2px 6px; border-radius: 999px; text-transform: capitalize; font-weight: 600;">
                      Wajah {{ ucfirst($hc['shape']) === 'Oval' ? 'Oval' : (ucfirst($hc['shape']) === 'Square' ? 'Kotak' : (ucfirst($hc['shape']) === 'Round' ? 'Bulat' : 'Hati')) }}
                    </span>
                  </div>
                </div>
                <!-- Content -->
                <div style="padding: 10px 12px;">
                  <h6 style="font-family: 'Montserrat', sans-serif; font-weight: 800; color: #fff; margin: 0 0 4px; font-size: 0.82rem;">{{ $hc['name'] }}</h6>
                  <p style="font-size: 0.72rem; color: #888; line-height: 1.4; margin: 0 0 6px;">{{ $hc['desc'] }}</p>
                </div>
              </div>
              <div style="padding: 0 12px 10px;">
                <span class="badge w-100 text-center py-1" style="background: rgba(255,255,255,0.05); color: #a1a1aa; font-size: 0.65rem; border: 1px solid rgba(255,255,255,0.08);">
                  <i class="bi bi-eye me-1"></i> Contoh Gambaran
                </span>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- KATALOG PORTFOLIO BARBER & STYLIST FAVORIT -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 18px 20px;" class="mb-4">
      <h3 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #ff9800; padding-left: 10px;" class="mb-3">
        Pilih Hair Artist Favorit
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
            <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.07); padding: 14px 16px; border-radius: 10px;">

              <div class="d-flex align-items-center gap-3 mb-2">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #ff9800, #f44336); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1rem; color: #fff; flex-shrink: 0;">
                  {{ strtoupper(substr($st->name, 0, 1)) }}
                </div>
                <div>
                  <h5 style="font-weight: 800; color: #fff; margin: 0; font-size: 0.9rem;">{{ $st->name }}</h5>
                  <p style="font-size: 0.7rem; color: #a1a1aa; margin: 1px 0 0;">Art Director & Stylist</p>
                </div>
                <span class="badge ms-auto" style="background: {{ $statusColor }}20; color: {{ $statusColor }}; font-size: 0.65rem; font-weight: 700; border: 1px solid {{ $statusColor }}40;">
                  {{ $st->work_status ?? 'Available' }}
                </span>
              </div>

              @if($st->portfolios->count() > 0)
                <div class="d-flex gap-2 mb-2">
                  @foreach($st->portfolios->take(2) as $pf)
                    <div style="width: 50%; position: relative; overflow: hidden; border-radius: 6px;">
                      <img src="{{ asset($pf->image_path) }}"
                           style="width: 100%; height: 85px; object-fit: cover; display: block;"
                           onerror="this.src='https://ui-avatars.com/api/?name=Style&background=ff9800&color=fff'"
                           alt="{{ $pf->title }}">
                      <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 3px 5px;">
                        <span style="font-size: 0.62rem; color: #ddd; line-height: 1.1; display: block;" class="font-monospace text-truncate">{{ $pf->title }}</span>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif

              <button class="btn btn-sm btn-outline-warning w-100 fw-bold py-1 mt-1" style="font-size: 0.72rem; font-family: 'Montserrat', sans-serif; text-transform: uppercase;" data-bs-toggle="modal" data-bs-target="#newBookingModal" onclick="selectStylistInModal({{ $st->id }})">
                <i class="bi bi-scissors me-1"></i> Booking Bersama {{ $st->name }}
              </button>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- RIWAYAT BOOKING & 1-CLICK REBOOK -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 18px 20px;">
      <h3 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #00c8c8; padding-left: 10px;" class="mb-3">
        Riwayat Reservasi Tempat & Rebook
      </h3>

      @if($bookings->isEmpty())
        <div class="text-center py-4 text-muted">
          <i class="bi bi-journal-x" style="font-size: 36px; display: block; margin-bottom: 6px;"></i>
          <p class="mb-0" style="font-size: 0.85rem;">Anda belum memiliki riwayat reservasi.</p>
        </div>
      @else
        <!-- Desktop Table View (>= md) -->
        <div class="table-responsive d-none d-md-block">
          <table class="table table-dark table-hover align-middle mb-0" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
            <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; color: #a1a1aa;">
              <tr>
                <th>No. Antrean</th>
                <th>Cabang</th>
                <th>Layanan & Detail Cukur</th>
                <th>Jadwal Potong</th>
                <th>Stylist</th>
                <th>Status</th>
                <th class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($bookings as $b)
                <tr>
                  <td><span class="badge bg-warning text-dark font-monospace fw-bold fs-6">{{ $b->queue_number ?? 'A-00' . $b->id }}</span></td>
                  <td><small class="text-muted">{{ $b->branch }}</small></td>
                  <td>
                    <strong class="text-white">{{ $b->service }}</strong>
                    @if(!empty($b->notes))
                      <div class="small text-warning mt-1" style="font-size: 0.75rem;">
                        <i class="bi bi-chat-left-dots me-1"></i>Catatan: {{ $b->notes }}
                      </div>
                    @endif
                  </td>
                  <td><span class="font-monospace">{{ $b->booking_date }} jam {{ $b->booking_time }} WIB</span></td>
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
                          $bWa = '6285770394148';
                          $notesPart = $b->notes ? "\n• Detail Cukur: " . $b->notes : "";
                          $bWaMsg = "Halo District Studio, saya ingin konfirmasi reservasi saya:\n\n"
                                  . "• No. Antrean: " . ($b->queue_number ?? 'A-00' . $b->id) . "\n"
                                  . "• Layanan: " . $b->service . $notesPart . "\n"
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

        <!-- Mobile Card List View (< md) - Clean & Simplified -->
        <div class="d-md-none d-flex flex-column gap-3">
          @foreach($bookings as $b)
            <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 14px;">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="badge bg-warning text-dark font-monospace fw-bold" style="font-size: 0.8rem;">
                  {{ $b->queue_number ?? 'A-00' . $b->id }}
                </span>
                <span class="badge 
                  @if($b->status === 'completed') bg-success 
                  @elseif($b->status === 'approved') bg-warning text-dark 
                  @else bg-secondary @endif font-monospace text-uppercase" style="font-size: 0.65rem;">
                  {{ $b->status }}
                </span>
              </div>
              <div class="fw-bold text-white mb-1" style="font-size: 0.88rem;">{{ $b->service }}</div>
              @if(!empty($b->notes))
                <div class="small text-warning mb-2" style="font-size: 0.75rem;">
                  <i class="bi bi-chat-left-dots me-1"></i>Catatan: {{ $b->notes }}
                </div>
              @endif
              <div style="font-size: 0.74rem; color: #a1a1aa;" class="mb-3">
                <div class="mb-1"><i class="bi bi-geo-alt me-1 text-warning"></i>{{ $b->branch }}</div>
                <div class="mb-1"><i class="bi bi-calendar3 me-1 text-warning"></i>{{ $b->booking_date }} • {{ $b->booking_time }} WIB</div>
                <div><i class="bi bi-scissors me-1 text-warning"></i>{{ $b->stylist ? $b->stylist->name : 'Auto Assign' }}</div>
              </div>
              <div class="d-flex gap-2 pt-2 border-top border-secondary border-opacity-25">
                <form action="{{ route('customer.rebook', $b->id) }}" method="POST" class="flex-grow-1 m-0">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold w-100" style="font-size: 0.72rem;">
                    ⚡ Rebook
                  </button>
                </form>
                @if(in_array($b->status, ['pending', 'approved']))
                  @php
                    $bWa = '6285770394148';
                    $notesPart = $b->notes ? " (Catatan: " . $b->notes . ")" : "";
                    $bWaMsg = "Halo District Studio, saya ingin konfirmasi reservasi: " . ($b->queue_number ?? 'A-00' . $b->id) . " - {$b->service}" . $notesPart;
                  @endphp
                  <a href="https://wa.me/{{ $bWa }}?text={{ urlencode($bWaMsg) }}" target="_blank" class="btn btn-sm btn-outline-success fw-semibold" style="font-size: 0.72rem;">
                    <i class="bi bi-whatsapp"></i> WA
                  </a>
                @endif
                @if($b->status === 'completed')
                  <button class="btn btn-sm btn-outline-light" style="font-size: 0.72rem;" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $b->id }}">
                    ⭐ Ulas
                  </button>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>

  </div>
</main>

<!-- MODAL NEW BOOKING (HANYA MEMBOOKING TEMPAT / KURSI DENGAN CATATAN CUKUR) -->
<div class="modal fade" id="newBookingModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-warning"><i class="bi bi-calendar-plus me-2"></i>Form Reservasi Kursi & Tempat Cukur</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="alert p-2 mb-3" style="background: rgba(255,152,0,0.12); border: 1px solid rgba(255,152,0,0.3); font-size: 0.75rem; color: #ffca28;">
            <i class="bi bi-info-circle-fill me-1"></i> <strong>Booking Kursi & Tempat:</strong> Anda dapat menceritakan model cukur yang diinginkan di kolom catatan di bawah ini.
          </div>

          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;"><i class="bi bi-geo-alt-fill text-warning me-1"></i>Lokasi Studio Barbershop:</label>
            <select name="branch" class="form-select bg-secondary text-white border-0" required>
              <option value="District Studio Jakarta Barat (SMKN 17 Slipi)">District Studio Jakarta Barat (SMKN 17 Slipi - Jl. G1 No.7)</option>
            </select>
            <small class="text-white-50" style="font-size: 0.7rem;">Jl. G1 No.7, RT.1/RW.3, Slipi, Kec. Palmerah, Jakarta Barat</small>
          </div>

          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Pilih Paket Layanan:</label>
            <select name="service" id="modalServiceSelect" class="form-select bg-secondary text-white border-0" required>
              @foreach($services as $s)
                <option value="{{ $s->name }} (IDR {{ number_format($s->price, 0, ',', '.') }})">{{ $s->name }} - Rp {{ number_format($s->price, 0, ',', '.') }}</option>
              @endforeach
            </select>
          </div>

          <!-- KOLOM CERITAKAN DETAIL CUKUR -->
          <div class="mb-3">
            <label class="form-label text-warning fw-semibold" style="font-size: 0.82rem;">
              <i class="bi bi-chat-left-text-fill me-1"></i> Ceritakan Detail Mau Dicukur Seperti Apa:
            </label>
            <textarea name="notes" class="form-control bg-secondary text-white border-0" rows="3" placeholder="Contoh: Samping fade tipis 1mm, bagian atas potong sedikit 2cm saja, belah samping kiri rapi, jenggot dirapikan..."></textarea>
            <small class="text-white-50" style="font-size: 0.7rem;">*Tuliskan detail request potongan Anda agar kapster dapat mempersiapkan penataan yang pas.</small>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label" style="font-size: 0.8rem;">Tanggal Booking:</label>
              <input type="date" name="booking_date" class="form-control bg-secondary text-white border-0" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-6">
              <label class="form-label" style="font-size: 0.8rem;">Slot Waktu:</label>
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
          </div>

          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Pilih Hair Stylist / Barber:</label>
            <select name="stylist_id" id="modalStylistSelect" class="form-select bg-secondary text-white border-0">
              <option value="">-- Bebas / Sesuai Giliran Kapster --</option>
              @foreach($stylists as $st)
                <option value="{{ $st->id }}">{{ $st->name }} ({{ $st->work_status ?? 'Available' }})</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold">Konfirmasi Booking Kursi</button>
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
  function selectStylistInModal(stylistId) {
    const sel = document.getElementById('modalStylistSelect');
    if (sel) {
      sel.value = stylistId;
    }
  }

  function filterFace(shape) {
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
      card.style.transform = 'translateY(-3px)';
      card.style.boxShadow = '0 8px 24px rgba(167,139,250,0.12)';
      card.style.borderColor = 'rgba(167,139,250,0.3)';
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
      card.style.boxShadow = '';
      card.style.borderColor = 'rgba(255,255,255,0.07)';
    });
  });

  // Hover effect for product cards
  document.querySelectorAll('.product-item').forEach(card => {
    card.addEventListener('mouseenter', () => {
      card.style.transform = 'translateY(-3px)';
      card.style.boxShadow = '0 8px 24px rgba(255,152,0,0.15)';
      card.style.borderColor = 'rgba(255,152,0,0.4)';
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
      card.style.boxShadow = '';
      card.style.borderColor = 'rgba(255,255,255,0.08)';
    });
  });
</script>
@endsection
