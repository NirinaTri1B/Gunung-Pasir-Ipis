<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Gunung Puncak Pasir Ipis</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        /* === MASUKKAN SEMUA CSS DARI CODEPEN DI SINI === */
        @yield('custom-css')
        /* https://coolors.co/2c3e50-e74c3c-ffffff-3498db-95a3b3 */

/* ========================
Utilities
======================== */

* {
  box-sizing: border-box;
}

.cf::before,
.cf::after {
    content: "";
    display: block;
}

.cf::after {
    clear: both;
}

html {
  position: relative;
}

img {
  max-width: 100%;
}

/* ========================
Global
======================== */

body {
  color: #444;
  font-family: Roboto, sans-serif;
  font-size: 18px;
  font-weight: 300;
  line-height: 1;
  margin: 0;
  padding: 0;
  background-color: #E7F5DC; /* Palette #1 */
}

h1, h2, h3, h4, h5, h6, ul, ol, p {
  margin-top: 0;
}

h1 {
  font-weight: 900;
}

p {
  line-height: 1.5;
}

a, a:hover, a:focus, a:active, a:visited {
  color: #728156; /* Palette #6 */
  text-decoration: underline;
}

/* ========================
Containers
======================== */

.container-fluid {
  padding: 0 1em;
}

.container {
  margin: 0 auto;
  max-width: 996px;
}


/* Custom Contact Container */
.contact-info-container {
    background-color: #CFE1B9; /* Palette #2 */
    border-radius: 4px;
    box-shadow: 0 1px 2px rgba(0,0,0,.15);
    padding: 3em 2em;
    text-align: left;
    width: 100%;
    max-width: none;
    margin: 0 auto;
}

.contact-info-container h2 {
    text-align: center;
    margin-bottom: 1.5em;
    color: #444;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 1.5em;
}

.contact-item i {
    font-size: 1.5em;
    color: #728156; /* Palette #6 */
    margin-right: 20px;
    width: 30px;
    text-align: center;
}

.contact-item p {
    margin: 0;
    font-size: 1.1em;
    line-height: 1.4;
    color: #555;
}

/* ulasan */
/* --- CSS UNTUK SECTION ULASAN --- */
    .ulasan-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        margin-top: 30px;
    }

    .review-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 25px;
        width: 30%; /* Berjejer 3 ke samping */
        min-width: 280px; /* Responsif untuk layar kecil */
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border-top: 4px solid #728156; /* Aksen hijau sage di atas kartu */
        transition: transform 0.3s ease;
    }

    .review-card:hover {
        transform: translateY(-5px); /* Efek melayang saat di-hover */
    }

    .review-stars {
        color: #f39c12; /* Warna kuning emas untuk bintang */
        margin-bottom: 10px;
        font-size: 1.2em;
    }

    .review-text {
        font-style: italic;
        color: #555;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .review-author {
        font-weight: bold;
        color: #414833; /* Hijau tua */
        font-size: 0.9em;
        border-top: 1px solid #eee;
        padding-top: 10px;
    }

    .review-date {
        font-weight: normal;
        color: #999;
        font-size: 0.85em;
        display: block;
        margin-top: 3px;
    }
/* Kotak pembungkus informasi kontak */
    .contact-card {
        background-color: #F4F7F0; /* Hijau sangat muda/krem */
        border-radius: 20px;
        padding: 50px 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06); /* Efek bayangan lembut */
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    /* Judulnya digeser ke dalam kotak */
    .contact-card h2 {
        width: 100%;
        margin-bottom: 40px;
    }

/* ========================
Navigation
======================== */

@keyframes show-header {
    0% {
        top: -4em;
        opacity: 0;
    }
    100% {
        top: 0;
        opacity: 1;
    }
}

nav {
  background-color: #E7F5DC; /* Palette #1 */
  box-shadow: 0 2px 2px rgba(0,0,0,.45);
  position: relative;
  top: 0;
}

nav a, nav a:hover, nav a:focus,  nav a:active, nav a:visited {
  text-decoration: none;
}

nav .brand {
  display: inline-block;
  float: left;
  font-size: 1.5em;
  font-weight: 900;
  text-decoration: none
}

nav .brand a {
  color: #444;
  display: block;
  padding: 1em 0;
}

nav .nav-toggle {
  color: #444;
  cursor: pointer;
  display: inline-block;
  float: right;
  font-size: 1.25em;
  padding: 1em 0;
  z-index: 1000
}

/* Frame bulat untuk logo GPPI */

    /* Perbarui kelas nav-logo di dalam frame */
    .nav-logo {
        width: 45px;         /* Ukurannya disesuaikan untuk navbar */
        height: 45px;
        border-radius: 50%;  /* Memotong langsung sudut hitamnya */
        object-fit: cover;   /* Memastikan gambar proporsional */
        border: 2px solid #728156; /* Bingkai sage green (opsional) */
        margin-right: 12px;  /* Jarak logo ke teks */
    }



nav ul {
  border-top: 1px solid #B6C99B; /* Palette #3 */
  clear: both;
  list-style: none;
  margin: 0 -1em;
  padding: 0;
  z-index: 999;
}

nav ul li {
  border-bottom: 1px solid #B6C99B; /* Palette #3 */
  text-align: center;
}

nav ul li a {
  color: #444;
  display: block;
  padding: .75em;
  text-decoration: none;
  font-size: 1.1em; /* Memperbesar sedikit teks profil, informasi, dll */
  font-weight: 400;  /* Membuat teks sedikit lebih tebal */
  transition: color 0.3s ease;
}

/* Memberikan efek hover agar navigasi tidak terasa kaku */
nav ul li a:hover {
  color: #728156; /* Menggunakan hijau tua dari palette */
}

@media (min-width: 768px) {
  /* Menambah jarak (spacing) antar menu agar mengisi ruang kosong */
  nav ul li {
    border: none;
    display: inline-block;
    float: left;
    margin-right: 3em; /* Menambah jarak antar menu (sebelumnya 1.5em) */
  }

  nav ul li:last-of-type {
    margin-right: 0;
  }
}

nav.sticky {
  animation: show-header .5s ease;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 9999 !important; /* TAMBAHKAN INI: Biar menu paling depan */
  background-color: #E7F5DC; /* TAMBAHKAN INI: Biar menu gak transparan pas scroll */
}

/* ========================
Sections
======================== */

.splash {
  background: linear-gradient(rgba(114, 151, 108, 0.65), rgba(114, 129, 86, 0.65)),
				url("/images/gunung.jpg") no-repeat fixed center;
	background-size: cover;
	color: #fff;
}

.splash .container {
  padding-top: 25vh;
  padding-bottom: 25vh;
}

.profile-image {
  border-radius: 50%;
  display: block;
  max-width: 200px;
  margin: 0 auto 1em;
  width: 100%;
}

.splash h1 {
  font-size: 3em;
  margin-bottom: .15em;
  text-align: center;
}

.splash .lead, .splash .continue {
  display: block;
  text-align: center;
}

.splash .lead {
  font-size: 1.5em;
  font-weight: 100;
  margin-bottom: 1em;
}

.splash .continue {
  font-size: 4em;
}

.splash .continue a {
  border: 4px solid #fff;
  border-radius: 100%;
  color: #fff;
  display: inline-block;
  text-decoration: none;
  width: 80px;
}
.splash .continue a:hover {
  background-color: rgba(85, 110, 89, 0.25);
}

/* Balikin dulu standarnya biar aman */
.intro .container,
.features .container,
.portfolio .container,
.contact .container {
    padding-top: 5em;
    padding-bottom: 5em; /* Standar awal */
}

/* KHUSUS untuk bagian Profil (Intro) yang di gambar Elsa mepet banget */
.intro .container {
    padding-bottom: 5em !important; /* Naikin sedikit dari 1em ke 3em biar gak sesak */
}

/* KHUSUS untuk bagian Galeri (Portfolio) biar jarak ke Ulasan gak kejauhan */
.portfolio .container {
    padding-bottom: 3em !important;
}

.intro, .features, .portfolio, .contact {
  text-align: center;
}

.intro {
  background-color: #88976C; /* Palette #5 */
  color: #fff;
}

.intro a, .intro a:hover, .intro a:focus, .intro a:active, .intro a:visited {
  color: #E7F5DC; /* Palette #1 */
}

.features {
  background-color: #E7F5DC; /* Palette #1 */
}

.features img {
  display: block;
  margin: 0 auto 1em;
  max-width: 200px;
}

.features .col-3 {
  margin: 3em auto;
  width: 100%;
}

.portfolio {
  background-color: #98A77C; /* Palette #4 */
  color: #fff;
}

.gallery .gallery-image {
  margin: 1em auto;
  width: 100%;
  overflow: hidden; /* TAMBAHKAN INI: Biar zoom gambarnya gak keluar kotak */
  border-radius: 8px; /* TAMBAHKAN INI: Biar sudutnya tetep bulet pas di-zoom */
}

.gallery .gallery-image img {
  background-color: #728156;
  border-radius: 4px;
  display: block;
  height: 300px;
  object-fit: cover;
  padding: 6px;
  width: 100%;
  transition: transform 0.3s ease; /* TAMBAHKAN INI: Biar zoom-nya mulus */
}

/* --- TAMBAHKAN EFEK INI DI BAWAHNYA --- */
.gallery .gallery-image:hover img {
  transform: scale(1.08); /* Efek zoom tipis pas kursor ke gambar */
}

/* --- CSS UNTUK LIGHTBOX GALERI SLIDER --- */

    .gallery-image img {
        cursor: pointer;
        transition: 0.3s;
    }
    .gallery-image img:hover {
        opacity: 0.8;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 50px; /* Kurangi padding atas biar gambar bisa lebih besar */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.9); /* Sedikit lebih gelap */
    }
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 800px;
        max-height: 80vh; /* Biar gambar gak kepanjangan ke bawah */
        object-fit: contain; /* Biar gambar gak gepeng */
        border-radius: 8px;
        animation-name: zoom;
        animation-duration: 0.4s;
    }
    @keyframes zoom {
        from {transform:scale(0.9); opacity:0;}
        to {transform:scale(1); opacity:1;}
    }
    .close-modal {
        position: absolute;
        top: 20px;
        right: 40px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
        z-index: 10000;
    }
    .close-modal:hover {
        color: #A4AC86;
    }

    /* Style Tombol Next & Prev */
    .prev-btn, .next-btn {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -50px;
        color: white;
        font-weight: bold;
        font-size: 40px;
        transition: 0.3s;
        border-radius: 0 3px 3px 0;
        user-select: none; /* Biar teks panahnya ga ke-blok */
    }
    .next-btn {
        right: 5%;
        border-radius: 3px 0 0 3px;
    }
    .prev-btn {
        left: 5%;
    }
    .prev-btn:hover, .next-btn:hover {
        background-color: rgba(0, 0, 0, 0.6);
        color: #A4AC86;
    }

.contact {
    background-color: #E7F5DC; /* Palette #1 */
}

.contact a {
  text-decoration: none;
  border-bottom: 1px solid #728156;
}
/* ========================
Footer
======================== */

.main-footer {
    background-color: #333D29; /* Hijau paling tua dari palette */
    color: #E7F5DC; /* Teks hijau sangat muda agar kontras */
    padding: 60px 0 20px 0;
    font-size: 0.8em;
}

.main-footer .col-3 h3 {
    color: #A4AC86; /* Warna aksen hijau pucat */
    margin-bottom: 20px;
    font-size: 0.8em;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.footer-links {
    list-style: none;
    padding: 0;
}

.footer-links li {
    margin-bottom: 10px;
}

.footer-links a {
    color: #E7F5DC;
    text-decoration: none;
    transition: 0.3s;
}

.footer-links a:hover {
    color: #B6AD90; /* Warna krem saat di-hover */
    padding-left: 5px;
}

/* Bagian Bawah (Copyright) */
.footer-bottom {
    background-color: #333D29;
    padding: 15px;
    margin-top: 30px;
    text-align: center;
    border-top: 1px solid #414833;
}

.footer-bottom p {
    margin: 0;
    opacity: 0.6;
}


.credit {
    font-size: 0.8em;
    font-style: italic;
    color: #B6AD90;
}

.main-footer .container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 15px;
  padding-left: 150px;
}

.main-footer .col-3 {
  flex: 1;
  min-width: 200px;
  text-align: left;
  padding: 0 10px;
}


/* ========================
Media Queries
======================== */

@media (min-width: 768px) {

  nav .nav-toggle {
    display: none;
  }

  nav ul {
    border: none;
    clear: none;
    display: inline-block !important;
    float: right;
    margin: 0;
    padding: 25px 0;
  }

  nav ul li {
    border: none;
    display: inline-block;
    float: left;
    margin-right: 1.5em;
  }

  nav ul li:last-of-type {
    margin-right: 0;
  }

  nav ul li a {
    padding: 0;
  }

  .splash h1 {
    font-size: 6em;
  }

  .splash .lead {
    font-size: 3em;
  }
  /* CSS Tambahan untuk Tombol Splash */
    .splash-buttons {
        margin-top: 25px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .btn-splash {
        display: inline-block;
        padding: 12px 30px;
        border-radius: 30px;
        text-decoration: none !important;
        font-weight: bold;
        transition: all 0.3s ease;
        font-size: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    /* Tombol Daftar menggunakan warna #656D4A */
    .btn-register {
        background-color: #656D4A;
        color: white !important;
    }

    .btn-register:hover {
        background-color: #414833; /* Warna lebih gelap saat hover */
        transform: translateY(-3px);
    }

    /* Tombol Login menggunakan warna #A4AC86 */
    .btn-login-splash {
        background-color: #c3cd9f;
        color: #333D29 !important;
    }

    .btn-login-splash:hover {
        background-color: #C2C5AA;
        transform: translateY(-3px);
    }

    /* Memastikan link arrow ke bawah tetap rapi */
    .splash .continue {
        margin-top: 30px;
    }

  .features .col-3 {
    float: left;
    margin: 2em 5% 0 0;
    padding: 0 1em;
    width: 30%;
  }

  .features .col-3:last-of-type {
    margin-right: 0;
  }

  .gallery .gallery-image {
    float: left;
    margin-right: 2.5%;
    width: 31.6666666667%;
  }

  .gallery .gallery-image:nth-of-type(3n) {
    margin-right: 0;
  }
}
.contact .col-3 {
  float: left;
  width: 30%;
  margin: 2em 5% 0 0;
  padding: 0 1em;
}

.contact .col-3:last-of-type {
  margin-right: 0;
}
/* KEUNGGULAN */

    </style>
</head>
<body>

    @yield('content')

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    <script>
        /* === MASUKKAN SEMUA JS DARI CODEPEN DI SINI === */
        @yield('custom-js')
        ////////////////////////////////////
        ////////////////////////////////////
// LIGHTBOX GALERI WISATA (DENGAN SLIDER)

$(document).ready(function() {
    var images = [];
    var currentIndex = 0;

    // 1. Kumpulkan semua alamat (src) gambar dari galeri ke dalam satu wadah
    $(".gallery-image img").each(function() {
        images.push($(this).attr("src"));
    });

    // 2. Saat gambar mana pun di galeri diklik
    $(".gallery-image img").click(function() {
        var clickedSrc = $(this).attr("src");
        currentIndex = images.indexOf(clickedSrc); // Cari tahu ini gambar ke berapa
        tampilkanGambar(currentIndex);             // Tampilkan gambarnya
        $("#imageModal").fadeIn("fast");           // Buka pop-up
    });

    // 3. Fungsi untuk mengganti gambar di dalam pop-up
    function tampilkanGambar(index) {
        // Kalau udah mentok kanan, balik ke gambar pertama
        if (index >= images.length) { currentIndex = 0; }
        // Kalau udah mentok kiri, pergi ke gambar terakhir
        if (index < 0) { currentIndex = images.length - 1; }

        // Ganti gambar di pop-up
        $("#img01").attr("src", images[currentIndex]);
    }

    // 4. Kalau tombol Kanan diklik
    $(".next-btn").click(function(e) {
        e.stopPropagation(); // Biar pop-up gak ketutup
        currentIndex++;
        tampilkanGambar(currentIndex);
    });

    // 5. Kalau tombol Kiri diklik
    $(".prev-btn").click(function(e) {
        e.stopPropagation(); // Biar pop-up gak ketutup
        currentIndex--;
        tampilkanGambar(currentIndex);
    });

    // 6. Tutup pop-up cuma kalau area hitam atau tombol X yang diklik
    $(".modal").click(function(e) {
        // Cek: Apakah yang diklik itu BUKAN gambar dan BUKAN tombol panah?
        if (!$(e.target).hasClass("modal-content") && !$(e.target).hasClass("next-btn") && !$(e.target).hasClass("prev-btn")) {
            $("#imageModal").fadeOut("fast");
        }
    });
});
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

function centerSplash() {
  var navHeight = $("nav").outerHeight();
  var splashHeight = $(".splash .container").height();
  var remainingHeight = $(window).height() - splashHeight - navHeight;
  $(".splash .container").css({"padding-top" : remainingHeight/2, "padding-bottom" : remainingHeight/2});
}

$( document ).ready( function() {
  centerSplash();
});

$( window ).resize( function() {
  centerSplash();
});
    </script>
</body>
</html>
