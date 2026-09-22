<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nota #POS-{{ $transaction->id }} — District Studio</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
  <style>
    /* ── Web Preview Styles ── */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: #0f0f11;
      font-family: 'Space Mono', 'Courier New', monospace;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 30px 16px 60px;
      min-height: 100vh;
      color: #fff;
    }

    /* ── Action Bar (no-print) ── */
    .action-bar {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      justify-content: center;
      margin-bottom: 28px;
      padding: 16px 20px;
      background: #18181b;
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
    }
    .btn-action {
      text-decoration: none;
      padding: 10px 18px;
      font-family: 'Montserrat', sans-serif;
      font-weight: 800;
      border-radius: 8px;
      font-size: 0.78rem;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      border: none;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      transition: opacity 0.15s;
    }
    .btn-action:hover { opacity: 0.88; }
    .btn-print  { background: #ffc107; color: #000; }
    .btn-wa     { background: #25d366; color: #fff; }
    .btn-back   { background: #3f3f46; color: #fff; }

    /* ── Receipt Box ── */
    .receipt-box {
      background: #fff;
      color: #000;
      width: 100%;
      max-width: 340px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 25px 60px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.04);
    }

    /* Header green gradient */
    .receipt-header {
      background: linear-gradient(135deg, #0a1f0e 0%, #0d2e14 100%);
      color: #fff;
      padding: 20px 20px 18px;
      text-align: center;
      position: relative;
    }
    .receipt-header::after {
      content: '';
      display: block;
      position: absolute;
      bottom: -8px;
      left: 0;
      right: 0;
      height: 16px;
      background: #fff;
      border-radius: 50% 50% 0 0 / 100% 100% 0 0;
      transform: scaleX(1.05);
    }
    .brand-name {
      font-family: 'Montserrat', sans-serif;
      font-size: 18px;
      font-weight: 900;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #fff;
    }
    .brand-tagline {
      font-size: 9px;
      color: rgba(255,255,255,0.55);
      margin: 3px 0;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    .brand-address {
      font-size: 9px;
      color: rgba(255,255,255,0.45);
      margin-top: 5px;
    }
    .green-dot {
      display: inline-block;
      width: 6px;
      height: 6px;
      background: #28a745;
      border-radius: 50%;
      margin: 0 4px;
      vertical-align: middle;
    }

    /* Info area */
    .receipt-info {
      padding: 22px 20px 10px;
      border-bottom: 1px dashed #ddd;
    }
    .info-row {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      margin-bottom: 4px;
      color: #555;
    }
    .info-row strong { color: #111; }
    .tx-number {
      font-size: 13px;
      font-weight: 700;
      color: #111;
      font-family: 'Space Mono', monospace;
    }

    /* Status badge */
    .status-badge {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 20px;
      font-size: 9px;
      font-family: 'Montserrat', sans-serif;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .status-paid { background: rgba(40,167,69,0.12); color: #28a745; border: 1px solid rgba(40,167,69,0.3); }
    .status-void { background: rgba(220,53,69,0.12); color: #dc3545; border: 1px solid rgba(220,53,69,0.3); }

    /* Items table */
    .items-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 11px;
      margin-bottom: 0;
    }
    .items-table thead tr {
      background: #f4f4f5;
      border-top: 1px dashed #ddd;
      border-bottom: 1px dashed #ddd;
    }
    .items-table th {
      font-family: 'Montserrat', sans-serif;
      font-size: 8.5px;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: #888;
      padding: 7px 10px;
    }
    .items-table td {
      padding: 7px 10px;
      color: #222;
      border-bottom: 1px solid #f0f0f0;
      vertical-align: middle;
    }
    .item-type-badge {
      display: inline-block;
      font-size: 7.5px;
      font-family: 'Montserrat', sans-serif;
      font-weight: 800;
      text-transform: uppercase;
      padding: 1px 5px;
      border-radius: 3px;
      margin-bottom: 2px;
    }
    .badge-service { background: #fff3cd; color: #856404; }
    .badge-product { background: #d1ecf1; color: #0c5460; }
    .item-name { font-weight: 600; color: #111; font-size: 11px; }

    /* Totals */
    .totals-section {
      padding: 12px 20px;
      border-top: 1px dashed #ddd;
    }
    .total-row {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      color: #555;
      margin-bottom: 5px;
    }
    .total-row.discount strong { color: #dc3545; }
    .total-row.grand {
      border-top: 1.5px solid #111;
      margin-top: 8px;
      padding-top: 8px;
    }
    .total-row.grand span { font-size: 13px; font-weight: 700; color: #111; }
    .total-row.grand .amount { font-size: 16px; font-weight: 700; color: #28a745; }

    .payment-method {
      text-align: center;
      margin: 10px 20px;
      padding: 8px;
      background: #f4f4f5;
      border-radius: 6px;
      font-size: 10px;
      color: #555;
      border: 1px solid #e5e5e5;
    }
    .payment-method strong {
      display: block;
      font-family: 'Montserrat', sans-serif;
      font-size: 11px;
      font-weight: 900;
      color: #111;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Footer */
    .receipt-footer {
      padding: 14px 20px 20px;
      text-align: center;
      border-top: 1px dashed #ddd;
    }
    .qr-seal {
      margin: 0 auto 10px;
      display: block;
    }
    .footer-tagline {
      font-family: 'Montserrat', sans-serif;
      font-size: 10px;
      font-weight: 800;
      color: #111;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 4px;
    }
    .footer-sub {
      font-size: 9px;
      color: #888;
    }
    .footer-social {
      margin-top: 8px;
      font-size: 9px;
      color: #28a745;
      font-weight: 700;
    }

    /* ── Print Overrides ── */
    @media print {
      * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
      body {
        background: #fff !important;
        padding: 0 !important;
        display: block;
        width: 58mm;
        margin: 0;
        font-size: 10px;
        color: #000;
      }
      .no-print { display: none !important; }
      .receipt-box {
        max-width: 100% !important;
        width: 100% !important;
        border-radius: 0 !important;
        box-shadow: none !important;
      }
      .receipt-header { padding: 12px 12px 14px; }
      .brand-name { font-size: 14px; }
      .receipt-info, .totals-section, .receipt-footer { padding: 8px 12px; }
      .items-table td, .items-table th { padding: 5px 8px; }
      .total-row.grand .amount { font-size: 14px; }
    }
  </style>
</head>
<body>

  {{-- ── Action Bar (no-print) ── --}}
  <div class="action-bar no-print">
    <button onclick="window.print()" class="btn-action btn-print">
      🖨️ Cetak Nota Thermal
    </button>

    @php
      $waMessage = "*DISTRICT STUDIO*\n_Premium Barbershop & Styling_\n\n"
        . "✅ *NOTA DIGITAL #POS-" . $transaction->id . "*\n"
        . "Tgl: " . $transaction->created_at->format('d/m/Y H:i') . "\n"
        . "Pelanggan: " . $transaction->customer_name . "\n"
        . "Kasir: " . ($transaction->cashier ? $transaction->cashier->name : 'System') . "\n\n"
        . "*RINCIAN:*\n";
      foreach($transaction->items as $item) {
        $waMessage .= "• " . $item->item_name . " (" . $item->quantity . "x) = Rp " . number_format($item->subtotal, 0, ',', '.') . "\n";
      }
      $waMessage .= "\nSubtotal : Rp " . number_format($transaction->subtotal, 0, ',', '.');
      if ($transaction->discount_amount > 0) {
        $waMessage .= "\nDiskon   : - Rp " . number_format($transaction->discount_amount, 0, ',', '.');
      }
      $waMessage .= "\n*TOTAL    : Rp " . number_format($transaction->final_amount, 0, ',', '.') . "* (" . strtoupper($transaction->payment_method) . ")\n\n"
        . "Terima kasih telah berkunjung ke District Studio! 💈\n"
        . "Instagram: @districtstudio.id";
      $waUrl = "https://api.whatsapp.com/send?text=" . urlencode($waMessage);
    @endphp

    <a href="{{ $waUrl }}" target="_blank" class="btn-action btn-wa">
      💬 Kirim via WhatsApp
    </a>
    <a href="{{ route('dashboard') }}" class="btn-action btn-back">
      ← Kembali Kasir
    </a>
  </div>

  {{-- ── Receipt Box ── --}}
  <div class="receipt-box">

    {{-- Header --}}
    <div class="receipt-header">
      <div class="brand-name">District Studio</div>
      <div class="brand-tagline">Premium Barbershop & Styling</div>
      <div class="brand-address">
        Kebayoran Baru, Jakarta Selatan
        <span class="green-dot"></span>
        Citarum, Bandung
      </div>
    </div>

    {{-- Transaction Info --}}
    <div class="receipt-info" style="padding-top: 24px;">
      <div class="info-row" style="margin-bottom: 10px;">
        <span class="tx-number">#POS-{{ $transaction->id }}</span>
        <span class="status-badge {{ $transaction->payment_status === 'paid' ? 'status-paid' : 'status-void' }}">
          {{ $transaction->payment_status === 'paid' ? '✓ LUNAS' : '✕ VOID' }}
        </span>
      </div>
      <div class="info-row">
        <span>Tanggal & Waktu:</span>
        <strong>{{ $transaction->created_at->format('d/m/Y H:i') }}</strong>
      </div>
      <div class="info-row">
        <span>Kasir:</span>
        <strong>{{ $transaction->cashier ? $transaction->cashier->name : 'System' }}</strong>
      </div>
      <div class="info-row">
        <span>Pelanggan:</span>
        <strong>{{ $transaction->customer_name }}</strong>
      </div>
      @if($transaction->booking)
        <div class="info-row">
          <span>No. Booking:</span>
          <strong>#{{ $transaction->booking->id }}</strong>
        </div>
      @endif
    </div>

    {{-- Items Table --}}
    <table class="items-table">
      <thead>
        <tr>
          <th>Item</th>
          <th style="text-align:center;">Qty</th>
          <th style="text-align:right;">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($transaction->items as $item)
          <tr>
            <td>
              <div class="item-type-badge {{ $item->item_type === 'service' ? 'badge-service' : 'badge-product' }}">
                {{ $item->item_type === 'service' ? '✂ Layanan' : '📦 Produk' }}
              </div>
              <div class="item-name">{{ $item->item_name }}</div>
              <div style="font-size: 9.5px; color: #888;">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</div>
            </td>
            <td style="text-align:center; color:#555;">{{ $item->quantity }}</td>
            <td style="text-align:right; font-weight:700; color:#111;">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Totals --}}
    <div class="totals-section">
      <div class="total-row">
        <span>Subtotal</span>
        <strong>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</strong>
      </div>
      @if($transaction->discount_amount > 0)
        <div class="total-row discount">
          <span>Diskon Promo</span>
          <strong style="color:#dc3545;">- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</strong>
        </div>
      @endif
      <div class="total-row grand">
        <span>TOTAL BAYAR</span>
        <span class="amount">Rp {{ number_format($transaction->final_amount, 0, ',', '.') }}</span>
      </div>
    </div>

    {{-- Payment Method --}}
    <div class="payment-method">
      Metode Pembayaran
      <strong>{{ strtoupper($transaction->payment_method) }}</strong>
    </div>

    {{-- Footer --}}
    <div class="receipt-footer">
      <img
        src="https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=DISTRICT-STUDIO-POS-{{ $transaction->id }}-{{ strtoupper($transaction->payment_status) }}"
        class="qr-seal"
        style="width:80px;height:80px;border-radius:4px;"
        alt="QR Verifikasi">

      <div class="footer-tagline">Terima Kasih Atas Kunjungan Anda!</div>
      <div class="footer-sub">Barbershop profesional terpercaya</div>
      <div class="footer-sub">📍 Kebayoran Baru · Citarum Bandung</div>
      <div class="footer-social">@districtstudio.id</div>
    </div>

  </div>

</body>
</html>
