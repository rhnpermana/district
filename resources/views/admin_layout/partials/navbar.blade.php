<nav class="navbar navbar-expand-lg w-100 p-0">
  <div class="container-fluid p-0 d-flex align-items-center justify-content-between">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="navbar-brand d-flex align-items-center sitename me-3 me-xl-4 mb-0">
      DISTRICT<span>STUDIO.</span>
    </a>

    <!-- Mobile Actions (Theme Switcher + Mobile Navbar Toggler) -->
    <div class="d-flex align-items-center gap-2 d-lg-none">
      <button type="button" 
              data-theme-toggle 
              aria-label="Toggle Theme"
              class="theme-toggle-btn border-0 bg-transparent p-2">
        <svg data-theme-icon-sun class="w-5 h-5 text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <svg data-theme-icon-moon class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
      </button>

      <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-list fs-2" style="color: var(--heading-color);"></i>
      </button>
    </div>

    <!-- Collapsible Menu -->
    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center gap-1">
        <li class="nav-item">
          <a class="nav-link px-3 py-2 rounded-3 {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2 me-1"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3 py-2 rounded-3" href="/">
            <i class="bi bi-house me-1"></i> Halaman Utama
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-3 py-2 rounded-3 position-relative {{ request()->is('mailbox*') ? 'active fw-bold' : '' }}" href="{{ route('mailbox.index') }}">
            <i class="bi bi-envelope me-1"></i> Mailbox
            @auth
              @php $unreadCount = Auth::user()->totalUnreadMessages(); @endphp
              @if($unreadCount > 0)
                <span id="navUnreadBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                      style="background: var(--accent-color); color: #000; font-size: 0.6rem; font-weight: 800; min-width: 16px; height: 16px; display: flex; align-items: center; justify-content: center; margin-left: -8px; margin-top: 6px;">
                  {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
              @else
                <span id="navUnreadBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                      style="background: var(--accent-color); color: #000; font-size: 0.6rem; font-weight: 800; min-width: 16px; height: 16px; display: none; align-items: center; justify-content: center; margin-left: -8px; margin-top: 6px;"></span>
              @endif
            @endauth
          </a>
        </li>
      </ul>

      @auth
        <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0 pb-3 pb-lg-0">
          <!-- Desktop Theme Toggle -->
          <div class="d-none d-lg-block">
            <button type="button" 
                    data-theme-toggle 
                    aria-label="Toggle Theme"
                    class="theme-toggle-btn border-0">
              <svg data-theme-icon-sun class="w-5 h-5 text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
              </svg>
              <svg data-theme-icon-moon class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
              </svg>
            </button>
          </div>

          {{-- Role badge --}}
          <span class="badge" style="
            @if(Auth::user()->role === 'owner') background: #dca53e; color: #000;
            @elseif(Auth::user()->role === 'supervisor') background: #64c8ff; color: #000;
            @elseif(Auth::user()->role === 'admin') background: #ffc107; color: #000;
            @elseif(Auth::user()->role === 'kasir') background: #28a745; color: #fff;
            @elseif(Auth::user()->role === 'receptionist') background: #00c8c8; color: #000;
            @elseif(Auth::user()->role === 'hair stylist') background: #ff9800; color: #000;
            @else background: #6c757d; color: #fff;
            @endif font-family: 'Montserrat', sans-serif; font-weight: 800; text-transform: uppercase; padding: 6px 12px; font-size: 0.7rem; border-radius: 6px;">
            {{ Auth::user()->role }}
          </span>

          {{-- Profile Avatar Dropdown --}}
          <div class="dropdown">
            <button class="btn btn-link p-0 d-flex align-items-center gap-2 text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: none;">
              @php
                $navAvatar = Auth::user()->avatar
                  ? (str_starts_with(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar))
                  : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=28a745&color=fff&size=64&bold=true';
              @endphp
              <img src="{{ $navAvatar }}" alt="{{ Auth::user()->name }}" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-color);">
              <span class="d-none d-lg-inline" style="color: var(--heading-color); font-size: 0.84rem; font-weight: 700; max-width: 130px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Auth::user()->name }}</span>
              <i class="bi bi-chevron-down d-none d-lg-inline" style="color: var(--muted-text); font-size: 0.65rem;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: 12px; min-width: 220px; padding: 8px;">
              <li>
                <div style="padding: 8px 12px 10px; border-bottom: 1px solid var(--border-color); margin-bottom: 4px;">
                  <div style="font-weight: 700; color: var(--heading-color); font-size: 0.88rem;">{{ Auth::user()->name }}</div>
                  <div style="font-size: 0.73rem; color: var(--muted-text);">{{ Auth::user()->email }}</div>
                </div>
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center gap-2 {{ request()->routeIs('profile.show') ? 'active' : '' }}"
                   href="{{ route('profile.show') }}"
                   style="color: var(--default-color); padding: 8px 12px; border-radius: 8px; font-size: 0.84rem; font-weight: 600;">
                  <i class="bi bi-person-circle" style="color: #28a745; font-size: 1rem;"></i>
                  <span>Profil Saya</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center gap-2"
                   href="{{ route('dashboard') }}"
                   style="color: var(--default-color); padding: 8px 12px; border-radius: 8px; font-size: 0.84rem; font-weight: 600;">
                  <i class="bi bi-speedometer2" style="color: #00c8c8; font-size: 1rem;"></i>
                  <span>Kembali ke Dashboard</span>
                </a>
              </li>
              <li style="border-top: 1px solid var(--border-color); margin-top: 4px; padding-top: 4px;">
                <a class="dropdown-item d-flex align-items-center gap-2 text-danger"
                   href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   style="padding: 8px 12px; border-radius: 8px; font-size: 0.84rem; font-weight: 600;">
                  <i class="bi bi-box-arrow-right" style="font-size: 1rem;"></i>
                  <span>Logout</span>
                </a>
              </li>
            </ul>
          </div>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      @endauth
    </div>
  </div>
</nav>
