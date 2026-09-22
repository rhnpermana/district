@extends('admin_layout.app')

@section('title', 'Dashboard - District Studio')

@section('content')
<main class="main" style="padding-top: 80px; min-height: 100vh; background-color: #0b0b0b;">

  <!-- Dashboard Header -->
  <section style="background-color: #121212; border-bottom: 1px solid rgba(255,255,255,0.05); padding: 30px 0;">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: var(--accent-color); font-weight: 700; margin-bottom: 5px;">
            @if(auth()->user()->role === 'owner') Pemilik
            @elseif(auth()->user()->role === 'supervisor') Supervisor
            @elseif(auth()->user()->role === 'admin') Administrator
            @elseif(auth()->user()->role === 'kasir') Kasir
            @elseif(auth()->user()->role === 'receptionist') Resepsionis
            @elseif(auth()->user()->role === 'hair stylist') Hair Artist
            @else Pelanggan
            @endif
          </p>
          <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.6rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0;">
            Halo, {{ auth()->user()->name }}!
          </h2>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
          @csrf
          <button type="submit" style="background: transparent; border: 1px solid rgba(255,255,255,0.15); color: #a0a0a0; padding: 10px 20px; font-family: 'Montserrat', sans-serif; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s;">
            <i class="bi bi-box-arrow-right me-2"></i>Keluar
          </button>
        </form>
      </div>
    </div>
  </section>

  <div class="container" style="padding: 50px 15px;">

    {{-- Alert Messages --}}
    @if(session('success'))
      <div style="background: rgba(220,165,62,0.1); border: 1px solid var(--accent-color); color: #fff; padding: 15px 20px; margin-bottom: 30px; font-size: 0.9rem;">
        <i class="bi bi-check-circle me-2" style="color: var(--accent-color);"></i> {{ session('success') }}
      </div>
    @endif

    {{-- ============================================================ --}}
    {{-- CUSTOMER DASHBOARD --}}
    {{-- ============================================================ --}}
    @if(auth()->user()->role === 'customer')

      <div class="row g-4">
        <!-- Form Booking Baru -->
        <div class="col-lg-5">
          <div style="background-color: #121212; border: 1px solid rgba(255,255,255,0.05); padding: 35px;">
            <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1.15rem; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; border-left: 3px solid var(--accent-color); padding-left: 15px; margin-bottom: 30px;">
              Buat Reservasi Baru
            </h3>

            <form action="{{ route('bookings.store') }}" method="POST">
              @csrf

              <div class="mb-3">
                <label style="font-family: 'Montserrat', sans-serif; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #fff; display: block; margin-bottom: 8px;">Pilih Cabang</label>
                <select name="branch" required style="width: 100%; background: #181818; border: 1px solid rgba(255,255,255,0.07); color: #fff; padding: 12px; font-family: 'Outfit', sans-serif; font-size: 0.9rem; outline: none;">
                  <option value="" disabled selected style="color: #666;">-- Pilih Cabang --</option>
                  <option value="Jakarta Kebayoran Baru" style="color: #fff;">Jakarta Kebayoran Baru</option>
                  <option value="Bandung Citarum" style="color: #fff;">Bandung Citarum</option>
                </select>
              </div>

              <div class="mb-3">
                <label style="font-family: 'Montserrat', sans-serif; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #fff; display: block; margin-bottom: 8px;">Pilih Layanan</label>
                <select name="service" required style="width: 100%; background: #181818; border: 1px solid rgba(255,255,255,0.07); color: #fff; padding: 12px; font-family: 'Outfit', sans-serif; font-size: 0.9rem; outline: none;">
                  <option value="" disabled selected style="color: #666;">-- Pilih Layanan --</option>
                  <option value="Potong Rambut Junior Stylist (IDR 85.000)">Potong Rambut Junior Stylist (IDR 85.000)</option>
                  <option value="Potong Rambut Senior Stylist (IDR 120.000)">Potong Rambut Senior Stylist (IDR 120.000)</option>
                  <option value="Potong & Tata Rambut Art Director (IDR 180.000)">Potong & Tata Rambut Art Director (IDR 180.000)</option>
                  <option value="Premium Down Perm (IDR 250.000)">Premium Down Perm (IDR 250.000)</option>
                  <option value="Volume/Root Lift Perm (IDR 300.000)">Volume/Root Lift Perm (IDR 300.000)</option>
                  <option value="Fashion Hair Coloring (IDR 450.000)">Fashion Hair Coloring (IDR 450.000)</option>
                </select>
              </div>

              <div class="row g-2 mb-3">
                <div class="col-6">
                  <label style="font-family: 'Montserrat', sans-serif; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #fff; display: block; margin-bottom: 8px;">Tanggal</label>
                  <input type="date" name="booking_date" required min="{{ date('Y-m-d') }}"
                    style="width: 100%; background: #181818; border: 1px solid rgba(255,255,255,0.07); color: #fff; padding: 12px; font-family: 'Outfit', sans-serif; font-size: 0.9rem; outline: none; color-scheme: dark;">
                </div>
                <div class="col-6">
                  <label style="font-family: 'Montserrat', sans-serif; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #fff; display: block; margin-bottom: 8px;">Jam</label>
                  <select name="booking_time" required style="width: 100%; background: #181818; border: 1px solid rgba(255,255,255,0.07); color: #fff; padding: 12px; font-family: 'Outfit', sans-serif; font-size: 0.9rem; outline: none;">
                    <option value="" disabled selected>-- Jam --</option>
                    <option value="10:00">10:00</option>
                    <option value="11:30">11:30</option>
                    <option value="13:00">13:00</option>
                    <option value="14:30">14:30</option>
                    <option value="16:00">16:00</option>
                    <option value="17:30">17:30</option>
                    <option value="19:00">19:00</option>
                    <option value="20:00">20:00</option>
                  </select>
                </div>
              </div>

              <button type="submit" style="width: 100%; background-color: var(--accent-color); color: #000; border: none; padding: 14px; font-family: 'Montserrat', sans-serif; font-size: 0.8rem; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; cursor: pointer; transition: all 0.3s; margin-top: 10px;">
                <i class="bi bi-calendar2-plus me-2"></i>Kirim Reservasi
              </button>
            </form>
          </div>
        </div>

        <!-- Riwayat Booking -->
        <div class="col-lg-7">
          <div style="background-color: #121212; border: 1px solid rgba(255,255,255,0.05); padding: 35px;">
            <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1.15rem; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; border-left: 3px solid var(--accent-color); padding-left: 15px; margin-bottom: 30px;">
              Riwayat Reservasi Saya
            </h3>

            @if($bookings->isEmpty())
              <div style="text-align: center; padding: 50px 0; color: #555;">
                <i class="bi bi-calendar-x" style="font-size: 48px; display: block; margin-bottom: 15px;"></i>
                <p>Anda belum memiliki reservasi. Buat reservasi pertama Anda sekarang!</p>
              </div>
            @else
              <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                  <thead>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                      <th style="padding: 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Layanan</th>
                      <th style="padding: 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Cabang</th>
                      <th style="padding: 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Jadwal</th>
                      <th style="padding: 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Stylist</th>
                      <th style="padding: 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($bookings as $booking)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                      <td style="padding: 14px 10px; color: #fff; font-weight: 600; font-size: 0.82rem;">{{ $booking->service }}</td>
                      <td style="padding: 14px 10px; color: #a0a0a0;">{{ $booking->branch }}</td>
                      <td style="padding: 14px 10px; color: #a0a0a0; white-space: nowrap;">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}<br><span style="color: var(--accent-color); font-size: 0.78rem;">{{ $booking->booking_time }}</span></td>
                      <td style="padding: 14px 10px; color: #a0a0a0;">{{ $booking->stylist ? $booking->stylist->name : '-' }}</td>
                      <td style="padding: 14px 10px;">
                        @if($booking->status === 'pending')
                          <span style="background: rgba(255,193,7,0.15); color: #ffc107; padding: 4px 10px; font-size: 0.72rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Menunggu</span>
                        @elseif($booking->status === 'approved')
                          <span style="background: rgba(220,165,62,0.15); color: var(--accent-color); padding: 4px 10px; font-size: 0.72rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Disetujui</span>
                        @elseif($booking->status === 'completed')
                          <span style="background: rgba(40,167,69,0.15); color: #28a745; padding: 4px 10px; font-size: 0.72rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Selesai</span>
                        @elseif($booking->status === 'cancelled')
                          <span style="background: rgba(220,53,69,0.15); color: #dc3545; padding: 4px 10px; font-size: 0.72rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Dibatalkan</span>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>
        </div>
      </div>

    {{-- ============================================================ --}}
    {{-- OWNER / ADMIN / KASIR DASHBOARD --}}
    {{-- ============================================================ --}}
    @elseif(in_array(auth()->user()->role, ['owner', 'supervisor', 'admin', 'kasir']))

      <!-- Summary Stats -->
      <div class="row g-3 mb-4">
        @php
          $total = $bookings->count();
          $pending = $bookings->where('status', 'pending')->count();
          $approved = $bookings->where('status', 'approved')->count();
          $completed = $bookings->where('status', 'completed')->count();
        @endphp
        <div class="col-6 col-md-3">
          <div style="background: #121212; border: 1px solid rgba(255,255,255,0.05); padding: 25px; text-align: center;">
            <h2 style="font-size: 2rem; font-weight: 900; color: #fff; margin: 0;">{{ $total }}</h2>
            <p style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: #666; margin: 5px 0 0;">Total Reservasi</p>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div style="background: #121212; border: 1px solid rgba(255,193,7,0.2); padding: 25px; text-align: center;">
            <h2 style="font-size: 2rem; font-weight: 900; color: #ffc107; margin: 0;">{{ $pending }}</h2>
            <p style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: #666; margin: 5px 0 0;">Menunggu</p>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div style="background: #121212; border: 1px solid rgba(220,165,62,0.2); padding: 25px; text-align: center;">
            <h2 style="font-size: 2rem; font-weight: 900; color: var(--accent-color); margin: 0;">{{ $approved }}</h2>
            <p style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: #666; margin: 5px 0 0;">Disetujui</p>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div style="background: #121212; border: 1px solid rgba(40,167,69,0.2); padding: 25px; text-align: center;">
            <h2 style="font-size: 2rem; font-weight: 900; color: #28a745; margin: 0;">{{ $completed }}</h2>
            <p style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: #666; margin: 5px 0 0;">Selesai</p>
          </div>
        </div>
      </div>

      <!-- Booking Table for Staff -->
      <div style="background-color: #121212; border: 1px solid rgba(255,255,255,0.05); padding: 35px;">
        <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1.15rem; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; border-left: 3px solid var(--accent-color); padding-left: 15px; margin-bottom: 30px;">
          Manajemen Reservasi Masuk
        </h3>

        @if($bookings->isEmpty())
          <div style="text-align: center; padding: 50px; color: #555;">
            <i class="bi bi-inbox" style="font-size: 48px; display: block; margin-bottom: 15px;"></i>
            <p>Belum ada reservasi masuk dari pelanggan.</p>
          </div>
        @else
          <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
              <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.07);">
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">#</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Pelanggan</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Layanan</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Cabang</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Jadwal</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Status</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($bookings as $booking)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);" id="row-{{ $booking->id }}">
                  <td style="padding: 14px 10px; color: #555; font-size: 0.8rem;">{{ $booking->id }}</td>
                  <td style="padding: 14px 10px;">
                    <p style="color: #fff; font-weight: 600; margin: 0; font-size: 0.85rem;">{{ $booking->user->name }}</p>
                    <p style="color: #666; margin: 0; font-size: 0.75rem;">{{ $booking->user->phone ?? '-' }}</p>
                  </td>
                  <td style="padding: 14px 10px; color: #a0a0a0; font-size: 0.82rem; max-width: 160px;">{{ $booking->service }}</td>
                  <td style="padding: 14px 10px; color: #a0a0a0; font-size: 0.82rem; white-space: nowrap;">{{ $booking->branch }}</td>
                  <td style="padding: 14px 10px; color: #a0a0a0; font-size: 0.82rem; white-space: nowrap;">
                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}<br>
                    <span style="color: var(--accent-color); font-size: 0.78rem;">{{ $booking->booking_time }}</span>
                  </td>
                  <td style="padding: 14px 10px;">
                    @if($booking->status === 'pending')
                      <span style="background: rgba(255,193,7,0.15); color: #ffc107; padding: 4px 10px; font-size: 0.68rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Menunggu</span>
                    @elseif($booking->status === 'approved')
                      <span style="background: rgba(220,165,62,0.15); color: var(--accent-color); padding: 4px 10px; font-size: 0.68rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Disetujui</span>
                    @elseif($booking->status === 'completed')
                      <span style="background: rgba(40,167,69,0.15); color: #28a745; padding: 4px 10px; font-size: 0.68rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Selesai</span>
                    @elseif($booking->status === 'cancelled')
                      <span style="background: rgba(220,53,69,0.15); color: #dc3545; padding: 4px 10px; font-size: 0.68rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Dibatalkan</span>
                    @endif
                  </td>
                  <td style="padding: 14px 10px;">
                    <button onclick="document.getElementById('modal-{{ $booking->id }}').style.display='flex'"
                      style="background: transparent; border: 1px solid rgba(220,165,62,0.3); color: var(--accent-color); padding: 6px 14px; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s; white-space: nowrap;">
                      <i class="bi bi-pencil-square me-1"></i>Kelola
                    </button>
                  </td>
                </tr>

                <!-- Inline Modal for Booking #id -->
                <div id="modal-{{ $booking->id }}" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.85); z-index:9999; align-items:center; justify-content:center;">
                  <div style="background:#121212; border:1px solid rgba(255,255,255,0.08); padding:40px; width:480px; max-width:90vw; position:relative;">
                    <button onclick="document.getElementById('modal-{{ $booking->id }}').style.display='none'"
                      style="position:absolute; top:15px; right:15px; background:transparent; border:none; color:#666; font-size:22px; cursor:pointer; line-height:1;">&times;</button>
                    <h4 style="font-family:'Montserrat',sans-serif; font-size:1rem; font-weight:800; color:#fff; text-transform:uppercase; letter-spacing:1px; margin-bottom:5px;">Kelola Reservasi #{{ $booking->id }}</h4>
                    <p style="font-size:0.82rem; color:#666; margin-bottom:25px;">{{ $booking->user->name }} — {{ $booking->service }}</p>

                    <form action="{{ route('bookings.update', $booking) }}" method="POST">
                      @csrf
                      <div class="mb-3">
                        <label style="font-family:'Montserrat',sans-serif; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#fff; display:block; margin-bottom:8px;">Status Reservasi</label>
                        <select name="status" style="width:100%; background:#181818; border:1px solid rgba(255,255,255,0.07); color:#fff; padding:12px; font-family:'Outfit',sans-serif; font-size:0.9rem; outline:none;">
                          <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                          <option value="approved" {{ $booking->status === 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                          <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>🏆 Selesai</option>
                          <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                        </select>
                      </div>
                      <div class="mb-4">
                        <label style="font-family:'Montserrat',sans-serif; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#fff; display:block; margin-bottom:8px;">Tetapkan Hair Artist</label>
                        <select name="stylist_id" style="width:100%; background:#181818; border:1px solid rgba(255,255,255,0.07); color:#fff; padding:12px; font-family:'Outfit',sans-serif; font-size:0.9rem; outline:none;">
                          <option value="">-- Belum ditetapkan --</option>
                          @foreach($stylists as $stylist)
                            <option value="{{ $stylist->id }}" {{ $booking->stylist_id === $stylist->id ? 'selected' : '' }}>
                              {{ $stylist->name }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                      <button type="submit" style="width:100%; background:var(--accent-color); color:#000; border:none; padding:13px; font-family:'Montserrat',sans-serif; font-size:0.8rem; font-weight:800; letter-spacing:2px; text-transform:uppercase; cursor:pointer;">
                        Simpan Perubahan
                      </button>
                    </form>
                  </div>
                </div>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>

    {{-- ============================================================ --}}
    {{-- RECEPTIONIST DASHBOARD --}}
    {{-- ============================================================ --}}
    @elseif(auth()->user()->role === 'receptionist')

      {{-- Info Banner: Receptionist Mode --}}
      <div style="background: linear-gradient(135deg, rgba(220,165,62,0.08), rgba(220,165,62,0.03)); border: 1px solid rgba(220,165,62,0.2); padding: 18px 25px; margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
        <i class="bi bi-calendar2-check" style="font-size: 1.8rem; color: var(--accent-color);"></i>
        <div>
          <p style="font-family: 'Montserrat', sans-serif; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; color: var(--accent-color); margin: 0 0 3px;">Mode Resepsionis</p>
          <p style="font-size: 0.85rem; color: #a0a0a0; margin: 0;">Fokus pada Manajemen Jadwal & Booking Pelanggan. Konfirmasi, reschedule, dan tetapkan Hair Artist untuk setiap reservasi.</p>
        </div>
      </div>

      {{-- Quick Stats: Bookings Only (no financial) --}}
      @php
        $totalRec = $bookings->count();
        $pendingRec = $bookings->where('status', 'pending')->count();
        $approvedRec = $bookings->where('status', 'approved')->count();
        $todayRec = $bookings->where('booking_date', today()->toDateString())->count();
      @endphp
      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
          <div style="background: #121212; border: 1px solid rgba(255,255,255,0.05); padding: 20px; text-align: center;">
            <h2 style="font-size: 1.8rem; font-weight: 900; color: #fff; margin: 0;">{{ $totalRec }}</h2>
            <p style="font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px; color: #666; margin: 5px 0 0;">Total Reservasi</p>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div style="background: #121212; border: 1px solid rgba(255,193,7,0.2); padding: 20px; text-align: center;">
            <h2 style="font-size: 1.8rem; font-weight: 900; color: #ffc107; margin: 0;">{{ $pendingRec }}</h2>
            <p style="font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px; color: #666; margin: 5px 0 0;">Menunggu Konfirmasi</p>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div style="background: #121212; border: 1px solid rgba(220,165,62,0.2); padding: 20px; text-align: center;">
            <h2 style="font-size: 1.8rem; font-weight: 900; color: var(--accent-color); margin: 0;">{{ $approvedRec }}</h2>
            <p style="font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px; color: #666; margin: 5px 0 0;">Sudah Dikonfirmasi</p>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div style="background: #121212; border: 1px solid rgba(100,200,255,0.2); padding: 20px; text-align: center;">
            <h2 style="font-size: 1.8rem; font-weight: 900; color: #64c8ff; margin: 0;">{{ $todayRec }}</h2>
            <p style="font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px; color: #666; margin: 5px 0 0;">Jadwal Hari Ini</p>
          </div>
        </div>
      </div>

      {{-- Booking Table --}}
      <div style="background-color: #121212; border: 1px solid rgba(255,255,255,0.05); padding: 35px;">
        <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1.15rem; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; border-left: 3px solid var(--accent-color); padding-left: 15px; margin-bottom: 30px;">
          Manajemen Jadwal & Booking
        </h3>

        @if($bookings->isEmpty())
          <div style="text-align: center; padding: 50px; color: #555;">
            <i class="bi bi-calendar-x" style="font-size: 48px; display: block; margin-bottom: 15px;"></i>
            <p>Belum ada reservasi masuk dari pelanggan.</p>
          </div>
        @else
          <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
              <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.07);">
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">#</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Pelanggan</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Layanan</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Cabang</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Jadwal</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Status</th>
                  <th style="padding: 12px 10px; text-align: left; color: #666; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($bookings as $booking)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);" id="rec-row-{{ $booking->id }}">
                  <td style="padding: 14px 10px; color: #555; font-size: 0.8rem;">{{ $booking->id }}</td>
                  <td style="padding: 14px 10px;">
                    <p style="color: #fff; font-weight: 600; margin: 0; font-size: 0.85rem;">{{ $booking->user->name }}</p>
                    <p style="color: #666; margin: 0; font-size: 0.75rem;">{{ $booking->user->phone ?? '-' }}</p>
                  </td>
                  <td style="padding: 14px 10px; color: #a0a0a0; font-size: 0.82rem; max-width: 160px;">{{ $booking->service }}</td>
                  <td style="padding: 14px 10px; color: #a0a0a0; font-size: 0.82rem; white-space: nowrap;">{{ $booking->branch }}</td>
                  <td style="padding: 14px 10px; color: #a0a0a0; font-size: 0.82rem; white-space: nowrap;">
                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}<br>
                    <span style="color: var(--accent-color); font-size: 0.78rem;">{{ $booking->booking_time }}</span>
                  </td>
                  <td style="padding: 14px 10px;">
                    @if($booking->status === 'pending')
                      <span style="background: rgba(255,193,7,0.15); color: #ffc107; padding: 4px 10px; font-size: 0.68rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Menunggu</span>
                    @elseif($booking->status === 'approved')
                      <span style="background: rgba(220,165,62,0.15); color: var(--accent-color); padding: 4px 10px; font-size: 0.68rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Disetujui</span>
                    @elseif($booking->status === 'completed')
                      <span style="background: rgba(40,167,69,0.15); color: #28a745; padding: 4px 10px; font-size: 0.68rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Selesai</span>
                    @elseif($booking->status === 'cancelled')
                      <span style="background: rgba(220,53,69,0.15); color: #dc3545; padding: 4px 10px; font-size: 0.68rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">Dibatalkan</span>
                    @endif
                  </td>
                  <td style="padding: 14px 10px;">
                    <button onclick="document.getElementById('rec-modal-{{ $booking->id }}').style.display='flex'"
                      style="background: transparent; border: 1px solid rgba(220,165,62,0.3); color: var(--accent-color); padding: 6px 14px; font-family: 'Montserrat', sans-serif; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s; white-space: nowrap;">
                      <i class="bi bi-calendar2-check me-1"></i>Konfirmasi
                    </button>
                  </td>
                </tr>

                {{-- Modal Receptionist --}}
                <div id="rec-modal-{{ $booking->id }}" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.85); z-index:9999; align-items:center; justify-content:center;">
                  <div style="background:#121212; border:1px solid rgba(255,255,255,0.08); padding:40px; width:480px; max-width:90vw; position:relative;">
                    <button onclick="document.getElementById('rec-modal-{{ $booking->id }}').style.display='none'"
                      style="position:absolute; top:15px; right:15px; background:transparent; border:none; color:#666; font-size:22px; cursor:pointer; line-height:1;">&times;</button>
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:5px;">
                      <i class="bi bi-calendar2-check" style="color:var(--accent-color); font-size:1.2rem;"></i>
                      <h4 style="font-family:'Montserrat',sans-serif; font-size:1rem; font-weight:800; color:#fff; text-transform:uppercase; letter-spacing:1px; margin:0;">Konfirmasi Booking #{{ $booking->id }}</h4>
                    </div>
                    <p style="font-size:0.82rem; color:#666; margin-bottom:25px;">{{ $booking->user->name }} — {{ $booking->service }}</p>

                    <form action="{{ route('bookings.update', $booking) }}" method="POST">
                      @csrf
                      <div class="mb-3">
                        <label style="font-family:'Montserrat',sans-serif; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#fff; display:block; margin-bottom:8px;">Status Reservasi</label>
                        <select name="status" style="width:100%; background:#181818; border:1px solid rgba(255,255,255,0.07); color:#fff; padding:12px; font-family:'Outfit',sans-serif; font-size:0.9rem; outline:none;">
                          <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                          <option value="approved" {{ $booking->status === 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                          <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>🏆 Selesai</option>
                          <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                        </select>
                      </div>
                      <div class="mb-4">
                        <label style="font-family:'Montserrat',sans-serif; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#fff; display:block; margin-bottom:8px;">Tetapkan Hair Artist</label>
                        <select name="stylist_id" style="width:100%; background:#181818; border:1px solid rgba(255,255,255,0.07); color:#fff; padding:12px; font-family:'Outfit',sans-serif; font-size:0.9rem; outline:none;">
                          <option value="">-- Belum ditetapkan --</option>
                          @foreach($stylists as $stylist)
                            <option value="{{ $stylist->id }}" {{ $booking->stylist_id === $stylist->id ? 'selected' : '' }}>
                              {{ $stylist->name }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                      <button type="submit" style="width:100%; background:var(--accent-color); color:#000; border:none; padding:13px; font-family:'Montserrat',sans-serif; font-size:0.8rem; font-weight:800; letter-spacing:2px; text-transform:uppercase; cursor:pointer;">
                        Simpan Konfirmasi
                      </button>
                    </form>
                  </div>
                </div>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>

    {{-- ============================================================ --}}
    {{-- HAIR STYLIST DASHBOARD --}}
    {{-- ============================================================ --}}
    @elseif(auth()->user()->role === 'hair stylist')

      <div style="background-color: #121212; border: 1px solid rgba(255,255,255,0.05); padding: 35px;">
        <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1.15rem; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; border-left: 3px solid var(--accent-color); padding-left: 15px; margin-bottom: 30px;">
          Jadwal Cukur Saya
        </h3>

        @if($bookings->isEmpty())
          <div style="text-align: center; padding: 60px; color: #555;">
            <i class="bi bi-scissors" style="font-size: 48px; display: block; margin-bottom: 15px;"></i>
            <p>Belum ada jadwal yang ditugaskan ke Anda. Resepsionis atau staff akan menetapkan sesi potong rambut untuk Anda.</p>
          </div>
        @else
          <div class="row g-3">
            @foreach($bookings as $booking)
            <div class="col-md-6 col-lg-4">
              <div style="background: #181818; border: 1px solid rgba(255,255,255,0.04); padding: 25px; position: relative; border-top: 3px solid
                @if($booking->status === 'approved') var(--accent-color)
                @elseif($booking->status === 'completed') #28a745
                @elseif($booking->status === 'cancelled') #dc3545
                @else #ffc107
                @endif;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                  <div>
                    <p style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; margin: 0;">{{ $booking->user->name }}</p>
                    <p style="font-size: 0.8rem; color: #666; margin: 3px 0 0;">{{ $booking->user->phone ?? '-' }}</p>
                  </div>
                  @if($booking->status === 'pending')
                    <span style="background: rgba(255,193,7,0.15); color: #ffc107; padding: 4px 10px; font-size: 0.65rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase;">Menunggu</span>
                  @elseif($booking->status === 'approved')
                    <span style="background: rgba(220,165,62,0.15); color: var(--accent-color); padding: 4px 10px; font-size: 0.65rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase;">Disetujui</span>
                  @elseif($booking->status === 'completed')
                    <span style="background: rgba(40,167,69,0.15); color: #28a745; padding: 4px 10px; font-size: 0.65rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase;">Selesai</span>
                  @else
                    <span style="background: rgba(220,53,69,0.15); color: #dc3545; padding: 4px 10px; font-size: 0.65rem; font-weight: 700; font-family: 'Montserrat', sans-serif; text-transform: uppercase;">Dibatalkan</span>
                  @endif
                </div>
                <p style="font-size: 0.82rem; color: #a0a0a0; margin-bottom: 12px; border-left: 2px solid var(--accent-color); padding-left: 10px;">{{ $booking->service }}</p>
                <div style="display: flex; gap: 15px; font-size: 0.78rem; color: #666;">
                  <span><i class="bi bi-geo-alt me-1" style="color: var(--accent-color);"></i>{{ $booking->branch }}</span>
                </div>
                <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.04); font-size: 0.82rem; font-weight: 700; color: #fff; font-family: 'Montserrat', sans-serif;">
                  <i class="bi bi-calendar2 me-2" style="color: var(--accent-color);"></i>
                  {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                  &nbsp;&bull;&nbsp;
                  <span style="color: var(--accent-color);">{{ $booking->booking_time }}</span>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        @endif
      </div>

    @endif

  </div>
</main>
@endsection
