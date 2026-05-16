@extends('layouts.master')

@section('custom-css')

    .gallery-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}
    .splash {
    /* Urutan: Gradasi warna dulu baru URL gambar */
    background: linear-gradient(
                    rgba(114, 129, 86, 0.4), /* Hijau Tua Palette #728156 dengan transparansi 60% */
                    rgba(152, 167, 124, 0.5)  /* Hijau Sedang Palette #98A77C dengan transparansi 50% */
                ),
                url("{{ asset('img/puncak.jpg') }}") no-repeat fixed center !important;
    background-size: cover;
    background-attachment: fixed; /* Menjaga efek parallax agar foto tetap diam saat di-scroll */
    min-height: 100vh; /* Memastikan splash screen menutupi layar penuh */
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-explore {
        background-color: #656D4A;
        color: white !important;
        padding: 12px 25px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        transition: 0.3s;
    }
    .btn-explore:hover {
        background-color: #414833;
        transform: translateY(-3px);
    }
    /* Perbaikan agar logo dan teks navigasi pas */
    .nav-logo {
        height: 40px;
        border-radius: 50%;
    }
/* Menurunkan posisi teks menu agar sejajar vertikal dengan logo */
    nav ul {
        margin-top: 18px !important;
    }
@endsection

@section('content')
<nav class="container-fluid nav">
  <div class="container-fluid cf">
    <div class="brand">
    <a href="#splash" style="display: flex; align-items: center;">
        <img src="{{ asset('img/logo.jpg') }}" alt="Logo GPPI" class="nav-logo">
        <span style="margin-left: 10px;">G. Puncak Pasir Ipis</span>
    </a>
    </div>
    <i class="fa fa-bars nav-toggle"></i>
    <ul>
      <li><a href="#about">Profil</a></li>
      <li><a href="#skills">Informasi</a></li>
      <li><a href="#portfolio">Galeri</a></li>
      <li><a href="#ulasan">Ulasan</a></li>
      <li><a href="#contact">Kontak</a></li>
      <li>
        <a href="{{ url('/login') }}" style="font-weight: bold;">
            LOGIN <i class="fa fa-user-circle"></i>
        </a>
      </li>
    </ul>
  </div>
</nav>


<div class="container-fluid splash" id="splash">
  <div class="container">
    <h1>SELAMAT DATANG</h1>
    <span class="lead">DI GUNUNG PUNCAK PASIR IPIS</span>

    <div class="splash-buttons">
        <a href="#about" class="btn-splash btn-explore">
             YUK, LIHAT KEINDAHANNYA! <i class="fas fa-arrow-right"></i>
        </a>
    </div>
  </div>
</div>

<div class="container-fluid intro" id="about">
    <div class="container">
        <h2>Profil Wisata</h2>
        <p style="text-align: justify; margin-bottom: 35px;">
            Gunung Pasir Ipis memiliki ketinggian sekitar <strong>1.307 meter di atas permukaan laut (MDPL)</strong>.
            Dengan jalur tracking yang relatif bersahabat namun tetap menantang,
            gunung ini cocok dikunjungi oleh pendaki pemula-menengah maupun wisatawan yang ingin menikmati
            keindahan alam pegunungan. Sepanjang jalur pendakian,
            pengunjung disuguhi panorama hutan pinus, hamparan kebun warga, serta udara sejuk khas kawasan Ciater.
        </p>

        <div class="info-box" style="display: flex; flex-wrap: wrap; gap: 20px; background: #F4F7F0; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); color: #414833;">

            <div style="flex: 1; min-width: 250px;">
                <h4 style="color: #414833; margin-bottom: 15px; border-bottom: 2px solid #A4AC86; display: inline-block;">Waktu Operasional</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 12px;">
                        <i class="fa fa-clock" style="color: #728156; width: 20px;"></i>
                        <strong>Jam:</strong> 06.00 - 16.30 WIB
                    </li>
                    <li>
                        <i class="fa fa-calendar-times" style="color: #728156; width: 20px;"></i>
                        <strong>Tutup:</strong> Senin & Kamis
                    </li>
                </ul>
            </div>

            <div style="flex: 1; min-width: 250px;">
                <h4 style="color: #414833; margin-bottom: 15px; border-bottom: 2px solid #A4AC86; display: inline-block;">Harga Tiket (HTM)</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 12px;">
                        <i class="fa fa-ticket-alt" style="color: #728156; width: 20px;"></i>
                        <strong>Tektok:</strong> Rp 15.000 / orang
                    </li>
                    <li>
                        <i class="fa fa-campground" style="color: #728156; width: 20px;"></i>
                        <strong>Camping:</strong> Rp 30.000 / orang
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>

<div class="container-fluid features" id="skills" style="background: #f8f9fa; padding: 30px 0 80px 0;">
  <div class="container cf text-center">
    <h2 style="color: #414833; font-weight: bold; margin-bottom: 10px;">Keunggulan Kami</h2>
    <hr style="width: 50px; border: 2px solid #656D4A; margin: 0 auto 40px;">

    <div class="row" style="display: flex; justify-content: space-around; flex-wrap: wrap;">
      <div class="col-3" style="flex: 1; min-width: 250px; padding: 20px;">
        <i class="fas fa-map-marked-alt fa-3x mb-3" style="color: #656D4A;"></i>
        <h3 style="color: #414833; margin-top: 15px;">Tracking Real-time</h3>
        <p style="color: #666;">Pantau posisi kamu secara akurat selama pendakian demi keamanan.</p>
      </div>
      <div class="col-3" style="flex: 1; min-width: 250px; padding: 20px;">
        <i class="fas fa-shield-alt fa-3x mb-3" style="color: #656D4A;"></i>
        <h3 style="color: #414833; margin-top: 15px;">Fitur SOS Cepat</h3>
        <p style="color: #666;">Kirim sinyal darurat langsung ke petugas jika terjadi kendala.</p>
      </div>
      <div class="col-3" style="flex: 1; min-width: 250px; padding: 20px;">
        <i class="fas fa-paw fa-3x mb-3" style="color: #656D4A;"></i>
        <h3 style="color: #414833; margin-top: 15px;">Laporan Satwa</h3>
        <p style="color: #666;">Bantu menjaga ekosistem dengan melaporkan perjumpaan satwa liar langsung melalui sistem selama pendakian.</p>
        </div>
    </div>

    <div class="mt-5 p-5" style="background: #414833; color: white; border-radius: 15px; margin-top: 60px; padding: 40px;">
        <h3 style="color: white; margin-bottom: 15px;">Ingin Mencoba Semua Fitur Keren Di Atas?</h3>
        <p style="color: #e0e0e0; margin-bottom: 30px;">Yuk, masuk ke akun kamu atau daftar sekarang untuk mulai berpetualang!</p>
        <div style="display: flex; justify-content: center; gap: 15px;">
            <a href="{{ url('/login') }}" style="background: white; color: #414833; padding: 12px 35px; border-radius: 8px; text-decoration: none; font-weight: bold; transition: 0.3s;">MASUK</a>
        </div>
    </div>
  </div>
</div>

<div class="container-fluid portfolio" id="portfolio">
  <div class="container cf">
    <h2>Galeri Wisata</h2>
    <div class="gallery">

      @forelse($galeri as $g)
        <div class="gallery-image">
            <img src="{{ asset('storage/galeri/' . $g->foto) }}" alt="{{ $g->judul }}">
        </div>
      @empty
        <div class="text-center w-100 p-4">
            <p class="text-muted" style="font-style: italic;">Belum ada dokumentasi foto galeri.</p>
        </div>
      @endforelse

    </div>
  </div>
</div>

<div class="container-fluid intro" id="ulasan" style="background-color: #F4F7F0; padding: 30px 0 60px 0;">
    <div class="container" style="max-width: 800px;">
        <h2 style="text-align: center; margin-top: 0; margin-bottom: 10px; color: #414833; font-weight: bold;">Apa Kata Pendaki?</h2>
        <p style="text-align: center; color: #728156; margin-bottom: 40px;">Ulasan asli dari para pengunjung Gunung Puncak Pasir Ipis</p>

        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 50px; border-bottom: 2px solid #E0E5D8; padding-bottom: 40px;">
            <div style="background: #fff; padding: 15px 30px; border-radius: 50px; border: 1px solid #eee; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 15px;">
                <div style="display: flex; align-items: baseline; gap: 5px;">
                    <strong style="font-size: 42px; color: #414833; font-family: sans-serif;">{{ $rataRata }}</strong>
                    <span style="font-size: 20px; color: #728156; font-style: italic;">/ 5.0</span>
                </div>
                <div style="color: #ffca08; font-size: 28px; display: flex; gap: 5px;">
                    @php $stars = floor($rataRata); @endphp
                    @for($i=1; $i<=5; $i++)
                        <i class="fa {{ $i <= $stars ? 'fa-star' : 'fa-star-o' }}" style="{{ $i > $stars ? 'color: #ddd;' : '' }}"></i>
                    @endfor
                </div>
            </div>

        </div>

        <div class="ulasan-list">
            @foreach($ulasan as $u)
            <div style="margin-bottom: 25px; padding: 25px; border-radius: 20px; background-color: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border: 1px solid #ececec;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <strong style="color: #414833; font-size: 1.1em;">{{ $u->user->nama_user ?? 'Pendaki Misterius' }}</strong>
                    <span style="color: #f39c12; font-size: 14px;">
                        @for($i=1; $i<=5; $i++)
                            <i class="fa {{ $i <= $u->rating ? 'fa-star' : 'fa-star-o' }}" style="{{ $i > $u->rating ? 'color: #ddd;' : '' }}"></i>
                        @endfor
                    </span>
                </div>

                <p style="color: #555; line-height: 1.6; margin: 0; text-align: left; font-size: 15px;">
                    "{{ $u->komentar }}"
                </p>

                <small style="color: #bbb; display: block; margin-top: 12px; text-align: left; font-style: italic;">
                    <i class="fa fa-calendar-o"></i> {{ $u->created_at->translatedFormat('d F Y') }}
                </small>
            </div>
            @endforeach

            @if($ulasan->isEmpty())
                <div style="text-align: center; padding: 40px; background: #fff; border-radius: 20px; color: #999;">
                    <i class="fa fa-comments-o" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                    Belum ada ulasan dari pendaki. Jadilah yang pertama!
                </div>
            @endif
        </div>

    </div>
</div>


<div class="container-fluid contact" id="contact">
    <div class="container cf">

        <h2 style="margin-bottom: 30px;">Lokasi Strategis Kami</h2>
        <iframe
            src="https://maps.google.com/maps?q=Parkiran%20Curug%20Cibareubeuy,%20Cibeusi,%20Kec.%20Ciater,%20Kabupaten%20Subang&t=k&z=15&output=embed"
            width="100%"
            height="450"
            style="border:0; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 10px;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>

        <div class="contact-card" style="margin-top: 10px;">
            <h2 style="margin-bottom: 40px;">Hubungi Kami</h2>

            <div class="col-3">
                <i class="fa fa-map-marker" style="font-size: 2em; color: #414833; margin-bottom: 15px;"></i>
                <h3>Alamat</h3>
                <p>
                    <a href="https://maps.app.goo.gl/FmnBqNdiZm31RKR86" target="_blank" style="text-decoration: none; color: inherit;">
                        Kampung Cibareubey, Desa Wisata Cibeusi, Kecamatan Ciater, Kabupaten Subang, Jawa Barat
                    </a>
                </p>
            </div>

            <div class="col-3">
                <i class="fa fa-phone" style="font-size: 2em; color: #414833; margin-bottom: 15px;"></i>
                <h3>Kontak</h3>
                <p>
                    <strong>Email:</strong> <a href="mailto:info@puncakpasiripis.com" style="color: inherit; text-decoration: none;">info@gmail.com</a><br>
                    <strong>Telepon:</strong> <a href="tel:0123456789" style="color: inherit; text-decoration: none;">(0123) 456789</a><br>
                    <strong>WhatsApp:</strong> <a href="https://wa.me/6283148112886" target="_blank" style="color: inherit; text-decoration: none;">+62 831-4811-2886</a>
                </p>
            </div>

            <div class="col-3">
                <i class="fa fa-share-alt" style="font-size: 2em; color: #414833; margin-bottom: 15px;"></i>
                <h3>Media Sosial</h3>
                <p>
                    <strong>Tiktok:</strong> <a href="https://www.tiktok.com/@puncakpasiripis1307mdpl" target="_blank" style="color: inherit; text-decoration: none;">@puncakpasiripis1307</a><br>
                    <strong>Instagram:</strong> <a href="https://www.instagram.com/puncakpasiripis_" target="_blank" style="color: inherit; text-decoration: none;">@puncakpasiripis_</a>
                </p>
            </div>

        </div>
    </div>
</div>

<footer class="main-footer">
  <div class="container cf">
    <!-- Kolom 1 -->
    <div class="col-3">
      <h3>Profil Wisata</h3>
      <p style="text-align: justify">
        Gunung Puncak Pasir Ipis merupakan destinasi wisata alam dengan jalur tracking,
        panorama hutan pinus, dan udara sejuk khas Ciater, Subang.
      </p>
    </div>

    <!-- Kolom 2 -->
    <div class="col-3">
      <h3>Kontak</h3>
      <ul class="footer-links">
        <li>Email: info@puncakpasiripis.com</li>
        <li>WhatsApp: +62 831-4811-2886</li>
        <li>Ciater, Subang, Jawa Barat</li>
      </ul>
    </div>
<!-- Kolom 3 -->
    <div class="col-3">
      <h3>Menu</h3>
      <ul class="footer-links">
        <li><a href="#about">Profil</a></li>
        <li><a href="#skills">Informasi</a></li>
        <li><a href="#portfolio">Galeri</a></li>
        <li><a href="#contact">Kontak</a></li>
      </ul>
    </div>
  </div>

  <!-- Bottom Copyright -->
  <div class="footer-bottom">
      <p>© 2026 Gunung Puncak Pasir Ipis</p><br>
      <span class="continue"><a href="#splash"><i class="fa fa-angle-up"></i></a></span>
  </div>
</footer>
<div id="imageModal" class="modal">
    <span class="close-modal">&times;</span>

    <a class="prev-btn">&#10094;</a>

    <img class="modal-content" id="img01">

    <a class="next-btn">&#10095;</a>
</div>
@endsection

@section('custom-js')
    /* Salin semua JS CodePen ke sini */
    ////////////////////////////////////
// NAVIGATION SHOW/HIDE

$("nav ul").hide();

$(".nav-toggle").click( function() {
  $("nav ul").slideToggle("medium");
});

$("nav ul li a, .brand a").click( function() {
  $("nav ul").hide();
});

////////////////////////////////////
// SMOOTH SCROLLING WITH NAV HEIGHT OFFSET

$(function() {
  var navHeight = $("nav").outerHeight();
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top - navHeight
        }, 1000);
        return false;
      }
    }
  });
});

////////////////////////////////////
// NAVIGATION STICKY

var viewHeight = $(window).height();
var navigation = $('nav');

$(window).scroll( function() {
  if ( $(window).scrollTop() > (viewHeight - 175) ) { //edit for nav height
    navigation.addClass('sticky');
  } else {
    navigation.removeClass('sticky');
  }
});

////////////////////////////////////////////////
// MAKE THE SPLASH CONTAINER VERTICALLY CENTERED

@endsection
