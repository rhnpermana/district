@extends('admin_layout.app')

@section('title', 'Executive Financial Dashboard - Owner District Studio')

@section('content')
<main class="main" style="padding-top: 56px; min-height: 100vh; background-color: #09090b;">

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
          <p class="d-none d-md-block" style="font-size: 0.85rem; color: #a1a1aa; margin: 4px 0 0;">Ringkasan visual diagram omzet kotor, net profit, biaya operasional, pembagian komisi kapster, & performa cabang.</p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
          <a href="{{ route('owner.reports.export_excel') }}" class="btn btn-success fw-bold px-3 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
            <i class="bi bi-file-earmark-excel-fill me-1"></i> Unduh Excel (.csv)
          </a>
          <a href="{{ route('owner.reports.print') }}" target="_blank" class="btn btn-warning text-dark fw-bold px-3 py-2" style="font-family: 'Montserrat', sans-serif; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
            <i class="bi bi-printer-fill me-1"></i> Cetak Laporan PDF (Formal)
          </a>
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

    <!-- ===== EXECUTIVE VISUAL DIAGRAMS & CHARTS SECTION ===== -->
    <div class="row g-4 mb-4">
      
      <!-- Chart 1: 7-Day Revenue & Profit Trend -->
      <div class="col-12 col-lg-8">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 22px;" class="h-100">
          <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <div>
              <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #dca53e; padding-left: 12px; margin: 0;">
                <i class="bi bi-graph-up me-2" style="color: #dca53e;"></i> Tren Finansial 7 Hari Terakhir
              </h4>
              <small style="color: #71717a; margin-left: 15px; font-size: 0.75rem;">Perbandingan Omzet Bruto, Pengeluaran Kas Kecil, dan Net Profit harian.</small>
            </div>
            <span class="badge" style="background: rgba(220,165,62,0.15); color: #dca53e; border: 1px solid rgba(220,165,62,0.3); font-size: 0.7rem;">
              <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Live Analytics
            </span>
          </div>
          <div style="position: relative; height: 260px; width: 100%;">
            <canvas id="trendChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Chart 2: Revenue Composition (Services vs Products) -->
      <div class="col-12 col-lg-4">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 22px;" class="h-100">
          <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #28a745; padding-left: 12px;" class="mb-3">
            <i class="bi bi-pie-chart-fill me-2" style="color: #28a745;"></i> Komposisi Pendapatan
          </h4>
          <div style="position: relative; height: 210px; width: 100%;">
            <canvas id="categoryChart"></canvas>
          </div>
          <div class="d-flex justify-content-around mt-3 text-center" style="font-size: 0.78rem;">
            <div>
              <div style="color: #28a745; font-weight: 700;">Layanan Pangkas</div>
              <div class="text-white font-monospace">Rp {{ number_format($serviceRevenue, 0, ',', '.') }}</div>
            </div>
            <div style="border-left: 1px solid rgba(255,255,255,0.1);"></div>
            <div>
              <div style="color: #dca53e; font-weight: 700;">Produk Retail</div>
              <div class="text-white font-monospace">Rp {{ number_format($productRevenue, 0, ',', '.') }}</div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- ===== CHARTS ROW 2: STYLIST PERFORMANCE & PAYMENT METHODS ===== -->
    <div class="row g-4 mb-4">
      
      <!-- Chart 3: Barber Productivity & Commission Comparison -->
      <div class="col-12 col-lg-8">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 22px;" class="h-100">
          <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <div>
              <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #00c8c8; padding-left: 12px; margin: 0;">
                <i class="bi bi-bar-chart-fill me-2" style="color: #00c8c8;"></i> Perbandingan Omzet & Komisi Hair Stylist
              </h4>
              <small style="color: #71717a; margin-left: 15px; font-size: 0.75rem;">Total omzet pengerjaan vs hak komisi yang diterima masing-masing kapster.</small>
            </div>
          </div>
          <div style="position: relative; height: 240px; width: 100%;">
            <canvas id="stylistBarChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Chart 4: Payment Methods Distribution -->
      <div class="col-12 col-lg-4">
        <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 22px;" class="h-100">
          <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #ff9800; padding-left: 12px;" class="mb-3">
            <i class="bi bi-wallet-fill me-2" style="color: #ff9800;"></i> Metode Pembayaran Kasir
          </h4>
          <div style="position: relative; height: 210px; width: 100%;">
            <canvas id="paymentChart"></canvas>
          </div>
          <div class="d-flex justify-content-around mt-3 text-center" style="font-size: 0.78rem;">
            <div>
              <div style="color: #28a745; font-weight: 700;">Cash (Tunai)</div>
              <div class="text-white font-monospace">Rp {{ number_format($paymentMethods['Cash'] ?? 0, 0, ',', '.') }}</div>
            </div>
            <div style="border-left: 1px solid rgba(255,255,255,0.1);"></div>
            <div>
              <div style="color: #00c8c8; font-weight: 700;">QRIS Digital</div>
              <div class="text-white font-monospace">Rp {{ number_format($paymentMethods['QRIS'] ?? 0, 0, ',', '.') }}</div>
            </div>
          </div>
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
            @forelse($peakHours as $ph)
              <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center px-0 border-secondary border-opacity-25 py-2">
                <div>
                  <i class="bi bi-alarm me-2" style="color: #ff9800;"></i> Slot Jam <strong>{{ $ph->booking_time }} WIB</strong>
                </div>
                <span class="badge bg-warning text-dark font-monospace fw-bold">{{ $ph->count }} Sesi Cukur</span>
              </li>
            @empty
              <li class="list-group-item bg-transparent text-muted text-center py-3">Belum ada data riwayat jam pangkas.</li>
            @endforelse
          </ul>
        </div>
      </div>

    </div>

    <!-- BEST PERFORMING BARBER & KOMISI REPORT -->
    <div style="background: #121215; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 25px;">
      <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <h4 style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; color: #fff; text-transform: uppercase; border-left: 3px solid #28a745; padding-left: 12px; margin: 0;">
          <i class="bi bi-award-fill me-2" style="color: #28a745;"></i> Best Performing Barber & Laporan Pembagian Komisi
        </h4>
        <a href="{{ route('owner.reports.print') }}" target="_blank" class="btn btn-sm btn-outline-warning" style="font-size: 0.75rem;">
          <i class="bi bi-printer me-1"></i> Cetak Rekap Komisi
        </a>
      </div>

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
            @forelse($stylists as $index => $s)
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
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-3">Belum ada data hair stylist.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</main>

<!-- Chart.js CDN for Visual Interactive Diagrams -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // 1. Trend 7 Days Chart (Line/Area)
    const trendLabels = {!! json_encode($trend7Days->pluck('label')) !!};
    const trendGross = {!! json_encode($trend7Days->pluck('gross')) !!};
    const trendExpense = {!! json_encode($trend7Days->pluck('expense')) !!};
    const trendNet = {!! json_encode($trend7Days->pluck('net')) !!};

    const ctxTrend = document.getElementById('trendChart').getContext('2d');
    new Chart(ctxTrend, {
      type: 'line',
      data: {
        labels: trendLabels,
        datasets: [
          {
            label: 'Omzet Kotor',
            data: trendGross,
            borderColor: '#dca53e',
            backgroundColor: 'rgba(220, 165, 62, 0.15)',
            fill: true,
            tension: 0.35,
            borderWidth: 2,
            pointBackgroundColor: '#dca53e',
          },
          {
            label: 'Profit Bersih',
            data: trendNet,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.15)',
            fill: true,
            tension: 0.35,
            borderWidth: 2,
            pointBackgroundColor: '#28a745',
          },
          {
            label: 'Petty Cash',
            data: trendExpense,
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            fill: false,
            tension: 0.35,
            borderWidth: 1.5,
            borderDash: [5, 5],
            pointBackgroundColor: '#dc3545',
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            labels: { color: '#a1a1aa', font: { family: 'Inter', size: 11 } }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': Rp ' + Number(context.raw).toLocaleString('id-ID');
              }
            }
          }
        },
        scales: {
          x: {
            ticks: { color: '#71717a', font: { size: 10 } },
            grid: { color: 'rgba(255, 255, 255, 0.05)' }
          },
          y: {
            ticks: {
              color: '#71717a',
              font: { size: 10 },
              callback: function(value) {
                return 'Rp ' + (value >= 1000000 ? (value/1000000).toFixed(1) + 'M' : (value/1000).toFixed(0) + 'k');
              }
            },
            grid: { color: 'rgba(255, 255, 255, 0.05)' }
          }
        }
      }
    });

    // 2. Category Doughnut Chart (Services vs Products)
    const ctxCat = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCat, {
      type: 'doughnut',
      data: {
        labels: ['Layanan Cukur', 'Produk Grooming'],
        datasets: [{
          data: [{{ $serviceRevenue }}, {{ $productRevenue }}],
          backgroundColor: ['#28a745', '#dca53e'],
          borderColor: '#121215',
          borderWidth: 3,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { color: '#a1a1aa', font: { family: 'Inter', size: 11 } }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const pct = total > 0 ? Math.round((context.raw / total) * 100) : 0;
                return context.label + ': Rp ' + Number(context.raw).toLocaleString('id-ID') + ' (' + pct + '%)';
              }
            }
          }
        },
        cutout: '70%',
      }
    });

    // 3. Stylist Bar Chart
    const stylistLabels = {!! json_encode($stylistChart['labels']) !!};
    const stylistRevenues = {!! json_encode($stylistChart['revenues']) !!};
    const stylistCommissions = {!! json_encode($stylistChart['commissions']) !!};

    const ctxStylist = document.getElementById('stylistBarChart').getContext('2d');
    new Chart(ctxStylist, {
      type: 'bar',
      data: {
        labels: stylistLabels,
        datasets: [
          {
            label: 'Total Omzet Pengerjaan',
            data: stylistRevenues,
            backgroundColor: '#00c8c8',
            borderRadius: 6,
          },
          {
            label: 'Hak Komisi Diterima',
            data: stylistCommissions,
            backgroundColor: '#28a745',
            borderRadius: 6,
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            labels: { color: '#a1a1aa', font: { family: 'Inter', size: 11 } }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': Rp ' + Number(context.raw).toLocaleString('id-ID');
              }
            }
          }
        },
        scales: {
          x: {
            ticks: { color: '#71717a', font: { size: 10 } },
            grid: { display: false }
          },
          y: {
            ticks: {
              color: '#71717a',
              font: { size: 10 },
              callback: function(value) {
                return 'Rp ' + (value/1000).toFixed(0) + 'k';
              }
            },
            grid: { color: 'rgba(255, 255, 255, 0.05)' }
          }
        }
      }
    });

    // 4. Payment Methods Doughnut Chart
    const ctxPay = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctxPay, {
      type: 'doughnut',
      data: {
        labels: ['Cash (Tunai)', 'QRIS Digital', 'Lainnya'],
        datasets: [{
          data: [
            {{ $paymentMethods['Cash'] ?? 0 }},
            {{ $paymentMethods['QRIS'] ?? 0 }},
            {{ $paymentMethods['Transfer / Lainnya'] ?? 0 }}
          ],
          backgroundColor: ['#28a745', '#00c8c8', '#ff9800'],
          borderColor: '#121215',
          borderWidth: 3,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { color: '#a1a1aa', font: { family: 'Inter', size: 11 } }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.label + ': Rp ' + Number(context.raw).toLocaleString('id-ID');
              }
            }
          }
        },
        cutout: '65%',
      }
    });

  });
</script>
@endsection
