@extends('layout.app')

@section('title', 'Tentang Kami - District Studio Barbershop')

@section('content')
<main class="main" style="padding-top: 100px; background-color: var(--background-color);">

  <!-- Hero Banner Tentang Kami -->
  <section class="section py-5" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
    <div class="container text-center" data-aos="fade-up">
      <span class="text-uppercase" style="color: var(--accent-color); font-weight: 800; letter-spacing: 2px; font-size: 0.85rem;">Mengenal Lebih Dekat</span>
      <h1 class="display-4 fw-bold text-white mt-2 mb-3" style="letter-spacing: 1px;">Tentang District Studio</h1>
      <p class="lead mx-auto text-muted" style="max-width: 750px; font-size: 1.15rem;">
        Lebih dari sekadar tempat potong rambut. Kami adalah ruang temu bagi Anda yang ingin mengekspresikan karakter, kepribadian, dan kepercayaan diri terbaik melalui tata rambut berkelas.
      </p>
    </div>
  </section>

  <!-- Filosofi & Cerita Kami -->
  <section class="section py-5">
    <div class="container">
      <div class="row align-items-center gy-5">
        <div class="col-lg-6" data-aos="fade-right">
          <div class="pe-lg-4">
            <span class="text-uppercase" style="color: var(--accent-color); font-weight: 700; font-size: 0.8rem; letter-spacing: 1.5px;">Filosofi Kami</span>
            <h2 class="text-white fw-bold mt-2 mb-4" style="font-size: 2.2rem; line-height: 1.3;">
              "Rambut Adalah Mahkota, dan Setiap Potongan Adalah Karya Seni."
            </h2>
            <p style="line-height: 1.8; color: var(--default-color);">
              Didirikan dengan visi mengangkat standar pangkas rambut pria dan penataan rambut modern di Indonesia, <strong>District Studio</strong> memadukan keterampilan gunting presisi ala barat dengan tren gaya hidup urban lokal.
            </p>
            <p style="line-height: 1.8; color: var(--default-color);">
              Bagi kami, setiap pelanggan memiliki keunikan struktur kepala, arah tumbuh rambut, dan gaya personal yang berbeda. Kami tidak sekadar mengikuti tren sesaat, melainkan mendengarkan kebutuhan Anda untuk menciptakan gaya rambut yang nyaman, berkarakter, dan mudah dirawat dalam aktivitas sehari-hari.
            </p>

            <div class="row g-4 mt-3 pt-3" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
              <div class="col-6 col-sm-4">
                <h3 class="fw-bold mb-0 text-white" style="font-size: 2.4rem; color: var(--accent-color) !important;">10+</h3>
                <p class="text-muted small mb-0 text-uppercase fw-semibold" style="letter-spacing: 1px;">Tahun Pengalaman</p>
              </div>
              <div class="col-6 col-sm-4">
                <h3 class="fw-bold mb-0 text-white" style="font-size: 2.4rem; color: var(--accent-color) !important;">50.000+</h3>
                <p class="text-muted small mb-0 text-uppercase fw-semibold" style="letter-spacing: 1px;">Pelanggan Puas</p>
              </div>
              <div class="col-6 col-sm-4">
                <h3 class="fw-bold mb-0 text-white" style="font-size: 2.4rem; color: var(--accent-color) !important;">2 Cabang</h3>
                <p class="text-muted small mb-0 text-uppercase fw-semibold" style="letter-spacing: 1px;">Jakarta & Bandung</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6" data-aos="fade-left">
          <div class="position-relative p-2" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px;">
            <img src="{{ asset('assets/img/barber_hero.jpg') }}" alt="Suasana District Studio" class="img-fluid rounded" style="width: 100%; object-fit: cover; max-height: 480px;">
            <div class="p-3 text-center position-absolute bottom-0 start-50 translate-middle-x mb-4 w-75 rounded" style="background: rgba(11, 11, 11, 0.88); backdrop-filter: blur(10px); border: 1px solid rgba(220, 165, 62, 0.3);">
              <p class="mb-0 text-white fw-semibold small">Studio Bernuansa Industrial Modern & Nyaman</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 4 Standar Kualitas Utama -->
  <section class="section py-5" style="background: rgba(255, 255, 255, 0.015); border-top: 1px solid rgba(255, 255, 255, 0.05); border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
    <div class="container" data-aos="fade-up">
      <div class="text-center mb-5">
        <span class="text-uppercase" style="color: var(--accent-color); font-weight: 800; letter-spacing: 2px; font-size: 0.8rem;">Keunggulan Kami</span>
        <h2 class="text-white fw-bold mt-2" style="font-size: 2rem;">Mengapa Memilih District Studio?</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">Kami berkomitmen memberikan pengalaman pangkas dan perawatan rambut terbaik tanpa kompromi.</p>
      </div>

      <div class="row g-4">
        <!-- Pilar 1 -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
          <div class="p-4 h-100 rounded" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.06); transition: transform 0.3s ease;">
            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 55px; height: 55px; background: rgba(220, 165, 62, 0.12); color: var(--accent-color); font-size: 1.5rem;">
              <i class="bi bi-scissors"></i>
            </div>
            <h4 class="text-white fw-bold mb-2" style="font-size: 1.15rem;">Guntingan Presisi Tinggi</h4>
            <p class="text-muted small mb-0" style="line-height: 1.7;">
              Teknik pemotongan rapi bertaraf profesional untuk berbagai gaya, mulai dari taper fade klasik, gaya rambut korea, hingga potongan modern bertekstur.
            </p>
          </div>
        </div>

        <!-- Pilar 2 -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
          <div class="p-4 h-100 rounded" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.06); transition: transform 0.3s ease;">
            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 55px; height: 55px; background: rgba(220, 165, 62, 0.12); color: var(--accent-color); font-size: 1.5rem;">
              <i class="bi bi-shield-check"></i>
            </div>
            <h4 class="text-white fw-bold mb-2" style="font-size: 1.15rem;">Sterilisasi & Higienis</h4>
            <p class="text-muted small mb-0" style="line-height: 1.7;">
              Semua gunting, clipper, dan mata pisau disterilkan secara berkala menggunakan sinar UV dan cairan antiseptik medis. Handuk bersih selalu disediakan.
            </p>
          </div>
        </div>

        <!-- Pilar 3 -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
          <div class="p-4 h-100 rounded" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.06); transition: transform 0.3s ease;">
            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 55px; height: 55px; background: rgba(220, 165, 62, 0.12); color: var(--accent-color); font-size: 1.5rem;">
              <i class="bi bi-chat-dots"></i>
            </div>
            <h4 class="text-white fw-bold mb-2" style="font-size: 1.15rem;">Konsultasi Gaya Gratis</h4>
            <p class="text-muted small mb-0" style="line-height: 1.7;">
              Hair artist kami siap berdiskusi sebelum pangkas dimulai untuk memastikan model rambut selaras dengan bentuk wajah dan gaya hidup Anda.
            </p>
          </div>
        </div>

        <!-- Pilar 4 -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
          <div class="p-4 h-100 rounded" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.06); transition: transform 0.3s ease;">
            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 55px; height: 55px; background: rgba(220, 165, 62, 0.12); color: var(--accent-color); font-size: 1.5rem;">
              <i class="bi bi-droplet-half"></i>
            </div>
            <h4 class="text-white fw-bold mb-2" style="font-size: 1.15rem;">Produk Perawatan Unggulan</h4>
            <p class="text-muted small mb-0" style="line-height: 1.7;">
              Hanya menggunakan bahan pewarna rambut, obat pengeriting (perm), pomade, serta serum rambut premium yang aman dan menyehatkan kulit kepala.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Tim Hair Artist Kami -->
  <section class="section py-5">
    <div class="container" data-aos="fade-up">
      <div class="text-center mb-5">
        <span class="text-uppercase" style="color: var(--accent-color); font-weight: 800; letter-spacing: 2px; font-size: 0.8rem;">Talenta Profesional</span>
        <h2 class="text-white fw-bold mt-2" style="font-size: 2rem;">Para Hair Artist Kami</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">Tim berdedikasi tinggi dengan sertifikasi profesional dan pengalaman bertahun-tahun di dunia tata rambut.</p>
      </div>

      <div class="row g-4 justify-content-center">
        <!-- Artist 1 -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
          <div class="text-center p-3 rounded h-100" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.06);">
            <div class="overflow-hidden rounded mb-3" style="aspect-ratio: 1/1; background: #222;">
              <img src="{{ asset('assets/img/rehan(3).png') }}" alt="Veng" class="w-100 h-100" style="object-fit: cover; object-position: top;">
            </div>
            <h4 class="text-white fw-bold mb-1">Veng</h4>
            <span class="small d-block mb-3" style="color: var(--accent-color); font-weight: 700;">Hair Art Director</span>
            <p class="text-muted small mb-3">Spesialisasi gaya rambut avant-garde, potongan tekstur presisi tinggi, dan konsultasi bentuk proporsi wajah.</p>
            <a href="https://www.instagram.com/rhnn.ap/" target="_blank" class="btn btn-sm btn-outline-secondary px-3 py-1" style="font-size: 0.8rem; border-color: rgba(255, 255, 255, 0.15);">
              <i class="bi bi-instagram me-1"></i> Profil Instagram
            </a>
          </div>
        </div>

        <!-- Artist 2 -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
          <div class="text-center p-3 rounded h-100" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.06);">
            <div class="overflow-hidden rounded mb-3" style="aspect-ratio: 1/1; background: #222;">
              <img src="{{ asset('assets/img/acel.png') }}" alt="Gallagher" class="w-100 h-100" style="object-fit: cover; object-position: top;">
            </div>
            <h4 class="text-white fw-bold mb-1">Gallagher</h4>
            <span class="small d-block mb-3" style="color: var(--accent-color); font-weight: 700;">Senior Hair Artist</span>
            <p class="text-muted small mb-3">Ahli dalam pewarnaan rambut kreatif (bleaching & tone balance) serta penataan gaya pengeritingan modern.</p>
            <a href="https://www.instagram.com/panchjul/" target="_blank" class="btn btn-sm btn-outline-secondary px-3 py-1" style="font-size: 0.8rem; border-color: rgba(255, 255, 255, 0.15);">
              <i class="bi bi-instagram me-1"></i> Profil Instagram
            </a>
          </div>
        </div>

        <!-- Artist 3 -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
          <div class="text-center p-3 rounded h-100" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.06);">
            <div class="overflow-hidden rounded mb-3" style="aspect-ratio: 1/1; background: #222;">
              <img src="{{ asset('assets/img/rasya.png') }}" alt="Pelupessy" class="w-100 h-100" style="object-fit: cover; object-position: top;">
            </div>
            <h4 class="text-white fw-bold mb-1">Pelupessy</h4>
            <span class="small d-block mb-3" style="color: var(--accent-color); font-weight: 700;">Senior Barber</span>
            <p class="text-muted small mb-3">Pakar gradasi fade klasik yang halus, pembersihan kontur jenggot, dan gaya rambut maskulin tahan lama.</p>
            <a href="https://www.instagram.com/rsyaalfqhh" target="_blank" class="btn btn-sm btn-outline-secondary px-3 py-1" style="font-size: 0.8rem; border-color: rgba(255, 255, 255, 0.15);">
              <i class="bi bi-instagram me-1"></i> Profil Instagram
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Galeri Suasana Studio -->
  <section class="section py-5" style="background: rgba(255, 255, 255, 0.015); border-top: 1px solid rgba(255, 255, 255, 0.05);">
    <div class="container" data-aos="fade-up">
      <div class="text-center mb-5">
        <span class="text-uppercase" style="color: var(--accent-color); font-weight: 800; letter-spacing: 2px; font-size: 0.8rem;">Galeri Studio</span>
        <h2 class="text-white fw-bold mt-2" style="font-size: 2rem;">Suasana & Fasilitas Studio</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">Desain interior industrial yang elegan, bersih, dan menenangkan untuk momen santai Anda.</p>
      </div>

      <div class="row g-4">
        <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
          <div class="rounded overflow-hidden" style="height: 240px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <img src="{{ asset('assets/img/barber_hero.jpg') }}" alt="Area Utama Studio" class="w-100 h-100" style="object-fit: cover;">
          </div>
          <p class="text-center text-white small mt-2 fw-semibold">Area Utama Studio</p>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
          <div class="rounded overflow-hidden" style="height: 240px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <img src="{{ asset('assets/img/barber_cut.jpg') }}" alt="Layanan Potong Rambut Presisi" class="w-100 h-100" style="object-fit: cover;">
          </div>
          <p class="text-center text-white small mt-2 fw-semibold">Pangkas & Penataan Presisi</p>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
          <div class="rounded overflow-hidden" style="height: 240px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <img src="{{ asset('assets/img/barber_perm.jpg') }}" alt="Treatment Pengeritingan Rambut" class="w-100 h-100" style="object-fit: cover;">
          </div>
          <p class="text-center text-white small mt-2 fw-semibold">Perawatan Tekstur Rambut</p>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="400">
          <div class="rounded overflow-hidden" style="height: 240px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <img src="{{ asset('assets/img/barber_coloring.jpg') }}" alt="Pewarnaan Rambut Khusus" class="w-100 h-100" style="object-fit: cover;">
          </div>
          <p class="text-center text-white small mt-2 fw-semibold">Pewarnaan Rambut Khusus</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Ajakan Bertindak (CTA) -->
  <section class="section py-5 text-center" style="background: linear-gradient(180deg, #111 0%, #000 100%); border-top: 1px solid rgba(220, 165, 62, 0.2);">
    <div class="container py-4" data-aos="fade-up">
      <h2 class="display-6 fw-bold text-white mb-3">Siap Tampil Beda & Lebih Percaya Diri?</h2>
      <p class="text-muted mx-auto mb-4" style="max-width: 650px;">
        Pilih hair artist favorit Anda dan tentukan jadwal kunjungan tanpa perlu menunggu antrean panjang di studio.
      </p>
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        @auth
          <a href="{{ route('dashboard') }}" class="btn px-4 py-3 fw-bold text-black" style="background-color: var(--accent-color); border-radius: 4px; font-size: 0.95rem;">
            <i class="bi bi-calendar-check me-2"></i> Buat Reservasi Sekarang
          </a>
        @else
          <a href="{{ route('register') }}" class="btn px-4 py-3 fw-bold text-black" style="background-color: var(--accent-color); border-radius: 4px; font-size: 0.95rem;">
            <i class="bi bi-calendar-check me-2"></i> Daftar & Reservasi Sekarang
          </a>
        @endauth
        <a href="{{ url('/contact') }}" class="btn px-4 py-3 fw-bold text-white" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 4px; font-size: 0.95rem;">
          <i class="bi bi-geo-alt me-2"></i> Lihat Alamat Studio
        </a>
      </div>
    </div>
  </section>

</main>
@endsection