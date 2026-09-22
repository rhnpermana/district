@extends('layout.app')

@section('title', 'District Studio - Barbershop & Studio Rambut Premium')

@section('content')
<main class="main">

  <!-- Hero Section -->
  <section id="hero" class="hero section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row align-items-center">
        <div class="col-lg-7 hero-content">
          <h2 data-aos="fade-up" data-aos-delay="200">Lebih dari sekadar potong rambut</h2>
          <h1 data-aos="fade-up" data-aos-delay="300">Ruang untuk <span class="highlight">menemukan jati diri</span></h1>
          <p data-aos="fade-up" data-aos-delay="400">District Studio adalah salon rambut dan barbershop bertema industrial yang dirancang untuk menghadirkan penataan rambut, pewarnaan, perming, dan perawatan grooming kelas atas bagi mereka yang menginginkan gaya hidup premium.</p>
          <div class="hero-actions" data-aos="fade-up" data-aos-delay="500">
            @auth
              <a href="{{ route('dashboard') }}" class="btn btn-primary">Reservasi Sekarang</a>
              <a href="#services" class="btn btn-outline">Jelajahi Layanan</a>
            @else
              <a href="{{ route('register') }}" class="btn btn-primary">Daftar & Reservasi</a>
              <a href="{{ route('login') }}" class="btn btn-outline">Masuk Akun</a>
            @endauth
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Hero Section -->

  <!-- Brand Story / About Section -->
  <section id="about" class="about-barber section">
    <div class="container" data-aos="fade-up">
      <div class="row align-items-center gy-5">
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
          <div class="section-title">
            <h2>Filosofi Kami</h2>
          </div>
          <p class="lead">"Kami tidak hanya memotong rambut; kami merancang karakter Anda."</p>
          <p class="mt-4">Didirikan dengan hasrat untuk meningkatkan standar perawatan rambut di Indonesia, District Studio memadukan seni tata rambut modern barat dengan tren urban lokal. Tim hair artist kami memperlakukan setiap potongan rambut sebagai kanvas, berfokus pada bentuk kepala, tekstur rambut, dan gaya hidup individu untuk membentuk penampilan unik Anda.</p>
          <p>Baik Anda mencari classic taper fade, premium down perm, root lift, dreadlock, atau fashion coloring avant-garde, kami menjamin presisi, higienitas, dan pengalaman bersantai di studio bernuansa industrial kami.</p>
          <div class="row mt-4">
            <div class="col-6 col-md-4">
              <h3 class="text-white mb-1" style="font-size: 2.2rem; font-weight: 800;">10+</h3>
              <p class="text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px; color: var(--accent-color); font-weight: 700;">Tahun Pengalaman</p>
            </div>
            <div class="col-6 col-md-4">
              <h3 class="text-white mb-1" style="font-size: 2.2rem; font-weight: 800;">50k+</h3>
              <p class="text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px; color: var(--accent-color); font-weight: 700;">Klien Puas</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
          <div class="about-image-wrapper">
            <img src="{{ asset('assets/img/barber_hero.jpg') }}" alt="Suasana District Studio" class="img-fluid">
            <div class="about-experience-badge">
              <h3>2026</h3>
              <span>New</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End About Section -->

  <!-- Services Pricing Menu -->
  <section id="services" class="services-menu section">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Daftar Layanan & Harga</h2>
      </div>

      <div class="row g-5">
        @if(isset($services) && $services->count() > 0)
          @php
            $half = ceil($services->count() / 2);
            $leftServices = $services->take($half);
            $rightServices = $services->skip($half);
          @endphp
          <!-- Left Column -->
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <h3 class="menu-category-title">Potong & Perawatan Utama</h3>
            @foreach($leftServices as $s)
              <div class="menu-item">
                <div class="menu-item-header">
                  <h4 class="menu-item-name">{{ $s->name }}</h4>
                  <div class="menu-item-dots"></div>
                  <span class="menu-item-price">IDR {{ number_format($s->price, 0, ',', '.') }}</span>
                </div>
                <p class="menu-item-description">{{ $s->description }}</p>
                <span class="menu-item-duration"><i class="bi bi-clock-history me-1"></i> {{ $s->duration_minutes }} menit</span>
              </div>
            @endforeach
          </div>

          <!-- Right Column -->
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <h3 class="menu-category-title">Perming & Pewarnaan Premium</h3>
            @foreach($rightServices as $s)
              <div class="menu-item">
                <div class="menu-item-header">
                  <h4 class="menu-item-name">{{ $s->name }}</h4>
                  <div class="menu-item-dots"></div>
                  <span class="menu-item-price">IDR {{ number_format($s->price, 0, ',', '.') }}</span>
                </div>
                <p class="menu-item-description">{{ $s->description }}</p>
                <span class="menu-item-duration"><i class="bi bi-clock-history me-1"></i> {{ $s->duration_minutes }} menit</span>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      <!-- Service Cards Highlight Images -->
      <div class="row mt-5 pt-4">
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
          <div class="service-card">
            <img src="{{ asset('assets/img/barber_cut.jpg') }}" alt="Pemotongan Presisi">
            <div class="service-card-overlay">
              <h3>Pemotongan Presisi</h3>
              <p>GARIS RAMBUT & FADE KLASIK</p>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
          <div class="service-card">
            <img src="{{ asset('assets/img/barber_coloring.jpg') }}" alt="Seni Pewarnaan Rambut">
            <div class="service-card-overlay">
              <h3>Seni Pewarnaan Rambut</h3>
              <p>PLATINUM, PASTEL & TONES</p>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
          <div class="service-card">
            <img src="{{ asset('assets/img/barber_perm.jpg') }}" alt="Perawatan Perming Teknis">
            <div class="service-card-overlay">
              <h3>Perawatan Perming Teknis</h3>
              <p>DOWN PERM & ROOT VOLUME</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
  <!-- End Services Section -->

  <!-- Stylists / Hair Artists Section -->
  <section id="stylists" class="stylists-section section">
    <div class="container" data-aos="fade-up">
      <div class="section-title text-center">
        <h2>Para Hair Artist</h2>
        <p class="text-muted">Pilih hair artist Anda untuk mendapatkan pengalaman potong rambut yang dipersonalisasi</p>
      </div>

      <div class="row g-4 mt-4 justify-content-center">
        <!-- Stylist 1 -->
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="stylist-card">
            <div class="stylist-img-wrapper">
              <img src="{{ asset('assets/img/rehan(3).png') }}" alt="Veng">
              <div class="stylist-socials">
                <a href="https://www.instagram.com/rhnn.ap/"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-tiktok"></i></a>
              </div>
            </div>
            <div class="stylist-info">
              <h4>Veng</h4>
              <span>Hair Art Director</span>
            </div>
          </div>
        </div>

        <!-- Stylist 2 -->
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="stylist-card">
            <div class="stylist-img-wrapper">
              <img src="{{ asset('assets/img/acel.png') }}" alt="Gallagher">
              <div class="stylist-socials">
                <a href="https://www.instagram.com/panchjul/?utm_source=ig_web_button_share_sheet"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-tiktok"></i></a>
              </div>
            </div>
            <div class="stylist-info">
              <h4>Gallagher</h4>
              <span>Senior Hair Artist</span>
            </div>
          </div>
        </div>

        <!-- Stylist 3 -->
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="stylist-card">
            <div class="stylist-img-wrapper">
              <img src="{{ asset('assets/img/rasya.png') }}" alt="Pelupessy">
              <div class="stylist-socials">
                <a href="https://www.instagram.com/rsyaalfqhh?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-tiktok"></i></a>
              </div>
            </div>
            <div class="stylist-info">
              <h4>Pelupessy</h4>
              <span>Senior Barber</span>
            </div>
          </div>
        </div>

        <!-- Stylist 4 -->
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
          <div class="stylist-card">
            <div class="stylist-img-wrapper">
              <img src="{{ asset('assets/img/sandi.jpeg') }}" alt="Sandi">
              <div class="stylist-socials">
                <a href="https://www.instagram.com/dwiiwarna/?utm_source=ig_web_button_share_sheet"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-tiktok"></i></a>
              </div>
            </div>
            <div class="stylist-info">
              <h4>Sandi</h4>
              <span>Senior Barber</span>
            </div>
          </div>
        </div>

        <!-- Stylist 5 -->
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="stylist-card">
            <div class="stylist-img-wrapper">
              <img src="{{ asset('assets/img/kikuk.jpeg') }}" alt="Kikuk">
              <div class="stylist-socials">
                <a href="https://www.instagram.com/zure4_h"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-tiktok"></i></a>
              </div>
            </div>
            <div class="stylist-info">
              <h4>Kikuk</h4>
              <span>Senior Barber</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Stylists Section -->

  <!-- Koleksi Gaya Rambut / Lookbook Section -->
  <section id="lookbook" class="lookbook-section section" style="background-color: #0d0d0d; padding: 90px 0; border-top: 1px solid rgba(255, 255, 255, 0.05); border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
    <div class="container" data-aos="fade-up">
      <div class="section-title text-center mb-5">
        <span class="text-uppercase" style="color: var(--accent-color); font-weight: 800; letter-spacing: 2px; font-size: 0.8rem;">Galeri & Inspirasi</span>
        <h2 class="text-white fw-bold mt-2" style="font-size: 2.2rem;">Koleksi Gaya Rambut</h2>
        <p class="text-muted mx-auto" style="max-width: 650px;">
          Jelajahi inspirasi potongan rambut terkini hasil karya para hair artist profesional District Studio. Pilih gaya yang mencerminkan jati diri Anda.
        </p>
      </div>

      @if(isset($portfolios) && $portfolios->count() > 0)
        <div class="row g-4">
          @foreach($portfolios as $item)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
              <div class="lookbook-card rounded overflow-hidden h-100 d-flex flex-column" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.08); transition: transform 0.3s ease, border-color 0.3s ease;">
                <div class="position-relative overflow-hidden" style="aspect-ratio: 4/3; background: #222;">
                  <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                  <div class="position-absolute top-0 start-0 m-3 px-3 py-1 rounded" style="background: rgba(11, 11, 11, 0.85); backdrop-filter: blur(8px); border: 1px solid rgba(220, 165, 62, 0.3);">
                    <small class="text-warning fw-bold" style="font-size: 0.75rem;"><i class="bi bi-scissors me-1"></i> {{ $item->stylist->name ?? 'District Barber' }}</small>
                  </div>
                </div>
                <div class="p-4 d-flex flex-column flex-grow-1">
                  <h4 class="text-white fw-bold mb-2" style="font-size: 1.25rem;">{{ $item->title }}</h4>
                  <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">{{ $item->description ?? 'Potongan rambut presisi dengan penataan berkelas untuk penampilan maksimal Anda.' }}</p>
                  <div class="pt-3" style="border-top: 1px solid rgba(255, 255, 255, 0.06);">
                    @auth
                      <a href="{{ route('dashboard') }}" class="btn btn-sm w-100 fw-bold py-2 text-black" style="background-color: var(--accent-color); border-radius: 4px;">
                        <i class="bi bi-calendar-check me-1"></i> Pilih Gaya Ini & Reservasi
                      </a>
                    @else
                      <a href="{{ route('register') }}" class="btn btn-sm w-100 fw-bold py-2 text-black" style="background-color: var(--accent-color); border-radius: 4px;">
                        <i class="bi bi-calendar-check me-1"></i> Pilih Gaya Ini & Reservasi
                      </a>
                    @endauth
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </section>
  <!-- End Lookbook Section -->

  <!-- Produk Perawatan & Styling (Grooming Products) -->
  <section id="products" class="products-section section" style="background-color: #0b0b0b; padding: 90px 0;">
    <div class="container" data-aos="fade-up">
      <div class="section-title text-center mb-5">
        <span class="text-uppercase" style="color: var(--accent-color); font-weight: 800; letter-spacing: 2px; font-size: 0.8rem;">Koleksi Grooming</span>
        <h2 class="text-white fw-bold mt-2" style="font-size: 2.2rem;">Produk Perawatan & Styling</h2>
        <p class="text-muted mx-auto" style="max-width: 650px;">
          Lanjutkan perawatan rambut dan penataan gaya terbaik di rumah dengan rangkaian produk premium resmi yang kami gunakan di studio.
        </p>
      </div>

      @if(isset($products) && $products->count() > 0)
        <div class="row g-4">
          @foreach($products as $prod)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
              <div class="product-card p-4 rounded h-100 d-flex flex-column" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.08); position: relative;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="badge px-2 py-1" style="background: rgba(220, 165, 62, 0.15); color: var(--accent-color); font-weight: 700; font-size: 0.75rem;">
                    {{ $prod->category }}
                  </span>
                  <span class="badge bg-dark text-success border border-success" style="font-size: 0.7rem;">
                    <i class="bi bi-check-circle-fill me-1"></i> Stok {{ $prod->stock }}
                  </span>
                </div>

                <div class="text-center py-3 my-2 rounded" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.04);">
                  <i class="bi bi-box-seam text-white" style="font-size: 3rem; opacity: 0.7;"></i>
                </div>

                <h4 class="text-white fw-bold mt-2 mb-1" style="font-size: 1.1rem;">{{ $prod->name }}</h4>
                <p class="text-muted small mb-3 flex-grow-1" style="line-height: 1.6;">{{ $prod->description }}</p>

                <div class="pt-3 mt-auto" style="border-top: 1px solid rgba(255, 255, 255, 0.06);">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="small text-muted">Harga:</span>
                    <span class="text-white fw-bold" style="color: var(--accent-color) !important; font-size: 1.15rem;">
                      Rp {{ number_format($prod->price, 0, ',', '.') }}
                    </span>
                  </div>
                  <a href="https://wa.me/6281234567890?text=Halo%20District%20Studio,%20saya%20tertarik%20membeli%20produk%20{{ urlencode($prod->name) }}." target="_blank" class="btn btn-sm w-100 py-2 fw-semibold text-white" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 4px;">
                    <i class="bi bi-whatsapp me-1 text-success"></i> Pesan via WhatsApp
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </section>
  <!-- End Products Section -->

  <!-- CTA Booking Banner -->
  <section class="cta-booking section">
    <div class="container" data-aos="zoom-in">
      <h2>Tingkatkan Gaya Rambut Anda</h2>
      <p>Bergabunglah dalam pergerakan ini. Pesan kursi Anda hari ini dan dapatkan perawatan terbaik dari para hair artist terbaik di industrinya.</p>
      @auth
        <a href="{{ route('dashboard') }}" class="btn btn-booking">Reservasi Sekarang</a>
      @else
        <a href="{{ route('register') }}" class="btn btn-booking">Daftar & Reservasi Sekarang</a>
      @endauth
    </div>
  </section>
  <!-- End CTA Booking Banner -->

  <!-- Contact & Info Section -->
  <section id="contact" class="contact section" style="background-color: #0b0b0b; padding: 100px 0;">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Kontak & Lokasi</h2>
      </div>

      <div class="row gy-4">
        <div class="col-lg-6">
          <div class="info-item d-flex align-items-center" style="background-color: #121212; padding: 30px; margin-bottom: 20px;" data-aos="fade-up" data-aos-delay="200">
            <i class="bi bi-geo-alt flex-shrink-0" style="font-size: 24px; color: var(--accent-color); margin-right: 20px;"></i>
            <div>
              <h3 style="font-size: 1.1rem; color: #fff; margin-bottom: 5px;">Studio Jakarta</h3>
              <p style="margin: 0;">SMK NEGERI 17 Jakarta Barat
5, Jl. G1 No.7, RT.1/RW.3, Slipi, Kec. Palmerah, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11410</p>
            </div>
          </div>
 
          <div class="info-item d-flex align-items-center" style="background-color: #121212; padding: 30px;" data-aos="fade-up" data-aos-delay="400">
            <i class="bi bi-envelope flex-shrink-0" style="font-size: 24px; color: var(--accent-color); margin-right: 20px;"></i>
            <div>
              <h3 style="font-size: 1.1rem; color: #fff; margin-bottom: 5px;">Layanan Online</h3>
              <p style="margin: 0;">district-studio@gmail.com | WhatsApp: +62 857-7039-4148</p>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div style="width: 100%; height: 380px; border: 1px solid rgba(255,255,255,0.05);" data-aos="fade-up" data-aos-delay="200">
            <!-- Custom Styled Google Maps Embed (Dark Theme) -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.545977120131!2d106.79695397364301!3d-6.191451193796155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f693c75dbed3%3A0xc6569c9cca3d85fc!2sSMK%20NEGERI%2017%20Jakarta%20Barat!5e0!3m2!1sid!2sid!4v1789364019940!5m2!1sid!2sid%22" width="100%" height="100%" style="border:0; filter: grayscale(100%) invert(90%) contrast(1.2);" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Contact Section -->

</main>

{{-- Notifikasi kecil di pojok bawah untuk tamu (guest) yang belum login --}}
@guest
<div id="guestNotif" style="position:fixed; bottom:30px; right:30px; z-index:9999; background:#121212; border:1px solid rgba(220,165,62,0.4); padding:20px 25px; max-width:320px; box-shadow: 0 10px 40px rgba(0,0,0,0.6); display:none;">
  <button onclick="document.getElementById('guestNotif').style.display='none'"
    style="position:absolute;top:10px;right:14px;background:transparent;border:none;color:#555;font-size:18px;cursor:pointer;line-height:1;">&times;</button>
  <p style="font-family:'Montserrat',sans-serif;font-size:0.72rem;color:var(--accent-color);font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:6px;">
    <i class="bi bi-scissors me-1"></i> District Studio
  </p>
  <p style="font-size:0.88rem;color:#ccc;margin-bottom:16px;line-height:1.5;">
    Daftar atau masuk akun untuk membuat reservasi online Anda.
  </p>
  <div style="display:flex;gap:10px;">
    <a href="{{ route('register') }}" style="flex:1;background:var(--accent-color);color:#000;text-align:center;padding:10px;font-family:'Montserrat',sans-serif;font-size:0.72rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;text-decoration:none;">Daftar</a>
    <a href="{{ route('login') }}" style="flex:1;background:transparent;border:1px solid rgba(255,255,255,0.15);color:#fff;text-align:center;padding:10px;font-family:'Montserrat',sans-serif;font-size:0.72rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;text-decoration:none;">Masuk</a>
  </div>
</div>
<script>
  // Show guest notif after 3 seconds
  setTimeout(function() {
    const notif = document.getElementById('guestNotif');
    if (notif) notif.style.display = 'block';
  }, 3000);
</script>
@endguest
@endsection