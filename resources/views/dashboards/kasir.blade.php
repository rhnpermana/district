@extends('admin_layout.app')

@section('title', 'Kasir Workstation & POS Terminal - District Studio')

@section('content')
<main class="main" style="padding-top: 80px; min-height: 100vh; background-color: #09090b;">

  {{-- ============================================================= --}}
  {{-- HEADER BANNER --}}
  {{-- ============================================================= --}}
  <section style="background: linear-gradient(135deg, #0f2415 0%, #07150c 100%); border-bottom: 1px solid rgba(40,167,69,0.25); padding: 30px 0;">
    <div class="container-fluid container-xl">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
            <span class="badge" style="background: rgba(40,167,69,0.15); color: #28a745; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; padding: 6px 14px; border: 1px solid rgba(40,167,69,0.3); font-family: 'Montserrat', sans-serif;">
              <i class="bi bi-calculator-fill me-1"></i> Point of Sale & Cashier Terminal
            </span>
            {{-- Shift badge --}}
            @php
              $hour = (int) date('H');
              $shiftLabel = $hour < 13 ? '☀️ Shift Pagi (07:00–13:00)' : ($hour < 19 ? '🌤️ Shift Siang (13:00–19:00)' : '🌙 Shift Malam (19:00–22:00)');
              $shiftColor = $hour < 13 ? '#ffc107' : ($hour < 19 ? '#00c8c8' : '#a78bfa');
            @endphp
            <span class="badge" style="background: rgba(255,255,255,0.06); color: {{ $shiftColor }}; font-size: 0.72rem; font-weight: 700; padding: 6px 14px; border: 1px solid rgba(255,255,255,0.12); font-family: 'Montserrat', sans-serif;">
              {{ $shiftLabel }}
            </span>
          </div>
          <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.9rem; font-weight: 900; color: #ffffff; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
            Kasir Workstation <span style="color: #28a745;">.</span>
          </h2>
          <p style="font-size: 0.88rem; color: #a1a1aa; margin: 6px 0 0; font-weight: 400;">
            Terminal transaksi tunai & QRIS, cetak struk thermal, manajemen kas kecil, dan laporan penutupan shift kasir.
          </p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
          <span style="font-size: 0.78rem; color: #71717a;">{{ now()->format('l, d M Y') }}</span>
          <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.1);"></div>
          <button class="btn btn-sm btn-outline-success px-3 py-2 fw-semibold" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px;" data-bs-toggle="modal" data-bs-target="#pettyCashModal">
            <i class="bi bi-cash-stack me-1"></i> Catat Kas Kecil
          </button>
          <button class="btn btn-sm text-dark fw-bold px-3 py-2" style="background-color: #28a745; font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px; border: none;" onclick="openQrisModalDirect()">
            <i class="bi bi-qr-code-scan me-1"></i> Generator QRIS
          </button>
        </div>
      </div>
    </div>
  </section>

  <div class="container-fluid container-xl" style="padding: 30px 15px 60px;">

    {{-- ============================================================= --}}
    {{-- FLASH ALERT MESSAGES --}}
    {{-- ============================================================= --}}
    @if(session('success'))
      <div class="alert alert-dismissible fade show d-flex align-items-center justify-content-between mb-4" role="alert" style="background: rgba(40,167,69,0.15); border: 1px solid rgba(40,167,69,0.4); color: #fff; border-radius: 10px; padding: 16px 20px;">
        <div class="d-flex align-items-center gap-3">
          <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(40,167,69,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i class="bi bi-check-circle-fill" style="color: #28a745; font-size: 1.1rem;"></i>
          </div>
          <div>
            <strong style="color: #28a745; display: block; font-size: 0.9rem;">Transaksi Berhasil!</strong>
            <span style="font-size: 0.83rem; color: #d4d4d8;">{{ session('success') }}</span>
          </div>
        </div>
        <div class="d-flex align-items-center gap-2">
          @if(session('receipt_id'))
            <a href="{{ route('pos.receipt', session('receipt_id')) }}" class="btn btn-sm btn-warning text-dark fw-bold px-3" target="_blank">
              <i class="bi bi-printer-fill me-1"></i> Cetak Nota #POS-{{ session('receipt_id') }}
            </a>
          @endif
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-dismissible fade show d-flex align-items-center gap-3 mb-4" role="alert" style="background: rgba(220,53,69,0.15); border: 1px solid rgba(220,53,69,0.4); color: #fff; border-radius: 10px; padding: 16px 20px;">
        <i class="bi bi-x-circle-fill" style="color: #dc3545; font-size: 1.3rem;"></i>
        <span>{{ session('error') }}</span>
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if($errors->any())
      <div class="alert alert-dismissible fade show d-flex align-items-center gap-3 mb-4" role="alert" style="background: rgba(220,53,69,0.15); border: 1px solid rgba(220,53,69,0.4); color: #fff; border-radius: 10px; padding: 16px 20px;">
        <i class="bi bi-exclamation-triangle-fill" style="color: #dc3545; font-size: 1.3rem; flex-shrink: 0;"></i>
        <div>
          <strong style="color: #dc3545; display: block; font-size: 0.9rem;">Gagal Memproses Checkout:</strong>
          <ul class="mb-0 ps-3 mt-1" style="font-size: 0.83rem; color: #fca5a5;">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- ============================================================= --}}
    {{-- METRIC CARDS --}}
    {{-- ============================================================= --}}
    @php
      $incomeChange = $yesterdayIncome > 0
        ? round((($todayIncome - $yesterdayIncome) / $yesterdayIncome) * 100, 1)
        : ($todayIncome > 0 ? 100 : 0);
      $incomeUp = $incomeChange >= 0;
    @endphp

    <div class="row g-3 mb-4">

      {{-- Pendapatan Hari Ini --}}
      <div class="col-12 col-sm-6 col-xl-3">
        <div class="kasir-card h-100" style="background: #121215; border: 1px solid rgba(40,167,69,0.35); border-radius: 12px; padding: 22px 20px; position: relative; overflow: hidden;">
          <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle at top right, rgba(40,167,69,0.12), transparent); border-radius: 0 12px;"></div>
          <div class="d-flex justify-content-between align-items-start mb-3">
            <span style="font-size: 0.68rem; font-family: 'Montserrat', sans-serif; font-weight: 800; color: #71717a; text-transform: uppercase; letter-spacing: 1.5px;">Pendapatan Hari Ini</span>
            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(40,167,69,0.12); color: #28a745; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
              <i class="bi bi-cash-coin"></i>
            </div>
          </div>
          <h3 style="font-size: 1.65rem; font-weight: 900; color: #28a745; margin: 0 0 6px; font-family: 'Montserrat', sans-serif;">
            Rp {{ number_format($todayIncome, 0, ',', '.') }}
          </h3>
          <div class="d-flex align-items-center gap-2">
            <span class="badge" style="background: {{ $incomeUp ? 'rgba(40,167,69,0.15)' : 'rgba(220,53,69,0.15)' }}; color: {{ $incomeUp ? '#28a745' : '#dc3545' }}; font-size: 0.72rem; font-weight: 700; padding: 3px 8px; border: 1px solid {{ $incomeUp ? 'rgba(40,167,69,0.3)' : 'rgba(220,53,69,0.3)' }};">
              {{ $incomeUp ? '▲' : '▼' }} {{ abs($incomeChange) }}%
            </span>
            <span style="font-size: 0.7rem; color: #71717a;">vs kemarin</span>
          </div>
          <div style="font-size: 0.7rem; color: #52525b; margin-top: 6px;">
            Cash: <span class="text-white-50">Rp {{ number_format($cashToday, 0, ',', '.') }}</span>
            &bull; QRIS: <span class="text-white-50">Rp {{ number_format($qrisToday, 0, ',', '.') }}</span>
          </div>
          <div class="mt-2 pt-2" style="border-top: 1px solid rgba(255,255,255,0.05);">
            <a href="javascript:void(0)" onclick="switchToTab('settlement')" class="text-decoration-none fw-bold d-inline-flex align-items-center" style="font-size: 0.7rem; color: #28a745; font-family: 'Montserrat', sans-serif;">
              <i class="bi bi-bar-chart-line-fill me-1"></i> Buka Diagram Penjualan &raquo;
            </a>
          </div>
        </div>
      </div>

      {{-- Antrean Checkout --}}
      <div class="col-12 col-sm-6 col-xl-3">
        <div class="kasir-card h-100" style="background: #121215; border: 1px solid rgba(255,193,7,0.35); border-radius: 12px; padding: 22px 20px; position: relative; overflow: hidden;">
          <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle at top right, rgba(255,193,7,0.1), transparent); border-radius: 0 12px;"></div>
          <div class="d-flex justify-content-between align-items-start mb-3">
            <span style="font-size: 0.68rem; font-family: 'Montserrat', sans-serif; font-weight: 800; color: #71717a; text-transform: uppercase; letter-spacing: 1.5px;">Antrean Checkout</span>
            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(255,193,7,0.12); color: #ffc107; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
              <i class="bi bi-hourglass-split"></i>
            </div>
          </div>
          <h3 style="font-size: 1.65rem; font-weight: 900; color: #ffc107; margin: 0 0 6px; font-family: 'Montserrat', sans-serif;">
            {{ $pendingPaymentCount }} Sesi
          </h3>
          <span style="font-size: 0.72rem; color: #a1a1aa;">Booking aktif menunggu kasir</span>
        </div>
      </div>

      {{-- Kas Kecil Hari Ini --}}
      <div class="col-12 col-sm-6 col-xl-3">
        <div class="kasir-card h-100" style="background: #121215; border: 1px solid rgba(0,200,200,0.35); border-radius: 12px; padding: 22px 20px; position: relative; overflow: hidden;">
          <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle at top right, rgba(0,200,200,0.1), transparent); border-radius: 0 12px;"></div>
          <div class="d-flex justify-content-between align-items-start mb-3">
            <span style="font-size: 0.68rem; font-family: 'Montserrat', sans-serif; font-weight: 800; color: #71717a; text-transform: uppercase; letter-spacing: 1.5px;">Kas Kecil Hari Ini</span>
            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(0,200,200,0.12); color: #00c8c8; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
              <i class="bi bi-wallet2"></i>
            </div>
          </div>
          <h3 style="font-size: 1.65rem; font-weight: 900; color: #00c8c8; margin: 0 0 6px; font-family: 'Montserrat', sans-serif;">
            Rp {{ number_format($todayPettyCash, 0, ',', '.') }}
          </h3>
          <span style="font-size: 0.72rem; color: #a1a1aa;">Pengeluaran operasional shift ini</span>
        </div>
      </div>

      {{-- Saldo Tunai Drawer --}}
      <div class="col-12 col-sm-6 col-xl-3">
        @php $drawerBalance = max(0, $cashToday - $todayPettyCash); @endphp
        <div class="kasir-card h-100" style="background: #121215; border: 1px solid rgba(220,165,62,0.35); border-radius: 12px; padding: 22px 20px; position: relative; overflow: hidden;">
          <div style="position: absolute; top: 0; right: 0; width: 80px; height: 80px; background: radial-gradient(circle at top right, rgba(220,165,62,0.1), transparent); border-radius: 0 12px;"></div>
          <div class="d-flex justify-content-between align-items-start mb-3">
            <span style="font-size: 0.68rem; font-family: 'Montserrat', sans-serif; font-weight: 800; color: #71717a; text-transform: uppercase; letter-spacing: 1.5px;">Saldo Tunai Drawer</span>
            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(220,165,62,0.12); color: #dca53e; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
              <i class="bi bi-safe-fill"></i>
            </div>
          </div>
          <h3 style="font-size: 1.65rem; font-weight: 900; color: #dca53e; margin: 0 0 6px; font-family: 'Montserrat', sans-serif;">
            Rp {{ number_format($drawerBalance, 0, ',', '.') }}
          </h3>
          <span style="font-size: 0.72rem; color: #a1a1aa;">Cash masuk - kas kecil keluar</span>
        </div>
      </div>

    </div>

    {{-- ============================================================= --}}
    {{-- CASHIER WORKSTATION TABS --}}
    {{-- ============================================================= --}}
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; overflow: hidden;" class="shadow-lg">

      {{-- Nav Tabs --}}
      <div style="background: #18181b; border-bottom: 1px solid rgba(255,255,255,0.08); padding: 10px 15px 0;">
        <ul class="nav nav-tabs border-0 flex-nowrap overflow-auto" id="kasirTabs" role="tablist" style="gap: 4px; scrollbar-width: none;">

          <li class="nav-item" role="presentation">
            <button class="nav-link {{ session('active_tab', 'pos') === 'pos' ? 'active' : '' }} font-monospace fw-bold text-uppercase border-0 py-3 px-4" id="pos-tab" data-bs-toggle="tab" data-bs-target="#tab-pos" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0; position: relative;">
              <i class="bi bi-calculator me-2"></i> POS Checkout
              <span id="cartCountBadge" class="badge rounded-pill" style="background: #dc3545; font-size: 0.62rem; position: absolute; top: 8px; right: 8px; display: none; padding: 2px 6px;">0</span>
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link {{ session('active_tab') === 'queue' ? 'active' : '' }} font-monospace fw-bold text-uppercase border-0 py-3 px-4" id="queue-tab" data-bs-toggle="tab" data-bs-target="#tab-queue" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-person-lines-fill me-2"></i> Antrean & Booking Hari Ini
              @php $unpaidQueueCount = isset($todayQueue) ? $todayQueue->where('is_paid', false)->count() : 0; @endphp
              <span class="badge {{ $unpaidQueueCount > 0 ? 'bg-warning text-dark' : 'bg-secondary' }} ms-1" style="font-size: 0.65rem;">{{ $unpaidQueueCount }} Belum Bayar</span>
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link {{ session('active_tab') === 'history' ? 'active' : '' }} font-monospace fw-bold text-uppercase border-0 py-3 px-4" id="history-tab" data-bs-toggle="tab" data-bs-target="#tab-history" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-receipt me-2"></i> Riwayat Transaksi <span class="badge bg-success ms-1" style="font-size: 0.65rem;">{{ $recentTransactions->count() }}</span>
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link {{ session('active_tab') === 'pettycash' ? 'active' : '' }} font-monospace fw-bold text-uppercase border-0 py-3 px-4" id="pettycash-tab" data-bs-toggle="tab" data-bs-target="#tab-pettycash" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-cash-coin me-2"></i> Kas Kecil
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link font-monospace fw-bold text-uppercase border-0 py-3 px-4" id="settlement-tab" data-bs-toggle="tab" data-bs-target="#tab-settlement" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-bar-chart-line-fill me-2"></i> Diagram & Settlement Shift
            </button>
          </li>

        </ul>
      </div>

      {{-- Tab Content --}}
      <div class="tab-content p-4" id="kasirTabsContent">

        {{-- ============================================================= --}}
        {{-- TAB 1: POS CHECKOUT --}}
        {{-- ============================================================= --}}
        <div class="tab-pane fade {{ session('active_tab', 'pos') === 'pos' ? 'show active' : '' }}" id="tab-pos" role="tabpanel">

          <form action="{{ route('pos.checkout') }}" method="POST" id="posForm" onsubmit="return validatePosCheckout(event)">
            @csrf
            <div class="row g-4">

              {{-- LEFT: Order Items --}}
              <div class="col-12 col-lg-7">
                <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 24px;">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #28a745; padding-left: 10px; margin: 0;">
                      1. Pelanggan & Keranjang
                    </h4>
                    <button type="button" id="clearCartBtn" class="btn btn-sm btn-outline-danger" style="font-size: 0.72rem; display: none;" onclick="clearCart()">
                      <i class="bi bi-trash me-1"></i> Kosongkan
                    </button>
                  </div>

                  {{-- Quick Chips: Antrean Hari Ini Belum Bayar --}}
                  @if(isset($todayQueue) && $todayQueue->where('is_paid', false)->count() > 0)
                    <div class="mb-3 p-3" style="background: rgba(255,193,7,0.06); border: 1px dashed rgba(255,193,7,0.3); border-radius: 8px;">
                      <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-1">
                        <small style="font-size: 0.72rem; font-weight: 800; color: #ffc107; text-transform: uppercase; letter-spacing: 0.5px; font-family: 'Montserrat', sans-serif;">
                          <i class="bi bi-clock-history me-1"></i> Antrean Hari Ini Belum Bayar (Klik Cepat):
                        </small>
                        <a href="javascript:void(0)" onclick="switchToTab('queue')" style="font-size: 0.72rem; color: #00c8c8;" class="text-decoration-none fw-bold">
                          Buka Tabel Antrean Lengkap &raquo;
                        </a>
                      </div>
                      <div class="d-flex gap-2 flex-wrap">
                        @foreach($todayQueue->where('is_paid', false) as $qb)
                          <button type="button" class="btn btn-xs btn-outline-warning py-1 px-2 text-start" style="font-size: 0.75rem; border-radius: 6px;" onclick="selectBookingForCheckout({{ $qb->id }})">
                            <span class="badge bg-warning text-dark font-monospace fw-bold">{{ $qb->queue_number ?? '#'.$qb->id }}</span>
                            <strong class="text-white ms-1">{{ $qb->user ? $qb->user->name : 'Walk-in' }}</strong>
                            <span class="text-white-50 ms-1">({{ Str::limit($qb->service, 22) }})</span>
                          </button>
                        @endforeach
                      </div>
                    </div>
                  @endif

                  <div class="row g-3 mb-4">
                    {{-- Customer Name --}}
                    <div class="col-12 col-md-6">
                      <label style="font-size: 0.75rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase; letter-spacing: 0.5px;">Nama Pelanggan *</label>
                      <input type="text" name="customer_name" id="posCustName" class="form-control bg-dark text-white border-secondary" placeholder="Misal: Budi Santoso" required style="font-size: 0.9rem; padding: 10px 14px;">
                    </div>

                    {{-- Booking Selector --}}
                    <div class="col-12 col-md-6">
                      <label style="font-size: 0.75rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase; letter-spacing: 0.5px;">Link ke Booking / Antrean</label>
                      <select name="booking_id" id="posBookingSelect" class="form-select bg-dark text-white border-secondary" onchange="applyBookingToPos(this)" style="font-size: 0.85rem; padding: 10px 14px;">
                        <option value="" data-price="0" data-customer="" data-service="">-- Walk-in (tanpa booking) --</option>
                        @foreach($allActiveBookings as $b)
                          <option value="{{ $b->id }}" data-price="{{ $b->price }}" data-customer="{{ $b->user ? $b->user->name : 'Pelanggan Walk-in' }}" data-service="{{ $b->service }}" data-queue="{{ $b->queue_number ?? '#'.$b->id }}">
                            {{ $b->queue_number ?? '#'.$b->id }} — {{ $b->user ? $b->user->name : 'Walk-in' }} | {{ $b->service }} [{{ strtoupper($b->status) }}]
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  {{-- Item Selectors --}}
                  <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                      <label style="font-size: 0.75rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #ffc107; text-transform: uppercase; letter-spacing: 0.5px;">+ Tambah Layanan:</label>
                      <div class="d-flex gap-2">
                        <select id="selectService" class="form-select form-select-sm bg-dark text-white border-secondary" style="font-size: 0.83rem;">
                          @foreach($services as $s)
                            <option value="{{ $s->id }}" data-name="{{ $s->name }}" data-price="{{ $s->price }}">{{ $s->name }} — Rp {{ number_format($s->price, 0, ',', '.') }}</option>
                          @endforeach
                        </select>
                        <button type="button" class="btn btn-warning btn-sm fw-bold px-3" onclick="addServiceItem()" style="white-space: nowrap; font-size: 0.8rem;">+ Tambah</button>
                      </div>
                    </div>

                    <div class="col-12 col-md-6">
                      <label style="font-size: 0.75rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #00c8c8; text-transform: uppercase; letter-spacing: 0.5px;">+ Tambah Produk Retail:</label>
                      <div class="d-flex gap-2">
                        <select id="selectProduct" class="form-select form-select-sm bg-dark text-white border-secondary" style="font-size: 0.83rem;">
                          @foreach($products as $p)
                            <option value="{{ $p->id }}" data-name="{{ $p->name }}" data-price="{{ $p->price }}" data-stock="{{ $p->stock }}">{{ $p->name }} [Stok: {{ $p->stock }}] — Rp {{ number_format($p->price, 0, ',', '.') }}</option>
                          @endforeach
                        </select>
                        <button type="button" class="btn btn-info btn-sm fw-bold text-dark px-3" onclick="addProductItem()" style="white-space: nowrap; font-size: 0.8rem;">+ Tambah</button>
                      </div>
                    </div>
                  </div>

                  {{-- Cart Table --}}
                  <div class="table-responsive" style="border-radius: 8px; overflow: hidden; border: 1px solid rgba(255,255,255,0.06);">
                    <table class="table table-dark table-sm align-middle mb-0" id="posItemsTable">
                      <thead style="background: #0f0f11; font-size: 0.68rem; font-family: 'Montserrat', sans-serif; text-transform: uppercase; color: #71717a; letter-spacing: 1px;">
                        <tr>
                          <th style="padding: 12px 14px; width: 80px;">Tipe</th>
                          <th>Item</th>
                          <th style="width: 110px;">Harga</th>
                          <th style="width: 80px;">Qty</th>
                          <th style="width: 110px;">Subtotal</th>
                          <th style="width: 50px;"></th>
                        </tr>
                      </thead>
                      <tbody id="posItemsBody">
                        <tr id="emptyPosRow">
                          <td colspan="6" class="text-center py-5" style="color: #52525b; font-size: 0.85rem;">
                            <i class="bi bi-cart-x" style="font-size: 2rem; display: block; margin-bottom: 8px; color: #3f3f46;"></i>
                            Keranjang POS masih kosong.<br>Pilih layanan atau produk di atas.
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                </div>
              </div>

              {{-- RIGHT: Payment & Totals --}}
              <div class="col-12 col-lg-5">
                <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 24px;">
                  <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #dca53e; padding-left: 10px; margin-bottom: 20px;">
                    2. Pembayaran & Total
                  </h4>

                  {{-- Payment Method --}}
                  <div class="mb-3">
                    <label style="font-size: 0.75rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Metode Pembayaran *</label>
                    <select name="payment_method" id="paymentMethodSelect" class="form-select bg-dark text-white border-secondary fw-bold" onchange="handlePaymentMethodChange(this)" required style="font-size: 0.88rem; padding: 10px 14px;">
                      <option value="Cash">💵 Cash (Uang Tunai)</option>
                      <option value="QRIS">📱 QRIS (Kode QR)</option>
                      <option value="E-Wallet">📲 E-Wallet (GoPay / OVO / Dana)</option>
                      <option value="Debit/Credit Card">💳 Debit / Kredit Card</option>
                    </select>
                  </div>

                  {{-- Cash Calculator Widget --}}
                  <div id="cashCalculatorWidget" style="background: rgba(40,167,69,0.07); border: 1px solid rgba(40,167,69,0.2); border-radius: 10px; padding: 16px;" class="mb-3">
                    <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 800; color: #28a745; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 10px;">
                      <i class="bi bi-calculator me-1"></i> Kalkulator Kembalian
                    </span>
                    <div class="row g-2 mb-2">
                      <div class="col-6">
                        <label style="font-size: 0.68rem; color: #71717a; display: block; margin-bottom: 4px;">Uang Diterima (Rp):</label>
                        <input type="number" id="cashGivenInput" class="form-control form-control-sm bg-dark text-white border-secondary fw-bold" placeholder="0" oninput="calculateChange()" style="font-size: 0.95rem;">
                      </div>
                      <div class="col-6">
                        <label style="font-size: 0.68rem; color: #71717a; display: block; margin-bottom: 4px;">Kembalian (Rp):</label>
                        <div id="cashChangeDisplay" style="font-size: 1.2rem; font-weight: 900; color: #28a745; padding: 4px 0; font-family: 'Montserrat', sans-serif;">Rp 0</div>
                      </div>
                    </div>
                    <div class="d-flex gap-1 flex-wrap">
                      <button type="button" class="btn btn-xs btn-outline-success" style="font-size: 0.68rem; padding: 3px 8px; font-family: 'Courier New', monospace;" onclick="setCashGiven('exact')">Uang Pas</button>
                      <button type="button" class="btn btn-xs btn-outline-secondary" style="font-size: 0.68rem; padding: 3px 8px; font-family: 'Courier New', monospace;" onclick="setCashGiven(50000)">50k</button>
                      <button type="button" class="btn btn-xs btn-outline-secondary" style="font-size: 0.68rem; padding: 3px 8px; font-family: 'Courier New', monospace;" onclick="setCashGiven(100000)">100k</button>
                      <button type="button" class="btn btn-xs btn-outline-secondary" style="font-size: 0.68rem; padding: 3px 8px; font-family: 'Courier New', monospace;" onclick="setCashGiven(150000)">150k</button>
                      <button type="button" class="btn btn-xs btn-outline-secondary" style="font-size: 0.68rem; padding: 3px 8px; font-family: 'Courier New', monospace;" onclick="setCashGiven(200000)">200k</button>
                    </div>
                  </div>

                  {{-- QRIS Widget --}}
                  <div id="qrisButtonWidget" style="display: none; background: rgba(0,200,200,0.07); border: 1px solid rgba(0,200,200,0.2); border-radius: 10px; padding: 16px; text-align: center;" class="mb-3">
                    <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 800; color: #00c8c8; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px;">
                      <i class="bi bi-qr-code me-1"></i> QRIS / E-Wallet Payment
                    </span>
                    <p style="font-size: 0.8rem; color: #71717a; margin-bottom: 12px;">Tampilkan QR Code untuk dipindai pelanggan.</p>
                    <button type="button" class="btn btn-info text-dark fw-bold w-100" onclick="generateAndShowQrisModal()" style="font-family: 'Montserrat', sans-serif; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 1px;">
                      <i class="bi bi-qr-code-scan me-1"></i> Tampilkan Kode QRIS
                    </button>
                  </div>

                  {{-- Voucher --}}
                  <div class="mb-3">
                    <label style="font-size: 0.75rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Kode Voucher Promo:</label>
                    <select id="voucherSelect" class="form-select form-select-sm bg-dark text-white border-secondary" onchange="applyVoucherFromSelect(this)" style="font-size: 0.85rem;">
                      <option value="" data-value="0" data-type="">-- Tidak Pakai Voucher --</option>
                      @foreach($vouchers as $v)
                        <option value="{{ $v->code }}" data-value="{{ $v->discount_value }}" data-type="{{ $v->type }}" data-min="{{ $v->min_spend }}">
                          {{ $v->code }} — Diskon {{ $v->type === 'percent' ? $v->discount_value.'%' : 'Rp '.number_format($v->discount_value, 0, ',', '.') }}
                          @if($v->min_spend > 0) (min. Rp {{ number_format($v->min_spend, 0, ',', '.') }}) @endif
                        </option>
                      @endforeach
                    </select>
                  </div>

                  {{-- Total Summary Box --}}
                  <div style="background: #0f0f11; border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 20px;" class="mb-4">
                    <div class="d-flex justify-content-between mb-2" style="font-size: 0.83rem; color: #71717a; font-family: 'Courier New', monospace;">
                      <span>Subtotal:</span>
                      <span id="subtotalText" class="text-white fw-bold">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size: 0.83rem; color: #dc3545; font-family: 'Courier New', monospace;">
                      <span>Diskon Promo:</span>
                      <span id="discountText">- Rp 0</span>
                    </div>
                    <hr style="border-color: rgba(255,255,255,0.08); margin: 12px 0;">
                    <div class="d-flex justify-content-between align-items-center">
                      <span style="font-family: 'Montserrat', sans-serif; font-size: 0.8rem; font-weight: 800; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">TOTAL BAYAR:</span>
                      <h2 style="font-family: 'Montserrat', sans-serif; font-size: 2rem; font-weight: 900; color: #28a745; margin: 0;" id="finalText">Rp 0</h2>
                    </div>
                  </div>

                  <input type="hidden" name="subtotal" id="inputSubtotal" value="0">
                  <input type="hidden" name="discount_amount" id="inputDiscount" value="0">
                  <input type="hidden" name="voucher_code" id="inputVoucherCode" value="">
                  <input type="hidden" name="final_amount" id="inputFinal" value="0">

                  <button type="submit" id="checkoutBtn" class="btn btn-success fw-bold w-100 py-3" style="font-family: 'Montserrat', sans-serif; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; border-radius: 10px; opacity: 0.5; cursor: not-allowed;" disabled>
                    <i class="bi bi-check-circle-fill me-2"></i> Selesaikan Transaksi & Cetak Nota
                  </button>
                  <p class="text-center mt-2" id="checkoutHint" style="font-size: 0.7rem; color: #52525b;">Tambahkan minimal 1 item ke keranjang untuk checkout</p>

                </div>
              </div>

            </div>
          </form>

        </div>

        {{-- ============================================================= --}}
        {{-- TAB: ANTREAN & BOOKING HARI INI --}}
        {{-- ============================================================= --}}
        <div class="tab-pane fade {{ session('active_tab') === 'queue' ? 'show active' : '' }}" id="tab-queue" role="tabpanel">

          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
              <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #ffc107; padding-left: 12px;">
                Daftar Antrean & Booking Pelanggan Hari Ini ({{ now()->format('d M Y') }})
              </h4>
              <p style="font-size: 0.8rem; color: #a1a1aa; margin: 4px 0 0;">
                Semua pemesanan riil dari customer & walk-in hari ini. Klik "Proses Bayar" untuk memuat layanan & harga langsung ke kasir.
              </p>
            </div>
            <div class="d-flex align-items-center gap-2">
              <a href="{{ route('queue.board') }}" target="_blank" class="btn btn-sm btn-outline-info" style="font-size: 0.75rem;">
                <i class="bi bi-tv-fill me-1"></i> Layar Antrean TV
              </a>
            </div>
          </div>

          @if(!isset($todayQueue) || $todayQueue->isEmpty())
            <div class="text-center py-5" style="background: #18181b; border: 1px dashed rgba(255,255,255,0.1); border-radius: 12px;">
              <i class="bi bi-calendar-x text-muted" style="font-size: 2.5rem; display: block; margin-bottom: 8px;"></i>
              <h5 class="text-white mb-1">Belum Ada Antrean atau Booking untuk Hari Ini</h5>
              <p class="text-muted" style="font-size: 0.82rem;">Pelanggan yang memesan dari web atau resepsionis akan langsung muncul di sini secara real-time.</p>
            </div>
          @else
            <div class="table-responsive" style="border-radius: 10px; border: 1px solid rgba(255,255,255,0.06); overflow: hidden;">
              <table class="table table-dark table-hover align-middle mb-0" style="font-size: 0.83rem;">
                <thead style="background: #0f0f11; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px; color: #71717a;">
                  <tr>
                    <th style="padding: 14px;">No. Antrean</th>
                    <th>Nama Pelanggan</th>
                    <th>Tipe</th>
                    <th>Layanan & Model Cukur</th>
                    <th>Stylist / Barber</th>
                    <th>Jam Slot</th>
                    <th>Status Alur</th>
                    <th>Status Pembayaran</th>
                    <th class="text-end" style="padding-right: 14px;">Aksi Kasir</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($todayQueue as $b)
                    @php
                      $statusBadge = match($b->status) {
                        'completed'   => ['bg'=>'rgba(40,167,69,0.2)','text'=>'#28a745','border'=>'rgba(40,167,69,0.4)','label'=>'SELESAI DIPOTONG'],
                        'in_progress' => ['bg'=>'rgba(0,200,200,0.2)','text'=>'#00c8c8','border'=>'rgba(0,200,200,0.4)','label'=>'SEDANG DICUKUR'],
                        'approved'    => ['bg'=>'rgba(255,193,7,0.2)','text'=>'#ffc107','border'=>'rgba(255,193,7,0.4)','label'=>'CHECK-IN / SIAP'],
                        default       => ['bg'=>'rgba(108,117,125,0.2)','text'=>'#adb5bd','border'=>'rgba(108,117,125,0.4)','label'=>'MENUNGGU'],
                      };
                      $matchedTrx = $recentTransactions->firstWhere('booking_id', $b->id);
                    @endphp
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                      <td style="padding: 14px;">
                        <span class="badge font-monospace fw-bold" style="background: rgba(255,193,7,0.15); color: #ffc107; font-size: 0.85rem; border: 1px solid rgba(255,193,7,0.3); padding: 4px 8px;">
                          {{ $b->queue_number ?? '#'.$b->id }}
                        </span>
                      </td>
                      <td>
                        <strong class="text-white" style="font-size: 0.88rem;">{{ $b->user ? $b->user->name : 'Walk-in' }}</strong>
                        @if($b->user && $b->user->phone)
                          <br><small class="text-muted" style="font-size: 0.72rem;">{{ $b->user->phone }}</small>
                        @endif
                      </td>
                      <td>
                        <span class="badge" style="font-size: 0.65rem; background: {{ $b->type === 'online' ? 'rgba(0,200,200,0.15)' : 'rgba(255,152,0,0.15)' }}; color: {{ $b->type === 'online' ? '#00c8c8' : '#ff9800' }}; border: 1px solid {{ $b->type === 'online' ? 'rgba(0,200,200,0.3)' : 'rgba(255,152,0,0.3)' }}; font-weight: 700; text-transform: uppercase;">
                          {{ $b->type ?? 'online' }}
                        </span>
                      </td>
                      <td>
                        <strong style="color: #fff; font-size: 0.84rem;">{{ $b->service }}</strong>
                        <div style="font-size: 0.75rem; color: #28a745; font-family: 'Montserrat', sans-serif; font-weight: 700;">
                          Rp {{ number_format($b->price, 0, ',', '.') }}
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-dark border border-secondary text-white" style="font-size: 0.72rem;">
                          <i class="bi bi-scissors me-1 text-warning"></i>{{ $b->stylist ? $b->stylist->name : 'Bebas / Auto' }}
                        </span>
                      </td>
                      <td>
                        <span class="font-monospace text-white-50" style="font-size: 0.8rem;">
                          <i class="bi bi-clock me-1"></i>{{ $b->booking_time }} WIB
                        </span>
                      </td>
                      <td>
                        <span class="badge" style="background: {{ $statusBadge['bg'] }}; color: {{ $statusBadge['text'] }}; border: 1px solid {{ $statusBadge['border'] }}; font-size: 0.68rem; font-weight: 800; letter-spacing: 0.5px; padding: 4px 8px;">
                          {{ $statusBadge['label'] }}
                        </span>
                      </td>
                      <td>
                        @if($b->is_paid)
                          <span class="badge" style="background: rgba(40,167,69,0.2); color: #28a745; border: 1px solid rgba(40,167,69,0.4); font-size: 0.72rem; font-weight: 800; padding: 5px 10px;">
                            <i class="bi bi-check-circle-fill me-1"></i> LUNAS (PAID)
                          </span>
                        @else
                          <span class="badge" style="background: rgba(255,193,7,0.15); color: #ffc107; border: 1px solid rgba(255,193,7,0.3); font-size: 0.72rem; font-weight: 800; padding: 5px 10px;">
                            <i class="bi bi-hourglass-split me-1"></i> BELUM BAYAR
                          </span>
                        @endif
                      </td>
                      <td class="text-end" style="padding-right: 14px;">
                        @if(!$b->is_paid)
                          <button type="button" class="btn btn-sm text-dark fw-bold px-3 py-2" style="background-color: #28a745; border: none; font-size: 0.78rem; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 6px;" onclick="selectBookingForCheckout({{ $b->id }})">
                            <i class="bi bi-cart-check-fill me-1"></i> Proses Bayar &raquo;
                          </button>
                        @else
                          @if($matchedTrx)
                            <a href="{{ route('pos.receipt', $matchedTrx->id) }}" target="_blank" class="btn btn-sm btn-outline-warning fw-semibold px-3 py-1" style="font-size: 0.75rem;">
                              <i class="bi bi-printer me-1"></i> Nota #POS-{{ $matchedTrx->id }}
                            </a>
                          @else
                            <span class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-check2"></i> Transaksi Selesai</span>
                          @endif
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif

        </div>

        {{-- ============================================================= --}}
        {{-- TAB 2: RIWAYAT TRANSAKSI --}}
        {{-- ============================================================= --}}
        <div class="tab-pane fade {{ session('active_tab') === 'history' ? 'show active' : '' }}" id="tab-history" role="tabpanel">

          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #28a745; padding-left: 12px;">
              Riwayat Transaksi Penjualan
            </h4>
          </div>

          {{-- Filter Bar --}}
          <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 16px;" class="mb-4">
            <div class="row g-2 align-items-end">
              <div class="col-12 col-md-4">
                <label style="font-size: 0.7rem; color: #71717a; text-transform: uppercase; letter-spacing: 1px; font-family: 'Montserrat', sans-serif; font-weight: 700; display: block; margin-bottom: 5px;">Cari Pelanggan / No. Transaksi:</label>
                <input type="text" id="txSearchInput" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="Nama atau #POS-..." oninput="filterTransactions()" style="font-size: 0.85rem;">
              </div>
              <div class="col-6 col-md-2">
                <label style="font-size: 0.7rem; color: #71717a; text-transform: uppercase; letter-spacing: 1px; font-family: 'Montserrat', sans-serif; font-weight: 700; display: block; margin-bottom: 5px;">Status:</label>
                <select id="txStatusFilter" class="form-select form-select-sm bg-dark text-white border-secondary" onchange="filterTransactions()" style="font-size: 0.83rem;">
                  <option value="">Semua</option>
                  <option value="paid">Paid</option>
                  <option value="void">Void</option>
                  <option value="pending">Pending</option>
                </select>
              </div>
              <div class="col-6 col-md-2">
                <label style="font-size: 0.7rem; color: #71717a; text-transform: uppercase; letter-spacing: 1px; font-family: 'Montserrat', sans-serif; font-weight: 700; display: block; margin-bottom: 5px;">Metode:</label>
                <select id="txMethodFilter" class="form-select form-select-sm bg-dark text-white border-secondary" onchange="filterTransactions()" style="font-size: 0.83rem;">
                  <option value="">Semua</option>
                  <option value="Cash">Cash</option>
                  <option value="QRIS">QRIS</option>
                  <option value="E-Wallet">E-Wallet</option>
                  <option value="Debit/Credit Card">Card</option>
                </select>
              </div>
              <div class="col-6 col-md-2">
                <label style="font-size: 0.7rem; color: #71717a; text-transform: uppercase; letter-spacing: 1px; font-family: 'Montserrat', sans-serif; font-weight: 700; display: block; margin-bottom: 5px;">Dari Tanggal:</label>
                <input type="date" id="txDateFrom" class="form-control form-control-sm bg-dark text-white border-secondary" onchange="filterTransactions()" style="font-size: 0.83rem; color-scheme: dark;">
              </div>
              <div class="col-6 col-md-2">
                <label style="font-size: 0.7rem; color: #71717a; text-transform: uppercase; letter-spacing: 1px; font-family: 'Montserrat', sans-serif; font-weight: 700; display: block; margin-bottom: 5px;">Sampai Tanggal:</label>
                <input type="date" id="txDateTo" class="form-control form-control-sm bg-dark text-white border-secondary" onchange="filterTransactions()" style="font-size: 0.83rem; color-scheme: dark;">
              </div>
            </div>
          </div>

          {{-- Transactions Table --}}
          <div class="table-responsive" style="border-radius: 10px; border: 1px solid rgba(255,255,255,0.06); overflow: hidden;">
            <table class="table table-dark table-hover align-middle mb-0" style="font-size: 0.83rem;">
              <thead style="background: #0f0f11; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px; color: #71717a;">
                <tr>
                  <th style="padding: 14px;">No. Transaksi</th>
                  <th>Waktu</th>
                  <th>Pelanggan</th>
                  <th>Metode</th>
                  <th>Status</th>
                  <th>Subtotal</th>
                  <th>Diskon</th>
                  <th>Total</th>
                  <th class="text-end" style="padding-right: 14px;">Aksi</th>
                </tr>
              </thead>
              <tbody id="txTableBody">
                @foreach($recentTransactions as $t)
                  <tr class="tx-row {{ $t->payment_status === 'void' ? 'opacity-50' : '' }}"
                      data-name="{{ strtolower($t->customer_name) }}"
                      data-id="{{ $t->id }}"
                      data-status="{{ $t->payment_status }}"
                      data-method="{{ $t->payment_method }}"
                      data-date="{{ $t->created_at->format('Y-m-d') }}">
                    <td style="padding: 14px;" class="font-monospace fw-bold" style="color: #fbbf24;">#POS-{{ $t->id }}</td>
                    <td><small style="color: #71717a;">{{ $t->created_at->format('d/m/Y') }}<br><strong class="text-white-50">{{ $t->created_at->format('H:i') }}</strong></small></td>
                    <td><strong class="text-white">{{ $t->customer_name }}</strong></td>
                    <td>
                      <span class="badge" style="
                        @if($t->payment_method === 'Cash') background: rgba(40,167,69,0.2); color: #28a745; border: 1px solid rgba(40,167,69,0.4);
                        @elseif($t->payment_method === 'QRIS') background: rgba(0,200,200,0.2); color: #00c8c8; border: 1px solid rgba(0,200,200,0.4);
                        @elseif($t->payment_method === 'E-Wallet') background: rgba(255,152,0,0.2); color: #ff9800; border: 1px solid rgba(255,152,0,0.4);
                        @else background: rgba(100,200,255,0.2); color: #64c8ff; border: 1px solid rgba(100,200,255,0.4); @endif
                        font-weight: 700; font-size: 0.68rem; text-transform: uppercase; font-family: 'Montserrat', sans-serif; padding: 4px 8px;">
                        {{ $t->payment_method }}
                      </span>
                    </td>
                    <td>
                      @if($t->payment_status === 'paid')
                        <span class="badge" style="background: rgba(40,167,69,0.15); color: #28a745; border: 1px solid rgba(40,167,69,0.3); font-size: 0.68rem; font-weight: 700; padding: 4px 8px;">✓ LUNAS</span>
                      @elseif($t->payment_status === 'void')
                        <span class="badge" style="background: rgba(220,53,69,0.15); color: #dc3545; border: 1px solid rgba(220,53,69,0.3); font-size: 0.68rem; font-weight: 700; padding: 4px 8px;">✕ VOID</span>
                      @else
                        <span class="badge" style="background: rgba(255,193,7,0.15); color: #ffc107; border: 1px solid rgba(255,193,7,0.3); font-size: 0.68rem; font-weight: 700; padding: 4px 8px;">⏳ PENDING</span>
                      @endif
                    </td>
                    <td class="font-monospace" style="font-size: 0.8rem;">Rp {{ number_format($t->subtotal, 0, ',', '.') }}</td>
                    <td class="font-monospace" style="color: #dc3545; font-size: 0.8rem;">- Rp {{ number_format($t->discount_amount, 0, ',', '.') }}</td>
                    <td class="font-monospace fw-bold" style="color: #28a745; font-size: 0.9rem;">Rp {{ number_format($t->final_amount, 0, ',', '.') }}</td>
                    <td class="text-end" style="padding-right: 14px;">
                      <div class="btn-group btn-group-sm">
                        <a href="{{ route('pos.receipt', $t->id) }}" class="btn btn-outline-warning" target="_blank" title="Cetak Nota" style="font-size: 0.72rem; padding: 4px 10px;">
                          <i class="bi bi-printer"></i>
                        </a>
                        <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailTransactionModal{{ $t->id }}" title="Detail" style="font-size: 0.72rem; padding: 4px 10px;">
                          <i class="bi bi-eye"></i>
                        </button>
                        @if($t->payment_status === 'paid')
                          <form action="{{ route('pos.transaction.void', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Void transaksi #POS-{{ $t->id }}?\nStok produk dan status booking akan dipulihkan.')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger" title="Void" style="font-size: 0.72rem; padding: 4px 10px; border-radius: 0 4px 4px 0;">
                              <i class="bi bi-x-circle"></i>
                            </button>
                          </form>
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div id="txNoResults" style="display: none; text-align: center; padding: 40px; color: #52525b;">
            <i class="bi bi-search" style="font-size: 2rem; display: block; margin-bottom: 8px;"></i>
            Tidak ada transaksi yang sesuai filter.
          </div>

        </div>

        {{-- ============================================================= --}}
        {{-- TAB 3: KAS KECIL --}}
        {{-- ============================================================= --}}
        <div class="tab-pane fade {{ session('active_tab') === 'pettycash' ? 'show active' : '' }}" id="tab-pettycash" role="tabpanel">

          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #00c8c8; padding-left: 12px;">
              Catatan Kas Kecil Operasional
            </h4>
            <button class="btn btn-sm btn-info text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#pettyCashModal" style="font-size: 0.8rem;">
              <i class="bi bi-plus-circle me-1"></i> Catat Pengeluaran
            </button>
          </div>

          {{-- Summary by Category --}}
          @if($pettyCashByCategory->count() > 0)
            <div class="row g-3 mb-4">
              @foreach($pettyCashByCategory as $cat)
                <div class="col-6 col-md-3">
                  <div style="background: #18181b; border: 1px solid rgba(0,200,200,0.2); border-radius: 10px; padding: 14px 16px;">
                    <span style="font-size: 0.68rem; color: #71717a; font-family: 'Montserrat', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 4px;">{{ $cat->category }}</span>
                    <span style="font-size: 1.1rem; font-weight: 900; color: #dc3545; font-family: 'Montserrat', sans-serif;">Rp {{ number_format($cat->total, 0, ',', '.') }}</span>
                  </div>
                </div>
              @endforeach
              <div class="col-6 col-md-3">
                <div style="background: rgba(220,53,69,0.08); border: 1px solid rgba(220,53,69,0.3); border-radius: 10px; padding: 14px 16px;">
                  <span style="font-size: 0.68rem; color: #71717a; font-family: 'Montserrat', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 4px;">Total Semua</span>
                  <span style="font-size: 1.1rem; font-weight: 900; color: #dc3545; font-family: 'Montserrat', sans-serif;">Rp {{ number_format($pettyCashByCategory->sum('total'), 0, ',', '.') }}</span>
                </div>
              </div>
            </div>
          @endif

          {{-- Petty Cash Table --}}
          <div class="table-responsive" style="border-radius: 10px; border: 1px solid rgba(255,255,255,0.06); overflow: hidden;">
            <table class="table table-dark table-hover align-middle mb-0" style="font-size: 0.83rem;">
              <thead style="background: #0f0f11; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px; color: #71717a;">
                <tr>
                  <th style="padding: 14px;">Tanggal</th>
                  <th>Kasir Pencatat</th>
                  <th>Kategori</th>
                  <th>Keterangan</th>
                  <th class="text-end" style="padding-right: 14px;">Jumlah</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pettyCashes as $pc)
                  <tr>
                    <td style="padding: 14px;"><strong class="text-white">{{ \Carbon\Carbon::parse($pc->expense_date)->format('d M Y') }}</strong></td>
                    <td><span style="color: #fbbf24; font-weight: 700;">{{ $pc->cashier ? $pc->cashier->name : 'Kasir' }}</span></td>
                    <td>
                      <span class="badge" style="background: rgba(255,255,255,0.06); color: #d4d4d8; border: 1px solid rgba(255,255,255,0.1); font-size: 0.72rem; font-family: 'Montserrat', sans-serif; font-weight: 700; padding: 4px 10px;">
                        {{ $pc->category }}
                      </span>
                    </td>
                    <td style="color: #a1a1aa; font-size: 0.8rem;">{{ $pc->description }}</td>
                    <td class="text-end font-monospace fw-bold" style="color: #dc3545; padding-right: 14px; font-size: 0.9rem;">- Rp {{ number_format($pc->amount, 0, ',', '.') }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-5" style="color: #52525b; font-size: 0.85rem;">
                      <i class="bi bi-wallet2" style="font-size: 2rem; display: block; margin-bottom: 8px; color: #3f3f46;"></i>
                      Belum ada catatan kas kecil.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>

        {{-- ============================================================= --}}
        {{-- TAB 4: DIAGRAM & SETTLEMENT SHIFT --}}
        {{-- ============================================================= --}}
        <div class="tab-pane fade" id="tab-settlement" role="tabpanel">

          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
              <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #28a745; padding-left: 12px;">
                Diagram Analisis & Laporan Settlement Shift Kasir
              </h4>
              <p style="font-size: 0.8rem; color: #71717a; margin: 4px 0 0 15px;">{{ date('l, d F Y') }} — Operator Kasir: <strong class="text-white">{{ Auth::user()->name }}</strong></p>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-success fw-semibold" onclick="updateKasirCharts()" style="font-size: 0.8rem;">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh Diagram
              </button>
              <button class="btn btn-sm btn-warning text-dark fw-bold" onclick="window.print()" style="font-size: 0.8rem;">
                <i class="bi bi-printer me-1"></i> Cetak Laporan Shift
              </button>
            </div>
          </div>

          {{-- ─── INTERACTIVE DIAGRAM CARDS (CHART.JS) ─── --}}
          <div class="row g-4 mb-4">

            {{-- Diagram 1: Tren Revenue 7 Hari Terakhir --}}
            <div class="col-12 col-xl-8">
              <div style="background: #18181b; border: 1px solid rgba(40,167,69,0.3); border-radius: 12px; padding: 22px; position: relative;">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                  <div>
                    <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.88rem; font-weight: 800; color: #28a745; text-transform: uppercase; margin: 0;">
                      <i class="bi bi-bar-chart-line-fill me-2"></i> Diagram Pendapatan 7 Hari Terakhir
                    </h5>
                    <small style="color: #71717a; font-size: 0.72rem;">Tren transaksi lunas harian barbershop</small>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge" style="background: rgba(40,167,69,0.15); color: #28a745; border: 1px solid rgba(40,167,69,0.3); font-size: 0.72rem; font-family: 'Montserrat', sans-serif;">
                      Total 7 Hari: Rp {{ number_format($weeklyRevenue->sum('amount'), 0, ',', '.') }}
                    </span>
                    <span class="badge" style="background: rgba(255,193,7,0.15); color: #ffc107; border: 1px solid rgba(255,193,7,0.3); font-size: 0.72rem; font-family: 'Montserrat', sans-serif;">
                      {{ $weeklyRevenue->sum('count') }} Transaksi
                    </span>
                  </div>
                </div>

                {{-- Canvas Chart --}}
                <div style="position: relative; height: 250px; width: 100%;">
                  <canvas id="weeklyRevenueChart"></canvas>
                </div>
              </div>
            </div>

            {{-- Diagram 2: Komposisi Metode Pembayaran Hari Ini --}}
            <div class="col-12 col-xl-4">
              <div style="background: #18181b; border: 1px solid rgba(0,200,200,0.3); border-radius: 12px; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                <div>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.88rem; font-weight: 800; color: #00c8c8; text-transform: uppercase; margin: 0;">
                      <i class="bi bi-pie-chart-fill me-2"></i> Distribusi Pembayaran
                    </h5>
                    <span class="badge bg-dark border border-secondary text-white-50" style="font-size: 0.65rem;">Hari Ini</span>
                  </div>
                  <small style="color: #71717a; font-size: 0.72rem; display: block; margin-bottom: 12px;">Proporsi uang masuk per kanal pembayaran</small>
                </div>

                {{-- Canvas Doughnut Chart --}}
                <div style="position: relative; height: 180px; width: 100%; display: flex; align-items: center; justify-content: center;">
                  <canvas id="paymentMethodChart"></canvas>
                </div>

                <div class="mt-3 pt-2 text-center" style="border-top: 1px solid rgba(255,255,255,0.05);">
                  <div class="d-flex justify-content-around text-center" style="font-size: 0.72rem;">
                    <div><span style="color: #28a745;">●</span> Cash: <strong class="text-white">Rp {{ number_format($cashToday, 0, ',', '.') }}</strong></div>
                    <div><span style="color: #00c8c8;">●</span> QRIS: <strong class="text-white">Rp {{ number_format($qrisToday, 0, ',', '.') }}</strong></div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          {{-- ─── SETTLEMENT & RECONCILIATION CARDS ─── --}}
          <div class="row g-4">

            {{-- Penerimaan per Metode --}}
            <div class="col-12 col-md-6">
              <div style="background: #18181b; border: 1px solid rgba(40,167,69,0.2); border-radius: 12px; padding: 24px;">
                <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; font-weight: 800; color: #28a745; text-transform: uppercase; margin-bottom: 20px;">
                  <i class="bi bi-receipt me-2"></i> Rincian Penerimaan Penjualan Shift
                </h5>
                @php
                  $methods = [
                    'Cash (Uang Tunai)'        => ['val' => $cashToday, 'color' => '#28a745', 'icon' => 'bi-cash-coin'],
                    'QRIS / GoPay / DANA'      => ['val' => $qrisToday, 'color' => '#00c8c8', 'icon' => 'bi-qr-code'],
                    'E-Wallet (OVO/ShopeePay)' => ['val' => $ewalletToday, 'color' => '#ff9800', 'icon' => 'bi-phone'],
                    'Debit / Credit Card'      => ['val' => $cardToday, 'color' => '#64c8ff', 'icon' => 'bi-credit-card'],
                  ];
                @endphp
                @foreach($methods as $label => $data)
                  <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <div class="d-flex align-items-center gap-2">
                      <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; color: {{ $data['color'] }};">
                        <i class="bi {{ $data['icon'] }}"></i>
                      </div>
                      <span style="font-size: 0.83rem; color: #d4d4d8;">{{ $label }}</span>
                    </div>
                    <span class="font-monospace fw-bold" style="color: {{ $data['color'] }}; font-size: 0.9rem;">Rp {{ number_format($data['val'], 0, ',', '.') }}</span>
                  </div>
                @endforeach
                <div class="d-flex justify-content-between align-items-center pt-2">
                  <span style="font-family: 'Montserrat', sans-serif; font-size: 0.8rem; font-weight: 900; color: #fff; text-transform: uppercase;">TOTAL GROSS REVENUE</span>
                  <span class="font-monospace fw-bold fs-5" style="color: #28a745;">Rp {{ number_format($todayIncome, 0, ',', '.') }}</span>
                </div>
              </div>
            </div>

            {{-- Rekonsiliasi Drawer --}}
            <div class="col-12 col-md-6">
              <div style="background: #18181b; border: 1px solid rgba(220,165,62,0.2); border-radius: 12px; padding: 24px;">
                <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; font-weight: 800; color: #dca53e; text-transform: uppercase; margin-bottom: 20px;">
                  <i class="bi bi-safe me-2"></i> Rekonsiliasi Laci Kasir (Cash Drawer)
                </h5>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                  <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(40,167,69,0.1); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; color: #28a745;">
                      <i class="bi bi-arrow-down-left-circle"></i>
                    </div>
                    <div>
                      <span style="font-size: 0.83rem; color: #d4d4d8; display: block;">Uang Tunai Masuk (Cash)</span>
                      <small style="font-size: 0.7rem; color: #71717a;">Total penerimaan cash transaksi POS</small>
                    </div>
                  </div>
                  <span class="font-monospace fw-bold" style="color: #28a745; font-size: 0.95rem;">+ Rp {{ number_format($cashToday, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                  <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(220,53,69,0.1); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; color: #dc3545;">
                      <i class="bi bi-arrow-up-right-circle"></i>
                    </div>
                    <div>
                      <span style="font-size: 0.83rem; color: #d4d4d8; display: block;">Pengeluaran Kas Kecil</span>
                      <small style="font-size: 0.7rem; color: #71717a;">Biaya operasional harian shift ini</small>
                    </div>
                  </div>
                  <span class="font-monospace fw-bold" style="color: #dc3545; font-size: 0.95rem;">- Rp {{ number_format($todayPettyCash, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center pt-2" style="border-top: 1px solid rgba(255,255,255,0.08);">
                  <div>
                    <span style="font-family: 'Montserrat', sans-serif; font-size: 0.82rem; font-weight: 900; color: #fff; text-transform: uppercase; display: block;">SALDO TUNAI FISIK DRAWER</span>
                    <small style="font-size: 0.7rem; color: #71717a;">Uang tunai wajib ada di laci fisik</small>
                  </div>
                  <span class="font-monospace fw-bold fs-5" style="color: #dca53e;">Rp {{ number_format($drawerBalance, 0, ',', '.') }}</span>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </div>

  </div>
</main>

{{-- ============================================================= --}}
{{-- MODAL: QRIS PAYMENT --}}
{{-- ============================================================= --}}
<div class="modal fade" id="qrisModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-white" style="background: #18181b; border: 1px solid rgba(0,200,200,0.3); border-radius: 14px;">
      <div class="modal-header" style="background: linear-gradient(135deg, rgba(0,20,24,0.95) 0%, rgba(6,20,24,0.95) 100%); border-bottom: 1px solid rgba(0,200,200,0.2); border-radius: 14px 14px 0 0;">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-qr-code-scan" style="font-size: 1.4rem; color: #00c8c8;"></i>
          <div>
            <h5 class="modal-title fw-bold" style="margin: 0; color: #00c8c8; font-family: 'Montserrat', sans-serif;">Pembayaran QRIS / DANA</h5>
            <small style="color: #71717a; font-size: 0.72rem;">Scan QR Code untuk bayar</small>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center p-4">
        <div style="background: rgba(0,200,200,0.07); border: 1px dashed rgba(0,200,200,0.3); border-radius: 10px; padding: 10px;" class="mb-3">
          <span style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; font-weight: 800; color: #00c8c8; text-transform: uppercase; letter-spacing: 1px;">DISTRICT STUDIO BARBERSHOP</span><br>
          <small style="color: #71717a; font-size: 0.7rem;">Scan menggunakan DANA, GoPay, OVO, ShopeePay, dll.</small>
        </div>
        <div class="mb-3">
          <span style="font-size: 0.72rem; color: #71717a; text-transform: uppercase; font-family: 'Montserrat', sans-serif; font-weight: 700;">Total Yang Harus Dibayar:</span>
          <h2 style="font-family: 'Montserrat', sans-serif; font-weight: 900; color: #28a745; font-size: 2.2rem; margin: 4px 0 0;" id="qrisModalAmount">Rp 0</h2>
        </div>
        <div style="border: 2px solid rgba(0,200,200,0.3); border-radius: 12px; padding: 10px; display: inline-block; background: #fff;" class="mb-3">
          <img id="qrisImage" src="{{ asset('assets/img/scan qris.jpeg') }}" alt="QRIS" style="max-width: 240px; max-height: 260px; width: 100%; height: auto; border-radius: 6px; display: block; object-fit: contain;">
        </div>
        <div id="qrisStatusNotice" style="background: rgba(40,167,69,0.1); border: 1px solid rgba(40,167,69,0.3); color: #28a745; padding: 10px 15px; border-radius: 8px; font-size: 0.8rem;" class="d-flex align-items-center justify-content-center gap-2">
          <i class="bi bi-phone-vibrate-fill"></i>
          <span>Cek notifikasi di HP, lalu klik Verifikasi di bawah.</span>
        </div>
      </div>
      <div class="modal-footer" style="border-top: 1px solid rgba(0,200,200,0.15);">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-sm btn-success fw-bold px-4" onclick="confirmQrisPaymentSuccess()">
          <i class="bi bi-check-circle-fill me-1"></i> Verifikasi Pembayaran & Cetak Nota
        </button>
      </div>
    </div>
  </div>
</div>

{{-- ============================================================= --}}
{{-- MODAL: PETTY CASH INPUT --}}
{{-- ============================================================= --}}
<div class="modal fade" id="pettyCashModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-white" style="background: #18181b; border: 1px solid rgba(0,200,200,0.25); border-radius: 14px;">
      <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
        <h5 class="modal-title fw-bold" style="color: #00c8c8; font-family: 'Montserrat', sans-serif;">
          <i class="bi bi-cash-stack me-2"></i> Catat Kas Kecil (Petty Cash)
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('pos.petty_cash') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase; letter-spacing: 0.5px;">Jumlah Pengeluaran (Rp): *</label>
            <input type="number" name="amount" class="form-control bg-dark text-white border-secondary" placeholder="Misal: 35000" required min="1000" style="font-size: 0.95rem; padding: 10px 14px;">
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase; letter-spacing: 0.5px;">Kategori Pengeluaran: *</label>
            <select name="category" class="form-select bg-dark text-white border-secondary" required style="font-size: 0.88rem; padding: 10px 14px;">
              <option value="Perlengkapan">Perlengkapan (Tisu, Kebersihan)</option>
              <option value="Konsumsi">Konsumsi / Air Mineral Staf</option>
              <option value="Perawatan">Perawatan Alat & Sanitasi Barber</option>
              <option value="Transport">Transport / Ojek</option>
              <option value="Lain-lain">Lain-lain Operasional</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase; letter-spacing: 0.5px;">Keterangan Rincian: *</label>
            <textarea name="description" class="form-control bg-dark text-white border-secondary" rows="2" placeholder="Beli es batu 2 plastik & tisu roll..." required style="font-size: 0.88rem;"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #a1a1aa; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Pengeluaran: *</label>
            <input type="date" name="expense_date" class="form-control bg-dark text-white border-secondary" value="{{ date('Y-m-d') }}" required style="font-size: 0.88rem; color-scheme: dark;">
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.08);">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-info text-dark fw-bold px-4">
            <i class="bi bi-save me-1"></i> Simpan Pengeluaran
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ============================================================= --}}
{{-- MODALS DETAIL TRANSAKSI (per transaksi) --}}
{{-- ============================================================= --}}
@foreach($recentTransactions as $t)
<div class="modal fade" id="detailTransactionModal{{ $t->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-white" style="background: #18181b; border: 1px solid rgba(255,193,7,0.25); border-radius: 14px;">
      <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
        <h5 class="modal-title fw-bold" style="color: #fbbf24; font-family: 'Montserrat', sans-serif;">
          <i class="bi bi-receipt me-2"></i> #POS-{{ $t->id }} — {{ $t->customer_name }}
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-2 mb-3" style="font-size: 0.82rem;">
          <div class="col-6"><span style="color: #71717a;">Kasir:</span> <strong class="text-white">{{ $t->cashier ? $t->cashier->name : 'System' }}</strong></div>
          <div class="col-6"><span style="color: #71717a;">Waktu:</span> <strong class="text-white">{{ $t->created_at->format('d/m/Y H:i') }}</strong></div>
          <div class="col-6"><span style="color: #71717a;">Metode:</span> <span class="badge bg-success">{{ $t->payment_method }}</span></div>
          <div class="col-6"><span style="color: #71717a;">Status:</span>
            @if($t->payment_status === 'paid') <span class="badge" style="background: rgba(40,167,69,0.2); color: #28a745; border: 1px solid rgba(40,167,69,0.4);">✓ LUNAS</span>
            @elseif($t->payment_status === 'void') <span class="badge" style="background: rgba(220,53,69,0.2); color: #dc3545; border: 1px solid rgba(220,53,69,0.4);">✕ VOID</span>
            @else <span class="badge bg-warning text-dark">PENDING</span> @endif
          </div>
        </div>
        <div class="table-responsive" style="border-radius: 8px; border: 1px solid rgba(255,255,255,0.06); overflow: hidden;">
          <table class="table table-dark table-sm align-middle mb-0" style="font-size: 0.8rem;">
            <thead style="background: #0f0f11; color: #71717a; font-size: 0.68rem; text-transform: uppercase; font-family: 'Montserrat', sans-serif;">
              <tr>
                <th style="padding: 10px;">Item</th>
                <th>Qty</th>
                <th>Harga</th>
                <th class="text-end" style="padding-right: 12px;">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($t->items as $item)
                <tr>
                  <td style="padding: 10px;">
                    <span class="badge me-1" style="font-size: 0.62rem; background: {{ $item->item_type === 'service' ? 'rgba(255,193,7,0.2)' : 'rgba(0,200,200,0.2)' }}; color: {{ $item->item_type === 'service' ? '#ffc107' : '#00c8c8' }}; border: 1px solid {{ $item->item_type === 'service' ? 'rgba(255,193,7,0.3)' : 'rgba(0,200,200,0.3)' }};">{{ strtoupper($item->item_type) }}</span>
                    {{ $item->item_name }}
                  </td>
                  <td>{{ $item->quantity }}x</td>
                  <td class="font-monospace">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                  <td class="text-end font-monospace" style="padding-right: 12px;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="text-end font-monospace pt-3" style="font-size: 0.83rem; border-top: 1px solid rgba(255,255,255,0.06); margin-top: 0;">
          <div style="color: #71717a;">Subtotal: <strong class="text-white">Rp {{ number_format($t->subtotal, 0, ',', '.') }}</strong></div>
          @if($t->discount_amount > 0)
            <div style="color: #dc3545;">Diskon: <strong>- Rp {{ number_format($t->discount_amount, 0, ',', '.') }}</strong></div>
          @endif
          <div style="font-size: 1.1rem; color: #28a745; font-weight: 900;">Total: Rp {{ number_format($t->final_amount, 0, ',', '.') }}</div>
        </div>
      </div>
      <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.08);">
        <a href="{{ route('pos.receipt', $t->id) }}" target="_blank" class="btn btn-sm btn-warning text-dark fw-bold px-3">
          <i class="bi bi-printer me-1"></i> Cetak Struk / Kirim WA
        </a>
      </div>
    </div>
  </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>
  // ========================================================
  // CART STATE
  // ========================================================
  let posItems = [];

  // ========================================================
  // RENDER CART TABLE
  // ========================================================
  function renderPosTable() {
    const tbody = document.getElementById('posItemsBody');
    const clearBtn = document.getElementById('clearCartBtn');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const checkoutHint = document.getElementById('checkoutHint');
    const cartBadge = document.getElementById('cartCountBadge');

    tbody.innerHTML = '';

    if (posItems.length === 0) {
      tbody.innerHTML = `<tr id="emptyPosRow"><td colspan="6" class="text-center py-5" style="color:#52525b;font-size:0.85rem;">
        <i class="bi bi-cart-x" style="font-size:2rem;display:block;margin-bottom:8px;color:#3f3f46;"></i>
        Keranjang POS masih kosong.<br>Pilih layanan atau produk di atas.
      </td></tr>`;
      clearBtn.style.display = 'none';
      checkoutBtn.disabled = true;
      checkoutBtn.style.opacity = '0.5';
      checkoutBtn.style.cursor = 'not-allowed';
      checkoutHint.style.display = 'block';
      cartBadge.style.display = 'none';
      updateTotals();
      return;
    }

    clearBtn.style.display = 'inline-block';
    checkoutBtn.disabled = false;
    checkoutBtn.style.opacity = '1';
    checkoutBtn.style.cursor = 'pointer';
    checkoutHint.style.display = 'none';
    cartBadge.textContent = posItems.length;
    cartBadge.style.display = 'inline';

    posItems.forEach((item, index) => {
      const tr = document.createElement('tr');
      tr.style.borderBottom = '1px solid rgba(255,255,255,0.04)';
      tr.innerHTML = `
        <td style="padding:12px 14px;">
          <span class="badge" style="font-size:0.62rem;background:${item.item_type==='service'?'rgba(255,193,7,0.2)':'rgba(0,200,200,0.2)'};color:${item.item_type==='service'?'#ffc107':'#00c8c8'};border:1px solid ${item.item_type==='service'?'rgba(255,193,7,0.3)':'rgba(0,200,200,0.3)'};font-family:'Montserrat',sans-serif;font-weight:800;padding:3px 8px;text-transform:uppercase;">${item.item_type}</span>
        </td>
        <td>
          <strong style="color:#fff;font-size:0.85rem;">${item.item_name}</strong>
          <input type="hidden" name="items[${index}][item_type]" value="${item.item_type}">
          <input type="hidden" name="items[${index}][item_id]" value="${(item.item_id && item.item_id !== 'null') ? item.item_id : ''}">
          <input type="hidden" name="items[${index}][item_name]" value="${item.item_name}">
          <input type="hidden" name="items[${index}][price]" value="${item.price}">
        </td>
        <td class="font-monospace" style="color:#a1a1aa;font-size:0.8rem;">Rp ${parseInt(item.price).toLocaleString('id-ID')}</td>
        <td>
          <input type="number" min="1" class="form-control form-control-sm bg-dark text-white border-secondary"
            style="width:70px;font-size:0.88rem;" value="${item.quantity}"
            name="items[${index}][quantity]" onchange="updateQty(${index}, this.value)">
        </td>
        <td class="font-monospace fw-bold" style="color:#28a745;font-size:0.88rem;">Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</td>
        <td style="padding-right:14px;">
          <button type="button" class="btn btn-link text-danger p-1" onclick="removeItem(${index})" title="Hapus">
            <i class="bi bi-trash3" style="font-size:1rem;"></i>
          </button>
        </td>
      `;
      tbody.appendChild(tr);
    });

    updateTotals();
  }

  // ========================================================
  // ADD ITEMS
  // ========================================================
  function addServiceItem() {
    const sel = document.getElementById('selectService');
    if (!sel || sel.options.length === 0) return;
    const opt = sel.options[sel.selectedIndex];
    posItems.push({
      item_type: 'service',
      item_id:   opt.value,
      item_name: opt.getAttribute('data-name'),
      price:     parseFloat(opt.getAttribute('data-price')),
      quantity:  1
    });
    renderPosTable();
  }

  function addProductItem() {
    const sel = document.getElementById('selectProduct');
    if (!sel || sel.options.length === 0) return;
    const opt      = sel.options[sel.selectedIndex];
    const id       = opt.value;
    const name     = opt.getAttribute('data-name');
    const price    = parseFloat(opt.getAttribute('data-price')) || 0;
    const maxStock = parseInt(opt.getAttribute('data-stock')) || 0;
    const existing = posItems.find(i => i.item_type === 'product' && i.item_id == id);
    const inCart   = existing ? existing.quantity : 0;

    if (inCart + 1 > maxStock) {
      alert(`⚠️ Stok "${name}" tidak mencukupi!\nTersisa: ${maxStock} | Di keranjang: ${inCart}`);
      return;
    }
    if (existing) {
      existing.quantity += 1;
    } else {
      posItems.push({ item_type: 'product', item_id: id, item_name: name, price, quantity: 1, max_stock: maxStock });
    }
    renderPosTable();
  }

  // ========================================================
  // CART OPERATIONS
  // ========================================================
  function removeItem(idx) {
    posItems.splice(idx, 1);
    renderPosTable();
  }

  function clearCart() {
    if (!confirm('Kosongkan seluruh keranjang POS?')) return;
    posItems = [];
    document.getElementById('posBookingSelect').value = '';
    document.getElementById('posCustName').value = '';
    document.getElementById('voucherSelect').value = '';
    document.getElementById('inputDiscount').value = 0;
    document.getElementById('inputVoucherCode').value = '';
    renderPosTable();
  }

  function updateQty(idx, val) {
    const newQty = parseInt(val) || 1;
    const item = posItems[idx];
    if (item.item_type === 'product' && item.max_stock !== undefined && newQty > item.max_stock) {
      alert(`⚠️ Stok "${item.item_name}" terbatas (maks. ${item.max_stock})!`);
      renderPosTable();
      return;
    }
    posItems[idx].quantity = Math.max(1, newQty);
    renderPosTable();
  }

  // ========================================================
  // TOTALS & VOUCHER
  // ========================================================
  function updateTotals() {
    let subtotal = posItems.reduce((s, i) => s + (i.price * i.quantity), 0);
    let discount = parseFloat(document.getElementById('inputDiscount').value) || 0;
    let final    = Math.max(0, subtotal - discount);

    document.getElementById('inputSubtotal').value  = subtotal;
    document.getElementById('subtotalText').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('discountText').innerText = '- Rp ' + discount.toLocaleString('id-ID');
    document.getElementById('inputFinal').value      = final;
    document.getElementById('finalText').innerText   = 'Rp ' + final.toLocaleString('id-ID');

    calculateChange();
  }

  function applyVoucherFromSelect(sel) {
    const opt     = sel.options[sel.selectedIndex];
    const code    = opt.value;
    const val     = parseFloat(opt.getAttribute('data-value')) || 0;
    const type    = opt.getAttribute('data-type');
    const minSpend = parseFloat(opt.getAttribute('data-min')) || 0;
    const sub     = parseFloat(document.getElementById('inputSubtotal').value) || 0;

    if (!code) {
      document.getElementById('inputDiscount').value    = 0;
      document.getElementById('inputVoucherCode').value = '';
      updateTotals();
      return;
    }

    if (minSpend > 0 && sub < minSpend) {
      alert(`Voucher ${code} memerlukan minimum belanja Rp ${minSpend.toLocaleString('id-ID')}`);
      sel.value = '';
      document.getElementById('inputDiscount').value = 0;
      updateTotals();
      return;
    }

    const disc = type === 'percent' ? (sub * val) / 100 : val;
    document.getElementById('inputDiscount').value    = disc;
    document.getElementById('inputVoucherCode').value = code;
    updateTotals();
  }

  // ========================================================
  // PAYMENT METHOD TOGGLE
  // ========================================================
  function handlePaymentMethodChange(sel) {
    const cashWidget = document.getElementById('cashCalculatorWidget');
    const qrisWidget = document.getElementById('qrisButtonWidget');
    cashWidget.style.display = sel.value === 'Cash' ? 'block' : 'none';
    qrisWidget.style.display = (sel.value === 'QRIS' || sel.value === 'E-Wallet') ? 'block' : 'none';
  }

  function calculateChange() {
    const final    = parseFloat(document.getElementById('inputFinal').value) || 0;
    const given    = parseFloat(document.getElementById('cashGivenInput').value) || 0;
    const change   = given - final;
    const display  = document.getElementById('cashChangeDisplay');
    display.innerText  = change >= 0 ? 'Rp ' + change.toLocaleString('id-ID') : 'Kurang Rp ' + Math.abs(change).toLocaleString('id-ID');
    display.style.color = change >= 0 ? '#28a745' : '#dc3545';
  }

  function setCashGiven(amount) {
    const final = parseFloat(document.getElementById('inputFinal').value) || 0;
    document.getElementById('cashGivenInput').value = amount === 'exact' ? final : amount;
    calculateChange();
  }

  // ========================================================
  // BOOKING AUTOFILL & QUICK LOAD
  // ========================================================
  function selectBookingForCheckout(bookingId) {
    const sel = document.getElementById('posBookingSelect');
    if (!sel) return;
    sel.value = bookingId;
    applyBookingToPos(sel);
    switchToTab('pos');
    setTimeout(() => {
      const nameInput = document.getElementById('posCustName');
      if (nameInput) {
        nameInput.focus();
      }
    }, 150);
  }

  function applyBookingToPos(sel) {
    if (!sel || !sel.options || sel.selectedIndex < 0) return;
    const opt  = sel.options[sel.selectedIndex];
    const name = opt.getAttribute('data-customer') || '';
    const svc  = opt.getAttribute('data-service') || '';
    const price = parseFloat(opt.getAttribute('data-price')) || 0;

    if (name) document.getElementById('posCustName').value = name;

    if (svc && price > 0) {
      posItems = posItems.filter(i => i.item_type !== 'service');
      
      // Match service ID if possible from selectService options
      let matchedSvcId = '';
      const svcSelect = document.getElementById('selectService');
      if (svcSelect) {
        for (let i = 0; i < svcSelect.options.length; i++) {
          const optS = svcSelect.options[i];
          const optName = optS.getAttribute('data-name') || '';
          if (optName && svc.toLowerCase().includes(optName.toLowerCase())) {
            matchedSvcId = optS.value;
            break;
          }
        }
      }

      posItems.push({
        item_type: 'service',
        item_id:   matchedSvcId || '',
        item_name: svc,
        price:     price,
        quantity:  1
      });
      renderPosTable();
    }
  }

  // ========================================================
  // FORM VALIDATION & CHECKOUT
  // ========================================================
  function validatePosCheckout(event) {
    if (posItems.length === 0) {
      alert('❌ Keranjang POS kosong! Tambahkan minimal 1 item.');
      if (event) event.preventDefault();
      return false;
    }
    const custName = document.getElementById('posCustName').value.trim();
    if (!custName) {
      alert('⚠️ Isi Nama Pelanggan terlebih dahulu.');
      if (event) event.preventDefault();
      document.getElementById('posCustName').focus();
      return false;
    }
    const payMethod  = document.getElementById('paymentMethodSelect').value;
    const finalAmt   = parseFloat(document.getElementById('inputFinal').value) || 0;

    if (payMethod === 'Cash') {
      const given = parseFloat(document.getElementById('cashGivenInput').value) || 0;
      if (given < finalAmt) {
        alert(`⚠️ Uang tunai Rp ${given.toLocaleString('id-ID')} kurang dari total tagihan Rp ${finalAmt.toLocaleString('id-ID')}!`);
        if (event) event.preventDefault();
        return false;
      }
    }

    // Update button text and avoid synchronous button disabling that can cancel form submit
    const btn = document.getElementById('checkoutBtn');
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Memproses Transaksi...';
    setTimeout(() => { btn.disabled = true; }, 100);

    return true;
  }

  // ========================================================
  // QRIS MODAL
  // ========================================================
  function generateAndShowQrisModal() {
    const finalAmt = parseFloat(document.getElementById('inputFinal').value) || 0;
    if (finalAmt <= 0 || posItems.length === 0) {
      alert('Tambahkan item terlebih dahulu sebelum membuka QRIS!');
      return;
    }
    document.getElementById('qrisModalAmount').innerText = 'Rp ' + finalAmt.toLocaleString('id-ID');
    new bootstrap.Modal(document.getElementById('qrisModal')).show();
  }

  function openQrisModalDirect() {
    const finalAmt = parseFloat(document.getElementById('inputFinal').value) || 0;
    document.getElementById('qrisModalAmount').innerText = 'Rp ' + finalAmt.toLocaleString('id-ID');
    new bootstrap.Modal(document.getElementById('qrisModal')).show();
  }

  function confirmQrisPaymentSuccess() {
    if (posItems.length === 0) {
      alert('❌ Keranjang POS kosong! Tambahkan minimal 1 item sebelum verifikasi pembayaran.');
      const modal = bootstrap.Modal.getInstance(document.getElementById('qrisModal'));
      if (modal) modal.hide();
      return;
    }
    const custName = document.getElementById('posCustName').value.trim();
    if (!custName) {
      alert('⚠️ Isi Nama Pelanggan terlebih dahulu.');
      const modal = bootstrap.Modal.getInstance(document.getElementById('qrisModal'));
      if (modal) modal.hide();
      document.getElementById('posCustName').focus();
      return;
    }

    const notice = document.getElementById('qrisStatusNotice');
    notice.style.background = 'rgba(40,167,69,0.25)';
    notice.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i> Pembayaran QRIS Terverifikasi! Menyimpan Transaksi...';

    // Set payment method select to QRIS
    const paySelect = document.getElementById('paymentMethodSelect');
    if (paySelect) {
      paySelect.value = 'QRIS';
    }

    setTimeout(() => {
      const modal = bootstrap.Modal.getInstance(document.getElementById('qrisModal'));
      if (modal) modal.hide();
      const form = document.getElementById('posForm');
      if (form) form.submit();
    }, 600);
  }

  // Helper to switch tabs
  function switchToTab(tabKey) {
    const tabEl = document.getElementById(tabKey + '-tab');
    if (tabEl) {
      const tab = new bootstrap.Tab(tabEl);
      tab.show();
    }
  }

  // ========================================================
  // TRANSACTION FILTER (CLIENT-SIDE)
  // ========================================================
  function filterTransactions() {
    const q       = (document.getElementById('txSearchInput').value || '').toLowerCase();
    const status  = document.getElementById('txStatusFilter').value;
    const method  = document.getElementById('txMethodFilter').value;
    const from    = document.getElementById('txDateFrom').value;
    const to      = document.getElementById('txDateTo').value;

    const rows    = document.querySelectorAll('.tx-row');
    let visible   = 0;

    rows.forEach(row => {
      const name    = row.dataset.name || '';
      const id      = row.dataset.id || '';
      const rowStat = row.dataset.status || '';
      const rowMeth = row.dataset.method || '';
      const rowDate = row.dataset.date || '';

      const matchQ   = !q || name.includes(q) || id.includes(q);
      const matchSt  = !status || rowStat === status;
      const matchMt  = !method || rowMeth === method;
      const matchFrom = !from || rowDate >= from;
      const matchTo   = !to   || rowDate <= to;

      const show = matchQ && matchSt && matchMt && matchFrom && matchTo;
      row.style.display = show ? '' : 'none';
      if (show) visible++;
    });

    document.getElementById('txNoResults').style.display = visible === 0 ? 'block' : 'none';
  }

  // ========================================================
  // CHART.JS: SISTEM DIAGRAM KASIR
  // ========================================================
  let weeklyChartInstance = null;
  let methodChartInstance = null;

  function initKasirCharts() {
    const weeklyCtx = document.getElementById('weeklyRevenueChart');
    if (weeklyCtx) {
      const weeklyLabels  = @json($weeklyRevenue->pluck('label'));
      const weeklyAmounts = @json($weeklyRevenue->pluck('amount'));
      const weeklyCounts  = @json($weeklyRevenue->pluck('count'));

      if (weeklyChartInstance) weeklyChartInstance.destroy();

      weeklyChartInstance = new Chart(weeklyCtx, {
        type: 'bar',
        data: {
          labels: weeklyLabels,
          datasets: [
            {
              label: 'Omzet (Rp)',
              data: weeklyAmounts,
              backgroundColor: 'rgba(40, 167, 69, 0.7)',
              borderColor: '#28a745',
              borderWidth: 1.5,
              borderRadius: 6,
              yAxisID: 'y',
            },
            {
              type: 'line',
              label: 'Volume Trx',
              data: weeklyCounts,
              borderColor: '#ffc107',
              backgroundColor: '#ffc107',
              borderWidth: 2,
              tension: 0.3,
              pointRadius: 4,
              pointHoverRadius: 6,
              yAxisID: 'y1',
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: {
            mode: 'index',
            intersect: false,
          },
          plugins: {
            legend: {
              labels: {
                color: '#d4d4d8',
                font: { family: 'Montserrat', size: 11, weight: '600' }
              }
            },
            tooltip: {
              backgroundColor: '#18181b',
              titleColor: '#fff',
              bodyColor: '#e4e4e7',
              borderColor: 'rgba(255,255,255,0.1)',
              borderWidth: 1,
              padding: 10,
              callbacks: {
                label: function(context) {
                  if (context.dataset.label === 'Omzet (Rp)') {
                    return ' Omzet: Rp ' + Number(context.parsed.y).toLocaleString('id-ID');
                  }
                  return ' Transaksi: ' + context.parsed.y + ' sesi';
                }
              }
            }
          },
          scales: {
            x: {
              grid: { color: 'rgba(255, 255, 255, 0.05)' },
              ticks: { color: '#a1a1aa', font: { family: 'Montserrat', size: 10 } }
            },
            y: {
              type: 'linear',
              display: true,
              position: 'left',
              grid: { color: 'rgba(255, 255, 255, 0.05)' },
              ticks: {
                color: '#28a745',
                font: { family: 'Montserrat', size: 10 },
                callback: function(val) {
                  if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + 'M';
                  if (val >= 1000) return 'Rp ' + (val / 1000).toFixed(0) + 'k';
                  return 'Rp ' + val;
                }
              }
            },
            y1: {
              type: 'linear',
              display: true,
              position: 'right',
              grid: { drawOnChartArea: false },
              ticks: {
                color: '#ffc107',
                stepSize: 1,
                font: { family: 'Montserrat', size: 10 }
              }
            }
          }
        }
      });
    }

    const methodCtx = document.getElementById('paymentMethodChart');
    if (methodCtx) {
      const cashVal    = {{ (float) $cashToday }};
      const qrisVal    = {{ (float) $qrisToday }};
      const ewalletVal = {{ (float) $ewalletToday }};
      const cardVal    = {{ (float) $cardToday }};
      const totalVal   = cashVal + qrisVal + ewalletVal + cardVal;

      if (methodChartInstance) methodChartInstance.destroy();

      const chartData   = totalVal > 0 ? [cashVal, qrisVal, ewalletVal, cardVal] : [1];
      const chartColors = totalVal > 0
        ? ['#28a745', '#00c8c8', '#ff9800', '#64c8ff']
        : ['rgba(255,255,255,0.08)'];
      const chartLabels = totalVal > 0
        ? ['Cash', 'QRIS', 'E-Wallet', 'Card']
        : ['Belum Ada Pembayaran'];

      methodChartInstance = new Chart(methodCtx, {
        type: 'doughnut',
        data: {
          labels: chartLabels,
          datasets: [{
            data: chartData,
            backgroundColor: chartColors,
            borderColor: '#18181b',
            borderWidth: 2,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: '70%',
          plugins: {
            legend: {
              position: 'bottom',
              display: totalVal > 0,
              labels: {
                color: '#a1a1aa',
                boxWidth: 10,
                font: { family: 'Montserrat', size: 10 }
              }
            },
            tooltip: {
              enabled: totalVal > 0,
              backgroundColor: '#18181b',
              callbacks: {
                label: function(ctx) {
                  const val = ctx.parsed;
                  const pct = totalVal > 0 ? ((val / totalVal) * 100).toFixed(1) : 0;
                  return ` ${ctx.label}: Rp ${Number(val).toLocaleString('id-ID')} (${pct}%)`;
                }
              }
            }
          }
        }
      });
    }
  }

  function updateKasirCharts() {
    initKasirCharts();
  }

  // ========================================================
  // INIT
  // ========================================================
  document.addEventListener('DOMContentLoaded', function () {
    // Load charts
    initKasirCharts();

    // Redraw charts when switching to Settlement tab so canvas dimensions fit properly
    const settlementTabBtn = document.getElementById('settlement-tab');
    if (settlementTabBtn) {
      settlementTabBtn.addEventListener('shown.bs.tab', function () {
        setTimeout(initKasirCharts, 100);
      });
    }

    // Init tab from session flash
    const activeTab = '{{ session("active_tab", "pos") }}';
    if (activeTab && activeTab !== 'pos') {
      const tabEl = document.getElementById(activeTab + '-tab');
      if (tabEl) { new bootstrap.Tab(tabEl).show(); }
    }

    // Set today dates in filter
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('txDateTo').value = today;
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
