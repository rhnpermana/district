<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Live Queue Tracker - District Studio</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800;900&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <style>
    body { background-color: #0b0b0b; color: #fff; font-family: 'Outfit', sans-serif; min-height: 100vh; display: flex; flex-direction: column; justify-content: center; }
    .tracker-card { background: #141414; border: 1px solid rgba(255,152,0,0.3); border-radius: 16px; padding: 35px 25px; box-shadow: 0 15px 40px rgba(0,0,0,0.6); }
    .q-number { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 3.5rem; color: #ff9800; line-height: 1; margin: 15px 0; text-shadow: 0 0 25px rgba(255,152,0,0.3); }
    .status-pill { display: inline-block; padding: 6px 16px; border-radius: 30px; font-size: 0.8rem; font-weight: 800; font-family: 'Montserrat', sans-serif; text-transform: uppercase; }
  </style>
  <meta http-equiv="refresh" content="10">
</head>
<body>

  <div class="container py-5" style="max-width: 480px;">
    <div class="tracker-card text-center">
      <span style="font-family: 'Montserrat', sans-serif; font-weight: 900; color: #fff; letter-spacing: 2px; font-size: 1.1rem;">
        DISTRICT<span style="color: #ff9800;">STUDIO.</span>
      </span>
      <p style="font-size: 0.75rem; color: #888; margin-top: 4px;">Live Mobile Queue Tracker</p>

      <hr style="border-color: rgba(255,255,255,0.1);" class="my-3">

      @if(!$booking)
        <div class="py-4">
          <i class="bi bi-ticket-perforated" style="font-size: 3rem; color: #555;"></i>
          <p style="color: #888;" class="mt-2">Anda tidak memiliki antrean aktif saat ini.</p>
          <a href="{{ route('dashboard') }}" class="btn btn-warning btn-sm fw-bold mt-2">Buat Booking Baru</a>
        </div>
      @else
        <div class="text-uppercase" style="font-size: 0.7rem; letter-spacing: 1.5px; color: #aaa;">Nomor Antrean Anda</div>
        <div class="q-number">{{ $booking->queue_number ?? 'A-00' . $booking->id }}</div>

        <div class="mb-4">
          @if($booking->status === 'completed')
            <span class="status-pill bg-success text-white"><i class="bi bi-check-circle me-1"></i> SELESAI DIPOTONG</span>
          @elseif($booking->status === 'approved' || $booking->status === 'serving')
            <span class="status-pill bg-warning text-dark"><i class="bi bi-scissors me-1"></i> SEDANG DIPOTONG</span>
          @elseif($booking->status === 'arrived')
            <span class="status-pill bg-info text-dark"><i class="bi bi-geo-alt me-1"></i> SUDAH CHECK-IN</span>
          @else
            <span class="status-pill bg-secondary text-white"><i class="bi bi-hourglass-split me-1"></i> MENUNGGU ANTREAN</span>
          @endif
        </div>

        <div style="background: #1a1a1a; padding: 20px; border-radius: 12px;" class="mb-4 text-start">
          <div class="d-flex justify-content-between mb-2">
            <span style="color: #888; font-size: 0.85rem;">Orang Di Depan Anda:</span>
            <strong style="color: #ff9800; font-size: 1rem;">{{ $aheadCount }} Pelanggan</strong>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span style="color: #888; font-size: 0.85rem;">Estimasi Tunggu:</span>
            <strong style="color: #fff; font-size: 0.9rem;">~ {{ $aheadCount * 30 }} Menit</strong>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span style="color: #888; font-size: 0.85rem;">Cabang:</span>
            <strong style="color: #fff; font-size: 0.85rem;">{{ $booking->branch }}</strong>
          </div>
          <div class="d-flex justify-content-between">
            <span style="color: #888; font-size: 0.85rem;">Kapster:</span>
            <strong style="color: #fff; font-size: 0.85rem;">{{ $booking->stylist ? $booking->stylist->name : 'Auto Assign' }}</strong>
          </div>
        </div>

        <p style="font-size: 0.72rem; color: #666;"><i class="bi bi-arrow-repeat me-1"></i> Halaman ini otomatis ter-update setiap 10 detik.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm w-100 mt-2 fw-bold" style="font-size: 0.8rem;">Kembali ke Dashboard</a>
      @endif
    </div>
  </div>

</body>
</html>
