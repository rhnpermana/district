<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'District Studio - Barbershop & Studio Rambut Premium')</title>
  <meta name="description" content="District Studio - Lebih dari sekadar potong rambut, ruang untuk menemukan jati diri. Barbershop premium dan studio tata rambut.">
  <meta name="keywords" content="barber, barbershop, studio rambut, district studio, potong rambut pria, pewarnaan rambut, perming">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
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
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid px-lg-5 px-3 d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center sitename me-3 me-xl-4">
        DISTRICT<span>STUDIO.</span>
      </a>
      @include('layout.partials.navbar')
    </div>
  </header>

  <!-- Tempat Konten Dinamis Halaman (Home, About, dll) -->
  @yield('content')

  <!-- Footer -->
  @include('layout.partials.footer')

  <!-- Tombol WhatsApp Mengambang -->
  <a href="https://wa.me/6285770394148?text=Halo%20District%20Studio,%20saya%20ingin%20konsultasi%20layanan%20potong%20rambut." 
     target="_blank" 
     id="whatsapp-floating-btn"
     title="Hubungi Kami via WhatsApp"
     style="position: fixed; bottom: 25px; left: 25px; z-index: 999; background: #25d366; color: #fff; width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4); text-decoration: none;">
    <i class="bi bi-whatsapp"></i>
  </a>

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

</body>

</html>