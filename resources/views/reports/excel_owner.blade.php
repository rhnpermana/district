<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <?php
    echo '<!--[if gte mso 9]><xml><' . 'x:ExcelWorkbook><' . 'x:ExcelWorksheets><' . 'x:ExcelWorksheet><' . 'x:Name>Laporan Eksekutif</' . 'x:Name><' . 'x:WorksheetOptions><' . 'x:DisplayGridlines/></' . 'x:WorksheetOptions></' . 'x:ExcelWorksheet></' . 'x:ExcelWorksheets></' . 'x:ExcelWorkbook></xml><![endif]-->';
  ?>
  <style>
    body { font-family: 'Calibri', 'Arial', sans-serif; font-size: 11pt; }
    table { border-collapse: collapse; margin-bottom: 20px; }
    th { border: 1px solid #000000; padding: 6px 10px; font-weight: bold; }
    td { border: 1px solid #000000; padding: 5px 8px; vertical-align: middle; }
    .header-gold { background-color: #dca53e; color: #000000; font-weight: bold; text-align: center; }
    .header-dark { background-color: #1f2937; color: #ffffff; font-weight: bold; font-size: 12pt; text-align: left; }
    .header-gray { background-color: #e5e7eb; font-weight: bold; text-align: center; }
    .title-main { font-size: 16pt; font-weight: bold; text-align: center; }
    .title-sub { font-size: 11pt; color: #4b5563; text-align: center; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .fw-bold { font-weight: bold; }
    .highlight-net { background-color: #dcfce7; color: #065f46; font-weight: bold; }
    .danger-row { background-color: #fee2e2; color: #991b1b; }
    .num { mso-number-format:"\#\,\#\#0"; text-align: right; }
  </style>
</head>
<body>

  <!-- KOP & METADATA -->
  <table style="width: 100%;">
    <tr>
      <td colspan="7" class="title-main" style="border: none;">DISTRICT STUDIO BARBERSHOP & EXECUTIVE GROOMING</td>
    </tr>
    <tr>
      <td colspan="7" class="title-sub" style="border: none;">LAPORAN EKSEKUTIF KEUANGAN & OPERASIONAL</td>
    </tr>
    <tr>
      <td colspan="7" class="text-center" style="border: none; font-size: 9pt; color: #6b7280;">District Studio Jakarta Barat (SMKN 17 Slipi) | Telp/WA: 0812-3456-7890 | Website: www.districtstudio.id</td>
    </tr>
    <tr><td colspan="7" style="border: none;"></td></tr>
    <tr>
      <td colspan="2" style="border: 1px solid #000; background: #f3f4f6;"><strong>Periode Laporan:</strong></td>
      <td colspan="5" style="border: 1px solid #000;">{{ $periodLabel }}</td>
    </tr>
    <tr>
      <td colspan="2" style="border: 1px solid #000; background: #f3f4f6;"><strong>Tanggal & Waktu Cetak:</strong></td>
      <td colspan="5" style="border: 1px solid #000;">{{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</td>
    </tr>
    <tr>
      <td colspan="2" style="border: 1px solid #000; background: #f3f4f6;"><strong>Dicetak Oleh:</strong></td>
      <td colspan="5" style="border: 1px solid #000;">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</td>
    </tr>
  </table>

  <br>

  <!-- 1. RINGKASAN FINANSIAL -->
  <table style="width: 100%;">
    <tr>
      <th colspan="3" class="header-dark">1. RINGKASAN METRIK KINERJA FINANSIAL</th>
    </tr>
    <tr class="header-gray">
      <th style="width: 5%;">No</th>
      <th style="width: 65%;">Komponen Finansial</th>
      <th style="width: 30%;">Total Nominal (Rp)</th>
    </tr>
    <tr>
      <td class="text-center">1</td>
      <td>Pendapatan Layanan Pangkas & Treatment (Service Revenue)</td>
      <td class="num">{{ $serviceRevenue }}</td>
    </tr>
    <tr>
      <td class="text-center">2</td>
      <td>Pendapatan Penjualan Produk Grooming (Product Retail)</td>
      <td class="num">{{ $productRevenue }}</td>
    </tr>
    <tr style="background-color: #fef3c7; font-weight: bold;">
      <td class="text-center">3</td>
      <td>TOTAL OMZET KOTOR (GROSS REVENUE)</td>
      <td class="num" style="color: #92400e;">{{ $grossOmzet }}</td>
    </tr>
    <tr class="danger-row">
      <td class="text-center">4</td>
      <td>Beban Operasional Kas Kecil (Petty Cash Expenses)</td>
      <td class="num">( {{ $totalPettyCash }} )</td>
    </tr>
    <tr class="danger-row">
      <td class="text-center">5</td>
      <td>Beban Pembagian Komisi Hair Stylist (Total Barber Commission)</td>
      <td class="num">( {{ $totalCommissions }} )</td>
    </tr>
    <tr class="highlight-net">
      <td class="text-center">6</td>
      <td><strong>PROFIT BERSIH (NET PROFIT SETELAH BEBAN OPERASIONAL & KOMISI)</strong></td>
      <td class="num" style="font-size: 12pt; color: #065f46;"><strong>{{ $netProfit }}</strong></td>
    </tr>
  </table>

  <br>

  <!-- 2. PRODUKTIVITAS & KOMISI HAIR STYLIST -->
  <table style="width: 100%;">
    <tr>
      <th colspan="6" class="header-dark">2. REKAPITULASI PRODUKTIVITAS & KOMISI HAIR STYLIST</th>
    </tr>
    <tr class="header-gold">
      <th style="width: 5%;">No</th>
      <th style="width: 30%;">Nama Hair Stylist</th>
      <th style="width: 15%;">Sesi Selesai</th>
      <th style="width: 20%;">Total Omzet Pengerjaan (Rp)</th>
      <th style="width: 12%;">Rate Komisi (%)</th>
      <th style="width: 18%;">Hak Komisi Bersih (Rp)</th>
    </tr>
    @forelse($stylists as $index => $s)
      <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td class="fw-bold">{{ $s->name }}</td>
        <td class="text-center">{{ $s->completed_count }} Sesi</td>
        <td class="num">{{ $s->total_revenue }}</td>
        <td class="text-center">{{ $s->commission_rate ?? 30 }}%</td>
        <td class="num fw-bold" style="color: #047857;">{{ $s->total_commission }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="6" class="text-center">Tidak ada data aktivitas hair stylist.</td>
      </tr>
    @endforelse
    <tr class="header-gray">
      <td colspan="3" class="text-center fw-bold">TOTAL KOMISI KESELURUHAN</td>
      <td class="num fw-bold">{{ $stylists->sum('total_revenue') }}</td>
      <td class="text-center">-</td>
      <td class="num fw-bold" style="color: #047857;">{{ $totalCommissions }}</td>
    </tr>
  </table>

  <br>

  <!-- 3. BEBAN KAS KECIL (PETTY CASH) -->
  <table style="width: 100%;">
    <tr>
      <th colspan="6" class="header-dark">3. RINCIAN PENGELUARAN PETTY CASH (KAS KECIL)</th>
    </tr>
    <tr class="header-gray">
      <th style="width: 5%;">No</th>
      <th style="width: 14%;">Tanggal</th>
      <th style="width: 18%;">Kategori</th>
      <th style="width: 33%;">Deskripsi Pengeluaran</th>
      <th style="width: 15%;">Kasir / Petugas</th>
      <th style="width: 15%;">Nominal (Rp)</th>
    </tr>
    @forelse($pettyCashes as $index => $pc)
      <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td class="text-center">{{ $pc->expense_date ? \Carbon\Carbon::parse($pc->expense_date)->format('d/m/Y') : $pc->created_at->format('d/m/Y') }}</td>
        <td class="text-center">{{ $pc->category ?? 'Operasional' }}</td>
        <td>{{ $pc->description }}</td>
        <td class="text-center">{{ $pc->cashier->name ?? 'Kasir' }}</td>
        <td class="num">{{ $pc->amount }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="6" class="text-center">Tidak ada catatan petty cash.</td>
      </tr>
    @endforelse
    <tr class="header-gray">
      <td colspan="5" class="text-center fw-bold">TOTAL PENGELUARAN KAS KECIL</td>
      <td class="num fw-bold" style="color: #dc2626;">{{ $totalPettyCash }}</td>
    </tr>
  </table>

  <br>

  <!-- 4. DAFTAR TRANSAKSI PENJUALAN -->
  <table style="width: 100%;">
    <tr>
      <th colspan="7" class="header-dark">4. DAFTAR TRANSAKSI PENJUALAN & PEMBAYARAN KASIR</th>
    </tr>
    <tr class="header-gold">
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
        <td class="text-center">TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
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
      <td colspan="6" class="text-center fw-bold">TOTAL PENERIMAAN TRANSAKSI</td>
      <td class="num fw-bold" style="color: #047857;">{{ $transactions->sum('final_amount') }}</td>
    </tr>
  </table>

</body>
</html>
