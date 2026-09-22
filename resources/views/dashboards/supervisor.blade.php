@extends('admin_layout.app')

@section('title', 'Supervisor Operations & Audit Workstation - District Studio')

@section('content')
<main class="main" style="padding-top: 80px; min-height: 100vh; background-color: #09090b;">

  <!-- Supervisor Header Banner -->
  <section style="background: linear-gradient(135deg, #182838 0%, #0d1620 100%); border-bottom: 1px solid rgba(100,200,255,0.25); padding: 35px 0;">
    <div class="container-fluid container-xl">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <span style="background: rgba(100,200,255,0.15); color: #64c8ff; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; padding: 5px 14px; border: 1px solid rgba(100,200,255,0.3); border-radius: 4px; font-family: 'Montserrat', sans-serif;">
            <i class="bi bi-shield-check me-1"></i> Operations & Quality Audit Workstation
          </span>
          <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.9rem; font-weight: 900; color: #fff; text-transform: uppercase; margin-top: 10px; margin-bottom: 0;">
            Supervisor Workstation <span style="color: #64c8ff;">.</span>
          </h2>
          <p style="font-size: 0.85rem; color: #a1a1aa; margin: 4px 0 0;">Pengawasan operasional harian, audit stok produk & bahan baku, penjadwalan shift staf, dan penanganan keluhan pelanggan.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-info btn-sm fw-bold text-dark px-3 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px;" data-bs-toggle="modal" data-bs-target="#shiftModal">
            <i class="bi bi-calendar-plus me-1"></i> + Atur Shift Staf
          </button>
        </div>
      </div>
    </div>
  </section>

  <div class="container-fluid container-xl" style="padding: 35px 15px 60px;">

    @if(session('success'))
      <div class="alert alert-dismissible fade show d-flex align-items-center justify-content-between mb-4" role="alert" style="background: rgba(100,200,255,0.15); border: 1px solid rgba(100,200,255,0.4); color: #fff; border-radius: 8px; padding: 16px 20px;">
        <div><i class="bi bi-check-circle-fill me-2" style="color: #64c8ff;"></i> {{ session('success') }}</div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- DAILY OPERATIONAL CHECKLIST WIDGET -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;" class="mb-4">
      <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #64c8ff; padding-left: 12px;" class="mb-3">
        <i class="bi bi-clipboard-check-fill me-2" style="color: #64c8ff;"></i> Checklist Kesiapan Operasional Barbershop Hari Ini
      </h4>
      <div class="row g-3">
        <div class="col-12 col-md-3">
          <div class="form-check form-switch bg-dark p-3 rounded border border-secondary border-opacity-25">
            <input class="form-check-input ms-0 me-2" type="checkbox" id="chk1" checked>
            <label class="form-label text-white mb-0" for="chk1" style="font-size: 0.82rem;">Sanitasi Alat Barber Ready</label>
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="form-check form-switch bg-dark p-3 rounded border border-secondary border-opacity-25">
            <input class="form-check-input ms-0 me-2" type="checkbox" id="chk2" checked>
            <label class="form-label text-white mb-0" for="chk2" style="font-size: 0.82rem;">Handuk Bersih & Tisu Cukup</label>
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="form-check form-switch bg-dark p-3 rounded border border-secondary border-opacity-25">
            <input class="form-check-input ms-0 me-2" type="checkbox" id="chk3" checked>
            <label class="form-label text-white mb-0" for="chk3" style="font-size: 0.82rem;">Layar Queue TV Aktif</label>
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="form-check form-switch bg-dark p-3 rounded border border-secondary border-opacity-25">
            <input class="form-check-input ms-0 me-2" type="checkbox" id="chk4" checked>
            <label class="form-label text-white mb-0" for="chk4" style="font-size: 0.82rem;">Kasir & POS System Ready</label>
          </div>
        </div>
      </div>
    </div>

    <!-- 2 MAIN COLUMNS: AUDIT STOK & SHIFT KERJA -->
    <div class="row g-4 mb-4">
      
      <!-- AUDIT OPERASIONAL & STOK -->
      <div class="col-12 col-lg-6">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;" class="h-100">
          <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #64c8ff; padding-left: 12px;" class="mb-3">
            <i class="bi bi-box-seam me-2" style="color: #64c8ff;"></i> Audit Stok Produk & Restok Cepat
          </h4>
          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="font-size: 0.82rem; border-color: rgba(255,255,255,0.06);">
              <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.7rem; text-transform: uppercase; color: #a1a1aa;">
                <tr>
                  <th>Nama Barang</th>
                  <th>Kategori</th>
                  <th>Stok</th>
                  <th>Min Stok</th>
                  <th>Status Audit</th>
                  <th class="text-end">Update Stok</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $prod)
                  <tr>
                    <td><strong class="text-white">{{ $prod->name }}</strong></td>
                    <td><span class="badge bg-secondary font-monospace">{{ $prod->category }}</span></td>
                    <td><strong class="{{ $prod->stock <= $prod->min_stock ? 'text-danger' : 'text-success' }} font-monospace">{{ $prod->stock }} pcs</strong></td>
                    <td class="font-monospace">{{ $prod->min_stock }} pcs</td>
                    <td>
                      @if($prod->stock <= $prod->min_stock)
                        <span class="badge bg-danger">PERLU RESTOK</span>
                      @else
                        <span class="badge bg-success">STOK CUKUP</span>
                      @endif
                    </td>
                    <td class="text-end">
                      <form action="{{ route('supervisor.stock', $prod->id) }}" method="POST" class="d-flex gap-1 justify-content-end">
                        @csrf
                        <input type="number" name="stock" value="{{ $prod->stock }}" class="form-control form-control-sm bg-dark text-white border-secondary font-monospace" style="width: 65px;">
                        <input type="hidden" name="min_stock" value="{{ $prod->min_stock }}">
                        <button type="submit" class="btn btn-sm btn-info text-dark font-monospace fw-bold p-1" title="Simpan Stok"><i class="bi bi-check-lg"></i></button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- SHIFT KERJA STAF -->
      <div class="col-12 col-lg-6">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #ff9800; padding-left: 12px; margin: 0;">
              <i class="bi bi-calendar-week me-2" style="color: #ff9800;"></i> Jadwal Shift Kerja Staf Barbershop
            </h4>
            <button class="btn btn-sm btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#shiftModal">
              + Tambah Shift
            </button>
          </div>
          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="font-size: 0.82rem; border-color: rgba(255,255,255,0.06);">
              <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.7rem; text-transform: uppercase; color: #a1a1aa;">
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Staf</th>
                  <th>Role</th>
                  <th>Tipe Shift</th>
                  <th>Catatan</th>
                </tr>
              </thead>
              <tbody>
                @foreach($workShifts as $ws)
                  <tr>
                    <td><span class="text-white font-monospace">{{ $ws->shift_date }}</span></td>
                    <td><strong class="text-white">{{ $ws->user ? $ws->user->name : '-' }}</strong></td>
                    <td><span class="badge bg-dark border border-secondary" style="color: #a1a1aa;">{{ strtoupper($ws->user ? $ws->user->role : '') }}</span></td>
                    <td>
                      <span class="badge 
                        @if($ws->shift_type === 'Pagi') bg-info text-dark
                        @elseif($ws->shift_type === 'Siang') bg-warning text-dark
                        @elseif($ws->shift_type === 'Full') bg-success
                        @else bg-secondary @endif font-monospace">
                        {{ $ws->shift_type }}
                      </span>
                    </td>
                    <td><small class="text-white-50">{{ $ws->notes ?? '-' }}</small></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>

    <!-- PENANGANAN KOMPLAIN PELANGGAN -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;">
      <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #dc3545; padding-left: 12px;" class="mb-4">
        <i class="bi bi-exclamation-octagon-fill me-2" style="color: #dc3545;"></i> Penanganan Komplain & Masukan Pelanggan
      </h4>

      @if($complaints->isEmpty())
        <div class="text-center py-4 text-muted">
          <i class="bi bi-check-circle" style="font-size: 35px; display: block; margin-bottom: 8px; color: #28a745;"></i>
          <p>Belum ada keluhan atau komplain pelanggan yang terdaftar.</p>
        </div>
      @else
        <div class="table-responsive">
          <table class="table table-dark table-hover align-middle mb-0" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
            <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; color: #a1a1aa;">
              <tr>
                <th>Pelanggan</th>
                <th>Kategori</th>
                <th>Pesan Komplain</th>
                <th>Status Penanganan</th>
                <th>Resolusi Supervisor</th>
                <th class="text-end">Aksi Resolusi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($complaints as $c)
                <tr>
                  <td><strong class="text-white">{{ $c->customer_name }}</strong></td>
                  <td><span class="badge bg-secondary font-monospace">{{ $c->category }}</span></td>
                  <td><small class="text-white-50">"{{ $c->message }}"</small></td>
                  <td>
                    <span class="badge 
                      @if($c->status === 'resolved') bg-success
                      @elseif($c->status === 'in_progress') bg-warning text-dark
                      @else bg-danger @endif font-monospace">
                      {{ strtoupper($c->status) }}
                    </span>
                  </td>
                  <td><small class="text-info">{{ $c->resolution ?? 'Belum ada catatan resolusi' }}</small></td>
                  <td class="text-end">
                    <button class="btn btn-sm btn-outline-warning" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#resolveComplaintModal{{ $c->id }}">
                      Tindak Lanjut
                    </button>
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

<!-- MODAL INPUT SHIFT KERJA -->
<div class="modal fade" id="shiftModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-info"><i class="bi bi-calendar-plus me-2"></i>Penjadwalan Shift Kerja Staf</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('supervisor.shifts') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Pilih Staf:</label>
            <select name="user_id" class="form-select bg-secondary text-white border-0" required>
              @foreach($staffMembers as $staff)
                <option value="{{ $staff->id }}">{{ $staff->name }} ({{ strtoupper($staff->role) }})</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Tanggal Shift:</label>
            <input type="date" name="shift_date" class="form-control bg-secondary text-white border-0" value="{{ date('Y-m-d') }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Tipe Shift:</label>
            <select name="shift_type" class="form-select bg-secondary text-white border-0" required>
              <option value="Pagi">Shift Pagi (09:00 - 16:00 WIB)</option>
              <option value="Siang">Shift Siang/Malam (14:00 - 21:00 WIB)</option>
              <option value="Full">Full Day Shift (09:00 - 21:00 WIB)</option>
              <option value="Off">Libur / Off Day</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Catatan Khusus (Opsional):</label>
            <input type="text" name="notes" class="form-control bg-secondary text-white border-0" placeholder="Misal: Bertugas di Station #1">
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-info text-dark fw-bold">Simpan Jadwal Shift</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODALS RESOLVE COMPLAINT -->
@foreach($complaints as $c)
<div class="modal fade" id="resolveComplaintModal{{ $c->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header border-secondary">
        <h5 class="modal-title font-monospace text-warning">Tindak Lanjut Komplain #{{ $c->id }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('supervisor.complaint', $c->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <p style="font-size: 0.85rem;" class="text-white-50">Pelanggan: <strong class="text-white">{{ $c->customer_name }}</strong></p>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Status Penanganan:</label>
            <select name="status" class="form-select bg-secondary text-white border-0" required>
              <option value="in_progress" {{ $c->status === 'in_progress' ? 'selected' : '' }}>Dalam Penyelidikan / Process</option>
              <option value="resolved" {{ $c->status === 'resolved' ? 'selected' : '' }}>Selesai / Resolved</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" style="font-size: 0.8rem;">Catatan Resolusi / Tindakan Perbaikan:</label>
            <textarea name="resolution" class="form-control bg-secondary text-white border-0" rows="3" placeholder="Jelaskan langkah penyelesaian..." required>{{ $c->resolution }}</textarea>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold">Simpan Resolusi</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@endsection
