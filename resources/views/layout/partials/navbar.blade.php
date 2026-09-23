<!-- Header Navigation Bar Component -->
<nav class="flex items-center justify-between w-full">
  <!-- Desktop Navigation Links -->
  <ul class="hidden md:flex items-center space-x-1 lg:space-x-6 text-sm font-medium text-slate-700 dark:text-slate-200">
    <li>
      <a href="{{ url('/') }}" 
         class="px-3 py-2 rounded-lg transition-all duration-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 {{ request()->is('/') ? 'text-amber-600 dark:text-amber-400 font-semibold bg-amber-500/10' : '' }}">
        Beranda
      </a>
    </li>
    <li>
      <a href="{{ route('about') }}" 
         class="px-3 py-2 rounded-lg transition-all duration-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 {{ request()->routeIs('about') ? 'text-amber-600 dark:text-amber-400 font-semibold bg-amber-500/10' : '' }}">
        Tentang Kami
      </a>
    </li>
    
    <!-- Dropdown Menu -->
    <li class="relative group">
      <button type="button" class="inline-flex items-center px-3 py-2 rounded-lg transition-all duration-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 focus:outline-none">
        <span>Layanan & Katalog</span>
        <svg class="w-4 h-4 ms-1 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
      </button>
      <div class="absolute left-0 mt-2 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2 z-50 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700/60 p-2">
        <a href="{{ url('/#services') }}" class="flex items-center px-3 py-2 text-xs font-medium text-slate-700 dark:text-slate-200 rounded-lg hover:bg-amber-500/10 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
          <i class="bi bi-scissors text-amber-500 me-2.5 text-base"></i> Daftar Layanan & Harga
        </a>
        <a href="{{ url('/#lookbook') }}" class="flex items-center px-3 py-2 text-xs font-medium text-slate-700 dark:text-slate-200 rounded-lg hover:bg-amber-500/10 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
          <i class="bi bi-camera text-amber-500 me-2.5 text-base"></i> Koleksi Gaya Rambut
        </a>
        <a href="{{ url('/#products') }}" class="flex items-center px-3 py-2 text-xs font-medium text-slate-700 dark:text-slate-200 rounded-lg hover:bg-amber-500/10 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
          <i class="bi bi-box-seam text-amber-500 me-2.5 text-base"></i> Produk Grooming
        </a>
      </div>
    </li>

    <li>
      <a href="{{ url('/#stylists') }}" class="px-3 py-2 rounded-lg transition-all duration-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800/60">
        Hair Artist
      </a>
    </li>
    <li>
      <a href="{{ route('queue.board') }}" target="_blank" class="px-3 py-2 rounded-lg transition-all duration-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 inline-flex items-center">
        <i class="bi bi-tv me-1.5 text-amber-500"></i> Papan Antrean
      </a>
    </li>
    <li>
      <a href="{{ route('contact') }}" class="px-3 py-2 rounded-lg transition-all duration-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 {{ request()->routeIs('contact') ? 'text-amber-600 dark:text-amber-400 font-semibold bg-amber-500/10' : '' }}">
        Kontak
      </a>
    </li>
  </ul>

  <!-- Right Actions (Theme Switcher, Booking CTA & Mobile Hamburger) -->
  <div class="flex items-center space-x-2 sm:space-x-3">
    <!-- Light / Dark Mode Toggle Button -->
    <button type="button" 
            data-theme-toggle 
            aria-label="Toggle Theme"
            class="p-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-300 hover:scale-105 active:scale-95 touch-manipulation focus:outline-none border border-slate-200/60 dark:border-slate-700/60">
      <!-- Sun Icon (shown in dark mode) -->
      <svg data-theme-icon-sun class="w-5 h-5 text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
      </svg>
      <!-- Moon Icon (shown in light mode) -->
      <svg data-theme-icon-moon class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
      </svg>
    </button>

    <!-- Desktop Reservation / Dashboard CTA Button -->
    @auth
      <a href="{{ route('dashboard') }}" 
         class="hidden sm:inline-flex items-center px-4 py-2.5 rounded-xl text-xs uppercase tracking-wider font-semibold text-white bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-500 hover:to-amber-400 shadow-md hover:shadow-amber-500/25 transition-all duration-300 hover:scale-105 active-bounce">
        <i class="bi bi-speedometer2 me-1.5"></i> Dashboard
      </a>
    @else
      <a href="{{ route('register') }}" 
         class="hidden sm:inline-flex items-center px-4 py-2.5 rounded-xl text-xs uppercase tracking-wider font-semibold text-white bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-500 hover:to-amber-400 shadow-md hover:shadow-amber-500/25 transition-all duration-300 hover:scale-105 active-bounce">
        <i class="bi bi-calendar-check me-1.5"></i> Reservasi
      </a>
    @endauth

    <!-- Mobile Hamburger Menu Toggle Button -->
    <button type="button" 
            id="mobile-menu-btn" 
            aria-label="Open Navigation Menu"
            class="md:hidden p-2.5 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-300 focus:outline-none border border-slate-200/60 dark:border-slate-700/60 touch-manipulation">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>
  </div>
</nav>

<!-- Mobile Slide-Over Navigation Drawer Backdrop -->
<div id="mobile-menu-backdrop" 
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300 md:hidden"></div>

<!-- Mobile Navigation Drawer -->
<aside id="mobile-menu-drawer" 
       class="fixed top-0 left-0 bottom-0 w-80 max-w-[85vw] bg-white dark:bg-slate-900 z-50 -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col justify-between md:hidden border-e border-slate-200 dark:border-slate-800">
  <div class="p-5 overflow-y-auto">
    <!-- Mobile Drawer Header -->
    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
      <a href="/" class="text-lg font-black tracking-wider text-slate-900 dark:text-white">
        DISTRICT<span class="text-amber-500">STUDIO.</span>
      </a>
      <button type="button" 
              id="mobile-menu-close-btn"
              aria-label="Close Navigation Menu"
              class="p-2 rounded-lg text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors touch-manipulation">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Mobile Drawer Navigation Links -->
    <ul class="mt-6 space-y-1">
      <li>
        <a href="{{ url('/') }}" 
           class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->is('/') ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
          <i class="bi bi-house-door me-3 text-lg"></i> Beranda
        </a>
      </li>
      <li>
        <a href="{{ route('about') }}" 
           class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('about') ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
          <i class="bi bi-info-circle me-3 text-lg"></i> Tentang Kami
        </a>
      </li>
      <li>
        <a href="{{ url('/#services') }}" 
           class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
          <i class="bi bi-scissors me-3 text-lg text-amber-500"></i> Layanan & Harga
        </a>
      </li>
      <li>
        <a href="{{ url('/#lookbook') }}" 
           class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
          <i class="bi bi-camera me-3 text-lg text-amber-500"></i> Koleksi Gaya Rambut
        </a>
      </li>
      <li>
        <a href="{{ url('/#products') }}" 
           class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
          <i class="bi bi-box-seam me-3 text-lg text-amber-500"></i> Produk Grooming
        </a>
      </li>
      <li>
        <a href="{{ url('/#stylists') }}" 
           class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
          <i class="bi bi-people me-3 text-lg"></i> Hair Artist
        </a>
      </li>
      <li>
        <a href="{{ route('queue.board') }}" target="_blank"
           class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
          <i class="bi bi-tv me-3 text-lg text-amber-500"></i> Papan Antrean
        </a>
      </li>
      <li>
        <a href="{{ route('contact') }}" 
           class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('contact') ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
          <i class="bi bi-envelope me-3 text-lg"></i> Kontak
        </a>
      </li>
    </ul>
  </div>

  <!-- Mobile Drawer Footer CTA & Theme Switcher -->
  <div class="p-5 border-t border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
    <div class="flex items-center justify-between mb-4">
      <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Mode Tampilan</span>
      <button type="button" 
              data-theme-toggle 
              class="flex items-center space-x-2 px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-200/80 dark:bg-slate-700 text-slate-800 dark:text-slate-200 transition-colors">
        <span data-theme-icon-sun class="hidden">Light Mode ☀️</span>
        <span data-theme-icon-moon>Dark Mode 🌙</span>
      </button>
    </div>

    @auth
      <a href="{{ route('dashboard') }}" 
         class="w-full flex items-center justify-center px-4 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-500 hover:to-amber-400 shadow-lg shadow-amber-500/20 transition-all active-bounce">
        <i class="bi bi-speedometer2 me-2"></i> Panel Dashboard
      </a>
    @else
      <a href="{{ route('register') }}" 
         class="w-full flex items-center justify-center px-4 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-500 hover:to-amber-400 shadow-lg shadow-amber-500/20 transition-all active-bounce">
        <i class="bi bi-calendar-check me-2"></i> Reservasi Sekarang
      </a>
    @endauth
  </div>
</aside>