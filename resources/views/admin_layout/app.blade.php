<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <title>@yield('title', 'District Studio - Premium Barbershop Panel')</title>
  <meta name="description" content="District Studio - Lebih dari sekadar potong rambut, ruang untuk menemukan jati diri. Barbershop premium dan studio tata rambut.">
  
  <!-- Android / PWA Support Meta Tags -->
  <meta name="theme-color" content="#0f172a" id="theme-color-meta">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <link rel="manifest" href="{{ asset('manifest.json') }}">

  <!-- Favicons -->
  <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/png">
  <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Vite Assets -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

  <!-- Main & Custom CSS Files -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>

<body class="bg-slate-950 text-slate-100 antialiased font-sans min-h-screen flex flex-col justify-between">

  <!-- Header & Navbar -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-xl d-flex align-items-center justify-content-between">
      @include('admin_layout.partials.navbar')
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow pt-20 pb-12">
    @yield('content')
  </main>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top fixed bottom-6 right-6 z-40 hidden items-center justify-center w-10 h-10 rounded-full bg-amber-500 text-white text-xl shadow-md hover:bg-amber-600 transition-all duration-300">
    <i class="bi bi-arrow-up-short"></i>
  </a>

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
      setInterval(updateBadge, 30000);
    })();
  </script>
  @endauth

  @yield('scripts')

</body>

</html>