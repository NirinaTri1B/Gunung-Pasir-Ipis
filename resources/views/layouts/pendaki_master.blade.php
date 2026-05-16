<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pendaki - GPPI</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-gpx/1.7.0/gpx.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    /* Box Utama Laporan */
    .laporan-container {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        max-width: 800px;
        margin: 20px auto;
    }

    .laporan-header {
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 25px;
        padding-bottom: 10px;
    }

    .laporan-header h2 {
        color: #414833; /* Hijau tua khas GPPI */
        font-weight: 700;
        letter-spacing: 1px;
    }

    /* Styling Form Input */
    .form-group label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 12px;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: #728156;
        box-shadow: 0 0 0 0.2rem rgba(114, 129, 86, 0.25);
    }

    /* Tombol Kirim */
    .btn-kirim {
        background-color: #414833;
        color: white;
        padding: 12px 40px;
        border-radius: 8px;
        font-weight: bold;
        border: none;
        transition: 0.3s;
        width: 100%;
        margin-top: 10px;
    }

    .btn-kirim:hover {
        background-color: #2c3123;
        transform: translateY(-2px);
    }

    .text-muted {
        font-size: 0.85rem;
        font-style: italic;
    }

    /* Mengecilkan semua ikon Pin Biru (Start & End) */
    .leaflet-marker-icon[src*="marker-icon.png"] {
        width: 20px !important;
        height: 32px !important;
        margin-left: -10px !important;
        margin-top: -32px !important;
    }

    /* Menyesuaikan bayangannya biar gak ketinggalan */
    .leaflet-marker-shadow {
        width: 25px !important;
        height: 25px !important;
        margin-left: -5px !important;
        margin-top: -25px !important;
        display: none;
    }
        /* CSS RESET & UTILITY */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #F4F7F0; color: #333; display: flex; height: 100vh; overflow: hidden; }
        a { text-decoration: none; color: inherit; transition: 0.3s; }

        /* SIDEBAR STYLE (Warna Tua #414833) */
        .sidebar { width: 260px; background-color: #414833; color: #C2C5AA; display: flex; flex-direction: column; padding: 20px 0; border-right: 1px solid rgba(255,255,255,0.05); }
        .sidebar-brand { text-align: center; padding-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .sidebar-brand img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #A4AC86; }
        .sidebar-brand h3 { font-size: 16px; margin-top: 10px; font-weight: 600; color: #A4AC86; }

        .sidebar-menu { flex: 1; padding: 0 15px; }
        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 14px;
            color: #A4AC86;
            cursor: pointer;
            text-decoration: none !important; /* Jaga-jaga biar pas diem gak ada garis */
        }

        /* Pas disorot cursor mouse, paksa garis bawahnya lenyap */
        .menu-item:hover, .menu-item.active {
            background-color: #656D4A;
            color: #F4F7F0;
            font-weight: 600;
            text-decoration: none !important; /* INI KUNCINYA SA */
        }
        .menu-item i { width: 25px; font-size: 18px; margin-right: 15px; text-align: center; }

        .sidebar-footer { padding: 0 15px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px; }
        .btn-logout { background-color: #A94442; color: white; border: none; width: 100%; padding: 10px; border-radius: 5px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .btn-logout:hover { background-color: #d9534f; }

        /* MAIN CONTENT AREA */
        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; }

        /* HEADER STYLE */
        .header {
            background-color: #414833;
            color: #F4F7F0;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #656D4A;
            position: fixed;
            top: 0;
            right: 0;
            width: calc(100% - 260px);
            z-index: 1000;
            height: 60px;
        }
        .header-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #FFFFFF !important;
            font-weight: 500;
        }

        .header-user span {
            color: #FFFFFF !important;
        }

        .header-user i {
            font-size: 20px;
            color: #F4F7F0;
        }

        /* CONTENT CONTAINER */
        .container { padding: 30px; max-width: 100% !important; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            padding-top: 60px;
        }

        /* Custom SweetAlert SOS */
        .swal2-popup-sos {
            border-radius: 20px !important;
            padding: 20px !important;
        }

        .swal-input-sos {
            width: 100% !important;
            margin: 10px 0 !important;
            border-radius: 10px !important;
            font-family: 'Poppins', sans-serif !important;
            font-size: 14px !important;
        }

        .swal2-title {
            color: #A94442 !important;
            font-weight: 700 !important;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo GPPI">
            <h3>G. Puncak Pasir Ipis</h3>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('pendaki.dbpendaki') }}" class="menu-item {{ request()->is('pendaki/dbpendaki') ? 'active' : '' }}">
                <i class="fas fa-map-marked-alt"></i> Jalur Pendakian
            </a>

            @if($isAktif)
                <a href="{{ url('/laporan-satwa') }}" class="menu-item {{ request()->is('laporan-satwa*') ? 'active' : '' }}">
                    <i class="fas fa-paw"></i> Laporan Satwa
                </a>
            @else
                <a href="#" class="menu-item" style="opacity: 0.5; cursor: not-allowed;" onclick="Swal.fire('Akses Terkunci', 'Fitur ini hanya tersedia saat kamu dalam masa pendakian di Puncak Pasir Ipis.', 'info')">
                    <i class="fas fa-paw"></i> Laporan Satwa (Terkunci)
                </a>
            @endif

            <a href="{{ route('pendaki.ulasan') }}" class="menu-item {{ request()->is('pendaki/ulasan*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i> Ulasan
            </a>

            <a href="{{ route('pendaki.aktivitas') }}" class="menu-item {{ request()->is('pendaki/aktivitas') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Aktivitas Pendakian
            </a>

            <a href="{{ route('pendaki.informasi') }}" class="menu-item {{ request()->is('pendaki/informasi*') ? 'active' : '' }}">
                <i class="fas fa-info-circle"></i> Informasi Umum
            </a>

            <a href="{{ route('pendaki.profil') }}" class="menu-item {{ request()->is('pendaki/profil') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> Pengaturan Akun
            </a>
        </div>

        <div class="sidebar-footer">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> LOGOUT
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="header-title">@yield('page_title', 'Dashboard')</div>
            <div class="header-user">
                <span>{{ Auth::user()->nama_user }}</span> <i class="fas fa-user-circle"></i>
            </div>
        </div>

        <div class="container">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
