<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Eksekutif Keuangan & Operasional – District Studio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      font-size: 11pt;
      line-height: 1.45;
      color: #1a1a1a;
      background-color: #f4f4f5;
    }

    /* Top Action Bar (Hidden when printing) */
    .no-print-bar {
      background: #18181b;
      color: #fff;
      padding: 14px 24px;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .no-print-bar .container {
      max-width: 1000px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      font-size: 0.82rem;
      font-weight: 700;
      text-decoration: none;
      border-radius: 6px;
      cursor: pointer;
      border: none;
      transition: all 0.2s;
    }
    .btn-primary { background: #dca53e; color: #000; }
    .btn-primary:hover { background: #c88e28; }
    .btn-success { background: #28a745; color: #fff; }
    .btn-success:hover { background: #218838; }
    .btn-outline { background: transparent; color: #e4e4e7; border: 1px solid rgba(255,255,255,0.2); }
    .btn-outline:hover { background: rgba(255,255,255,0.1); }
    .filter-form {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.8rem;
    }
    .filter-form input {
      padding: 6px 10px;
      border-radius: 4px;
      border: 1px solid #3f3f46;
      background: #27272a;
      color: #fff;
      font-size: 0.78rem;
    }

    /* Paper Page Layout (Formal A4 Document) */
    .page-container {
      max-width: 210mm;
      margin: 24px auto;
      background: #ffffff;
      padding: 20mm 20mm;
      box-shadow: 0 0 20px rgba(0,0,0,0.08);
      border-radius: 4px;
    }

    /* Formal Letterhead (KOP SURAT) */
    .kop-surat {
      display: flex;
      align-items: center;
      gap: 18px;
      padding-bottom: 12px;
      border-bottom: 3px double #000000;
      margin-bottom: 20px;
    }
    .kop-logo {
      width: 75px;
      height: 75px;
      background: #111;
      border-radius: 12px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: #dca53e;
      font-weight: 900;
      font-family: 'Montserrat', sans-serif;
      flex-shrink: 0;
      border: 2px solid #dca53e;
    }
    .kop-logo span {
      font-size: 1.1rem;
      letter-spacing: 1px;
    }
    .kop-logo small {
      font-size: 0.5rem;
      letter-spacing: 2px;
      color: #fff;
    }
    .kop-text {
      flex: 1;
      text-align: center;
    }
    .kop-text h1 {
      font-family: 'Cinzel', 'Montserrat', serif;
      font-size: 18pt;
      font-weight: 800;
      color: #09090b;
      letter-spacing: 1.5px;
      margin-bottom: 2px;
      text-transform: uppercase;
    }
    .kop-text h2 {
      font-size: 10pt;
      font-weight: 700;
      letter-spacing: 2px;
      color: #854d0e;
      text-transform: uppercase;
      margin-bottom: 4px;
    }
    .kop-text p {
      font-size: 8.5pt;
      color: #4b5563;
      line-height: 1.35;
    }

    /* Document Metadata Box */
    .doc-meta {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 22px;
      background: #fafafa;
      border: 1px solid #e5e7eb;
      padding: 10px 14px;
      border-radius: 6px;
      font-size: 9pt;
    }
    .doc-title {
      font-size: 13pt;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #111827;
      text-decoration: underline;
      margin-bottom: 3px;
    }

    /* Section Headings */
    .section-title {
      font-size: 10.5pt;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #111827;
      border-bottom: 1.5px solid #111827;
      padding-bottom: 4px;
      margin: 20px 0 10px 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    /* Financial Summary Grid */
    .summary-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 18px;
    }
    .summary-table th, .summary-table td {
      border: 1px solid #d1d5db;
      padding: 7px 10px;
      font-size: 9.5pt;
    }
    .summary-table th {
      background: #f3f4f6;
      font-weight: 700;
      text-align: left;
    }
    .summary-table .nominal {
      text-align: right;
      font-weight: 700;
      font-family: 'Montserrat', sans-serif;
    }
    .summary-table .highlight-net {
      background: #ecfdf5;
      color: #065f46;
      font-size: 11pt;
      font-weight: 900;
    }

    /* Data Tables */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 18px;
      font-size: 8.5pt;
    }
    .data-table th, .data-table td {
      border: 1px solid #d1d5db;
      padding: 6px 8px;
    }
    .data-table th {
      background: #f3f4f6;
      font-weight: 700;
      text-align: center;
      text-transform: uppercase;
      color: #1f2937;
    }
    .data-table tbody tr:nth-child(even) {
      background: #fafafa;
    }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .fw-bold { font-weight: 700; }

    /* Signatures / Mengetahui */
    .signatures {
      display: flex;
      justify-content: space-between;
      margin-top: 35px;
      padding-top: 10px;
      page-break-inside: avoid;
    }
    .sign-box {
      width: 42%;
      text-align: center;
      font-size: 9pt;
    }
    .sign-space {
      height: 65px;
    }
    .sign-name {
      font-weight: 800;
      text-decoration: underline;
      text-transform: uppercase;
    }
    .sign-role {
      font-size: 8pt;
      color: #4b5563;
    }

    /* Print Styles */
    @media print {
      body {
        background: #ffffff;
        color: #000;
        font-size: 10pt;
      }
      .no-print-bar {
        display: none !important;
      }
      .page-container {
        max-width: 100%;
        margin: 0;
        padding: 0;
        box-shadow: none;
        border-radius: 0;
      }
      @page {
        size: A4 portrait;
        margin: 15mm 15mm 15mm 15mm;
      }
      .summary-table th, .data-table th {
        background-color: #f0f0f0 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
      .summary-table .highlight-net {
        background-color: #e6f7ee !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
    }
  </style>
</head>
<body>

  <!-- Top Action & Filter Bar (Screen Only) -->
  <div class="no-print-bar">
    <div class="container">
      <div style="display: flex; align-items: center; gap: 10px;">
        <a href="{{ route('dashboard') }}" class="btn btn-outline">
          <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
        <span style="font-weight: 700; font-size: 0.9rem; color: #dca53e;">
          <i class="bi bi-file-earmark-pdf-fill me-1"></i> Mode Cetak Laporan Formal
        </span>
      </div>

      <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <!-- Date Filter -->
        <form action="{{ route('owner.reports.print') }}" method="GET" class="filter-form">
          <label style="color: #a1a1aa;">Dari:</label>
          <input type="date" name="start_date" value="{{ $startDate }}">
          <label style="color: #a1a1aa;">Sampai:</label>
          <input type="date" name="end_date" value="{{ $endDate }}">
          <button type="submit" class="btn btn-outline" style="padding: 6px 12px;">
            <i class="bi bi-funnel-fill"></i> Filter
          </button>
        </form>

        <!-- Excel Export Button -->
        <a href="{{ route('owner.reports.export_excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-success">
          <i class="bi bi-file-earmark-excel-fill"></i> Unduh Excel (.csv)
        </a>

        <!-- Print / PDF Button -->
        <button onclick="window.print()" class="btn btn-primary">
          <i class="bi bi-printer-fill"></i> Cetak / Simpan PDF
        </button>
      </div>
    </div>
  </div>

  <!-- A4 Printable Document Container -->
  <div class="page-container">

    <!-- Formal Letterhead (KOP SURAT RESMI) -->
    <div class="kop-surat">
      <div class="kop-logo">
        <span>DISTRICT</span>
        <small>STUDIO</small>
      </div>
      <div class="kop-text">
        <h1>DISTRICT STUDIO BARBERSHOP</h1>
        <h2>Executive Grooming & Hair Artist Service</h2>
        <p>
          District Studio Jakarta Barat (SMKN 17 Slipi) &bull; Jl. Slipi Dalam, Palmerah, Jakarta Barat 11410<br>
          Layanan Pelanggan & WA: 0812-3456-7890 &bull; Website: www.districtstudio.id &bull; Email: management@districtstudio.id
        </p>
      </div>
    </div>

    <!-- Document Title & Meta Box -->
    <div class="doc-meta">
      <div>
        <div class="doc-title">LAPORAN EKSEKUTIF KEUANGAN & OPERASIONAL</div>
        <div><strong>Periode Laporan:</strong> {{ $periodLabel }}</div>
        <div><strong>Unit Cabang:</strong> District Studio Jakarta Barat (SMKN 17 Slipi)</div>
      </div>
      <div style="text-align: right;">
        <div><strong>No. Dokumen:</strong> DS/REP-EKS/{{ date('Y') }}/{{ date('m') }}/{{ str_pad(auth()->id(), 3, '0', STR_PAD_LEFT) }}</div>
        <div><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</div>
        <div><strong>Otorisator:</strong> {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</div>
      </div>
    </div>

    <!-- 1. RINGKASAN FINANSIAL EKSEKUTIF -->
    <div class="section-title">
      <span>1. Ringkasan Kinerja Finansial (Executive Financial Summary)</span>
      <span style="font-size: 8pt; font-weight: normal; color: #4b5563;">Mata Uang: Rupiah (IDR)</span>
    </div>

    <table class="summary-table">
      <thead>
        <tr>
          <th style="width: 70%;">Komponen Finansial</th>
          <th style="width: 30%; text-align: right;">Total Nominal (Rp)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <strong>Pendapatan Bruto Layanan (Haircut, Grooming & Styling)</strong><br>
            <small style="color: #6b7280;">Akumulasi total dari seluruh sesi booking & walk-in berstatus Selesai (Completed)</small>
          </td>
          <td class="nominal">Rp {{ number_format($serviceRevenue, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td>
            <strong>Pendapatan Penjualan Produk (Pomade, Hair Powder, Tonic & Retail)</strong><br>
            <small style="color: #6b7280;">Akumulasi total penjualan merchandise & retail kasir POS</small>
          </td>
          <td class="nominal">Rp {{ number_format($productRevenue, 0, ',', '.') }}</td>
        </tr>
        <tr style="background: #f9fafb;">
          <td><strong>TOTAL OMZET KOTOR (GROSS REVENUE)</strong></td>
          <td class="nominal" style="color: #b45309; font-size: 10pt;">Rp {{ number_format($grossOmzet, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td>
            <strong>Beban Pengeluaran Kas Kecil (Petty Cash Operasional)</strong><br>
            <small style="color: #6b7280;">Biaya perlengkapan, konsumsi, kebersihan, & operasional outlet harian</small>
          </td>
          <td class="nominal" style="color: #dc2626;">( Rp {{ number_format($totalPettyCash, 0, ',', '.') }} )</td>
        </tr>
        <tr>
          <td>
            <strong>Beban Pembagian Komisi Hair Stylist (Barber Commission Share)</strong><br>
            <small style="color: #6b7280;">Total alokasi komisi bagi hasil kerja seluruh hair stylist</small>
          </td>
          <td class="nominal" style="color: #d97706;">( Rp {{ number_format($totalCommissions, 0, ',', '.') }} )</td>
        </tr>
        <tr class="highlight-net">
          <td>
            <strong>PROFIT BERSIH EKSEKUTIF (NET PROFIT SETELAH BEBAN)</strong><br>
            <small style="font-weight: 500; color: #047857;">Laba bersih bersih bersih = Omzet Kotor - Petty Cash - Komisi Kapster</small>
          </td>
          <td class="nominal" style="color: #065f46; font-size: 11.5pt;">Rp {{ number_format($netProfit, 0, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>

    <!-- 2. LAPORAN PRODUKTIVITAS & KOMISI HAIR STYLIST -->
    <div class="section-title">
      <span>2. Rekapitulasi Produktivitas & Hak Komisi Barber</span>
      <span style="font-size: 8pt; font-weight: normal; color: #4b5563;">Total {{ $stylists->count() }} Stylist</span>
    </div>

    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 28%; text-align: left;">Nama Hair Stylist</th>
          <th style="width: 15%;">Sesi Selesai</th>
          <th style="width: 20%; text-align: right;">Omzet Pengerjaan</th>
          <th style="width: 12%;">Rate Komisi</th>
          <th style="width: 20%; text-align: right;">Hak Komisi (Rp)</th>
        </tr>
      </thead>
      <tbody>
        @forelse($stylists as $index => $s)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-left fw-bold">{{ $s->name }}</td>
            <td class="text-center">{{ $s->completed_count }} Sesi</td>
            <td class="text-right font-monospace">Rp {{ number_format($s->total_revenue, 0, ',', '.') }}</td>
            <td class="text-center">{{ $s->commission_rate ?? 30 }}%</td>
            <td class="text-right font-monospace fw-bold" style="color: #047857;">Rp {{ number_format($s->total_commission, 0, ',', '.') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center" style="color: #6b7280; padding: 12px;">Tidak ada data aktivitas hair stylist pada periode ini.</td>
          </tr>
        @endforelse
      </tbody>
      <tfoot>
        <tr style="background: #f3f4f6; font-weight: 700;">
          <td colspan="3" class="text-center">TOTAL KOMISI KESELURUHAN</td>
          <td class="text-right">Rp {{ number_format($stylists->sum('total_revenue'), 0, ',', '.') }}</td>
          <td>-</td>
          <td class="text-right" style="color: #047857;">Rp {{ number_format($totalCommissions, 0, ',', '.') }}</td>
        </tr>
      </tfoot>
    </table>

    <!-- 3. RINCIAN PENGELUARAN PETTY CASH -->
    <div class="section-title">
      <span>3. Rekapitulasi Beban Kas Kecil (Petty Cash Expenses)</span>
      <span style="font-size: 8pt; font-weight: normal; color: #4b5563;">Total {{ $pettyCashes->count() }} Pengeluaran</span>
    </div>

    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 14%;">Tanggal</th>
          <th style="width: 18%;">Kategori</th>
          <th style="width: 33%; text-align: left;">Deskripsi Pengeluaran</th>
          <th style="width: 15%;">Kasir/Petugas</th>
          <th style="width: 15%; text-align: right;">Nominal (Rp)</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pettyCashes as $index => $pc)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ $pc->expense_date ? \Carbon\Carbon::parse($pc->expense_date)->format('d/m/Y') : $pc->created_at->format('d/m/Y') }}</td>
            <td class="text-center"><span style="background: #f3f4f6; padding: 2px 6px; border-radius: 4px; font-size: 7.5pt;">{{ $pc->category ?? 'Operasional' }}</span></td>
            <td class="text-left">{{ $pc->description }}</td>
            <td class="text-center">{{ $pc->cashier->name ?? 'Kasir' }}</td>
            <td class="text-right font-monospace fw-bold">Rp {{ number_format($pc->amount, 0, ',', '.') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center" style="color: #6b7280; padding: 12px;">Tidak ada catatan petty cash pada periode ini.</td>
          </tr>
        @endforelse
      </tbody>
      <tfoot>
        <tr style="background: #f3f4f6; font-weight: 700;">
          <td colspan="5" class="text-center">TOTAL PENGELUARAN PETTY CASH</td>
          <td class="text-right" style="color: #dc2626;">Rp {{ number_format($totalPettyCash, 0, ',', '.') }}</td>
        </tr>
      </tfoot>
    </table>

    <!-- 4. DAFTAR TRANSAKSI PENJUALAN KASIR -->
    <div class="section-title">
      <span>4. Rincian Transaksi Penjualan & Kasir (50 Trx Terbaru)</span>
      <span style="font-size: 8pt; font-weight: normal; color: #4b5563;">Total {{ $transactions->count() }} Transaksi Tercatat</span>
    </div>

    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 14%;">ID Transaksi</th>
          <th style="width: 16%;">Waktu</th>
          <th style="width: 25%; text-align: left;">Pelanggan</th>
          <th style="width: 12%;">Metode</th>
          <th style="width: 12%;">Status</th>
          <th style="width: 16%; text-align: right;">Total (Rp)</th>
        </tr>
      </thead>
      <tbody>
        @forelse($transactions->take(50) as $index => $trx)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center font-monospace">TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
            <td class="text-center">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
            <td class="text-left fw-bold">{{ $trx->customer_name ?? ($trx->customer->name ?? 'Pelanggan Walk-in') }}</td>
            <td class="text-center">{{ strtoupper($trx->payment_method ?? 'Cash') }}</td>
            <td class="text-center">
              <span style="font-weight: 700; color: {{ $trx->payment_status === 'paid' ? '#047857' : '#b45309' }};">
                {{ strtoupper($trx->payment_status ?? 'PAID') }}
              </span>
            </td>
            <td class="text-right font-monospace fw-bold">Rp {{ number_format($trx->final_amount, 0, ',', '.') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center" style="color: #6b7280; padding: 12px;">Tidak ada catatan transaksi penjualan.</td>
          </tr>
        @endforelse
      </tbody>
      <tfoot>
        <tr style="background: #f3f4f6; font-weight: 700;">
          <td colspan="6" class="text-center">TOTAL NILAI TRANSAKSI KASIR TERCATAT</td>
          <td class="text-right" style="color: #047857;">Rp {{ number_format($transactions->sum('final_amount'), 0, ',', '.') }}</td>
        </tr>
      </tfoot>
    </table>

    <!-- LEMBAR PENGESAHAN & TANDA TANGAN -->
    <div class="signatures">
      <div class="sign-box">
        <div>Dibuat & Diverifikasi Oleh,</div>
        <div class="sign-role">Supervisor / Kasir Operasional</div>
        <div class="sign-space"></div>
        <div class="sign-name">( ............................................ )</div>
        <div class="sign-role">Petugas Keuangan Cabang</div>
      </div>

      <div class="sign-box">
        <div>Jakarta Barat, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
        <div>Mengetahui & Menyetujui,</div>
        <div class="sign-role">Owner District Studio</div>
        <div class="sign-space"></div>
        <div class="sign-name">{{ auth()->user()->role === 'owner' ? auth()->user()->name : '( ............................................ )' }}</div>
        <div class="sign-role">Executive Business Owner</div>
      </div>
    </div>

  </div>

</body>
</html>
