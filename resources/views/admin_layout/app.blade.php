<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'District Studio - Premium Barbershop')</title>
  <meta name="description" content="District Studio - Lebih dari sekadar potong rambut, ruang untuk menemukan jati diri. Barbershop premium dan studio tata rambut.">
  <meta name="keywords" content="barber, barbershop, hair studio, district, district studio, haircut, styling, coloring, perming, down perm">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/Gemini_Generated_Image_v41tj7v41tj7v41t.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  <!-- Custom Barber CSS File -->
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>

<body>

  <!-- Header & Navbar -->
  <header id="header" class="header d-flex align-items-center fixed-top" style="background: #0f0f0f; border-bottom: 1px solid rgba(255,255,255,0.08);">
    <div class="container-fluid container-xl">
      @include('admin_layout.partials.navbar')
    </div>
  </header>

  <!-- Tempat Konten Dinamis Halaman (Home, About, dll) -->
  @yield('content')

  <!-- Footer -->

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  @auth
  {{-- ─── Mailbox Unread Badge Polling (every 30s) ──────────────────────── --}}
  <script>
    (function mailboxBadgePoll() {
      function updateBadge() {
        fetch('{{ route('mailbox.unread') }}', {
          headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
          const badge = document.getElementById('navUnreadBadge');
          if (!badge) return;
          if (data.unread > 0) {
            badge.textContent = data.unread > 9 ? '9+' : data.unread;
            badge.style.display = 'flex';
          } else {
            badge.style.display = 'none';
          }
        })
        .catch(() => {});
      }
      // Poll every 30 seconds
      setInterval(updateBadge, 30000);
    })();
  </script>
  @endauth

  @yield('scripts')

</body>

</html>