@extends('admin_layout.app')

@section('title', 'Hair Stylist Workstation - District Studio')

@section('content')
<main class="main" style="padding-top: 80px; min-height: 100vh; background-color: #09090b;">

  <!-- Hair Stylist Header Banner -->
  <section style="background: linear-gradient(135deg, #22160d 0%, #120b06 100%); border-bottom: 1px solid rgba(255,152,0,0.25); padding: 35px 0;">
    <div class="container-fluid container-xl">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <span style="background: rgba(255,152,0,0.15); color: #ff9800; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; padding: 5px 14px; border: 1px solid rgba(255,152,0,0.3); border-radius: 4px; font-family: 'Montserrat', sans-serif;">
            <i class="bi bi-scissors me-1"></i> Hair Artist Workstation
          </span>
          <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.9rem; font-weight: 900; color: #fff; text-transform: uppercase; margin-top: 10px; margin-bottom: 0;">
            Station {{ auth()->user()->name }} <span style="color: #ff9800;">.</span>
          </h2>
          <p style="font-size: 0.85rem; color: #a1a1aa; margin: 4px 0 0;">Kelola status kerja, jadwal cukur hari ini, komisi harian/bulanan, portofolio karya, dan catatan pelanggan.</p>
        </div>

        <div class="d-flex align-items-center gap-2">
          <!-- WORK STATUS TOGGLE WIDGET -->
          <form action="{{ route('stylist.work_status') }}" method="POST" class="d-flex align-items-center gap-1 bg-dark p-2 border border-secondary border-opacity-25 rounded-3">
            @csrf
            <span style="font-size: 0.7rem; color: #a1a1aa; text-transform: uppercase; font-family: 'Montserrat', sans-serif; font-weight: 800; padding: 0 6px;">Status Saya:</span>
            <button type="submit" name="work_status" value="Available" class="btn btn-sm {{ auth()->user()->work_status === 'Available' ? 'btn-success fw-bold' : 'btn-outline-secondary' }}" style="font-size: 0.72rem;">Available</button>
            <button type="submit" name="work_status" value="On Duty" class="btn btn-sm {{ auth()->user()->work_status === 'On Duty' ? 'btn-warning text-dark fw-bold' : 'btn-outline-secondary' }}" style="font-size: 0.72rem;">On Duty</button>
            <button type="submit" name="work_status" value="Break" class="btn btn-sm {{ auth()->user()->work_status === 'Break' ? 'btn-danger fw-bold' : 'btn-outline-secondary' }}" style="font-size: 0.72rem;">Break</button>
            <button type="submit" name="work_status" value="Off" class="btn btn-sm {{ auth()->user()->work_status === 'Off' ? 'btn-dark text-white-50 fw-bold' : 'btn-outline-secondary' }}" style="font-size: 0.72rem;">Off</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <div class="container-fluid container-xl" style="padding: 35px 15px 60px;">

    @if(session('success'))
      <div class="alert alert-dismissible fade show d-flex align-items-center justify-content-between mb-4" role="alert" style="background: rgba(255,152,0,0.15); border: 1px solid rgba(255,152,0,0.4); color: #fff; border-radius: 8px; padding: 16px 20px;">
        <div><i class="bi bi-check-circle-fill me-2" style="color: #ff9800;"></i> {{ session('success') }}</div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- PERFORMANCE METRICS SUMMARY -->
    <div class="row g-3 mb-4">
      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(255,152,0,0.3); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Antrean Sesi Hari Ini</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(255,152,0,0.12); color: #ff9800; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-scissors"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #fff; margin: 0; font-family: 'Montserrat', sans-serif;">
            {{ $todaySchedule->count() }} Sesi
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">
            {{ $todaySchedule->where('status', 'completed')->count() }} sesi selesai dipotong
          </span>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(40,167,69,0.3); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Komisi Hari Ini ({{ auth()->user()->commission_rate ?? 30 }}%)</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(40,167,69,0.12); color: #28a745; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-cash-coin"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #28a745; margin: 0; font-family: 'Montserrat', sans-serif;">
            Rp {{ number_format($dailyCommission, 0, ',', '.') }}
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">Perolehan bersih komisi hari ini</span>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(0,200,200,0.3); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Estimasi Komisi Bulan Ini</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(0,200,200,0.12); color: #00c8c8; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-wallet-fill"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #00c8c8; margin: 0; font-family: 'Montserrat', sans-serif;">
            Rp {{ number_format($monthlyCommission, 0, ',', '.') }}
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">Total akumulasi komisi bulan ini</span>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(255,193,7,0.3); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Rating & Kepuasan</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(255,193,7,0.12); color: #ffc107; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-star-fill"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #ffc107; margin: 0; font-family: 'Montserrat', sans-serif;">
            ⭐ {{ number_format($avgRating, 1) }} <span style="font-size: 0.9rem; color: #71717a;">/ 5.0</span>
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">Dari {{ $reviews->count() }} ulasan pelanggan</span>
        </div>
      </div>
    </div>

    <!-- ANTREAN POTONG RAMBUT HARI INI -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;" class="mb-4">
      <h3 style="font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; border-left: 3px solid #ff9800; padding-left: 12px;" class="mb-4">
        Jadwal & Antrean Cukur Hari Ini ({{ date('d M Y') }})
      </h3>

      @if($todaySchedule->isEmpty())
        <div class="text-center py-5 text-muted">
          <i class="bi bi-scissors" style="font-size: 40px; display: block; margin-bottom: 8px; color: #ff9800;"></i>
          <p class="mb-0">Belum ada antrean cukur yang ditugaskan kepada Anda hari ini.</p>
        </div>
      @else
        <div class="row g-3">
          @foreach($todaySchedule as $booking)
            <div class="col-12 col-md-6 col-xl-4">
              <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 22px; border-top: 4px solid @if($booking->status === 'completed') #28a745 @elseif($booking->status === 'in_progress') #00c8c8 @else #ff9800 @endif;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="badge bg-warning text-dark font-monospace fw-bold fs-6">{{ $booking->queue_number ?? 'A-00' . $booking->id }}</span>
                  <span class="badge font-monospace fw-bold" style="
                    @if($booking->status === 'in_progress') background: #00c8c8; color: #000;
                    @elseif($booking->status === 'completed') background: #28a745; color: #fff;
                    @else background: rgba(255,152,0,0.15); color: #ff9800; border: 1px solid rgba(255,152,0,0.3); @endif">
                    @if($booking->status === 'in_progress')
                      <i class="bi bi-scissors me-1"></i> SEDANG DI CUKUR
                    @else
                      {{ strtoupper($booking->status) }}
                    @endif
                  </span>
                </div>
                <h5 style="font-weight: 800; color: #fff; margin: 8px 0 2px; font-size: 1.05rem;">{{ $booking->user->name }}</h5>
                <p style="font-size: 0.82rem; color: #ff9800; margin-bottom: 12px; font-weight: 600;">{{ $booking->service }}</p>
                <div style="font-size: 0.78rem; color: #a1a1aa;" class="mb-3">
                  <div><i class="bi bi-clock me-1" style="color: #ff9800;"></i> Jam Slot: <strong>{{ $booking->booking_time }} WIB</strong></div>
                  <div><i class="bi bi-geo-alt me-1" style="color: #ff9800;"></i> Cabang: <strong>{{ $booking->branch }}</strong></div>
                </div>

                @if($booking->status === 'completed')
                  <div class="badge bg-success w-100 py-2 font-monospace" style="font-size: 0.8rem;"><i class="bi bi-check-all me-1"></i> SESI CUKUR SELESAI</div>
                @elseif($booking->status === 'in_progress')
                  <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="btn btn-success fw-bold w-100 py-2" style="font-size: 0.78rem; font-family: 'Montserrat', sans-serif; text-transform: uppercase;">
                      <i class="bi bi-check-circle-fill me-1"></i> Tandai Selesai Dipotong
                    </button>
                  </form>
                @else
                  <div class="d-flex gap-2">
                    <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="w-50">
                      @csrf
                      <input type="hidden" name="status" value="in_progress">
                      <button type="submit" class="btn btn-info text-dark fw-bold w-100 py-2" style="font-size: 0.73rem; font-family: 'Montserrat', sans-serif; text-transform: uppercase;">
                        <i class="bi bi-scissors me-1"></i> Sedang Cukur
                      </button>
                    </form>
                    <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="w-50">
                      @csrf
                      <input type="hidden" name="status" value="completed">
                      <button type="submit" class="btn btn-success fw-bold w-100 py-2" style="font-size: 0.73rem; font-family: 'Montserrat', sans-serif; text-transform: uppercase;">
                        <i class="bi bi-check-lg me-1"></i> Selesai
                      </button>
                    </form>
                  </div>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>

    <!-- 2 COLUMNS: PORTOFOLIO & CATATAN PREFERENSI PELANGGAN -->
    <div class="row g-4">
      
      <!-- PORTOFOLIO HAPUS & UPLOAD -->
      <div class="col-12 col-lg-6">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; margin: 0; border-left: 3px solid #ff9800; padding-left: 12px;">
              <i class="bi bi-camera-fill me-2" style="color: #ff9800;"></i> Portofolio Karya Hasil Potongan
            </h4>
            <button class="btn btn-sm btn-warning text-dark fw-bold" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#uploadPortfolioModal">
              + Unggah Foto Karya
            </button>
          </div>

          @if($portfolios->isEmpty())
            <p style="font-size: 0.85rem; color: #71717a;">Belum ada foto portofolio. Unggah hasil potongan terbaik Anda untuk dilihat oleh calon pelanggan saat booking.</p>
          @else
            <div class="row g-3">
              @foreach($portfolios as $p)
                <div class="col-6">
                  <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.06); padding: 12px; border-radius: 8px;">
                    <img src="{{ asset($p->image_path) }}" style="width: 100%; height: 120px; object-fit: cover; border-radius: 6px;" alt="{{ $p->title }}"
                         onerror="this.src='https://ui-avatars.com/api/?name=Barber+Style&background=ff9800&color=fff&size=200'">
                    <div style="font-weight: 700; font-size: 0.82rem; color: #fff; margin-top: 8px;">{{ $p->title }}</div>
                    <div style="font-size: 0.72rem; color: #a1a1aa;">{{ Str::limit($p->description, 40) }}</div>
                    <form action="{{ route('stylist.portfolio.delete', $p->id) }}" method="POST" class="mt-2 text-end">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-link text-danger p-0" style="font-size: 0.72rem;" onclick="return confirm('Hapus foto ini dari portofolio Anda?')"><i class="bi bi-trash me-1"></i>Hapus</button>
                    </form>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>

      <!-- CATATAN PREFERENSI PELANGGAN (CLIENT NOTES) -->
      <div class="col-12 col-lg-6">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;" class="h-100">
          <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #00c8c8; padding-left: 12px;" class="mb-3">
            <i class="bi bi-journal-text me-2" style="color: #00c8c8;"></i> Catatan Preferensi Pelanggan Langganan
          </h4>

          <form action="{{ route('stylist.client_notes') }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-2">
              <label style="font-size: 0.75rem; color: #a1a1aa;">Pilih Pelanggan:</label>
              <select name="customer_id" class="form-select form-select-sm bg-dark text-white border-secondary" required>
                <option value="">-- Pilih Pelanggan --</option>
                @foreach($clients as $client)
                  <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->phone ?? $client->email }})</option>
                @endforeach
              </select>
            </div>
            <div class="mb-2">
              <label style="font-size: 0.75rem; color: #a1a1aa;">Catatan Preferensi Gaya Potong Rambut:</label>
              <textarea name="notes" class="form-control form-control-sm bg-dark text-white border-secondary" rows="2" placeholder="Misal: Samping fade 1mm, bagian atas potong tipis, tipe rambut kaku..." required></textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-info text-dark fw-bold w-100" style="font-size: 0.75rem;">Simpan Catatan Pelanggan</button>
          </form>

          <h6 style="font-size: 0.75rem; color: #ff9800; text-transform: uppercase; font-weight: 700;">Daftar Catatan Langganan:</h6>
          <div style="max-height: 200px; overflow-y: auto;">
            @foreach($clientNotes as $note)
              <div style="background: #18181b; padding: 10px 12px; border-left: 3px solid #00c8c8; border-radius: 4px; margin-bottom: 8px;">
                <div style="font-weight: 700; font-size: 0.82rem; color: #fff;">{{ $note->customer ? $note->customer->name : 'Pelanggan' }}</div>
                <div style="font-size: 0.75rem; color: #a1a1aa; font-style: italic;">"{{ $note->notes }}"</div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

    </div>

  </div>
</main>

<!-- MODAL UNGGAH PORTOFOLIO -->
<div class="modal fade" id="uploadPortfolioModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-warning"><i class="bi bi-camera me-2"></i>Unggah Foto Hasil Potongan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('stylist.portfolio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Judul Model Potongan:</label>
            <input type="text" name="title" class="form-control bg-secondary text-white border-0" placeholder="Misal: Low Fade Sidepart" required>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Deskripsi / Teknik Cukur:</label>
            <textarea name="description" class="form-control bg-secondary text-white border-0" rows="2" placeholder="Gunakan clipper 1mm gradasi halus..."></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Pilih Foto Hasil Potongan:</label>
            <input type="file" name="image" class="form-control bg-secondary text-white border-0" accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold">Unggah ke Portofolio</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
