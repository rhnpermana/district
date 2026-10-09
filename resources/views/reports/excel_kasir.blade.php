<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <?php
    echo '<!--[if gte mso 9]><xml><' . 'x:ExcelWorkbook><' . 'x:ExcelWorksheets><' . 'x:ExcelWorksheet><' . 'x:Name>Laporan Penjualan Kasir</' . 'x:Name><' . 'x:WorksheetOptions><' . 'x:DisplayGridlines/></' . 'x:WorksheetOptions></' . 'x:ExcelWorksheet></' . 'x:ExcelWorksheets></' . 'x:ExcelWorkbook></xml><![endif]-->';
  ?>
  <style>
    body { font-family: 'Calibri', 'Arial', sans-serif; font-size: 11pt; }
    table { border-collapse: collapse; margin-bottom: 20px; }
    th { border: 1px solid #000000; padding: 6px 10px; font-weight: bold; }
    td { border: 1px solid #000000; padding: 5px 8px; vertical-align: middle; }
    .header-green { background-color: #28a745; color: #ffffff; font-weight: bold; text-align: center; }
    .header-dark { background-color: #1f2937; color: #ffffff; font-weight: bold; font-size: 12pt; text-align: left; }
    .header-gray { background-color: #e5e7eb; font-weight: bold; text-align: center; }
    .title-main { font-size: 16pt; font-weight: bold; text-align: center; }
    .title-sub { font-size: 11pt; color: #4b5563; text-align: center; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .fw-bold { font-weight: bold; }
    .highlight-row { background-color: #dcfce7; color: #065f46; font-weight: bold; }
    .danger-row { background-color: #fee2e2; color: #991b1b; }
    .num { mso-number-format:"\#\,\#\#0"; text-align: right; }
  </style>
</head>
<body>

  <!-- KOP & METADATA -->
  <table style="width: 100%;">
    <tr>
      <td colspan="7" class="title-main" style="border: none;">DISTRICT STUDIO BARBERSHOP & GROOMING</td>
    </tr>
    <tr>
      <td colspan="7" class="title-sub" style="border: none;">LAPORAN HASIL PENJUALAN & SETTLEMENT KASIR (POS)</td>
    </tr>
    <tr>
      <td colspan="7" class="text-center" style="border: none; font-size: 9pt; color: #6b7280;">District Studio Jakarta Barat (SMKN 17 Slipi) | Telp/WA: 0812-3456-7890</td>
    </tr>
    <tr><td colspan="7" style="border: none;"></td></tr>
    <tr>
      <td colspan="2" style="border: 1px solid #000; background: #f3f4f6;"><strong>Periode Penjualan:</strong></td>
      <td colspan="5" style="border: 1px solid #000;">{{ $periodLabel }}</td>
    </tr>
    <tr>
      <td colspan="2" style="border: 1px solid #000; background: #f3f4f6;"><strong>Tanggal & Waktu Cetak:</strong></td>
      <td colspan="5" style="border: 1px solid #000;">{{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</td>
    </tr>
    <tr>
      <td colspan="2" style="border: 1px solid #000; background: #f3f4f6;"><strong>Operator Kasir:</strong></td>
      <td colspan="5" style="border: 1px solid #000;">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</td>
    </tr>
  </table>

  <br>

  <!-- 1. RINGKASAN SETTLEMENT -->
  <table style="width: 100%;">
    <tr>
      <th colspan="3" class="header-dark">1. RINGKASAN PENERIMAAN KAS & SETTLEMENT HASIL PENJUALAN</th>
    </tr>
    <tr class="header-gray">
      <th style="width: 5%;">No</th>
      <th style="width: 65%;">Komponen Penerimaan & Penjualan</th>
      <th style="width: 30%;">Total Nominal (Rp)</th>
    </tr>
    <tr>
      <td class="text-center">1</td>
      <td>Penerimaan Tunai (Cash Inflow)</td>
      <td class="num">{{ $cashTotal }}</td>
    </tr>
    <tr>
      <td class="text-center">2</td>
      <td>Penerimaan QRIS Digital (QRIS Inflow)</td>
      <td class="num">{{ $qrisTotal }}</td>
    </tr>
    @if($otherTotal > 0)
      <tr>
        <td class="text-center">3</td>
        <td>Penerimaan Transfer Bank / EDC Lainnya</td>
        <td class="num">{{ $otherTotal }}</td>
      </tr>
    @endif
    <tr style="background-color: #fef3c7; font-weight: bold;">
      <td class="text-center">4</td>
      <td>TOTAL OMZET PENJUALAN KASIR (GROSS SALES)</td>
      <td class="num" style="color: #92400e;">{{ $totalOmzet }}</td>
    </tr>
    <tr class="danger-row">
      <td class="text-center">5</td>
      <td>Pengeluaran Kas Kecil Operasional (Petty Cash Shift)</td>
      <td class="num">( {{ $totalPettyCash }} )</td>
    </tr>
    <tr class="highlight-row">
      <td class="text-center">6</td>
      <td><strong>SETTLEMENT UANG TUNAI FISIK LACI KASIR (NET CASH DRAWER)</strong></td>
      <td class="num" style="font-size: 12pt; color: #065f46;"><strong>{{ $netCashDrawer }}</strong></td>
    </tr>
  </table>

  <br>

  <!-- 2. PENGELUARAN PETTY CASH -->
  @if($pettyCashes->isNotEmpty())
    <table style="width: 100%;">
      <tr>
        <th colspan="5" class="header-dark">2. RINCIAN PENGELUARAN KAS KECIL (PETTY CASH)</th>
      </tr>
      <tr class="header-gray">
        <th style="width: 5%;">No</th>
        <th style="width: 18%;">Tanggal</th>
        <th style="width: 22%;">Kategori</th>
        <th style="width: 35%;">Deskripsi Pengeluaran</th>
        <th style="width: 20%;">Nominal (Rp)</th>
      </tr>
      @foreach($pettyCashes as $index => $pc)
        <tr>
          <td class="text-center">{{ $index + 1 }}</td>
          <td class="text-center">{{ $pc->expense_date ? \Carbon\Carbon::parse($pc->expense_date)->format('d/m/Y') : $pc->created_at->format('d/m/Y') }}</td>
          <td class="text-center">{{ $pc->category ?? 'Operasional' }}</td>
          <td>{{ $pc->description }}</td>
          <td class="num">{{ $pc->amount }}</td>
        </tr>
      @endforeach
      <tr class="header-gray">
        <td colspan="4" class="text-center fw-bold">TOTAL PENGELUARAN KAS KECIL</td>
        <td class="num fw-bold" style="color: #dc2626;">{{ $totalPettyCash }}</td>
      </tr>
    </table>
    <br>
  @endif

  <!-- 3. DAFTAR TRANSAKSI PENJUALAN -->
  <table style="width: 100%;">
    <tr>
      <th colspan="7" class="header-dark">{{ $pettyCashes->isNotEmpty() ? '3' : '2' }}. DAFTAR TRANSAKSI PENJUALAN KASIR</th>
    </tr>
    <tr class="header-green">
      <th style="width: 5%;">No</th>
      <th style="width: 14%;">ID Transaksi</th>
      <th style="width: 16%;">Waktu Transaksi</th>
      <th style="width: 25%;">Nama Pelanggan</th>
      <th style="width: 12%;">Metode</th>
      <th style="width: 12%;">Status</th>
      <th style="width: 16%;">Total (Rp)</th>
    </tr>
    @forelse($transactions as $index => $trx)
      <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td class="text-center">#POS-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
        <td class="text-center">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
        <td class="fw-bold">{{ $trx->customer_name ?? ($trx->customer->name ?? 'Pelanggan Walk-in') }}</td>
        <td class="text-center">{{ strtoupper($trx->payment_method ?? 'Cash') }}</td>
        <td class="text-center">{{ strtoupper($trx->payment_status ?? 'PAID') }}</td>
        <td class="num">{{ $trx->final_amount }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="7" class="text-center">Tidak ada catatan transaksi penjualan.</td>
      </tr>
    @endforelse
    <tr class="header-gray">
      <td colspan="6" class="text-center fw-bold">TOTAL HASIL PENJUALAN LUNAS</td>
      <td class="num fw-bold" style="color: #047857;">{{ $totalOmzet }}</td>
    </tr>
  </table>

</body>
</html>
