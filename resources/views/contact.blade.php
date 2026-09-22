@extends('layout.app')

@section('title', 'Kontak & Lokasi Studio - District Studio')

@section('content')
<main class="main" style="padding-top: 100px; background-color: var(--background-color);">

  <!-- Header Kontak -->
  <section class="section py-5" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
    <div class="container text-center" data-aos="fade-up">
      <span class="text-uppercase" style="color: var(--accent-color); font-weight: 800; letter-spacing: 2px; font-size: 0.85rem;">Informasi & Lokasi</span>
      <h1 class="display-4 fw-bold text-white mt-2 mb-3" style="letter-spacing: 1px;">Hubungi Kami</h1>
      <p class="lead mx-auto text-muted" style="max-width: 750px; font-size: 1.15rem;">
        Punya pertanyaan seputar layanan tata rambut, konsultasi gaya, atau ingin reservasi langsung untuk grup? Tim District Studio siap melayani Anda.
      </p>
    </div>
  </section>

  <!-- Informasi Cabang & Form Kontak -->
  <section class="section py-5">
    <div class="container">
      <div class="row g-5">

        <!-- Kolom Informasi Cabang -->
        <div class="col-lg-5" data-aos="fade-right">
          <div class="pe-lg-3">
            <span class="text-uppercase" style="color: var(--accent-color); font-weight: 700; font-size: 0.8rem; letter-spacing: 1.5px;">Lokasi Fisik</span>
            <h2 class="text-white fw-bold mt-2 mb-4" style="font-size: 1.8rem;">Cabang Resmi Studio</h2>

            <!-- Cabang Jakarta -->
            <div class="p-4 rounded mb-4" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.08);">
              <div class="d-flex align-items-center mb-3">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle me-3" style="width: 44px; height: 44px; background: rgba(220, 165, 62, 0.15); color: var(--accent-color); font-size: 1.25rem;">
                  <i class="bi bi-geo-alt-fill"></i>
                </div>
                <div>
                  <h4 class="text-white fw-bold mb-0" style="font-size: 1.2rem;">Studio Jakarta Selatan</h4>
                  <span class="small text-muted">Kebayoran Baru</span>
                </div>
              </div>
              <p class="text-muted small mb-2">
                <strong class="text-white">Alamat:</strong> Jl. Gandaria I No. 55, Kebayoran Baru, Jakarta Selatan, DKI Jakarta 12130
              </p>
              <p class="text-muted small mb-2">
                <strong class="text-white">WhatsApp:</strong> +62 838-0871-72955
              </p>
              <p class="text-muted small mb-3">
                <strong class="text-white">Jam Buka:</strong><br>
                Senin - Jumat: 10:00 - 21:00 WIB<br>
                Sabtu - Minggu: 09:00 - 21:00 WIB
              </p>
              <a href="https://maps.google.com/?q=Jl.+Gandaria+I+No.55+Jakarta+Selatan" target="_blank" class="btn btn-sm px-3 py-2 fw-semibold text-white" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 4px;">
                <i class="bi bi-map me-1"></i> Buka di Google Maps
              </a>
            </div>

            <!-- Cabang Bandung -->
            <div class="p-4 rounded mb-4" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.08);">
              <div class="d-flex align-items-center mb-3">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle me-3" style="width: 44px; height: 44px; background: rgba(220, 165, 62, 0.15); color: var(--accent-color); font-size: 1.25rem;">
                  <i class="bi bi-geo-alt-fill"></i>
                </div>
                <div>
                  <h4 class="text-white fw-bold mb-0" style="font-size: 1.2rem;">Studio Bandung</h4>
                  <span class="small text-muted">Citarum</span>
                </div>
              </div>
              <p class="text-muted small mb-2">
                <strong class="text-white">Alamat:</strong> Jl. Progo No. 30, Citarum, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115
              </p>
              <p class="text-muted small mb-2">
                <strong class="text-white">WhatsApp:</strong> +62 813-9876-5432
              </p>
              <p class="text-muted small mb-3">
                <strong class="text-white">Jam Buka:</strong><br>
                Setiap Hari: 10:00 - 21:00 WIB
              </p>
              <a href="https://maps.google.com/?q=Jl.+Progo+No.30+Bandung" target="_blank" class="btn btn-sm px-3 py-2 fw-semibold text-white" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 4px;">
                <i class="bi bi-map me-1"></i> Buka di Google Maps
              </a>
            </div>

            <!-- Layanan Bantuan Cepat WhatsApp -->
            <div class="p-3 rounded d-flex align-items-center justify-content-between" style="background: rgba(37, 211, 102, 0.1); border: 1px solid rgba(37, 211, 102, 0.3);">
              <div>
                <p class="fw-bold mb-0 text-white" style="font-size: 0.95rem;"><i class="bi bi-whatsapp text-success me-2"></i> Chat Langsung via WhatsApp</p>
                <small class="text-muted">Respon cepat dalam hitungan menit pada jam operasional</small>
              </div>
              <a href="https://wa.me/6281234567890?text=Halo%20District%20Studio,%20saya%20ingin%20tanya%20seputar%20layanan%20barber." target="_blank" class="btn btn-sm btn-success fw-bold px-3 py-2">
                Kirim Chat
              </a>
            </div>

          </div>
        </div>

        <!-- Kolom Form Kirim Pesan -->
        <div class="col-lg-7" data-aos="fade-left">
          <div class="p-4 p-md-5 rounded" style="background: #141414; border: 1px solid rgba(255, 255, 255, 0.08);">
            <span class="text-uppercase" style="color: var(--accent-color); font-weight: 700; font-size: 0.8rem; letter-spacing: 1.5px;">Formulir Pesan</span>
            <h2 class="text-white fw-bold mt-2 mb-2" style="font-size: 1.8rem;">Kirim Pesan & Pertanyaan</h2>
            <p class="text-muted small mb-4">Silakan isi formulir di bawah ini, tim customer service kami akan segera merespons pesan Anda.</p>

            <form action="https://wa.me/6281234567890" method="GET" target="_blank" onsubmit="return submitToWhatsApp(this);">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label text-white small fw-semibold">Nama Lengkap *</label>
                  <input type="text" id="contact_name" class="form-control" placeholder="Contoh: Budi Santoso" required style="background: #0b0b0b; border: 1px solid rgba(255,255,255,0.15); color: #fff;">
                </div>

                <div class="col-md-6">
                  <label class="form-label text-white small fw-semibold">Nomor WhatsApp *</label>
                  <input type="tel" id="contact_phone" class="form-control" placeholder="Contoh: 08123456789" required style="background: #0b0b0b; border: 1px solid rgba(255,255,255,0.15); color: #fff;">
                </div>

                <div class="col-md-6">
                  <label class="form-label text-white small fw-semibold">Alamat Email</label>
                  <input type="email" id="contact_email" class="form-control" placeholder="Contoh: budi@gmail.com" style="background: #0b0b0b; border: 1px solid rgba(255,255,255,0.15); color: #fff;">
                </div>

                <div class="col-md-6">
                  <label class="form-label text-white small fw-semibold">Pilih Cabang Tujuan *</label>
                  <select id="contact_branch" class="form-select" required style="background: #0b0b0b; border: 1px solid rgba(255,255,255,0.15); color: #fff;">
                    <option value="Jakarta Kebayoran Baru">Studio Jakarta (Kebayoran Baru)</option>
                    <option value="Bandung Citarum">Studio Bandung (Citarum)</option>
                  </select>
                </div>

                <div class="col-12">
                  <label class="form-label text-white small fw-semibold">Topik Pembahasan</label>
                  <input type="text" id="contact_subject" class="form-control" placeholder="Contoh: Konsultasi Gaya Rambut / Booking Rombongan" style="background: #0b0b0b; border: 1px solid rgba(255,255,255,0.15); color: #fff;">
                </div>

                <div class="col-12">
                  <label class="form-label text-white small fw-semibold">Pesan Anda *</label>
                  <textarea id="contact_message" class="form-control" rows="5" placeholder="Tuliskan pertanyaan atau informasi yang ingin Anda tanyakan..." required style="background: #0b0b0b; border: 1px solid rgba(255,255,255,0.15); color: #fff;"></textarea>
                </div>

                <div class="col-12 mt-4">
                  <button type="submit" class="btn w-100 py-3 fw-bold text-black" style="background-color: var(--accent-color); border-radius: 4px; font-size: 1rem;">
                    <i class="bi bi-send-fill me-2"></i> Kirim Pesan via WhatsApp
                  </button>
                  <p class="text-muted text-center small mt-2 mb-0">Pesan akan langsung diarahkan ke nomor WhatsApp resmi District Studio.</p>
                </div>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </section>

</main>

<script>
function submitToWhatsApp(form) {
  const name = document.getElementById('contact_name').value;
  const phone = document.getElementById('contact_phone').value;
  const email = document.getElementById('contact_email').value || '-';
  const branch = document.getElementById('contact_branch').value;
  const subject = document.getElementById('contact_subject').value || 'Pertanyaan Umum';
  const message = document.getElementById('contact_message').value;

  const text = `Halo District Studio, saya ingin bertanya:\n\n` +
               `*Nama:* ${name}\n` +
               `*Nomor HP/WA:* ${phone}\n` +
               `*Email:* ${email}\n` +
               `*Cabang:* ${branch}\n` +
               `*Topik:* ${subject}\n\n` +
               `*Pesan:*\n${message}`;

  const targetWa = branch.includes('Bandung') ? '6281398765432' : '6281234567890';
  window.open(`https://wa.me/${targetWa}?text=${encodeURIComponent(text)}`, '_blank');
  return false;
}
</script>
@endsection