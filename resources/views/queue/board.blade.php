<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Display Antrean Real-Time - District Studio</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <style>
    body {
      background-color: #080808;
      color: #ffffff;
      font-family: 'Outfit', sans-serif;
      overflow-x: hidden;
      margin: 0;
      padding: 0;
    }
    .board-header {
      background: linear-gradient(135deg, #141414 0%, #080808 100%);
      border-bottom: 2px solid #ff9800;
      padding: 20px 40px;
    }
    .brand-title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 900;
      font-size: 2rem;
      letter-spacing: 2px;
      color: #fff;
    }
    .brand-title span { color: #ff9800; }
    .card-serving {
      background: linear-gradient(145deg, #1a150e 0%, #110d07 100%);
      border: 2px solid #ff9800;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(255,152,0,0.15);
    }
    .queue-num-large {
      font-family: 'Montserrat', sans-serif;
      font-weight: 900;
      font-size: 4rem;
      color: #ff9800;
      line-height: 1;
      text-shadow: 0 0 20px rgba(255,152,0,0.4);
    }
    .card-waiting {
      background: #111111;
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 10px;
      padding: 20px;
    }
    .badge-live {
      animation: pulse 2s infinite;
      background: rgba(220, 53, 69, 0.2);
      color: #dc3545;
      border: 1px solid #dc3545;
      font-weight: 700;
      text-transform: uppercase;
      padding: 4px 12px;
      border-radius: 4px;
      font-size: 0.75rem;
    }
    @keyframes pulse {
      0% { opacity: 1; }
      50% { opacity: 0.4; }
      100% { opacity: 1; }
    }
  </style>
  <meta http-equiv="refresh" content="15">
</head>
<body>

  <div class="board-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <div class="brand-title">DISTRICT<span>STUDIO.</span></div>
      <div style="font-size: 0.9rem; color: #888;">Layar Ruang Tunggu & Display Antrean Real-Time</div>
    </div>
    <div class="d-flex align-items-center gap-3">
      <button type="button" class="btn btn-sm btn-outline-warning font-monospace" onclick="speakFirstQueue()">
        🔊 Tes Suara Bel Panggilan
      </button>
      <span class="badge-live"><i class="bi bi-broadcast me-1"></i> LIVE BOARD</span>
      <div style="background: #181818; padding: 8px 18px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1); font-size: 0.9rem;">
        <i class="bi bi-geo-alt-fill me-1" style="color: #ff9800;"></i> <strong>{{ $selectedBranch }}</strong>
      </div>
      <div style="font-size: 1.2rem; font-weight: 800; font-family: 'Montserrat', sans-serif; color: #ff9800;">
        {{ \Carbon\Carbon::now()->format('H:i') }} WIB
      </div>
    </div>
  </div>

  <div class="container-fluid px-4 py-4">
    <div class="row g-4">
      
      <!-- SEDANG DIPOTONG (NOW SERVING) -->
      <div class="col-12 col-lg-7">
        <h4 style="font-family: 'Montserrat', sans-serif; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; border-left: 4px solid #ff9800; padding-left: 12px;" class="mb-4">
          <i class="bi bi-scissors me-2" style="color: #ff9800;"></i> Sedang Dilayani (Now Serving)
        </h4>

        @if($nowServing->isEmpty())
          <div class="card-serving text-center py-5">
            <i class="bi bi-info-circle" style="font-size: 3rem; color: #666;"></i>
            <h5 class="mt-3" style="color: #aaa;">Belum Ada Antrean yang Sedang Dipotong</h5>
            <p style="color: #666; font-size: 0.85rem;">Antrean berikutnya akan segera dipanggil oleh Receptionist.</p>
          </div>
        @else
          <div class="row g-3">
            @foreach($nowServing as $item)
              <div class="col-12 col-md-6">
                <div class="card-serving">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge" style="background: rgba(255,152,0,0.2); color: #ff9800; font-size: 0.8rem; font-weight: 800;">
                      SERVING NOW
                    </span>
                    <button type="button" class="btn btn-sm btn-link text-warning p-0" onclick="announceQueue('{{ $item->queue_number ?? 'A-00'.$item->id }}', '{{ addslashes($item->user->name) }}', '{{ addslashes($item->stylist ? $item->stylist->name : 'Staff') }}')">
                      🔊 Panggil Suara
                    </button>
                  </div>
                  <div class="queue-num-large mb-1">{{ $item->queue_number ?? 'A-00' . $item->id }}</div>
                  <h4 style="font-weight: 800; color: #fff; margin-bottom: 4px;">{{ $item->user->name }}</h4>
                  <p style="color: #ff9800; font-size: 0.85rem; font-weight: 600; margin-bottom: 12px;">{{ $item->service }}</p>
                  <div class="pt-2 border-top border-secondary border-opacity-25 d-flex justify-content-between text-muted" style="font-size: 0.8rem;">
                    <span>Kapster: <strong class="text-white">{{ $item->stylist ? $item->stylist->name : 'Auto Assign' }}</strong></span>
                    <span>Tipe: <span class="badge bg-secondary">{{ strtoupper($item->type) }}</span></span>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        <!-- STYLIST AVAILABILITY BOARD -->
        <h5 style="font-family: 'Montserrat', sans-serif; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px;" class="mt-5 mb-3">
          <i class="bi bi-people me-2" style="color: #00c8c8;"></i> Status Kerja Kapster Hari Ini
        </h5>
        <div class="row g-2">
          @foreach($activeStylists as $stylist)
            <div class="col-6 col-md-4">
              <div style="background: #121212; border: 1px solid rgba(255,255,255,0.06); padding: 15px; border-radius: 8px;" class="d-flex align-items-center justify-content-between">
                <div>
                  <div style="font-weight: 700; font-size: 0.9rem; color: #fff;">{{ $stylist->name }}</div>
                  <div style="font-size: 0.75rem; color: #777;">Hair Artist</div>
                </div>
                <span class="badge" style="
                  @if($stylist->work_status === 'Available') background: rgba(40,167,69,0.2); color: #28a745;
                  @elseif($stylist->work_status === 'On Duty') background: rgba(255,152,0,0.2); color: #ff9800;
                  @elseif($stylist->work_status === 'Break') background: rgba(220,53,69,0.2); color: #dc3545;
                  @else background: rgba(108,117,125,0.2); color: #6c757d; @endif
                  font-size: 0.7rem; font-weight: 800;">
                  {{ strtoupper($stylist->work_status ?? 'Available') }}
                </span>
              </div>
            </div>
          @endforeach
        </div>

      </div>

      <!-- DAFTAR MENUNGGU (WAITING LIST) -->
      <div class="col-12 col-lg-5">
        <h4 style="font-family: 'Montserrat', sans-serif; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; border-left: 4px solid #00c8c8; padding-left: 12px;" class="mb-4">
          <i class="bi bi-hourglass-split me-2" style="color: #00c8c8;"></i> Daftar Menunggu (Waiting List)
        </h4>

        @if($waitingList->isEmpty())
          <div class="card-waiting text-center py-5">
            <p style="color: #666; margin: 0;">Tidak ada antrean menunggu saat ini.</p>
          </div>
        @else
          <div class="d-flex flex-column gap-2" style="max-height: 600px; overflow-y: auto;">
            @foreach($waitingList as $index => $wItem)
              <div class="card-waiting d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                  <div style="background: rgba(0,200,200,0.15); color: #00c8c8; font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 1.4rem; padding: 10px 16px; border-radius: 8px;">
                    {{ $wItem->queue_number ?? 'W-00' . $wItem->id }}
                  </div>
                  <div>
                    <h6 style="font-weight: 700; color: #fff; margin: 0;">{{ $wItem->user->name }}</h6>
                    <span style="font-size: 0.78rem; color: #888;">{{ $wItem->service }}</span>
                  </div>
                </div>
                <div class="text-end">
                  <div style="font-weight: 700; color: #ff9800; font-size: 0.9rem;">{{ $wItem->booking_time }}</div>
                  <span class="badge" style="background: rgba(255,255,255,0.1); color: #aaa; font-size: 0.65rem;">
                    {{ $wItem->stylist ? $wItem->stylist->name : 'Bebas' }}
                  </span>
                </div>
              </div>
            @endforeach
          </div>
        @endif

      </div>

    </div>
  </div>

<script>
  function announceQueue(num, name, stylist) {
    if ('speechSynthesis' in window) {
      const text = `Panggilan antrean nomor ${num.split('').join(' ')}, atas nama ${name}, silakan menuju kursi kapster ${stylist}.`;
      const utterance = new SpeechSynthesisUtterance(text);
      utterance.lang = 'id-ID';
      utterance.rate = 0.9;
      window.speechSynthesis.speak(utterance);
    }
  }

  function speakFirstQueue() {
    announceQueue('A-001', 'Pelanggan District Studio', 'Hair Stylist 1');
  }
</script>
</body>
</html>
