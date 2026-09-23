<nav id="navmenu" class="navmenu">
  <ul>
    <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a></li>
    
    <li class="dropdown">
      <a href="{{ url('/#services') }}">
        <span>Layanan & Katalog</span> <i class="bi bi-chevron-down toggle-dropdown ms-1"></i>
      </a>
      <ul>
        <li><a href="{{ url('/#services') }}"><i class="bi bi-scissors me-2 text-warning"></i>Daftar Layanan & Harga</a></li>
        <li><a href="{{ url('/#lookbook') }}"><i class="bi bi-camera me-2 text-warning"></i>Koleksi Gaya Rambut</a></li>
        <li><a href="{{ url('/#products') }}"><i class="bi bi-box-seam me-2 text-warning"></i>Produk Grooming</a></li>
      </ul>
    </li>

    <li><a href="{{ url('/#stylists') }}">Hair Artist</a></li>
    <li><a href="{{ route('queue.board') }}" target="_blank"><i class="bi bi-tv me-1"></i>Papan Antrean</a></li>
    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a></li>

    <!-- Light / Dark Mode Toggle Button -->
    <li class="theme-toggle-li">
      <button type="button" 
              data-theme-toggle 
              aria-label="Toggle Theme"
              class="theme-toggle-btn border-0 bg-transparent p-2">
        <svg data-theme-icon-sun class="w-5 h-5 text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <svg data-theme-icon-moon class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
      </button>
    </li>

    @auth
      <li><a href="{{ route('dashboard') }}" class="btn-book-nav">Panel Dashboard</a></li>
    @else
      <li><a href="{{ route('register') }}" class="btn-book-nav">Reservasi Sekarang</a></li>
    @endauth
  </ul>
  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>