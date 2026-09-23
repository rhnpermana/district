<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <title>@yield('title', 'District Studio - Barbershop & Studio Rambut Premium')</title>
  <meta name="description" content="District Studio - Lebih dari sekadar potong rambut, ruang untuk menemukan jati diri. Barbershop premium dan studio tata rambut.">
  <meta name="keywords" content="barber, barbershop, studio rambut, district studio, potong rambut pria, pewarnaan rambut, perming">
  
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

  <!-- Inline Script to prevent Theme Flash (FOUC) -->
  <script>
    (function () {
      const userPref = localStorage.getItem('theme');
      const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      if (userPref === 'dark' || (!userPref && systemDark)) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    })();
  </script>

  <!-- Vite Assets (Tailwind CSS v4 & App JS) -->
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

<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased font-sans transition-colors duration-300 min-h-screen flex flex-col justify-between selection:bg-amber-500 selection:text-white">

  <!-- Header & Navigation Bar -->
  <header id="header" class="fixed top-0 left-0 right-0 z-40 bg-white/90 dark:bg-slate-900/90 border-b border-slate-200/80 dark:border-slate-800/80 backdrop-blur-md transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
      <a href="/" class="flex items-center text-xl sm:text-2xl font-black tracking-wider text-slate-900 dark:text-white hover:opacity-90 transition-opacity">
        DISTRICT<span class="text-amber-500">STUDIO.</span>
      </a>
      
      @include('layout.partials.navbar')
    </div>
  </header>

  <!-- Main Dynamic Page Content -->
  <main class="flex-grow pt-20 pb-20 md:pb-12">
    @yield('content')
  </main>

  <!-- Footer -->
  @include('layout.partials.footer')

  <!-- Mobile Bottom Navigation Bar (Android/PWA App Experience) -->
  <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 dark:bg-slate-900/95 border-t border-slate-200 dark:border-slate-800/80 backdrop-blur-lg px-2 py-1.5 flex justify-around items-center shadow-lg transition-colors duration-300">
    <a href="{{ url('/') }}" class="flex flex-col items-center py-1 px-3 text-xs font-medium transition-all duration-200 {{ request()->is('/') ? 'text-amber-600 dark:text-amber-400 font-bold scale-105' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100' }}">
      <i class="bi bi-house-door text-lg mb-0.5"></i>
      <span>Beranda</span>
    </a>

    <a href="{{ url('/#services') }}" class="flex flex-col items-center py-1 px-3 text-xs font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-all duration-200">
      <i class="bi bi-scissors text-lg mb-0.5"></i>
      <span>Layanan</span>
    </a>

    <!-- Center Action Floating Button -->
    <a href="{{ route('register') }}" class="flex items-center justify-center -mt-5 w-12 h-12 rounded-full bg-gradient-to-r from-amber-600 to-amber-500 text-white shadow-lg shadow-amber-500/30 hover:scale-110 active:scale-95 transition-all duration-300">
      <i class="bi bi-calendar-check text-xl"></i>
    </a>

    <a href="{{ route('queue.board') }}" target="_blank" class="flex flex-col items-center py-1 px-3 text-xs font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-all duration-200">
      <i class="bi bi-tv text-lg mb-0.5"></i>
      <span>Antrean</span>
    </a>

    @auth
      <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-1 px-3 text-xs font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-all duration-200">
        <i class="bi bi-person-circle text-lg mb-0.5"></i>
        <span>Akun</span>
      </a>
    @else
      <a href="{{ route('login') }}" class="flex flex-col items-center py-1 px-3 text-xs font-medium transition-all duration-200 {{ request()->routeIs('login') ? 'text-amber-600 dark:text-amber-400 font-bold scale-105' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100' }}">
        <i class="bi bi-box-arrow-in-right text-lg mb-0.5"></i>
        <span>Masuk</span>
      </a>
    @endauth
  </nav>

  <!-- Floating WhatsApp Action Button -->
  <a href="https://wa.me/6285770394148?text=Halo%20District%20Studio,%20saya%20ingin%20konsultasi%20layanan%20potong%20rambut." 
     target="_blank" 
     id="whatsapp-floating-btn"
     aria-label="Contact us on WhatsApp"
     class="fixed bottom-20 md:bottom-8 left-5 z-40 flex items-center justify-center w-13 h-13 rounded-full bg-emerald-500 text-white text-2xl shadow-lg shadow-emerald-500/40 hover:scale-110 active:scale-95 transition-all duration-300 group touch-manipulation">
    <i class="bi bi-whatsapp"></i>
    <span class="absolute left-16 bg-slate-900 text-white text-xs font-medium px-2.5 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-md hidden md:block">
      Konsultasi WhatsApp
    </span>
  </a>

  <!-- Scroll Top Button -->
  <a href="#" id="scroll-top" class="scroll-top fixed bottom-20 md:bottom-8 right-5 z-40 hidden items-center justify-center w-10 h-10 rounded-full bg-amber-500 text-white text-xl shadow-md hover:bg-amber-600 transition-all duration-300">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>

  <!-- Main Theme JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  @yield('scripts')

</body>

</html>