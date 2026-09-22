@extends('admin_layout.app')

@section('title', 'Receptionist & Queue Live Workstation - District Studio')

@section('content')
<main class="main" style="padding-top: 80px; min-height: 100vh; background-color: #09090b;">

  <!-- Receptionist Header Banner -->
  <section style="background: linear-gradient(135deg, #092026 0%, #061217 100%); border-bottom: 1px solid rgba(0,200,200,0.25); padding: 35px 0;">
    <div class="container-fluid container-xl">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <span style="background: rgba(0,200,200,0.15); color: #00c8c8; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; padding: 5px 14px; border: 1px solid rgba(0,200,200,0.3); border-radius: 4px; font-family: 'Montserrat', sans-serif;">
            <i class="bi bi-person-workspace me-1"></i> Front Desk & Live Queue Monitor
          </span>
          <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.9rem; font-weight: 900; color: #fff; text-transform: uppercase; margin-top: 10px; margin-bottom: 0;">
            Receptionist Workstation <span style="color: #00c8c8;">.</span>
          </h2>
          <p style="font-size: 0.85rem; color: #a1a1aa; margin: 4px 0 0;">Monitoring live queue board, notifikasi panggil pelanggan, registrasi walk-in, & status potong rambut.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
          <a href="{{ route('queue.board') }}" target="_blank" class="btn btn-info btn-sm fw-bold text-dark px-3 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px;">
            <i class="bi bi-tv-fill me-1"></i> Layar TV Queue Board (Ruang Tunggu)
          </a>
          <button class="btn btn-warning btn-sm fw-bold text-dark px-3 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px;" data-bs-toggle="modal" data-bs-target="#walkinModal">
            <i class="bi bi-person-plus-fill me-1"></i> + Input Walk-In Pelanggan
          </button>
        </div>
      </div>
    </div>
  </section>

  <div class="container-fluid container-xl" style="padding: 35px 15px 60px;">

    @if(session('success'))
      <div class="alert alert-dismissible fade show d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2" role="alert" style="background: rgba(0,200,200,0.15); border: 1px solid rgba(0,200,200,0.4); color: #fff; border-radius: 8px; padding: 16px 20px;">
        <div class="d-flex align-items-center">
          <i class="bi bi-check-circle-fill me-2" style="color: #00c8c8;"></i>
          <div>{{ session('success') }}</div>
        </div>
        <div class="d-flex align-items-center gap-2">
          @if(session('wa_url'))
            <a href="{{ session('wa_url') }}" target="_blank" class="btn btn-sm btn-success fw-bold px-3">
              <i class="bi bi-whatsapp me-1"></i> Kirim No. Antrean ke WhatsApp
            </a>
          @endif
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-dismissible fade show d-flex align-items-center justify-content-between mb-4" role="alert" style="background: rgba(220,53,69,0.15); border: 1px solid rgba(220,53,69,0.4); color: #fff; border-radius: 8px; padding: 16px 20px;">
        <div><i class="bi bi-exclamation-triangle-fill me-2" style="color: #dc3545;"></i> {{ $errors->first() }}</div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- LIVE QUEUE MONITOR SUMMARY CARDS -->
    @php
      $inProgressNow = $todayQueue->where('status', 'in_progress');
      $arrivedWaiting = $todayQueue->whereNotNull('arrived_at')->where('status', '!=', 'completed')->where('status', '!=', 'in_progress');
      $completedToday = $todayQueue->where('status', 'completed');
    @endphp

    <div class="row g-3 mb-4">
      
      <!-- SEDANG DIPOTONG NOW -->
      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(0,200,200,0.4); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Sedang Di Kursi Cukur</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(0,200,200,0.12); color: #00c8c8; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-scissors"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #00c8c8; margin: 0; font-family: 'Montserrat', sans-serif;">
            {{ $inProgressNow->count() }} Sesi Active
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">
            Pelanggan sedang dalam proses cukur
          </span>
        </div>
      </div>

      <!-- HADIR / SIAP DIPANGGIL -->
      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(40,167,69,0.4); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Hadir & Siap Dipanggil</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(40,167,69,0.12); color: #28a745; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-person-check-fill"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #28a745; margin: 0; font-family: 'Montserrat', sans-serif;">
            {{ $arrivedWaiting->count() }} Orang
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">
            Telah check-in di front desk
          </span>
        </div>
      </div>

      <!-- MENUNGGU TIBA -->
      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(255,193,7,0.4); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Menunggu Tiba</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(255,193,7,0.12); color: #ffc107; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-hourglass-split"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #ffc107; margin: 0; font-family: 'Montserrat', sans-serif;">
            {{ $pendingBookings->count() }} Booking
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">Booking online belum check-in</span>
        </div>
      </div>

      <!-- SELESAI TODAY -->
      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(220,165,62,0.4); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Selesai Dipotong</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(220,165,62,0.12); color: #dca53e; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-check-all"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #dca53e; margin: 0; font-family: 'Montserrat', sans-serif;">
            {{ $completedToday->count() }} Sesi
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">Siap checkout di kasir</span>
        </div>
      </div>

    </div>

    <!-- LIVE BOARD PREVIEW & MONITORING WIDGET -->
    <div style="background: linear-gradient(135deg, #091c20 0%, #061114 100%); border: 1px solid rgba(0,200,200,0.3); border-radius: 12px; padding: 25px;" class="mb-4 shadow-lg">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-broadcast text-info" style="font-size: 1.4rem;"></i>
          <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0;">
            Live Queue Monitor - Tampilan Layar Ruang Tunggu (TV Screen)
          </h4>
        </div>
        <a href="{{ route('queue.board') }}" target="_blank" class="btn btn-sm btn-info text-dark fw-bold px-3">
          <i class="bi bi-box-arrow-up-right me-1"></i> Buka Layar Penuh TV
        </a>
      </div>

      <div class="row g-3">
        @if($inProgressNow->count() > 0)
          @foreach($inProgressNow as $curr)
            <div class="col-12 col-md-6">
              <div style="background: rgba(0,200,200,0.1); border: 1px solid #00c8c8; border-radius: 8px; padding: 15px;" class="d-flex align-items-center justify-content-between">
                <div>
                  <span class="badge bg-info text-dark font-monospace fw-bold mb-1">DIPANGGIL / SEDANG DIPOTONG</span>
                  <h3 style="font-family: 'Montserrat', sans-serif; font-weight: 900; color: #00c8c8; margin: 0;" class="font-monospace">
                    {{ $curr->queue_number ?? '#'.$curr->id }}
                  </h3>
                  <div style="font-size: 0.82rem; color: #fff; margin-top: 3px;">
                    <strong>{{ $curr->user->name }}</strong> ({{ $curr->service }})
                  </div>
                  <small class="text-white-50">Kapster: {{ $curr->stylist ? $curr->stylist->name : 'Staff' }}</small>
                </div>
                <div class="spinner-grow text-info" role="status" style="width: 2rem; height: 2rem;"></div>
              </div>
            </div>
          @endforeach
        @else
          <div class="col-12">
            <div style="background: rgba(255,255,255,0.03); border: 1px dashed rgba(255,255,255,0.1); border-radius: 8px; padding: 15px;" class="text-center text-muted">
              <i class="bi bi-person-workspace me-1"></i> Belum ada antrean yang sedang dipotong saat ini.
            </div>
          </div>
        @endif
      </div>
    </div>

    <!-- ANTREAN HARI INI TABLE -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; border-left: 3px solid #00c8c8; padding-left: 12px; margin: 0;">
          Kelola Antrean & Status Kedatangan Hari Ini ({{ date('d M Y') }})
        </h3>
      </div>

      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
          <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; color: #a1a1aa;">
            <tr>
              <th>No. Antrean</th>
              <th>Nama Pelanggan</th>
              <th>Tipe</th>
              <th>Cabang & Layanan</th>
              <th>Waktu Slot</th>
              <th>Status Alur</th>
              <th>Kapster</th>
              <th class="text-end">Aksi Resepsionis</th>
            </tr>
          </thead>
          <tbody>
            @foreach($todayQueue as $idx => $b)
              <tr>
                <td><span class="badge bg-warning text-dark font-monospace fw-bold fs-6">{{ $b->queue_number ?? 'A-00' . $b->id }}</span></td>
                <td>
                  <strong class="text-white">{{ $b->user->name }}</strong><br>
                  <small class="text-white-50"><i class="bi bi-telephone me-1"></i>{{ $b->user->phone ?? '-' }}</small>
                </td>
                <td>
                  <span class="badge {{ $b->type === 'walkin' ? 'bg-info text-dark' : 'bg-primary' }} font-monospace">{{ strtoupper($b->type) }}</span>
                </td>
                <td>
                  <span class="text-white fw-semibold">{{ $b->service }}</span><br>
                  <small class="text-white-50">{{ $b->branch }}</small>
                </td>
                <td><strong class="text-warning font-monospace">{{ $b->booking_time }}</strong></td>
                <td>
                  @if($b->status === 'in_progress')
                    <span class="badge bg-info text-dark font-monospace fw-bold"><i class="bi bi-scissors me-1"></i> SEDANG DIPOTONG</span>
                  @elseif($b->status === 'completed')
                    <span class="badge bg-success font-monospace fw-bold"><i class="bi bi-check-all me-1"></i> SELESAI</span>
                  @elseif($b->arrived_at)
                    <span class="badge bg-success font-monospace"><i class="bi bi-geo-alt-fill me-1"></i> HADIR ({{ \Carbon\Carbon::parse($b->arrived_at)->format('H:i') }})</span>
                  @else
                    <span class="badge bg-secondary font-monospace">BELUM TIBA</span>
                  @endif
                </td>
                <td><span class="badge bg-dark border border-secondary">{{ $b->stylist ? $b->stylist->name : 'Auto Assign' }}</span></td>
                <td class="text-end">
                  <div class="btn-group">
                    @if(!$b->arrived_at && $b->status !== 'completed' && $b->status !== 'in_progress')
                      <form action="{{ route('receptionist.arrival', $b->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-info" style="font-size: 0.75rem;">
                          <i class="bi bi-person-check me-1"></i> Check-In Kedatangan
                        </button>
                      </form>
                    @endif

                    @if($b->status !== 'completed' && $b->status !== 'in_progress')
                      <form action="{{ route('bookings.update', $booking->id ?? $b->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="status" value="in_progress">
                        <button type="submit" class="btn btn-sm btn-outline-warning" style="font-size: 0.75rem;" title="Mulai Cukur">
                          <i class="bi bi-scissors me-1"></i> Mulai Cukur
                        </button>
                      </form>
                    @endif

                    @if($b->user && $b->user->phone)
                      @php
                        $phone = preg_replace('/[^0-9]/', '', $b->user->phone);
                        if (str_starts_with($phone, '0')) {
                            $phone = '62' . substr($phone, 1);
                        }
                        $waText = "Halo kak " . $b->user->name . ", nomor antrean Anda *" . ($b->queue_number ?? 'A-00'.$b->id) . "* di District Studio Barbershop (" . $b->branch . ") sudah mendekati giliran! Silakan bersiap-siap menuju kursi pangkas. Terima kasih!";
                        $waLink = "https://wa.me/" . $phone . "?text=" . urlencode($waText);
                      @endphp
                      <a href="{{ $waLink }}" target="_blank" class="btn btn-sm btn-outline-success" style="font-size: 0.75rem;" title="Panggil via WhatsApp">
                        <i class="bi bi-whatsapp me-1"></i> Panggil WA
                      </a>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</main>

<!-- Modal Input Walk-in Customer -->
<div class="modal fade" id="walkinModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-warning"><i class="bi bi-person-plus me-2"></i>Pendaftaran Antrean Walk-In</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('receptionist.walkin') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Nama Pelanggan Walk-In:</label>
            <input type="text" name="customer_name" class="form-control bg-secondary text-white border-0" placeholder="Misal: Budi Santoso" required>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">No. HP WhatsApp (Opsional):</label>
            <input type="text" name="customer_phone" class="form-control bg-secondary text-white border-0" placeholder="0812...">
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Cabang Barbershop:</label>
            <select name="branch" class="form-select bg-secondary text-white border-0" required>
              <option value="Jakarta Slipi">Jakarta Slipi</option>
              <option value="Bandung Citarum">Bandung Citarum</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Layanan Potong Rambut:</label>
            <select name="service" class="form-select bg-secondary text-white border-0" required>
              @foreach($services as $s)
                <option value="{{ $s->name }} (IDR {{ number_format($s->price, 0, ',', '.') }})">{{ $s->name }} - Rp {{ number_format($s->price, 0, ',', '.') }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Jam Slot Dipilih:</label>
            <input type="time" name="booking_time" class="form-control bg-secondary text-white border-0" value="{{ date('H:i') }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Pilih Kapster / Stylist:</label>
            <select name="stylist_id" class="form-select bg-secondary text-white border-0">
              <option value="">-- Auto Assign / Bebas --</option>
              @foreach($stylists as $stylist)
                <option value="{{ $stylist->id }}">{{ $stylist->name }} (Status: {{ $stylist->work_status ?? 'Available' }})</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold">Daftarkan Antrean Walk-In</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
