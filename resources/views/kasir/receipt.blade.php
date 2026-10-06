<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struk Pembayaran #POS-{{ $transaction->id }} — District Studio</title>
  <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Inter:wght@400;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: #18181b;
      font-family: 'Courier Prime', 'Courier New', monospace;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 30px 16px 60px;
      min-height: 100vh;
      color: #000;
    }

    /* ── Action Toolbar (Screen Only) ── */
    .action-bar {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      justify-content: center;
      margin-bottom: 24px;
      padding: 14px 20px;
      background: #27272a;
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 10px;
      width: 100%;
      max-width: 400px;
    }
    .btn-action {
      text-decoration: none;
      padding: 9px 16px;
      font-family: 'Inter', sans-serif;
      font-weight: 700;
      border-radius: 6px;
      font-size: 0.8rem;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      border: none;
      transition: opacity 0.2s;
    }
    .btn-action:hover { opacity: 0.88; }
    .btn-print  { background: #ffffff; color: #000000; border: 1px solid #000; font-weight: 800; }
    .btn-wa     { background: #25d366; color: #ffffff; }
    .btn-back   { background: #3f3f46; color: #ffffff; }

    /* ── Formal Black & White Thermal Receipt ── */
    .receipt-container {
      background: #ffffff;
      color: #000000;
      width: 100%;
      max-width: 380px;
      padding: 28px 24px 32px;
      border-radius: 4px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.5);
      border: 1px solid #000000;
    }

    /* Header */
    .receipt-header {
      text-align: center;
      padding-bottom: 12px;
    }
    .brand-title {
      font-family: 'Montserrat', sans-serif;
      font-size: 17px;
      font-weight: 900;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: #000000;
    }
    .brand-subtitle {
      font-family: 'Inter', sans-serif;
      font-size: 9px;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: #333333;
      margin: 2px 0 4px;
    }
    .brand-address {
      font-size: 9.5px;
      color: #444444;
      line-height: 1.35;
    }

    /* Line Dividers */
    .divider-double {
      border-top: 2px solid #000000;
      border-bottom: 1px solid #000000;
      height: 3px;
      margin: 10px 0;
    }
    .divider-dashed {
      border-top: 1px dashed #000000;
      margin: 10px 0;
    }
    .divider-solid {
      border-top: 1px solid #000000;
      margin: 8px 0;
    }

    /* Meta Info */
    .receipt-info {
      font-size: 10.5px;
      line-height: 1.5;
    }
    .info-row {
      display: flex;
      justify-content: space-between;
    }

    /* Items Table */
    .items-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 10.5px;
      margin: 8px 0;
    }
    .items-table th {
      text-align: left;
      font-weight: 700;
      padding: 4px 0;
      border-bottom: 1px dashed #000000;
      font-size: 10px;
      text-transform: uppercase;
    }
    .items-table td {
      padding: 5px 0;
      vertical-align: top;
    }
    .item-name {
      font-weight: 700;
      color: #000000;
    }
    .item-desc {
      font-size: 9.5px;
      color: #555555;
    }

    /* Totals */
    .total-section {
      font-size: 11px;
      line-height: 1.6;
    }
    .total-row {
      display: flex;
      justify-content: space-between;
    }
    .total-grand {
      font-size: 13px;
      font-weight: 700;
      border-top: 1px solid #000000;
      border-bottom: 1px solid #000000;
      padding: 4px 0;
      margin: 6px 0;
    }

    /* Payment & Status Stamp */
    .status-stamp {
      text-align: center;
      margin: 12px 0 6px;
    }
    .stamp-box {
      display: inline-block;
      border: 2px solid #000000;
      padding: 4px 18px;
      font-family: 'Montserrat', sans-serif;
      font-weight: 900;
      font-size: 12px;
      letter-spacing: 2px;
      text-transform: uppercase;
    }

    /* Footer */
    .receipt-footer {
      text-align: center;
      font-size: 9.5px;
      color: #333333;
      line-height: 1.4;
      margin-top: 10px;
    }
    .qr-container {
      margin: 8px auto;
      text-align: center;
    }

    /* Print Overrides */
    @media print {
      * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
      body {
        background: #ffffff !important;
        padding: 0 !important;
        display: block;
        width: 100%;
        margin: 0;
        font-size: 10px;
        color: #000000;
      }
      .no-print { display: none !important; }
      .receipt-container {
        max-width: 78mm;
        width: 78mm;
        margin: 0 auto;
        padding: 10px 8px;
        border: none;
        box-shadow: none;
      }
      @page {
        size: 80mm auto;
        margin: 2mm;
      }
    }
  </style>
</head>
<body>

  {{-- ── Action Toolbar (Screen Only) ── --}}
  <div class="action-bar no-print">
    <button onclick="window.print()" class="btn-action btn-print">
      🖨️ Cetak Struk Formal (B&W)
    </button>

    @php
      $waMessage = "*DISTRICT STUDIO BARBERSHOP*\n"
        . "Executive Grooming & Hair Service\n"
        . "SMKN 17 Slipi, Jakarta Barat\n"
        . "--------------------------------\n"
        . "No. Struk : #POS-" . $transaction->id . "\n"
        . "Waktu     : " . $transaction->created_at->format('d/m/Y H:i') . " WIB\n"
        . "Kasir     : " . ($transaction->cashier ? $transaction->cashier->name : 'Kasir System') . "\n"
        . "Pelanggan : " . $transaction->customer_name . "\n"
        . "--------------------------------\n";
      foreach($transaction->items as $item) {
        $waMessage .= $item->item_name . "\n  " . $item->quantity . "x @ Rp " . number_format($item->price, 0, ',', '.') . " = Rp " . number_format($item->subtotal, 0, ',', '.') . "\n";
      }
      $waMessage .= "--------------------------------\n"
        . "Subtotal  : Rp " . number_format($transaction->subtotal, 0, ',', '.') . "\n";
      if ($transaction->discount_amount > 0) {
        $waMessage .= "Diskon    : - Rp " . number_format($transaction->discount_amount, 0, ',', '.') . "\n";
      }
      $waMessage .= "*TOTAL    : Rp " . number_format($transaction->final_amount, 0, ',', '.') . "*\n"
        . "Metode    : " . strtoupper($transaction->payment_method) . "\n"
        . "Status    : " . strtoupper($transaction->payment_status) . "\n"
        . "--------------------------------\n"
        . "Terima kasih atas kunjungan Anda!\n"
        . "Instagram: @districtstudio.id";
      $waUrl = "https://api.whatsapp.com/send?text=" . urlencode($waMessage);
    @endphp

    <a href="{{ $waUrl }}" target="_blank" class="btn-action btn-wa">
      💬 WhatsApp
    </a>
    <a href="{{ route('dashboard') }}" class="btn-action btn-back">
      ← Kasir
    </a>
  </div>

  {{-- ── Formal Black & White Receipt ── --}}
  <div class="receipt-container">

    <!-- Kop Struk Formal -->
    <div class="receipt-header">
      <div class="brand-title">DISTRICT STUDIO</div>
      <div class="brand-subtitle">Barbershop & Executive Grooming</div>
      <div class="brand-address">
        District Studio Jakarta Barat (SMKN 17 Slipi)<br>
        Jl. Slipi Dalam, Palmerah, Jakarta Barat 11410<br>
        Telp / WA: 0812-3456-7890
      </div>
    </div>

    <div class="divider-double"></div>

    <!-- Metadata Transaksi -->
    <div class="receipt-info">
      <div class="info-row">
        <span>No. Transaksi</span>
        <strong>#POS-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</strong>
      </div>
      <div class="info-row">
        <span>Waktu</span>
        <span>{{ $transaction->created_at->format('d/m/Y H:i') }} WIB</span>
      </div>
      <div class="info-row">
        <span>Kasir</span>
        <span>{{ $transaction->cashier ? $transaction->cashier->name : 'Kasir Utama' }}</span>
      </div>
      <div class="info-row">
        <span>Pelanggan</span>
        <strong>{{ $transaction->customer_name }}</strong>
      </div>
      @if($transaction->booking_id)
        <div class="info-row">
          <span>Ref. Booking</span>
          <span>#BK-{{ $transaction->booking_id }}</span>
        </div>
      @endif
    </div>

    <div class="divider-dashed"></div>

    <!-- Daftar Item Penjualan -->
    <table class="items-table">
      <thead>
        <tr>
          <th style="width: 55%;">ITEM / LAYANAN</th>
          <th style="width: 15%; text-align: center;">QTY</th>
          <th style="width: 30%; text-align: right;">TOTAL (Rp)</th>
        </tr>
      </thead>
      <tbody>
        @foreach($transaction->items as $item)
          <tr>
            <td>
              <div class="item-name">{{ $item->item_name }}</div>
              <div class="item-desc">@ Rp {{ number_format($item->price, 0, ',', '.') }}</div>
            </td>
            <td style="text-align: center;">{{ $item->quantity }}</td>
            <td style="text-align: right; font-weight: 700;">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="divider-dashed"></div>

    <!-- Rincian Pembayaran -->
    <div class="total-section">
      <div class="total-row">
        <span>Subtotal</span>
        <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
      </div>
      @if($transaction->discount_amount > 0)
        <div class="total-row">
          <span>Diskon Promo</span>
          <span>- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</span>
        </div>
      @endif
      <div class="total-row total-grand">
        <span>TOTAL PEMBAYARAN</span>
        <span>Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</span>
      </div>
      <div class="total-row">
        <span>Metode Pembayaran</span>
        <strong>{{ strtoupper($transaction->payment_method ?? 'TUNAI') }}</strong>
      </div>
      <div class="total-row">
        <span>Status Transaksi</span>
        <strong>{{ strtoupper($transaction->payment_status === 'paid' ? 'LUNAS (PAID)' : 'VOID / BATAL') }}</strong>
      </div>
    </div>

    <!-- Stempel Formal Status Lunas -->
    <div class="status-stamp">
      <div class="stamp-box">
        {{ $transaction->payment_status === 'paid' ? '★ LUNAS ★' : 'BATAL (VOID)' }}
      </div>
    </div>

    <div class="divider-dashed"></div>

    <!-- QR Code & Footer -->
    <div class="receipt-footer">
      <div class="qr-container">
        <img
          src="https://api.qrserver.com/v1/create-qr-code/?size=85x85&data=DISTRICT-STUDIO-POS-{{ $transaction->id }}-{{ strtoupper($transaction->payment_status) }}"
          style="width: 75px; height: 75px; display: block; margin: 0 auto;"
          alt="QR Verifikasi Struk">
      </div>
      <p style="font-weight: 700; margin-top: 6px;">TERIMA KASIH ATAS KUNJUNGAN ANDA</p>
      <p style="font-size: 8.5px; color: #555555; margin-top: 2px;">Barang yang sudah dibeli tidak dapat ditukar kembali kecuali ada perjanjian khusus.</p>
      <p style="font-size: 8.5px; margin-top: 4px;">Kritik & Saran: 0812-3456-7890 | IG: @districtstudio.id</p>
    </div>

  </div>

</body>
</html>
