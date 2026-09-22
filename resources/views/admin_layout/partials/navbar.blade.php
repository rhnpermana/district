<nav class="navbar navbar-expand-lg navbar-dark w-100 px-0">
  <div class="container-fluid px-0">
    <a href="{{ route('dashboard') }}" class="navbar-brand me-4" style="font-family: 'Montserrat', sans-serif; font-weight: 800; letter-spacing: 1px; color: #fff;">
      DISTRICT<span style="color: var(--accent-color, #dca53e);">STUDIO.</span>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2 me-1"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/">
            <i class="bi bi-house me-1"></i> Halaman Utama
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link position-relative {{ request()->is('mailbox*') ? 'active' : '' }}" href="{{ route('mailbox.index') }}">
            <i class="bi bi-envelope me-1"></i> Mailbox
            @auth
              @php $unreadCount = Auth::user()->totalUnreadMessages(); @endphp
              @if($unreadCount > 0)
                <span id="navUnreadBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                      style="background: #dca53e; color: #000; font-size: 0.6rem; font-weight: 800; min-width: 16px; height: 16px; display: flex; align-items: center; justify-content: center; margin-left: -8px; margin-top: 4px;">
                  {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
              @else
                <span id="navUnreadBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                      style="background: #dca53e; color: #000; font-size: 0.6rem; font-weight: 800; min-width: 16px; height: 16px; display: none; align-items: center; justify-content: center; margin-left: -8px; margin-top: 4px;"></span>
              @endif
            @endauth
          </a>
        </li>

      </ul>

      @auth
        <div class="d-flex align-items-center gap-2">
          {{-- Role badge --}}
          <span class="badge d-none d-lg-inline" style="
            @if(Auth::user()->role === 'owner') background: #dca53e; color: #000;
            @elseif(Auth::user()->role === 'supervisor') background: #64c8ff; color: #000;
            @elseif(Auth::user()->role === 'admin') background: #ffc107; color: #000;
            @elseif(Auth::user()->role === 'kasir') background: #28a745; color: #fff;
            @elseif(Auth::user()->role === 'receptionist') background: #00c8c8; color: #000;
            @elseif(Auth::user()->role === 'hair stylist') background: #ff9800; color: #000;
            @else background: #6c757d; color: #fff;
            @endif font-family: 'Montserrat', sans-serif; font-weight: 800; text-transform: uppercase; padding: 5px 11px; font-size: 0.68rem;">
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
              <img src="{{ $navAvatar }}" alt="{{ Auth::user()->name }}" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.2);">
              <span class="text-white d-none d-lg-inline" style="font-size: 0.82rem; font-weight: 600; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Auth::user()->name }}</span>
              <i class="bi bi-chevron-down text-white-50 d-none d-lg-inline" style="font-size: 0.65rem;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="background: #18181b; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; min-width: 200px; padding: 8px;">
              <li>
                <div style="padding: 8px 12px 10px; border-bottom: 1px solid rgba(255,255,255,0.07); margin-bottom: 4px;">
                  <div style="font-weight: 700; color: #fff; font-size: 0.88rem;">{{ Auth::user()->name }}</div>
                  <div style="font-size: 0.73rem; color: #71717a;">{{ Auth::user()->email }}</div>
                </div>
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center gap-2 {{ request()->routeIs('profile.show') ? 'active' : '' }}"
                   href="{{ route('profile.show') }}"
                   style="color: #e4e4e7; padding: 8px 12px; border-radius: 6px; font-size: 0.84rem;">
                  <i class="bi bi-person-circle" style="color: #28a745; font-size: 1rem;"></i>
                  <span>Profil Saya</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center gap-2"
                   href="{{ route('dashboard') }}"
                   style="color: #e4e4e7; padding: 8px 12px; border-radius: 6px; font-size: 0.84rem;">
                  <i class="bi bi-speedometer2" style="color: #00c8c8; font-size: 1rem;"></i>
                  <span>Kembali ke Dashboard</span>
                </a>
              </li>
              <li style="border-top: 1px solid rgba(255,255,255,0.07); margin-top: 4px; padding-top: 4px;">
                <a class="dropdown-item d-flex align-items-center gap-2"
                   href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   style="color: #dc3545; padding: 8px 12px; border-radius: 6px; font-size: 0.84rem;">
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

