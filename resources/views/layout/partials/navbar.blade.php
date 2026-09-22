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

    @auth
      <li><a href="{{ route('dashboard') }}" class="btn-book-nav">Panel Dashboard</a></li>
    @else
      <li><a href="{{ route('register') }}" class="btn-book-nav">Reservasi Sekarang</a></li>
    @endauth
  </ul>
  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>