<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Hasil Penjualan & Kasir – District Studio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      font-size: 11pt;
      line-height: 1.45;
      color: #1a1a1a;
      background-color: #f4f4f5;
    }

    /* Top Action Bar */
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
      max-width: 1050px;
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
    .btn-primary { background: #28a745; color: #fff; }
    .btn-primary:hover { background: #218838; }
    .btn-excel { background: #107c41; color: #fff; }
    .btn-excel:hover { background: #0c5e31; }
    .btn-outline { background: transparent; color: #e4e4e7; border: 1px solid rgba(255,255,255,0.2); }
    .btn-outline:hover { background: rgba(255,255,255,0.1); }
    
    .filter-form {
      display: flex;
      align-items: center;
      gap: 6px;
      flex-wrap: wrap;
      font-size: 0.8rem;
    }
    .filter-form select, .filter-form input {
      padding: 6px 10px;
      border-radius: 4px;
      border: 1px solid #3f3f46;
      background: #27272a;
      color: #fff;
      font-size: 0.78rem;
    }

    /* Paper Page Layout (Formal A4) */
    .page-container {
      max-width: 210mm;
      margin: 24px auto;
      background: #ffffff;
      padding: 20mm 20mm;
      box-shadow: 0 0 20px rgba(0,0,0,0.08);
      border-radius: 4px;
    }

    /* Kop Surat Resmi */
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
      color: #28a745;
      font-weight: 900;
      font-family: 'Montserrat', sans-serif;
      flex-shrink: 0;
      border: 2px solid #28a745;
    }
    .kop-logo span { font-size: 1.1rem; letter-spacing: 1px; color: #fff; }
    .kop-logo small { font-size: 0.5rem; letter-spacing: 2px; color: #28a745; }
    .kop-text { flex: 1; text-align: center; }
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
      color: #15803d;
      text-transform: uppercase;
      margin-bottom: 4px;
    }
    .kop-text p {
      font-size: 8.5pt;
      color: #4b5563;
      line-height: 1.35;
    }

    /* Metadata Box */
    .doc-meta {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 20px;
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

    /* Section Title */
    .section-title {
      font-size: 10.5pt;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #111827;
      border-bottom: 1.5px solid #111827;
      padding-bottom: 4px;
      margin: 18px 0 10px 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    /* Summary Table */
    .summary-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 16px;
    }
    .summary-table th, .summary-table td {
      border: 1px solid #d1d5db;
      padding: 7px 10px;
      font-size: 9.5pt;
    }
    .summary-table th { background: #f3f4f6; font-weight: 700; text-align: left; }
    .summary-table .nominal { text-align: right; font-weight: 700; font-family: 'Montserrat', sans-serif; }
    .highlight-row { background: #ecfdf5; color: #065f46; font-weight: 800; }

    /* Data Table */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 16px;
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
    .data-table tbody tr:nth-child(even) { background: #fafafa; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .fw-bold { font-weight: 700; }

    /* Signatures */
    .signatures {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
      padding-top: 10px;
      page-break-inside: avoid;
    }
    .sign-box { width: 42%; text-align: center; font-size: 9pt; }
    .sign-space { height: 60px; }
    .sign-name { font-weight: 800; text-decoration: underline; text-transform: uppercase; }
    .sign-role { font-size: 8pt; color: #4b5563; }

    /* Print Styles */
    @media print {
      body { background: #ffffff; color: #000; font-size: 10pt; }
      .no-print-bar { display: none !important; }
      .page-container {
        max-width: 100%;
        margin: 0;
        padding: 0;
        box-shadow: none;
        border-radius: 0;
      }
      @page { size: A4 portrait; margin: 15mm; }
      .summary-table th, .data-table th {
        background-color: #f0f0f0 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
      .highlight-row {
        background-color: #e6f7ee !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
    }
  </style>
</head>
<body>

  <!-- Top Action & Filter Toolbar -->
  <div class="no-print-bar">
    <div class="container">
      <div style="display: flex; align-items: center; gap: 10px;">
        <a href="{{ route('dashboard') }}" class="btn btn-outline">
          <i class="bi bi-arrow-left"></i> Kasir Dashboard
        </a>
        <span style="font-weight: 700; font-size: 0.9rem; color: #28a745;">
          <i class="bi bi-receipt me-1"></i> Laporan Hasil Penjualan Kasir (POS)
        </span>
      </div>

      <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <!-- Date / Month / Year Filter -->
        <form action="{{ route('pos.reports.print') }}" method="GET" class="filter-form">
          <select name="preset" onchange="this.form.submit()">
            <option value="">-- Periode Cepat --</option>
            <option value="today" {{ $preset === 'today' ? 'selected' : '' }}>Hari Ini</option>
            <option value="yesterday" {{ $preset === 'yesterday' ? 'selected' : '' }}>Kemarin</option>
            <option value="this_week" {{ $preset === 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
            <option value="this_month" {{ $preset === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
            <option value="last_month" {{ $preset === 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
            <option value="this_year" {{ $preset === 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
          </select>

          <input type="date" name="start_date" value="{{ $startDate }}" title="Dari Tanggal">
          <input type="date" name="end_date" value="{{ $endDate }}" title="Sampai Tanggal">

          <button type="submit" class="btn btn-outline" style="padding: 6px 12px;">
            <i class="bi bi-funnel-fill"></i> Filter
          </button>
        </form>

        <!-- Excel Export Button -->
        <a href="{{ route('pos.reports.export_excel', ['start_date' => $startDate, 'end_date' => $endDate, 'preset' => $preset]) }}" class="btn btn-excel">
          <i class="bi bi-file-earmark-excel-fill"></i> Unduh Excel (.xls)
        </a>

        <!-- Print / PDF Button -->
        <button onclick="window.print()" class="btn btn-primary">
          <i class="bi bi-printer-fill"></i> Cetak / Simpan PDF
        </button>
      </div>
    </div>
  </div>

  <!-- A4 Document Container -->
  <div class="page-container">

    <!-- Formal Letterhead (KOP SURAT) -->
    <div class="kop-surat">
      <div class="kop-logo">
        <span>DISTRICT</span>
        <small>POS KASIR</small>
      </div>
      <div class="kop-text">
        <h1>DISTRICT STUDIO BARBERSHOP</h1>
        <h2>Laporan Hasil Penjualan & Settlement Shift Kasir</h2>
        <p>
          District Studio Jakarta Barat (SMKN 17 Slipi) &bull; Jl. Slipi Dalam, Palmerah, Jakarta Barat 11410<br>
          Layanan Pelanggan & WA: 0812-3456-7890 &bull; Website: www.districtstudio.id
        </p>
      </div>
    </div>

    <!-- Metadata Dokumen -->
    <div class="doc-meta">
      <div>
        <div class="doc-title">LAPORAN HASIL PENJUALAN KASIR & POS</div>
        <div><strong>Periode Penjualan:</strong> {{ $periodLabel }}</div>
        <div><strong>Unit Kasir:</strong> District Studio Jakarta Barat (SMKN 17 Slipi)</div>
      </div>
      <div style="text-align: right;">
        <div><strong>No. Dokumen:</strong> DS/POS-REP/{{ date('Y') }}/{{ date('m') }}/{{ str_pad(auth()->id(), 3, '0', STR_PAD_LEFT) }}</div>
        <div><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</div>
        <div><strong>Operator Kasir:</strong> {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</div>
      </div>
    </div>

    <!-- 1. RINGKASAN SETTLEMENT PENJUALAN -->
    <div class="section-title">
      <span>1. Ringkasan Penerimaan Kas & Settlement Shift</span>
      <span style="font-size: 8pt; font-weight: normal; color: #4b5563;">Status: Lunas (Paid)</span>
    </div>

    <table class="summary-table">
      <thead>
        <tr>
          <th style="width: 70%;">Komponen Penerimaan & Penjualan</th>
          <th style="width: 30%; text-align: right;">Total Nominal (Rp)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <strong>Penerimaan Tunai (Cash Payments)</strong><br>
            <small style="color: #6b7280;">Uang fisik masuk laci kasir dari pembayaran tunai</small>
          </td>
          <td class="nominal" style="color: #15803d;">Rp {{ number_format($cashTotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td>
            <strong>Penerimaan Non-Tunai QRIS Digital (QRIS Payments)</strong><br>
            <small style="color: #6b7280;">Pembayaran digital QRIS Gopay, OVO, Dana, BCA, dll.</small>
          </td>
          <td class="nominal" style="color: #0369a1;">Rp {{ number_format($qrisTotal, 0, ',', '.') }}</td>
        </tr>
        @if($otherTotal > 0)
          <tr>
            <td><strong>Penerimaan Transfer Bank / EDC Lainnya</strong></td>
            <td class="nominal">Rp {{ number_format($otherTotal, 0, ',', '.') }}</td>
          </tr>
        @endif
        <tr style="background: #f9fafb;">
          <td>
            <strong>TOTAL OMZET HASIL PENJUALAN (GROSS SALES)</strong><br>
            <small style="color: #6b7280;">Total {{ $paidTransactions->count() }} transaksi lunas ({{ $serviceCount }} item layanan + {{ $productCount }} produk)</small>
          </td>
          <td class="nominal" style="color: #b45309; font-size: 10.5pt;">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td>
            <strong>Pengeluaran Kas Kecil Operasional (Petty Cash Shift)</strong><br>
            <small style="color: #6b7280;">Pengeluaran darurat/harian yang diambil dari laci kasir</small>
          </td>
          <td class="nominal" style="color: #dc2626;">( Rp {{ number_format($totalPettyCash, 0, ',', '.') }} )</td>
        </tr>
        <tr class="highlight-row">
          <td>
            <strong>SETTLEMENT UANG TUNAI FISIK LACI KASIR (NET CASH IN DRAWER)</strong><br>
            <small style="font-weight: 500; color: #047857;">Uang tunai yang wajib diserahkan = Penerimaan Cash - Pengeluaran Petty Cash</small>
          </td>
          <td class="nominal" style="color: #065f46; font-size: 11pt;">Rp {{ number_format($netCashDrawer, 0, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>

    <!-- 2. PENGELUARAN PETTY CASH SHIFT -->
    @if($pettyCashes->isNotEmpty())
      <div class="section-title">
        <span>2. Rincian Kas Kecil / Petty Cash (Total {{ $pettyCashes->count() }} Pengeluaran)</span>
      </div>
      <table class="data-table">
        <thead>
          <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tanggal</th>
            <th style="width: 20%;">Kategori</th>
            <th style="width: 42%; text-align: left;">Deskripsi</th>
            <th style="width: 18%; text-align: right;">Nominal (Rp)</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pettyCashes as $index => $pc)
            <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td class="text-center">{{ $pc->expense_date ? \Carbon\Carbon::parse($pc->expense_date)->format('d/m/Y') : $pc->created_at->format('d/m/Y') }}</td>
              <td class="text-center">{{ $pc->category ?? 'Operasional' }}</td>
              <td>{{ $pc->description }}</td>
              <td class="text-right font-monospace fw-bold">Rp {{ number_format($pc->amount, 0, ',', '.') }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr style="background: #f3f4f6; font-weight: 700;">
            <td colspan="4" class="text-center">TOTAL KAS KECIL</td>
            <td class="text-right" style="color: #dc2626;">Rp {{ number_format($totalPettyCash, 0, ',', '.') }}</td>
          </tr>
        </tfoot>
      </table>
    @endif

    <!-- 3. RINCIAN TRANSAKSI PENJUALAN -->
    <div class="section-title">
      <span>{{ $pettyCashes->isNotEmpty() ? '3' : '2' }}. Daftar Rincian Transaksi Penjualan Kasir</span>
      <span style="font-size: 8pt; font-weight: normal; color: #4b5563;">Total {{ $transactions->count() }} Transaksi</span>
    </div>

    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 13%;">ID Transaksi</th>
          <th style="width: 15%;">Waktu</th>
          <th style="width: 25%; text-align: left;">Nama Pelanggan</th>
          <th style="width: 12%;">Metode</th>
          <th style="width: 12%;">Status</th>
          <th style="width: 18%; text-align: right;">Total Bayar (Rp)</th>
        </tr>
      </thead>
      <tbody>
        @forelse($transactions as $index => $trx)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center font-monospace">#POS-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
            <td class="text-center">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
            <td class="text-left fw-bold">{{ $trx->customer_name ?? ($trx->customer->name ?? 'Pelanggan Walk-in') }}</td>
            <td class="text-center">{{ strtoupper($trx->payment_method ?? 'Cash') }}</td>
            <td class="text-center">
              <span style="font-weight: 700; color: {{ $trx->payment_status === 'paid' ? '#047857' : '#dc2626' }};">
                {{ strtoupper($trx->payment_status ?? 'PAID') }}
              </span>
            </td>
            <td class="text-right font-monospace fw-bold">Rp {{ number_format($trx->final_amount, 0, ',', '.') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center" style="color: #6b7280; padding: 12px;">Tidak ada catatan transaksi pada periode ini.</td>
          </tr>
        @endforelse
      </tbody>
      <tfoot>
        <tr style="background: #f3f4f6; font-weight: 700;">
          <td colspan="6" class="text-center">TOTAL HASIL PENJUALAN LUNAS</td>
          <td class="text-right" style="color: #047857;">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
        </tr>
      </tfoot>
    </table>

    <!-- LEMBAR PENGESAHAN -->
    <div class="signatures">
      <div class="sign-box">
        <div>Diserahkan Oleh,</div>
        <div class="sign-role">Operator Kasir Shift</div>
        <div class="sign-space"></div>
        <div class="sign-name">{{ auth()->user()->name }}</div>
        <div class="sign-role">Petugas Kasir</div>
      </div>

      <div class="sign-box">
        <div>Diterima & Diverifikasi Oleh,</div>
        <div class="sign-role">Supervisor / Owner Barbershop</div>
        <div class="sign-space"></div>
        <div class="sign-name">( ............................................ )</div>
        <div class="sign-role">Penanggung Jawab Cabang</div>
      </div>
    </div>

  </div>

</body>
</html>
