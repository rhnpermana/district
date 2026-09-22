@extends('admin_layout.app')

@section('title', 'Admin Central Workstation - District Studio')

@section('content')
<main class="main" style="padding-top: 80px; min-height: 100vh; background-color: #09090b;">

  <!-- Admin Header Section -->
  <section style="background: linear-gradient(135deg, #18140a 0%, #0d0b06 100%); border-bottom: 1px solid rgba(220,165,62,0.25); padding: 35px 0;">
    <div class="container-fluid container-xl">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge" style="background: rgba(220,165,62,0.15); color: #dca53e; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; padding: 6px 14px; border: 1px solid rgba(220,165,62,0.3); font-family: 'Montserrat', sans-serif;">
              <i class="bi bi-shield-lock-fill me-1"></i> System Administration & Central Control
            </span>
          </div>
          <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.9rem; font-weight: 900; color: #ffffff; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
            Admin Workstation <span style="color: #dca53e;">.</span>
          </h2>
          <p style="font-size: 0.88rem; color: #a1a1aa; margin: 6px 0 0; font-weight: 400;">
            Kelola pengguna, master layanan & produk, voucher diskon, monitor reservasi, shift kerja staf, dan audit keamanan sistem.
          </p>
        </div>

        <!-- Quick Top Actions -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
          <button class="btn btn-sm text-dark fw-bold px-3 py-2" style="background-color: #dca53e; font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px; border: none;" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah User
          </button>
          <button class="btn btn-sm btn-outline-light px-3 py-2 fw-semibold" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px; border-color: rgba(255,255,255,0.2);" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="bi bi-scissors me-1"></i> Tambah Layanan
          </button>
          <button class="btn btn-sm btn-outline-info px-3 py-2 fw-semibold" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px;" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-box-seam me-1"></i> Tambah Produk
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Container -->
  <div class="container-fluid container-xl" style="padding: 35px 15px 60px;">

    {{-- System Flash Alert Messages --}}
    @if(session('success'))
      <div class="alert alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background: rgba(220,165,62,0.12); border: 1px solid rgba(220,165,62,0.4); color: #fff; border-radius: 8px; padding: 16px 20px;">
        <i class="bi bi-check-circle-fill me-3" style="color: #dca53e; font-size: 1.3rem;"></i>
        <div>
          <strong style="color: #dca53e;">Berhasil!</strong> {{ session('success') }}
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background: rgba(220,53,69,0.12); border: 1px solid rgba(220,53,69,0.4); color: #fff; border-radius: 8px; padding: 16px 20px;">
        <i class="bi bi-exclamation-triangle-fill me-3" style="color: #dc3545; font-size: 1.3rem;"></i>
        <div>
          <strong style="color: #dc3545;">Perhatian!</strong> {{ $errors->first() }}
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- 1. KPI TOP STAT CARDS SUMMARY -->
    <div class="row g-3 mb-4">
      
      <!-- Card Total User & Staff -->
      <div class="col-12 col-sm-6 col-xl-2">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 20px 18px; transition: transform 0.2s, border-color 0.2s;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Pengguna</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(100,200,255,0.1); color: #64c8ff; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-people-fill"></i>
            </div>
          </div>
          <h3 style="font-size: 1.8rem; font-weight: 900; color: #fff; margin: 0;">{{ $kpiStats['total_users'] }}</h3>
          <span style="font-size: 0.72rem; color: #64c8ff; font-weight: 600;">{{ $kpiStats['total_staff'] }} Staf / Barber</span>
        </div>
      </div>

      <!-- Card Total Bookings -->
      <div class="col-12 col-sm-6 col-xl-2">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 20px 18px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Reservasi</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(220,165,62,0.1); color: #dca53e; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-calendar2-check-fill"></i>
            </div>
          </div>
          <h3 style="font-size: 1.8rem; font-weight: 900; color: #fff; margin: 0;">{{ $kpiStats['total_bookings'] }}</h3>
          <span style="font-size: 0.72rem; color: #ffc107; font-weight: 600;">{{ $kpiStats['pending_bookings'] }} Menunggu Konfirmasi</span>
        </div>
      </div>

      <!-- Card Layanan & Produk -->
      <div class="col-12 col-sm-6 col-xl-2">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 20px 18px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Katalog</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(0,200,200,0.1); color: #00c8c8; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-scissors"></i>
            </div>
          </div>
          <h3 style="font-size: 1.8rem; font-weight: 900; color: #fff; margin: 0;">{{ $services->count() }}</h3>
          <span style="font-size: 0.72rem; color: #00c8c8; font-weight: 600;">{{ $products->count() }} Produk Retail</span>
        </div>
      </div>

      <!-- Card Stok Menipis -->
      <div class="col-12 col-sm-6 col-xl-2">
        <div style="background: #121215; border: 1px solid {{ $kpiStats['low_stock_products'] > 0 ? 'rgba(220,53,69,0.5)' : 'rgba(255,255,255,0.07)' }}; border-radius: 10px; padding: 20px 18px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Stok Alert</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(220,53,69,0.1); color: #dc3545; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
          </div>
          <h3 style="font-size: 1.8rem; font-weight: 900; color: {{ $kpiStats['low_stock_products'] > 0 ? '#dc3545' : '#fff' }}; margin: 0;">{{ $kpiStats['low_stock_products'] }}</h3>
          <span style="font-size: 0.72rem; color: {{ $kpiStats['low_stock_products'] > 0 ? '#dc3545' : '#a1a1aa' }}; font-weight: 600;">
            {{ $kpiStats['low_stock_products'] > 0 ? 'Perlu Restock Segera!' : 'Stok Aman' }}
          </span>
        </div>
      </div>

      <!-- Card Voucher Aktif -->
      <div class="col-12 col-sm-6 col-xl-2">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 20px 18px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Voucher</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(40,167,69,0.1); color: #28a745; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-ticket-perforated-fill"></i>
            </div>
          </div>
          <h3 style="font-size: 1.8rem; font-weight: 900; color: #fff; margin: 0;">{{ $kpiStats['active_vouchers'] }}</h3>
          <span style="font-size: 0.72rem; color: #28a745; font-weight: 600;">Voucher Promo Aktif</span>
        </div>
      </div>

      <!-- Card Pending Complaints -->
      <div class="col-12 col-sm-6 col-xl-2">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 20px 18px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Komplain</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(255,152,0,0.1); color: #ff9800; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-chat-left-dots-fill"></i>
            </div>
          </div>
          <h3 style="font-size: 1.8rem; font-weight: 900; color: #fff; margin: 0;">{{ $kpiStats['pending_complaints'] }}</h3>
          <span style="font-size: 0.72rem; color: #ff9800; font-weight: 600;">Perlu Tindak Lanjut</span>
        </div>
      </div>

    </div>

    <!-- 2. NAVIGATION TABS BARBER ADMIN -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; overflow: hidden;" class="shadow-lg">
      
      <!-- Nav Tabs Bar -->
      <div style="background: #18181b; border-bottom: 1px solid rgba(255,255,255,0.08); padding: 10px 15px 0;">
        <ul class="nav nav-tabs border-0 flex-nowrap overflow-auto" id="adminTabs" role="tablist" style="gap: 5px; scrollbar-width: none;">
          
          <li class="nav-item" role="presentation">
            <button class="nav-link active font-monospace fw-bold text-uppercase border-0 py-3 px-3" id="overview-tab" data-bs-toggle="tab" data-bs-target="#tab-overview" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-grid-1x2-fill me-2"></i> Overview
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link font-monospace fw-bold text-uppercase border-0 py-3 px-3" id="users-tab" data-bs-toggle="tab" data-bs-target="#tab-users" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-people me-2"></i> User & Staff ({{ $users->count() }})
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link font-monospace fw-bold text-uppercase border-0 py-3 px-3" id="services-tab" data-bs-toggle="tab" data-bs-target="#tab-services" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-scissors me-2"></i> Layanan ({{ $services->count() }})
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link font-monospace fw-bold text-uppercase border-0 py-3 px-3" id="products-tab" data-bs-toggle="tab" data-bs-target="#tab-products" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-box-seam me-2"></i> Produk Retail ({{ $products->count() }})
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link font-monospace fw-bold text-uppercase border-0 py-3 px-3" id="vouchers-tab" data-bs-toggle="tab" data-bs-target="#tab-vouchers" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-ticket-perforated me-2"></i> Voucher Promo ({{ $vouchers->count() }})
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link font-monospace fw-bold text-uppercase border-0 py-3 px-3" id="bookings-tab" data-bs-toggle="tab" data-bs-target="#tab-bookings" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-calendar2-week me-2"></i> Monitoring Booking ({{ $bookings->count() }})
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link font-monospace fw-bold text-uppercase border-0 py-3 px-3" id="shifts-tab" data-bs-toggle="tab" data-bs-target="#tab-shifts" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-clock-history me-2"></i> Shift Kerja
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link font-monospace fw-bold text-uppercase border-0 py-3 px-3" id="complaints-tab" data-bs-toggle="tab" data-bs-target="#tab-complaints" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-chat-left-quote me-2"></i> Komplain Pelanggan ({{ $complaints->count() }})
            </button>
          </li>

          <li class="nav-item" role="presentation">
            <button class="nav-link font-monospace fw-bold text-uppercase border-0 py-3 px-3" id="logs-tab" data-bs-toggle="tab" data-bs-target="#tab-logs" type="button" role="tab" style="font-size: 0.78rem; border-radius: 8px 8px 0 0;">
              <i class="bi bi-shield-check me-2"></i> Security Logs
            </button>
          </li>

        </ul>
      </div>

      <!-- Tab Content Area -->
      <div class="tab-content p-4" id="adminTabsContent">
        
        <!-- ======================================================== -->
        <!-- TAB 1: OVERVIEW & QUICK ACTIONS -->
        <!-- ======================================================== -->
        <div class="tab-pane fade show active" id="tab-overview" role="tabpanel" aria-labelledby="overview-tab">
          <div class="row g-4">
            
            <!-- System Welcome Box -->
            <div class="col-12 col-lg-8">
              <div style="background: linear-gradient(135deg, rgba(220,165,62,0.1), rgba(0,0,0,0.4)); border: 1px solid rgba(220,165,62,0.25); border-radius: 10px; padding: 30px;">
                <div class="d-flex align-items-center gap-3 mb-3">
                  <div style="width: 50px; height: 50px; border-radius: 12px; background: #dca53e; color: #000; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;" class="fw-bold">
                    <i class="bi bi-sliders"></i>
                  </div>
                  <div>
                    <h4 style="font-family: 'Montserrat', sans-serif; font-weight: 800; color: #fff; margin: 0; text-transform: uppercase;">
                      District Studio Control Panel
                    </h4>
                    <p style="color: #a1a1aa; font-size: 0.85rem; margin: 2px 0 0;">
                      Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>. Seluruh master data dan operasional barbershop berjalan secara optimal.
                    </p>
                  </div>
                </div>

                <hr style="border-color: rgba(255,255,255,0.08); margin: 20px 0;">

                <div class="row g-3">
                  <div class="col-6 col-md-4">
                    <div style="background: rgba(255,255,255,0.03); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                      <span style="font-size: 0.72rem; color: #71717a; text-transform: uppercase; font-family: 'Montserrat', sans-serif; font-weight: 700; display: block; margin-bottom: 5px;">Hair Artist / Stylist</span>
                      <span style="font-size: 1.2rem; font-weight: 800; color: #ff9800;">{{ $stylists->count() }} Staff Aktif</span>
                    </div>
                  </div>

                  <div class="col-6 col-md-4">
                    <div style="background: rgba(255,255,255,0.03); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                      <span style="font-size: 0.72rem; color: #71717a; text-transform: uppercase; font-family: 'Montserrat', sans-serif; font-weight: 700; display: block; margin-bottom: 5px;">Low Stock Alerts</span>
                      <span style="font-size: 1.2rem; font-weight: 800; color: {{ $kpiStats['low_stock_products'] > 0 ? '#dc3545' : '#28a745' }};">
                        {{ $kpiStats['low_stock_products'] }} Item
                      </span>
                    </div>
                  </div>

                  <div class="col-6 col-md-4">
                    <div style="background: rgba(255,255,255,0.03); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                      <span style="font-size: 0.72rem; color: #71717a; text-transform: uppercase; font-family: 'Montserrat', sans-serif; font-weight: 700; display: block; margin-bottom: 5px;">Total Log Aktivitas</span>
                      <span style="font-size: 1.2rem; font-weight: 800; color: #64c8ff;">{{ $systemLogs->count() }} Rec</span>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <!-- Quick Action Shortcuts -->
            <div class="col-12 col-lg-4">
              <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 25px;" class="h-100">
                <h5 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; border-left: 3px solid #dca53e; padding-left: 10px;" class="mb-3">
                  Pintasan Aksi Admin
                </h5>

                <div class="d-grid gap-2">
                  <button class="btn btn-dark text-start py-2 px-3 border-secondary d-flex align-items-center justify-content-between" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <span style="font-size: 0.85rem;"><i class="bi bi-person-plus text-warning me-2"></i> Tambah User / Staff</span>
                    <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
                  </button>

                  <button class="btn btn-dark text-start py-2 px-3 border-secondary d-flex align-items-center justify-content-between" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <span style="font-size: 0.85rem;"><i class="bi bi-scissors text-info me-2"></i> Tambah Master Layanan</span>
                    <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
                  </button>

                  <button class="btn btn-dark text-start py-2 px-3 border-secondary d-flex align-items-center justify-content-between" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <span style="font-size: 0.85rem;"><i class="bi bi-box-seam text-success me-2"></i> Tambah Produk Retail</span>
                    <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
                  </button>

                  <button class="btn btn-dark text-start py-2 px-3 border-secondary d-flex align-items-center justify-content-between" data-bs-toggle="modal" data-bs-target="#addVoucherModal">
                    <span style="font-size: 0.85rem;"><i class="bi bi-ticket-perforated text-warning me-2"></i> Terbitkan Voucher</span>
                    <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
                  </button>

                  <button class="btn btn-dark text-start py-2 px-3 border-secondary d-flex align-items-center justify-content-between" data-bs-toggle="modal" data-bs-target="#addShiftModal">
                    <span style="font-size: 0.85rem;"><i class="bi bi-calendar2-plus text-primary me-2"></i> Buat Shift Kerja Staf</span>
                    <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
                  </button>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 2: MANAJEMEN USER & STAFF -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-users" role="tabpanel" aria-labelledby="users-tab">
          
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #ffc107; padding-left: 12px;">
              Master Data Pengguna & Hak Akses Role
            </h4>
            
            <div class="d-flex align-items-center gap-2">
              <!-- Filter Form -->
              <form action="{{ route('dashboard') }}" method="GET" class="d-flex gap-2 m-0">
                <input type="text" name="search" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="Cari nama / email / phone..." value="{{ request('search') }}" style="width: 200px;">
                <select name="role_filter" class="form-select form-select-sm bg-dark text-white border-secondary" style="width: 140px;" onchange="this.form.submit()">
                  <option value="">-- Semua Role --</option>
                  <option value="owner" {{ request('role_filter') === 'owner' ? 'selected' : '' }}>Owner</option>
                  <option value="supervisor" {{ request('role_filter') === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                  <option value="admin" {{ request('role_filter') === 'admin' ? 'selected' : '' }}>Admin</option>
                  <option value="kasir" {{ request('role_filter') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                  <option value="receptionist" {{ request('role_filter') === 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                  <option value="hair stylist" {{ request('role_filter') === 'hair stylist' ? 'selected' : '' }}>Hair Stylist</option>
                  <option value="customer" {{ request('role_filter') === 'customer' ? 'selected' : '' }}>Customer</option>
                </select>
                <button type="submit" class="btn btn-sm btn-secondary"><i class="bi bi-search"></i></button>
                @if(request('search') || request('role_filter'))
                  <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i> Reset</a>
                @endif
              </form>

              <button class="btn btn-sm btn-warning fw-bold" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah User
              </button>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
              <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: #a1a1aa;">
                <tr>
                  <th>ID</th>
                  <th>Nama Pengguna</th>
                  <th>Kontak</th>
                  <th>Role Hak Akses</th>
                  <th>Komisi (%)</th>
                  <th>Work Status</th>
                  <th class="text-end">Aksi Admin</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $u)
                  <tr>
                    <td class="text-muted font-monospace">#{{ $u->id }}</td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.1); color: #dca53e; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;">
                          {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        <div>
                          <strong style="color: #fff;">{{ $u->name }}</strong>
                          @if($u->id === auth()->id())
                            <span class="badge bg-warning text-dark ms-1" style="font-size: 0.65rem;">Anda</span>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td>
                      <span style="color: #e4e4e7;">{{ $u->email }}</span><br>
                      <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $u->phone ?? '-' }}</small>
                    </td>
                    <td>
                      <span class="badge" style="
                        @if($u->role === 'owner') background: #dca53e; color: #000;
                        @elseif($u->role === 'supervisor') background: #64c8ff; color: #000;
                        @elseif($u->role === 'admin') background: #ffc107; color: #000;
                        @elseif($u->role === 'kasir') background: #28a745; color: #fff;
                        @elseif($u->role === 'receptionist') background: #00c8c8; color: #000;
                        @elseif($u->role === 'hair stylist') background: #ff9800; color: #000;
                        @else background: #52525b; color: #fff; @endif
                        font-weight: 800; text-transform: uppercase; padding: 5px 12px; font-family: 'Montserrat', sans-serif;">
                        {{ strtoupper($u->role) }}
                      </span>
                    </td>
                    <td class="font-monospace">
                      {{ $u->role === 'hair stylist' ? ($u->commission_rate ?? 30) . '%' : '-' }}
                    </td>
                    <td>
                      @if($u->work_status === 'Available')
                        <span class="badge bg-success text-white">Available</span>
                      @elseif($u->work_status === 'On Duty')
                        <span class="badge bg-warning text-dark">On Duty</span>
                      @elseif($u->work_status === 'Off')
                        <span class="badge bg-secondary">Off</span>
                      @else
                        <span class="badge bg-info text-dark">{{ $u->work_status ?? 'Available' }}</span>
                      @endif
                    </td>
                    <td class="text-end">
                      <div class="btn-group">
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $u->id }}" title="Edit User">
                          <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        @if($u->id !== auth()->id())
                          <form action="{{ route('users.delete', $u->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus user {{ $u->name }}? Action ini tidak bisa dibatalkan.')">
                              <i class="bi bi-trash"></i>
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

        </div>

        <!-- ======================================================== -->
        <!-- TAB 3: MASTER LAYANAN BARBERSHOP -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-services" role="tabpanel" aria-labelledby="services-tab">
          
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #ff9800; padding-left: 12px;">
              Master Layanan & Treatment Barbershop
            </h4>

            <button class="btn btn-sm btn-warning fw-bold" data-bs-toggle="modal" data-bs-target="#addServiceModal">
              <i class="bi bi-plus-circle me-1"></i> Tambah Layanan
            </button>
          </div>

          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
              <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: #a1a1aa;">
                <tr>
                  <th>Nama Layanan</th>
                  <th>Kategori</th>
                  <th>Harga (Rp)</th>
                  <th>Durasi</th>
                  <th>Status Aktif</th>
                  <th class="text-end">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($services as $s)
                  <tr>
                    <td>
                      <strong style="color: #fff;">{{ $s->name }}</strong>
                      @if($s->description)
                        <br><small class="text-muted">{{ Str::limit($s->description, 60) }}</small>
                      @endif
                    </td>
                    <td><span class="badge bg-secondary font-monospace">{{ $s->category }}</span></td>
                    <td class="text-warning fw-bold font-monospace">Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                    <td><i class="bi bi-clock me-1 text-muted"></i>{{ $s->duration_minutes }} Mins</td>
                    <td>
                      <form action="{{ route('admin.services.toggle', $s->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $s->is_active ? 'btn-success' : 'btn-outline-secondary' }}" style="font-size: 0.7rem; font-weight: 700; padding: 2px 10px;">
                          {{ $s->is_active ? 'AKTIF' : 'NON-AKTIF' }}
                        </button>
                      </form>
                    </td>
                    <td class="text-end">
                      <div class="btn-group">
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $s->id }}">
                          <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <form action="{{ route('admin.services.delete', $s->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus layanan {{ $s->name }}?')">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>

        <!-- ======================================================== -->
        <!-- TAB 4: MASTER PRODUK RETAIL & STOK -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-products" role="tabpanel" aria-labelledby="products-tab">
          
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #00c8c8; padding-left: 12px;">
              Katalog Produk Retail & Audit Stok
            </h4>

            <button class="btn btn-sm btn-info text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#addProductModal">
              <i class="bi bi-plus-circle me-1"></i> Tambah Produk Retail
            </button>
          </div>

          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
              <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: #a1a1aa;">
                <tr>
                  <th>Nama Produk</th>
                  <th>Kategori</th>
                  <th>Harga Jual (Rp)</th>
                  <th>Jumlah Stok</th>
                  <th>Min Alert Threshold</th>
                  <th class="text-end">Aksi Admin</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $p)
                  <tr>
                    <td>
                      <strong style="color: #fff;">{{ $p->name }}</strong>
                      @if($p->description)
                        <br><small class="text-muted">{{ Str::limit($p->description, 50) }}</small>
                      @endif
                    </td>
                    <td><span class="badge bg-secondary font-monospace">{{ $p->category }}</span></td>
                    <td class="text-info fw-bold font-monospace">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                    <td>
                      <span class="badge {{ $p->stock <= $p->min_stock ? 'bg-danger text-white' : 'bg-success text-white' }}" style="font-size: 0.85rem;">
                        {{ $p->stock }} pcs
                      </span>
                      @if($p->stock <= $p->min_stock)
                        <small class="text-danger d-block font-monospace" style="font-size: 0.68rem;"><i class="bi bi-exclamation-circle me-1"></i>Stok Menipis!</small>
                      @endif
                    </td>
                    <td class="font-monospace text-muted">{{ $p->min_stock }} pcs</td>
                    <td class="text-end">
                      <div class="btn-group">
                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#restockModal{{ $p->id }}" title="Tambah Stok">
                          <i class="bi bi-plus-lg"></i> Restock
                        </button>
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $p->id }}" title="Edit Produk">
                          <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <form action="{{ route('admin.products.delete', $p->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus produk {{ $p->name }}?')">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>

        <!-- ======================================================== -->
        <!-- TAB 5: VOUCHER PROMO & DISKON -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-vouchers" role="tabpanel" aria-labelledby="vouchers-tab">
          
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #28a745; padding-left: 12px;">
              Voucher Promo & Kode Diskon
            </h4>

            <button class="btn btn-sm btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#addVoucherModal">
              <i class="bi bi-plus-circle me-1"></i> Terbitkan Voucher Baru
            </button>
          </div>

          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
              <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: #a1a1aa;">
                <tr>
                  <th>Kode Voucher</th>
                  <th>Tipe Diskon</th>
                  <th>Nilai Diskon</th>
                  <th>Minimal Spend</th>
                  <th>Masa Berlaku</th>
                  <th>Status</th>
                  <th class="text-end">Aksi Admin</th>
                </tr>
              </thead>
              <tbody>
                @foreach($vouchers as $v)
                  <tr>
                    <td>
                      <span class="badge bg-warning text-dark font-monospace fw-bold" style="font-size: 0.85rem; letter-spacing: 1px;">
                        {{ $v->code }}
                      </span>
                    </td>
                    <td><span class="badge bg-secondary font-monospace">{{ strtoupper($v->type) }}</span></td>
                    <td class="text-success fw-bold font-monospace">
                      {{ $v->type === 'percent' ? $v->discount_value . '%' : 'Rp ' . number_format($v->discount_value, 0, ',', '.') }}
                    </td>
                    <td class="font-monospace">Rp {{ number_format($v->min_spend, 0, ',', '.') }}</td>
                    <td>
                      @if($v->valid_until)
                        <small class="text-muted"><i class="bi bi-calendar-event me-1"></i>{{ \Carbon\Carbon::parse($v->valid_until)->format('d M Y') }}</small>
                      @else
                        <small class="text-success">Selamanya</small>
                      @endif
                    </td>
                    <td>
                      <form action="{{ route('admin.vouchers.toggle', $v->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $v->is_active ? 'btn-success' : 'btn-outline-secondary' }}" style="font-size: 0.7rem; font-weight: 700; padding: 2px 10px;">
                          {{ $v->is_active ? 'AKTIF' : 'NON-AKTIF' }}
                        </button>
                      </form>
                    </td>
                    <td class="text-end">
                      <div class="btn-group">
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editVoucherModal{{ $v->id }}">
                          <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <form action="{{ route('admin.vouchers.delete', $v->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus voucher {{ $v->code }}?')">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>

        <!-- ======================================================== -->
        <!-- TAB 6: MONITORING & MANAJEMEN BOOKING -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-bookings" role="tabpanel" aria-labelledby="bookings-tab">
          
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #dca53e; padding-left: 12px;">
              Monitoring & Kelola Reservasi Pelanggan
            </h4>

            <!-- Filter Status Booking -->
            <form action="{{ route('dashboard') }}" method="GET" class="d-flex gap-2 m-0">
              <select name="status_filter" class="form-select form-select-sm bg-dark text-white border-secondary" onchange="this.form.submit()" style="width: 180px;">
                <option value="">-- Semua Status --</option>
                <option value="pending" {{ request('status_filter') === 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                <option value="approved" {{ request('status_filter') === 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                <option value="completed" {{ request('status_filter') === 'completed' ? 'selected' : '' }}>🏆 Selesai</option>
                <option value="cancelled" {{ request('status_filter') === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
              </select>
              @if(request('status_filter'))
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i> Clear Filter</a>
              @endif
            </form>
          </div>

          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
              <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: #a1a1aa;">
                <tr>
                  <th>No. Antrean</th>
                  <th>Pelanggan</th>
                  <th>Layanan</th>
                  <th>Cabang</th>
                  <th>Jadwal</th>
                  <th>Stylist / Barber</th>
                  <th>Status</th>
                  <th class="text-end">Aksi Admin</th>
                </tr>
              </thead>
              <tbody>
                @foreach($bookings as $booking)
                  <tr>
                    <td class="font-monospace fw-bold text-warning">{{ $booking->queue_number ?? '#'.$booking->id }}</td>
                    <td>
                      <strong style="color: #fff;">{{ $booking->user->name }}</strong>
                      <br><small class="text-muted">{{ $booking->user->phone ?? '-' }}</small>
                    </td>
                    <td><span style="color: #e4e4e7;">{{ $booking->service }}</span></td>
                    <td><small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $booking->branch }}</small></td>
                    <td>
                      <small class="text-white">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</small><br>
                      <span style="color: #dca53e; font-weight: 700; font-size: 0.78rem;">{{ $booking->booking_time }}</span>
                    </td>
                    <td>
                      @if($booking->stylist)
                        <span class="badge bg-secondary"><i class="bi bi-person me-1"></i>{{ $booking->stylist->name }}</span>
                      @else
                        <small class="text-muted font-italic">Belum ditugaskan</small>
                      @endif
                    </td>
                    <td>
                      @if($booking->status === 'pending')
                        <span class="badge bg-warning text-dark">⏳ MENUNGGU</span>
                      @elseif($booking->status === 'approved')
                        <span class="badge bg-info text-dark">✅ DISETUJUI</span>
                      @elseif($booking->status === 'completed')
                        <span class="badge bg-success">🏆 SELESAI</span>
                      @elseif($booking->status === 'cancelled')
                        <span class="badge bg-danger">❌ DIBATALKAN</span>
                      @endif
                    </td>
                    <td class="text-end">
                      <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#adminBookingModal{{ $booking->id }}">
                        <i class="bi bi-sliders me-1"></i> Kelola
                      </button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>

        <!-- ======================================================== -->
        <!-- TAB 7: JADWAL SHIFT KERJA STAF -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-shifts" role="tabpanel" aria-labelledby="shifts-tab">
          
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #64c8ff; padding-left: 12px;">
              Jadwal Shift Kerja Barber & Staf
            </h4>

            <button class="btn btn-sm btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#addShiftModal">
              <i class="bi bi-calendar-plus me-1"></i> + Buat / Update Shift Kerja
            </button>
          </div>

          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
              <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: #a1a1aa;">
                <tr>
                  <th>Tanggal</th>
                  <th>Staf / Barber</th>
                  <th>Role</th>
                  <th>Tipe Shift</th>
                  <th>Catatan</th>
                </tr>
              </thead>
              <tbody>
                @forelse($workShifts as $ws)
                  <tr>
                    <td><strong class="text-white">{{ \Carbon\Carbon::parse($ws->shift_date)->format('d M Y') }}</strong></td>
                    <td><span class="text-warning fw-bold">{{ $ws->user ? $ws->user->name : 'N/A' }}</span></td>
                    <td><small class="text-muted">{{ strtoupper($ws->user->role ?? '-') }}</small></td>
                    <td>
                      @if($ws->shift_type === 'Pagi')
                        <span class="badge bg-info text-dark">Shift Pagi (10:00 - 16:00)</span>
                      @elseif($ws->shift_type === 'Siang')
                        <span class="badge bg-warning text-dark">Shift Siang (14:00 - 21:00)</span>
                      @elseif($ws->shift_type === 'Full')
                        <span class="badge bg-success">Full Day Shift</span>
                      @else
                        <span class="badge bg-secondary">Off / Libur</span>
                      @endif
                    </td>
                    <td><small class="text-muted">{{ $ws->notes ?? '-' }}</small></td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Belum ada data shift kerja yang dibuat. Klik tombol di atas untuk menambah shift.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>

        <!-- ======================================================== -->
        <!-- TAB 8: PUSAT KOMPLAIN PELANGGAN -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-complaints" role="tabpanel" aria-labelledby="complaints-tab">
          
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #ff9800; padding-left: 12px;">
              Pusat Penanganan Komplain & Feedback Pelanggan
            </h4>
          </div>

          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
              <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; color: #a1a1aa;">
                <tr>
                  <th>Tanggal</th>
                  <th>Pelanggan</th>
                  <th>Kategori</th>
                  <th>Pesan Keluhan</th>
                  <th>Status Penanganan</th>
                  <th>Resolusi Catatan</th>
                  <th class="text-end">Aksi Admin</th>
                </tr>
              </thead>
              <tbody>
                @forelse($complaints as $c)
                  <tr>
                    <td><small class="text-muted">{{ $c->created_at->format('d/m/Y H:i') }}</small></td>
                    <td><strong class="text-white">{{ $c->customer_name }}</strong></td>
                    <td><span class="badge bg-secondary">{{ $c->category }}</span></td>
                    <td style="max-width: 250px;"><small class="text-white-50">{{ $c->message }}</small></td>
                    <td>
                      @if($c->status === 'pending')
                        <span class="badge bg-warning text-dark">PENDING</span>
                      @elseif($c->status === 'in_progress')
                        <span class="badge bg-info text-dark">DIPROSES</span>
                      @else
                        <span class="badge bg-success">TERSELESAIKAN</span>
                      @endif
                    </td>
                    <td style="max-width: 200px;"><small class="text-info">{{ $c->resolution ?? '-' }}</small></td>
                    <td class="text-end">
                      <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#resolveComplaintModal{{ $c->id }}">
                        <i class="bi bi-chat-right-check me-1"></i> Resolusi
                      </button>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Belum ada catatan komplain pelanggan.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>

        <!-- ======================================================== -->
        <!-- TAB 9: SYSTEM AUDIT LOGS & SECURITY -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-logs" role="tabpanel" aria-labelledby="logs-tab">
          
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #dc3545; padding-left: 12px;">
              <i class="bi bi-shield-lock me-1" style="color: #dc3545;"></i> Audit Trail Aktivitas Keamanan Sistem
            </h4>

            <form action="{{ route('admin.logs.clear') }}" method="POST" onsubmit="return confirm('Bersihkan seluruh log audit keamanan sistem?')">
              @csrf
              <button type="submit" class="btn btn-sm btn-outline-danger fw-bold">
                <i class="bi bi-trash me-1"></i> Bersihkan Log Audit
              </button>
            </form>
          </div>

          <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
            <table class="table table-dark table-striped align-middle" style="font-size: 0.8rem;">
              <thead class="table-black sticky-top" style="font-family: 'Montserrat', sans-serif; font-size: 0.7rem; text-transform: uppercase;">
                <tr>
                  <th>Waktu</th>
                  <th>Pengguna</th>
                  <th>Aksi Audit</th>
                  <th>Detail Aktivitas</th>
                  <th>IP Address</th>
                </tr>
              </thead>
              <tbody>
                @foreach($systemLogs as $log)
                  <tr>
                    <td><small class="text-muted font-monospace">{{ $log->created_at->format('d/m/Y H:i:s') }}</small></td>
                    <td><strong class="text-warning">{{ $log->user ? $log->user->name : 'System' }}</strong></td>
                    <td><span class="badge bg-secondary font-monospace">{{ $log->action }}</span></td>
                    <td><small class="text-white-50">{{ $log->details }}</small></td>
                    <td><code style="color: #64c8ff;">{{ $log->ip_address ?? '127.0.0.1' }}</code></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>

      </div>

    </div>

  </div>
</main>

<!-- =================================================================== -->
<!-- ALL MODAL DIALOGS FOR ADMIN WORKSTATION -->
<!-- =================================================================== -->

<!-- 1. MODAL ADD USER -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-warning"><i class="bi bi-person-plus-fill me-2"></i>Tambah User Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Nama Lengkap:</label>
            <input type="text" name="name" class="form-control bg-secondary text-white border-0" required placeholder="Contoh: Budi Santoso">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Email Address:</label>
            <input type="email" name="email" class="form-control bg-secondary text-white border-0" required placeholder="budi@district.com">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">No. Telepon / WA:</label>
            <input type="text" name="phone" class="form-control bg-secondary text-white border-0" placeholder="08123456789">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Role Akses Sistem:</label>
            <select name="role" class="form-select bg-secondary text-white border-0" required>
              <option value="customer">Pelanggan / Customer</option>
              <option value="hair stylist">Hair Stylist / Barber</option>
              <option value="kasir">Kasir (POS)</option>
              <option value="receptionist">Resepsionis</option>
              <option value="supervisor">Supervisor</option>
              <option value="admin">Admin System</option>
              <option value="owner">Owner Barbershop</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Rate Komisi Barber (%):</label>
            <input type="number" name="commission_rate" class="form-control bg-secondary text-white border-0" value="30" min="0" max="100">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Password Login:</label>
            <input type="password" name="password" class="form-control bg-secondary text-white border-0" value="123456" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">PIN Keamanan Admin (6 Digit - Khusus Role Admin):</label>
            <input type="password" name="security_pin" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" class="form-control bg-secondary text-white border-0" placeholder="Default: 123456">
            <small class="text-warning font-monospace" style="font-size: 0.7rem;">Wajib 6 digit angka untuk verifikasi login admin (Default: 123456).</small>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning fw-bold">Simpan User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- 2. EDIT USER MODALS -->
@foreach($users as $u)
<div class="modal fade" id="editUserModal{{ $u->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-warning"><i class="bi bi-pencil-square me-2"></i>Edit User #{{ $u->id }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('users.update', $u->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Nama Lengkap:</label>
            <input type="text" name="name" class="form-control bg-secondary text-white border-0" value="{{ $u->name }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Email Address:</label>
            <input type="email" name="email" class="form-control bg-secondary text-white border-0" value="{{ $u->email }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">No. Telepon / WA:</label>
            <input type="text" name="phone" class="form-control bg-secondary text-white border-0" value="{{ $u->phone }}">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Role Akses Sistem:</label>
            <select name="role" class="form-select bg-secondary text-white border-0" required>
              <option value="customer" {{ $u->role === 'customer' ? 'selected' : '' }}>Pelanggan / Customer</option>
              <option value="hair stylist" {{ $u->role === 'hair stylist' ? 'selected' : '' }}>Hair Stylist / Barber</option>
              <option value="kasir" {{ $u->role === 'kasir' ? 'selected' : '' }}>Kasir (POS)</option>
              <option value="receptionist" {{ $u->role === 'receptionist' ? 'selected' : '' }}>Resepsionis</option>
              <option value="supervisor" {{ $u->role === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
              <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin System</option>
              <option value="owner" {{ $u->role === 'owner' ? 'selected' : '' }}>Owner Barbershop</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Rate Komisi Barber (%):</label>
            <input type="number" name="commission_rate" class="form-control bg-secondary text-white border-0" value="{{ $u->commission_rate ?? 30 }}" min="0" max="100">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Work Status:</label>
            <select name="work_status" class="form-select bg-secondary text-white border-0">
              <option value="Available" {{ $u->work_status === 'Available' ? 'selected' : '' }}>Available</option>
              <option value="On Duty" {{ $u->work_status === 'On Duty' ? 'selected' : '' }}>On Duty</option>
              <option value="Break" {{ $u->work_status === 'Break' ? 'selected' : '' }}>Break</option>
              <option value="Off" {{ $u->work_status === 'Off' ? 'selected' : '' }}>Off</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Password Baru (Kosongkan jika tidak diubah):</label>
            <input type="password" name="password" class="form-control bg-secondary text-white border-0" placeholder="••••••••">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">PIN Keamanan Admin (Kosongkan jika tidak diubah):</label>
            <input type="password" name="security_pin" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" class="form-control bg-secondary text-white border-0" placeholder="6 digit angka baru">
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning fw-bold">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- 3. MODAL ADD SERVICE -->
<div class="modal fade" id="addServiceModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-warning"><i class="bi bi-scissors me-2"></i>Tambah Layanan Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.services.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Nama Layanan:</label>
            <input type="text" name="name" class="form-control bg-secondary text-white border-0" required placeholder="Contoh: Premium Down Perm">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Kategori:</label>
            <input type="text" name="category" class="form-control bg-secondary text-white border-0" value="Haircut" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Harga (Rp):</label>
            <input type="number" name="price" class="form-control bg-secondary text-white border-0" required placeholder="150000">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Estimasi Durasi (Menit):</label>
            <input type="number" name="duration_minutes" class="form-control bg-secondary text-white border-0" value="45" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Deskripsi Layanan:</label>
            <textarea name="description" class="form-control bg-secondary text-white border-0" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning fw-bold">Simpan Layanan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- EDIT SERVICE MODALS -->
@foreach($services as $s)
<div class="modal fade" id="editServiceModal{{ $s->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-warning"><i class="bi bi-pencil-square me-2"></i>Edit Layanan #{{ $s->id }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.services.update', $s->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Nama Layanan:</label>
            <input type="text" name="name" class="form-control bg-secondary text-white border-0" value="{{ $s->name }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Kategori:</label>
            <input type="text" name="category" class="form-control bg-secondary text-white border-0" value="{{ $s->category }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Harga (Rp):</label>
            <input type="number" name="price" class="form-control bg-secondary text-white border-0" value="{{ (int)$s->price }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Estimasi Durasi (Menit):</label>
            <input type="number" name="duration_minutes" class="form-control bg-secondary text-white border-0" value="{{ $s->duration_minutes }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Deskripsi Layanan:</label>
            <textarea name="description" class="form-control bg-secondary text-white border-0" rows="2">{{ $s->description }}</textarea>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning fw-bold">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- 4. MODAL ADD PRODUCT -->
<div class="modal fade" id="addProductModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-info"><i class="bi bi-box-seam me-2"></i>Tambah Produk Retail</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Nama Produk:</label>
            <input type="text" name="name" class="form-control bg-secondary text-white border-0" required placeholder="Contoh: Matte Clay Wax">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Kategori:</label>
            <input type="text" name="category" class="form-control bg-secondary text-white border-0" value="Pomade" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Harga Jual (Rp):</label>
            <input type="number" name="price" class="form-control bg-secondary text-white border-0" required placeholder="120000">
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label font-monospace" style="font-size: 0.78rem;">Stok Awal:</label>
              <input type="number" name="stock" class="form-control bg-secondary text-white border-0" value="10" required>
            </div>
            <div class="col-6">
              <label class="form-label font-monospace" style="font-size: 0.78rem;">Min Alert Threshold:</label>
              <input type="number" name="min_stock" class="form-control bg-secondary text-white border-0" value="3" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Deskripsi Produk:</label>
            <textarea name="description" class="form-control bg-secondary text-white border-0" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-info text-dark fw-bold">Simpan Produk</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- EDIT & RESTOCK PRODUCT MODALS -->
@foreach($products as $p)
<!-- EDIT PRODUCT MODAL -->
<div class="modal fade" id="editProductModal{{ $p->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-info"><i class="bi bi-pencil-square me-2"></i>Edit Produk #{{ $p->id }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.products.update', $p->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Nama Produk:</label>
            <input type="text" name="name" class="form-control bg-secondary text-white border-0" value="{{ $p->name }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Kategori:</label>
            <input type="text" name="category" class="form-control bg-secondary text-white border-0" value="{{ $p->category }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Harga Jual (Rp):</label>
            <input type="number" name="price" class="form-control bg-secondary text-white border-0" value="{{ (int)$p->price }}" required>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label font-monospace" style="font-size: 0.78rem;">Jumlah Stok:</label>
              <input type="number" name="stock" class="form-control bg-secondary text-white border-0" value="{{ $p->stock }}" required>
            </div>
            <div class="col-6">
              <label class="form-label font-monospace" style="font-size: 0.78rem;">Min Alert Threshold:</label>
              <input type="number" name="min_stock" class="form-control bg-secondary text-white border-0" value="{{ $p->min_stock }}" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Deskripsi Produk:</label>
            <textarea name="description" class="form-control bg-secondary text-white border-0" rows="2">{{ $p->description }}</textarea>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-info text-dark fw-bold">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- RESTOCK PRODUCT MODAL -->
<div class="modal fade" id="restockModal{{ $p->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-success"><i class="bi bi-box-arrow-in-down me-2"></i>Quick Restock: {{ $p->name }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.products.stock', $p->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <p style="font-size: 0.85rem; color: #a1a1aa;" class="mb-3">
            Stok saat ini: <strong class="text-white">{{ $p->stock }} pcs</strong>
          </p>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Tambah Jumlah Stok (Pcs):</label>
            <input type="number" name="add_stock" class="form-control bg-secondary text-white border-0" value="10" min="1" required>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-success fw-bold">Tambah Stok</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- 5. MODAL ADD VOUCHER -->
<div class="modal fade" id="addVoucherModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-success"><i class="bi bi-ticket-perforated me-2"></i>Terbitkan Voucher Promo</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.vouchers.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Kode Voucher (Kapital):</label>
            <input type="text" name="code" class="form-control bg-secondary text-white border-0 text-uppercase" placeholder="Misal: DISTRICT20" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Tipe Diskon:</label>
            <select name="type" class="form-select bg-secondary text-white border-0" required>
              <option value="percent">Persentase (%)</option>
              <option value="fixed">Nominal Tetap (Rp)</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Nilai Diskon:</label>
            <input type="number" name="discount_value" class="form-control bg-secondary text-white border-0" placeholder="20 atau 25000" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Minimal Spend (Rp):</label>
            <input type="number" name="min_spend" class="form-control bg-secondary text-white border-0" value="0">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Berlaku Sampai Tanggal (Opsional):</label>
            <input type="date" name="valid_until" class="form-control bg-secondary text-white border-0">
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-success fw-bold">Terbitkan Voucher</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- EDIT VOUCHER MODALS -->
@foreach($vouchers as $v)
<div class="modal fade" id="editVoucherModal{{ $v->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-success"><i class="bi bi-pencil-square me-2"></i>Edit Voucher #{{ $v->code }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.vouchers.update', $v->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Kode Voucher (Kapital):</label>
            <input type="text" name="code" class="form-control bg-secondary text-white border-0 text-uppercase" value="{{ $v->code }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Tipe Diskon:</label>
            <select name="type" class="form-select bg-secondary text-white border-0" required>
              <option value="percent" {{ $v->type === 'percent' ? 'selected' : '' }}>Persentase (%)</option>
              <option value="fixed" {{ $v->type === 'fixed' ? 'selected' : '' }}>Nominal Tetap (Rp)</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Nilai Diskon:</label>
            <input type="number" name="discount_value" class="form-control bg-secondary text-white border-0" value="{{ (int)$v->discount_value }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Minimal Spend (Rp):</label>
            <input type="number" name="min_spend" class="form-control bg-secondary text-white border-0" value="{{ (int)$v->min_spend }}">
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Berlaku Sampai Tanggal:</label>
            <input type="date" name="valid_until" class="form-control bg-secondary text-white border-0" value="{{ $v->valid_until }}">
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-success fw-bold">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- 6. MODAL MANAJEMEN BOOKING ADMIN -->
@foreach($bookings as $booking)
<div class="modal fade" id="adminBookingModal{{ $booking->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-warning"><i class="bi bi-sliders me-2"></i>Kelola Reservasi #{{ $booking->queue_number ?? $booking->id }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('bookings.update', $booking) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3 border-bottom border-secondary pb-3">
            <p style="font-size: 0.85rem; margin: 0; color: #a1a1aa;">Pelanggan: <strong class="text-white">{{ $booking->user->name }}</strong></p>
            <p style="font-size: 0.85rem; margin: 2px 0 0; color: #a1a1aa;">Layanan: <strong class="text-warning">{{ $booking->service }}</strong></p>
            <p style="font-size: 0.85rem; margin: 2px 0 0; color: #a1a1aa;">Waktu: <strong class="text-white">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }} - {{ $booking->booking_time }}</strong></p>
          </div>

          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Status Reservasi:</label>
            <select name="status" class="form-select bg-secondary text-white border-0">
              <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu Konfirmasi</option>
              <option value="approved" {{ $booking->status === 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
              <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>🏆 Selesai</option>
              <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Tetapkan Hair Artist / Barber:</label>
            <select name="stylist_id" class="form-select bg-secondary text-white border-0">
              <option value="">-- Belum Ditetapkan --</option>
              @foreach($stylists as $stylist)
                <option value="{{ $stylist->id }}" {{ $booking->stylist_id === $stylist->id ? 'selected' : '' }}>
                  {{ $stylist->name }} ({{ $stylist->work_status ?? 'Available' }})
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning fw-bold">Simpan Status</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- 7. MODAL ADD / UPDATE SHIFT STAF -->
<div class="modal fade" id="addShiftModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-primary"><i class="bi bi-calendar-plus me-2"></i>Penjadwalan Shift Kerja Staf</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.shifts.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Pilih Staf / Barber:</label>
            <select name="user_id" class="form-select bg-secondary text-white border-0" required>
              @foreach($staffMembers as $sm)
                <option value="{{ $sm->id }}">{{ $sm->name }} ({{ strtoupper($sm->role) }})</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Tanggal Shift:</label>
            <input type="date" name="shift_date" class="form-control bg-secondary text-white border-0" value="{{ date('Y-m-d') }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Tipe Shift:</label>
            <select name="shift_type" class="form-select bg-secondary text-white border-0" required>
              <option value="Pagi">Shift Pagi (10:00 - 16:00)</option>
              <option value="Siang">Shift Siang (14:00 - 21:00)</option>
              <option value="Full">Full Day Shift (10:00 - 21:00)</option>
              <option value="Off">Off / Libur</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Catatan Khusus:</label>
            <input type="text" name="notes" class="form-control bg-secondary text-white border-0" placeholder="Contoh: Cover shift Kebayoran">
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-primary fw-bold">Simpan Shift</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- 8. MODALS RESOLVE COMPLAINT -->
@foreach($complaints as $c)
<div class="modal fade" id="resolveComplaintModal{{ $c->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-warning"><i class="bi bi-chat-right-check me-2"></i>Tindak Lanjut Komplain #{{ $c->id }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.complaint.resolve', $c->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3 border-bottom border-secondary pb-2">
            <p style="font-size: 0.85rem; margin: 0; color: #a1a1aa;">Pelanggan: <strong class="text-white">{{ $c->customer_name }}</strong></p>
            <p style="font-size: 0.85rem; margin: 2px 0 0; color: #a1a1aa;">Pesan Keluhan: <span class="text-warning">"{{ $c->message }}"</span></p>
          </div>

          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Status Penanganan:</label>
            <select name="status" class="form-select bg-secondary text-white border-0" required>
              <option value="pending" {{ $c->status === 'pending' ? 'selected' : '' }}>PENDING</option>
              <option value="in_progress" {{ $c->status === 'in_progress' ? 'selected' : '' }}>DIPROSES</option>
              <option value="resolved" {{ $c->status === 'resolved' ? 'selected' : '' }}>TERSELESAIKAN</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label font-monospace" style="font-size: 0.78rem;">Catatan Resolusi / Tindakan:</label>
            <textarea name="resolution" class="form-control bg-secondary text-white border-0" rows="3" required placeholder="Jelaskan solusi atau permohonan maaf yang diberikan...">{{ $c->resolution }}</textarea>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning fw-bold">Simpan Resolusi</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@endsection
