<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan - GPPI</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Kasih jarak bawah buat Show Entries dan Search */
    .dataTables_length, .dataTables_filter {
        margin-bottom: 20px !important;
        padding-top: 10px;
    }

    /* Kasih jarak atas buat Info dan Pagination di bawah tabel */
    .dataTables_info, .dataTables_paginate {
        margin-top: 20px !important;
    }
        /* CSS RESET & UTILITY */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #F4F7F0; color: #333; display: flex; height: 100vh; overflow: hidden; }
        a { text-decoration: none; color: inherit; transition: 0.3s; }

        /* SIDEBAR STYLE */
        .sidebar { width: 260px; background-color: #414833; color: #C2C5AA; display: flex; flex-direction: column; padding: 20px 0; border-right: 1px solid rgba(255,255,255,0.05); }
        .sidebar-brand { text-align: center; padding-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .sidebar-brand img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #A4AC86; }
        .sidebar-brand h3 { font-size: 16px; margin-top: 10px; font-weight: 600; color: #A4AC86; }

        .sidebar-menu { flex: 1; padding: 0 15px; }
        .menu-item { display: flex; align-items: center; padding: 12px 15px; border-radius: 8px; margin-bottom: 8px; font-size: 14px; color: #A4AC86; cursor: pointer; }
        .menu-item:hover, .menu-item.active { background-color: #656D4A; color: #F4F7F0; font-weight: 600; }
        .menu-item i { width: 25px; font-size: 18px; margin-right: 15px; text-align: center; }

        .sidebar-footer { padding: 0 15px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px; }
        .btn-logout { background-color: #A94442; color: white; border: none; width: 100%; padding: 10px; border-radius: 5px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .btn-logout:hover { background-color: #d9534f; }

        /* MAIN CONTENT AREA */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            padding-top: 60px; /* Jarak untuk header fix */
        }

        /* HEADER STYLE */
        .header {
            background-color: #414833;
            color: #F4F7F0;
            padding: 0 30px;
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

        .header-title { font-weight: 600; font-size: 18px; color: #F4F7F0; }

        .header-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #FFFFFF !important;
            font-weight: 500;
        }

        /* CONTENT CONTAINER */
        .container-fluid { padding: 30px; }

        /* Custom Scrollbar biar estetik */
        .main-content::-webkit-scrollbar { width: 8px; }
        .main-content::-webkit-scrollbar-track { background: #f1f1f1; }
        .main-content::-webkit-scrollbar-thumb { background: #A4AC86; border-radius: 10px; }

        /* CSS untuk merapikan input di dalam modal */
.form-input-custom {
    width: 100%;
    padding: 10px;
    margin: 5px 0 10px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
}

.bg-light {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
}

/* Hilangkan garis scroll di modal */
.swal2-html-container {
    overflow: hidden !important;
}

.rounded-modal {
    border-radius: 0px !important;
    padding: 0 !important;
}
.form-input-custom {
    width: 100%;
    padding: 8px;
    border: 1px solid #000;
    margin-top: 5px;
    box-sizing: border-box;
}
 /* CSS Tabel & Halaman Utama */
    tbody tr:hover { background-color: #fcfdfa !important; }
    .btn-action { border: none; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 11px; cursor: pointer; transition: 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .btn-action:hover:not([disabled]) { opacity: 0.9; transform: scale(1.05); }
    .btn-action[disabled] { opacity: 0.3 !important; cursor: not-allowed !important; box-shadow: none !important; }
    .btn-action.btn-regis[disabled] { background: #A4AC86 !important; color: #414833 !important; } /* Khusus regist, biar tetep keliatan color palette */

    /* ==========================================
       CSS MODAL UMUM & TABEL
       ========================================== */
    .puncak-pasir-ipis-modal { border-radius: 20px !important; overflow: hidden; padding: 0 !important; }
    .form-section-title { font-weight: 700; font-size: 14px; color: #333D29; margin-bottom: 15px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 5px; }
    .form-label-custom { font-size: 12px; font-weight: 600; color: #414833; display: block; margin-top: 10px; }
    .form-input-custom { width: 100%; padding: 10px; border: 1px solid #000; border-radius: 8px; margin-top: 5px; }
    .form-input-readonly { width: 100%; padding: 10px; border: 1px solid #000; border-radius: 8px; background: rgba(255,255,255,0.7); font-weight: 700; }
    .form-textarea-custom { width: 100%; height: 100px; padding: 10px; border: 1px solid #000; border-radius: 8px; background: rgba(255,255,255,0.7); resize: none; }

    /* ==========================================
       1. KHUSUS MODAL REGISTRASI (Color Palette 2)
       ========================================== */
    .reg-modal-container {
        display: flex; /* Memastikan kiri dan kanan sejajar */
        text-align: left;
        background: #fff;
        overflow: hidden;
    }

    /* Kolom Kiri (Data) */
    .reg-col-left {
        flex: 1.2;
        padding: 30px;
        background-color: #FDFDF7; /* Krem bersih */
    }

    /* Kolom Kanan (Tiket) */
    .reg-col-right {
        flex: 0.8;
        padding: 30px;
        background-color: #C2C5AA; /* Light Sage */
    }

    .reg-section-title {
        font-weight: 700;
        font-size: 15px;
        color: #414833;
        border-bottom: 2px solid #A4AC86;
        padding-bottom: 5px;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .reg-label {
        font-size: 12px;
        font-weight: 700;
        color: #414833;
        display: block;
        margin-top: 12px;
    }

    .reg-input-custom {
        width: 100%;
        padding: 10px;
        border: 1px solid #414833;
        border-radius: 10px;
        margin-top: 5px;
        background: #fff;
        font-family: 'Poppins', sans-serif;
    }

    .reg-input-readonly {
        width: 100%;
        padding: 12px;
        border: 1px solid #414833;
        border-radius: 10px;
        background: rgba(255,255,255,0.5);
        font-weight: 800;
        text-align: center;
        color: #333D29;
    }

    /* Footer Tombol (Di bawah grid) */
    .reg-footer-btns {
        display: flex;
        justify-content: center;
        gap: 15px;
        padding: 20px;
        background: #fff;
        border-top: 1px solid #eee;
    }

    .btn-proses-reg {
        background-color: #333D29; /* Dark Green */
        color: white;
        border: none;
        padding: 12px 35px;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-proses-reg:hover { background-color: #000; }

    .btn-cancel-reg {
        background-color: #656D4A; /* Army Green */
        color: white;
        border: none;
        padding: 12px 35px;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
    }



    /* CSS RESET & LAYOUT */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    body { background-color: #F4F7F0; color: #333; display: flex; height: 100vh; overflow: hidden; }

    /* SIDEBAR & HEADER  */
    .sidebar { width: 260px; background-color: #414833; color: #C2C5AA; display: flex; flex-direction: column; padding: 20px 0; }
    .sidebar-menu { flex: 1; padding: 0 15px; }
    .menu-item { display: flex; align-items: center; padding: 12px 15px; border-radius: 8px; margin-bottom: 8px; font-size: 14px; color: #A4AC86; }
    .menu-item.active { background-color: #656D4A; color: #F4F7F0; font-weight: 600; }
    .header { background-color: #414833; color: #F4F7F0; padding: 0 30px; display: flex; justify-content: space-between; align-items: center; position: fixed; top: 0; right: 0; width: calc(100% - 260px); height: 60px; z-index: 1000; }

    /* STAT CARD STYLE */
    .stat-card { flex: 1; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between; }
    .stat-card h3 { margin: 0; color: #414833; font-size: 24px; font-weight: 700; }
    .stat-card i { font-size: 35px; color: #A4AC86; opacity: 0.5; }

    /* UTILITY MODAL (Sama untuk Regist & Validasi) */
    .puncak-pasir-ipis-modal { border-radius: 25px !important; overflow: hidden; padding: 0 !important; border: none !important; }

    /* REGISTRASI STRUCTURE (HORIZONTAL) */
    .reg-container { display: flex; text-align: left; }
    .reg-left { flex: 1.2; padding: 35px; background: #FDFDF7; } /* Krem Palette */
    .reg-right { flex: 0.8; padding: 35px; background: #C2C5AA; } /* Sage Palette */
    .reg-title { font-weight: 800; font-size: 14px; color: #936639; border-bottom: 2px solid #A4AC86; padding-bottom: 5px; margin-bottom: 20px; text-transform: uppercase; }
    .reg-label { font-size: 12px; font-weight: 700; color: #414833; display: block; margin-top: 15px; }
    .reg-input { width: 100%; padding: 12px; border: 1px solid #414833; border-radius: 12px; margin-top: 5px; background: white; font-weight: 600; }
    .reg-readonly { width: 100%; padding: 12px; border: 1px solid #414833; border-radius: 12px; background: rgba(255,255,255,0.5); font-weight: 800; text-align: center; }

    .price-tag-box { background: white; padding: 15px; border-radius: 15px; border: 2px dashed #414833; margin-top: 10px; text-align: center; }
    .price-val { font-size: 22px; font-weight: 900; color: #333D29; border: none; background: transparent; width: 100%; text-align: center; }

    /* PILL RADIO CUSTOM */
    .pill-group { display: flex; gap: 10px; margin-top: 10px; }
    .pill-item { flex: 1; cursor: pointer; }
    .pill-item input { display: none; }
    .pill-item span { display: block; text-align: center; padding: 10px; background: white; border: 1px solid #A4AC86; border-radius: 10px; font-size: 12px; font-weight: 600; }
    .pill-item input:checked + span { background: #656D4A; color: white; }

    /* FOOTER BUTTONS */
    .reg-footer { padding: 20px; background: white; display: flex; justify-content: center; gap: 15px; border-top: 1px solid #eee; }
    .btn-reg-submit { background: #333D29; color: white; border: none; padding: 13px 35px; border-radius: 12px; font-weight: 700; cursor: pointer; }
    .btn-reg-cancel { background: #656D4A; color: white; border: none; padding: 13px 35px; border-radius: 12px; font-weight: 700; cursor: pointer; }

    /* VALIDASI SYNC (Warna Sage Elsa) */
    .modal-grid-validasi { display: flex; text-align: left; position: relative; }
    .modal-grid-validasi .col-left { flex: 1.2; padding: 30px; background: #C2C5AA; border-right: 1px solid rgba(0,0,0,0.1); }
    .modal-grid-validasi .col-right { flex: 0.8; padding: 30px; background: #A4AC86; }
    .close-btn-top { position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 20px; cursor: pointer; }

    /* ==========================================
       DESAIN TOMBOL PAGINATION PUNCAK PASIR IPIS
       ========================================== */
    #pagination-container nav {
        display: flex;
        justify-content: flex-end;
        width: 100%;
    }

    /* Sembunyikan teks "Showing 1 to 10..." biar rapi */
    #pagination-container nav > div:first-child { display: none; }

    #pagination-container .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        gap: 8px;
        margin: 0;
    }

    #pagination-container .page-item .page-link,
    #pagination-container .page-item span.page-link {
        display: block;
        padding: 8px 16px;
        color: #414833;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    #pagination-container .page-item.active span.page-link {
        color: #fff;
        background-color: #656D4A;
        border-color: #656D4A;
    }

    #pagination-container .page-item:not(.active) .page-link:hover {
        background-color: #f0f4e8;
        color: #333D29;
        border-color: #A4AC86;
    }

    #pagination-container svg {
        width: 18px;
        height: 18px;
    }
    /* Menghilangkan bullet dan merapikan urutan ke samping */
.pagination {
    display: flex;
    list-style: none;
    padding-left: 0;
    gap: 10px; /* Jarak antar angka */
    margin-top: 20px;
    justify-content: flex-end; /* Biar nangkring di kanan bawah */
}

.page-item {
    display: inline;
}

.page-link {
    text-decoration: none;
    color: #414833;
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
}

.page-item.active .page-link {
    background-color: #656D4A; /* Warna hijau project kamu */
    color: white;
    border-color: #656D4A;
}

.page-item.disabled .page-link {
    color: #ccc;
    pointer-events: none;
}

.page-link:hover:not(.active) {
    background-color: #f4f7f0;
}

/* Sembunyikan teks keterangan bawaan Laravel yang bikin berantakan */
nav div.hidden {
    display: none !important;
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
            <a href="{{ route('petugas.dblap') }}" class="menu-item {{ request()->routeIs('petugas.dblap') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i> Tugas Penyelamatan
            </a>

            <a href="{{ route('petugas.riwayat') }}" class="menu-item {{ request()->routeIs('petugas.riwayat') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Riwayat Penanganan
            </a>
        </div>

        <div class="sidebar-footer">
            <form action="/logout" method="POST" id="logout-form">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> LOGOUT
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="header-title">@yield('page_title', 'Dashboard Karyawan')</div>
            <div class="header-user">
                <span class="user-name" style="font-weight: bold;">{{ Auth::user()->nama_user }}</span>
                <i class="fas fa-user-shield"></i>
            </div>
        </div>

        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
<script>
    function cekNotifikasiSOS() {
        // 1. JANGAN JALAN kalau lagi di halaman SOS
        if (window.location.pathname.includes('/sos')) {
            return;
        }

        fetch('/karyawan/cek-sos-terbaru')
            .then(response => response.json())
            .then(data => {
                if (data.ada_sos) {
                    // Pakai localStorage biar lebih awet (tetap ingat walau pindah menu)
                    let lastSosId = data.id_sos;
                    let isIgnored = localStorage.getItem('ignore_sos_' + lastSosId);

                    // 2. JANGAN MUNCUL kalau ID SOS ini sudah pernah di-ignore atau dilihat detailnya
                    if (!Swal.isVisible() && !isIgnored) {
                        Swal.fire({
                            title: '<span style="color: #FF0000; font-weight: bold;">DARURAT !!!</span>',
                            text: data.jumlah > 1
                                  ? `PERINGATAN! Ada ${data.jumlah} orang butuh bantuan: ${data.nama_pendaki}`
                                  : `Ada pendaki bernama ${data.nama_pendaki} butuh bantuan segera!`,
                            icon: 'warning',
                            iconColor: '#FF0000',
                            showCancelButton: true,
                            confirmButtonText: 'Lihat Detail',
                            confirmButtonColor: '#d33',
                            cancelButtonText: 'Tutup',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Tandai ID ini sudah dilihat sebelum pindah halaman
                                localStorage.setItem('ignore_sos_' + lastSosId, 'true');
                                window.location.href = "{{ route('karyawan.sos') }}";
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                // Tandai ID ini untuk di-ignore agar tidak muncul lagi
                                localStorage.setItem('ignore_sos_' + lastSosId, 'true');
                            }
                        });
                    }
                }
            })
            .catch(error => console.error('Fetch Error:', error));
    }

    cekNotifikasiSOS();
    setInterval(cekNotifikasiSOS, 3000);
</script>
</body>
</html>
