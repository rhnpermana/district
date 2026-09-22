<footer id="footer" class="footer">

  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="/" class="footer-logo">
          DISTRICT<span>STUDIO.</span>
        </a>
        <p>Ruang untuk menemukan jati diri. Kami memperlakukan rambut sebagai kanvas dan pangkas rambut sebagai karya seni. Menakjubkan secara visual, presisi secara teknis, dan dirancang khusus untuk meningkatkan rasa percaya diri Anda.</p>
        
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Tautan Cepat</h4>
        <ul>
          <li><a href="{{ url('/') }}">Beranda</a></li>
          <li><a href="{{ route('about') }}">Tentang Kami</a></li>
          <li><a href="{{ url('/#services') }}">Layanan & Harga</a></li>
          <li><a href="{{ url('/#stylists') }}">Hair Artist</a></li>
          <li><a href="{{ url('/#lookbook') }}">Koleksi Gaya</a></li>
          <li><a href="{{ url('/#products') }}">Produk Grooming</a></li>
          <li><a href="{{ route('queue.board') }}" target="_blank">Papan Antrean</a></li>
          <li><a href="{{ route('contact') }}">Kontak & Lokasi</a></li>
          @auth
          <li><a href="{{ route('dashboard') }}">Panel Reservasi</a></li>
          @else
          <li><a href="{{ route('register') }}">Reservasi Sekarang</a></li>
          @endauth
        </ul>
      </div>

      <div class="col-lg-3 col-md-3 footer-contact">
        <h4>Cabang Studio Kami</h4>
        <p><strong>Jakarta Barat:</strong><br>
Jl. G1 No.7, RT.1/RW.3, Slipi, Kec. Palmerah, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11410</p>
        <p><strong>WhatsApp:</strong> +62 857-7039-4148</p>
        <p><strong>Email:</strong> district-studio@gmail.com</p>
      </div>

      <div class="col-lg-3 col-md-6 footer-hours">
        <h4>Jam Operasional</h4>
        <table class="footer-hours-table">
          <tr>
            <td>Senin - Jumat</td>
            <td>10:00 - 21:00 WIB</td>
          </tr>
          <tr>
            <td>Sabtu</td>
            <td>09:00 - 21:00 WIB</td>
          </tr>
          <tr>
            <td>Minggu</td>
            <td>09:00 - 20:00 WIB</td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="container footer-bottom text-center">
    <p>© <span>Hak Cipta</span> <strong class="px-1 sitename">District Studio</strong> <span>Seluruh Hak Dilindungi</span></p>
  </div>

</footer>
