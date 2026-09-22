@extends('admin_layout.app')

@section('title', 'Executive Financial Dashboard - Owner District Studio')

@section('content')
<main class="main" style="padding-top: 80px; min-height: 100vh; background-color: #09090b;">

  <!-- Owner Header Banner -->
  <section style="background: linear-gradient(135deg, #2b1f0c 0%, #150f05 100%); border-bottom: 1px solid rgba(220,165,62,0.3); padding: 35px 0;">
    <div class="container-fluid container-xl">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <span style="background: rgba(220,165,62,0.15); color: #dca53e; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; padding: 5px 14px; border: 1px solid rgba(220,165,62,0.3); border-radius: 4px; font-family: 'Montserrat', sans-serif;">
            <i class="bi bi-crown-fill me-1"></i> Executive Financial & Branch Analytics Workstation
          </span>
          <h2 style="font-family: 'Montserrat', sans-serif; font-size: 1.9rem; font-weight: 900; color: #fff; text-transform: uppercase; margin-top: 10px; margin-bottom: 0;">
            Owner Executive Dashboard <span style="color: #dca53e;">.</span>
          </h2>
          <p style="font-size: 0.85rem; color: #a1a1aa; margin: 4px 0 0;">Ringkasan omzet kotor, net profit, biaya operasional, pembagian komisi kapster, & performa cabang real-time.</p>
        </div>

        <div class="d-flex align-items-center gap-2">
          <button onclick="window.print()" class="btn btn-warning text-dark fw-bold px-4 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px;">
            <i class="bi bi-printer-fill me-1"></i> Cetak Laporan Keuangan Eksekutif
          </button>
        </div>
      </div>
    </div>
  </section>

  <div class="container-fluid container-xl" style="padding: 35px 15px 60px;">

    <!-- FINANCIAL METRICS SUMMARY CARDS -->
    <div class="row g-3 mb-4">
      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(220,165,62,0.4); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Omzet Kotor (Gross Revenue)</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(220,165,62,0.12); color: #dca53e; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-graph-up-arrow"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #dca53e; margin: 0; font-family: 'Montserrat', sans-serif;">
            Rp {{ number_format($grossOmzet, 0, ',', '.') }}
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">Total pemasukan bruto dari transaksi & booking</span>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(40,167,69,0.4); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Profit Bersih (Net Profit)</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(40,167,69,0.12); color: #28a745; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-wallet2"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #28a745; margin: 0; font-family: 'Montserrat', sans-serif;">
            Rp {{ number_format($netProfit, 0, ',', '.') }}
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">Net laba bersih setelah petty cash & komisi</span>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(220,53,69,0.4); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Pengeluaran Petty Cash</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(220,53,69,0.12); color: #dc3545; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-arrow-down-right-circle"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #dc3545; margin: 0; font-family: 'Montserrat', sans-serif;">
            Rp {{ number_format($totalPettyCash, 0, ',', '.') }}
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">Beban operasional harian barbershop</span>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <div style="background: #121215; border: 1px solid rgba(0,200,200,0.4); padding: 22px; border-radius: 10px;" class="h-100">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span style="font-size: 0.7rem; font-family: 'Montserrat', sans-serif; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px;">Total Komisi Hair Stylist</span>
            <div style="width: 34px; height: 34px; border-radius: 8px; background: rgba(0,200,200,0.12); color: #00c8c8; display: flex; align-items: center; justify-content: center;">
              <i class="bi bi-scissors"></i>
            </div>
          </div>
          <h2 style="font-size: 1.7rem; font-weight: 900; color: #00c8c8; margin: 0; font-family: 'Montserrat', sans-serif;">
            Rp {{ number_format($totalCommissions, 0, ',', '.') }}
          </h2>
          <span style="font-size: 0.72rem; color: #a1a1aa; font-weight: 500;">Alokasi pembayaran komisi kapster</span>
        </div>
      </div>
    </div>

    <!-- MULTI-BRANCH PERFORMANCE ANALYTICS & PEAK HOURS -->
    <div class="row g-4 mb-4">
      
      <!-- MULTI-BRANCH ANALYTICS -->
      <div class="col-12 col-lg-7">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;">
          <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #dca53e; padding-left: 12px;" class="mb-4">
            <i class="bi bi-buildings me-2" style="color: #dca53e;"></i> Analisis Performa Multi-Cabang Barbershop
          </h4>
          <div class="row g-3">
            @foreach($branchStats as $bName => $bStat)
              <div class="col-12 col-md-6">
                <div style="background: #18181b; border: 1px solid rgba(255,255,255,0.06); padding: 20px; border-radius: 8px;">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 style="font-weight: 800; color: #fff; margin: 0; font-size: 0.95rem;">{{ $bName }}</h6>
                    <span class="badge bg-warning text-dark font-monospace">{{ $bStat['completed'] }} Sesi Selesai</span>
                  </div>
                  <div style="font-size: 0.78rem; color: #a1a1aa;" class="mb-2">Total Permintaan Booking: <strong>{{ $bStat['total'] }} antrean</strong></div>
                  <div style="font-size: 1.3rem; font-weight: 900; color: #28a745; font-family: 'Montserrat', sans-serif;">
                    Rp {{ number_format($bStat['revenue'], 0, ',', '.') }}
                  </div>
                  @php
                    $branchPct = $grossOmzet > 0 ? min(100, round(($bStat['revenue'] / $grossOmzet) * 100)) : 0;
                  @endphp
                  <div class="progress mt-2" style="height: 6px; background: rgba(255,255,255,0.08);">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $branchPct }}%;"></div>
                  </div>
                  <small class="text-white-50 mt-1 d-block" style="font-size: 0.7rem;">Kontribusi {{ $branchPct }}% dari omzet kotor total</small>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- PEAK HOURS ANALYTICS -->
      <div class="col-12 col-lg-5">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;">
          <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #ff9800; padding-left: 12px;" class="mb-4">
            <i class="bi bi-clock-history me-2" style="color: #ff9800;"></i> Jam Tersibuk (Peak Hours)
          </h4>
          <ul class="list-group list-group-flush bg-transparent">
            @foreach($peakHours as $ph)
              <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center px-0 border-secondary border-opacity-25 py-2">
                <div>
                  <i class="bi bi-alarm me-2" style="color: #ff9800;"></i> Slot Jam <strong>{{ $ph->booking_time }} WIB</strong>
                </div>
                <span class="badge bg-warning text-dark font-monospace fw-bold">{{ $ph->count }} Sesi Cukur</span>
              </li>
            @endforeach
          </ul>
        </div>
      </div>

    </div>

    <!-- BEST PERFORMING BARBER & KOMISI REPORT -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;">
      <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #28a745; padding-left: 12px;" class="mb-4">
        <i class="bi bi-award-fill me-2" style="color: #28a745;"></i> Best Performing Barber & Laporan Pembagian Komisi
      </h4>

      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0" style="font-size: 0.85rem; border-color: rgba(255,255,255,0.06);">
          <thead class="table-black" style="font-family: 'Montserrat', sans-serif; font-size: 0.72rem; text-transform: uppercase; color: #a1a1aa;">
            <tr>
              <th>Peringkat</th>
              <th>Nama Hair Stylist</th>
              <th>Status Kerja</th>
              <th>Sesi Cukur Selesai</th>
              <th>Total Omzet Pengerjaan</th>
              <th>Rate Komisi (%)</th>
              <th>Hak Komisi (Rp)</th>
            </tr>
          </thead>
          <tbody>
            @foreach($stylists as $index => $s)
              <tr>
                <td>
                  @if($index === 0)
                    <span class="badge bg-warning text-dark font-monospace"><i class="bi bi-trophy-fill me-1"></i> TOP #1 BARBER</span>
                  @else
                    <span class="badge bg-secondary font-monospace">#{{ $index + 1 }}</span>
                  @endif
                </td>
                <td><strong class="text-white">{{ $s->name }}</strong></td>
                <td>
                  <span class="badge bg-dark border border-secondary" style="color: #a1a1aa;">{{ $s->work_status ?? 'Available' }}</span>
                </td>
                <td><strong class="text-warning font-monospace">{{ $s->completed_count }} Sesi</strong></td>
                <td class="font-monospace">Rp {{ number_format($s->total_revenue, 0, ',', '.') }}</td>
                <td class="font-monospace fw-bold">{{ $s->commission_rate ?? 30 }}%</td>
                <td class="text-success fw-bold font-monospace fs-6">Rp {{ number_format($s->total_commission, 0, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</main>
@endsection
