<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gunung Puncak Pasir Ipis</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ==========================================
           CORE LAYOUT STYLE
           ========================================== */
        .stat-card h3 {
            font-size: 20px !important;
            margin-top: 5px !important;
            font-weight: 700 !important;
        }
        .stat-card p {
            font-size: 11px !important;
            margin: 0 !important;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body { background-color: #F4F7F0; color: #333; display: flex; min-height: 100vh; }
        a { text-decoration: none !important; color: inherit; transition: 0.3s; }

        /* SIDEBAR STYLE */
        .sidebar { width: 260px; background-color: #333D29; color: #C2C5AA; display: flex; flex-direction: column; padding: 20px 0; position: fixed; height: 100vh; left: 0; top: 0; z-index: 1001; }
        .sidebar-brand { text-align: center; padding-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .sidebar-brand img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #A4AC86; }
        .sidebar-brand h3 { font-size: 16px; margin-top: 10px; font-weight: 600; color: #A4AC86; }

        .sidebar-menu { flex: 1; padding: 0 15px; }
        .menu-item { display: flex; align-items: center; padding: 12px 15px; border-radius: 8px; margin-bottom: 8px; font-size: 14px; color: #A4AC86; cursor: pointer; }
        .menu-item:hover, .menu-item.active { background-color: #936639; color: #F4F7F0; font-weight: 600; }
        .menu-item i { width: 25px; font-size: 18px; margin-right: 15px; text-align: center; }

        .sidebar-footer { padding: 0 15px; padding-top: 15px; }
        .btn-logout { background-color: #A94442; color: white; border: none; width: 100%; padding: 10px; border-radius: 5px; cursor: pointer; font-weight: bold; }

        /* MAIN CONTENT AREA */
        .main-content {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* HEADER STYLE */
        .header {
            background-color: #333D29;
            color: #F4F7F0;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            height: 60px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .container-fluid { padding: 25px; }

        /* ACCORDION NAVIGATION MENU */
        .menu-accordion-group { width: 100%; }
        .toggle-accordion { display: flex !important; align-items: center; cursor: pointer; }
        .arrow-icon { font-size: 12px; transition: transform 0.3s ease; }

        /* Rotasi panah kustom saat accordion collapse terbuka/tertutup */
        .toggle-accordion[aria-expanded="false"] .arrow-icon { transform: rotate(-90deg); }
        .toggle-accordion[aria-expanded="true"] .arrow-icon { transform: rotate(0deg); }

        .sub-menu-box {
            background-color: rgba(0, 0, 0, 0.15);
            margin: 2px 12px 8px 12px;
            border-radius: 8px;
            padding: 5px 0;
        }
        .sub-item {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            color: #cbd5e1;
            font-size: 13px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        .sub-item:hover { color: #fff; background-color: rgba(255, 255, 255, 0.05); text-decoration: none; }
        .sub-active { color: #fff !important; font-weight: 700; background-color: rgba(255, 255, 255, 0.1) !important; border-left: 3px solid #b7b7a4; }

        /* ==========================================
           DATATABLES ELEMENTS STYLING (ANTI-TABRAKAN)
           ========================================== */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 5px 10px;
            margin-left: 10px;
            outline: none;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #656D4A;
            box-shadow: 0 0 0 0.2rem rgba(101, 109, 74, 0.25);
        }
        .dataTables_wrapper .dataTables_length select {
            padding: 4px 10px !important;
            border-radius: 6px !important;
            border: 1px solid #ddd !important;
            margin: 0 5px !important;
            min-width: 60px !important;
        }
        #tabelSatwaAdmin thead th {
            border-bottom: none !important;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .badge-light { background-color: #f8f9fa; color: #495057; }

        /* RESET KOTAK GANDA PAGINATION */
        .dataTables_wrapper .dataTables_paginate .page-item,
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 15px;
            display: flex;
            justify-content: flex-end;
        }
        .dataTables_wrapper .dataTables_paginate .page-link {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 36px !important;
            height: 36px !important;
            padding: 0 12px !important;
            margin: 0 3px !important;
            border: 1px solid #ced4da !important;
            border-radius: 8px !important;
            background: #fff !important;
            color: #656D4A !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            cursor: pointer !important;
            text-decoration: none !important;
            transition: all 0.2s ease;
        }
        .dataTables_wrapper .dataTables_paginate .ellipsis {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 36px !important;
            padding: 0 8px !important;
            color: #666 !important;
            font-weight: 700 !important;
            margin: 0 2px !important;
        }
        .dataTables_wrapper .dataTables_paginate .page-link:hover {
            background: #f0f4e8 !important;
            color: #333D29 !important;
            border-color: #A4AC86 !important;
        }
        .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
            background: #656D4A !important;
            color: #fff !important;
            border-color: #656D4A !important;
        }
        .dataTables_wrapper .dataTables_paginate .page-item.disabled .page-link {
            opacity: 0.4 !important;
            cursor: not-allowed !important;
            background: #f8f9fa !important;
            border-color: #dee2e6 !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 5px 10px;
            margin-left: 10px;
            outline: none;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 5px;
        }
        .page-item.active .page-link {
            background-color: #656D4A !important;
            border-color: #656D4A !important;
            color: white !important;
        }
        .page-link {
            color: #656D4A !important;
        }

        /* Efek warna emas untuk rating Tambah Admin */
    .rating-container-admin input:checked ~ label,
    .rating-container-admin label:hover,
    .rating-container-admin label:hover ~ label {
        color: #ffca08 !important;
    }

    /* Efek warna emas untuk rating Edit Admin */
    .rating-container-admin-edit input:checked ~ label,
    .rating-container-admin-edit label:hover,
    .rating-container-admin-edit label:hover ~ label {
        color: #ffca08 !important;
    }
    /* CSS Pintar memutar panah "Lihat Balasan" saat statusnya terbuka */
    .btn[aria-expanded="true"] .arrow-balasan {
        transform: rotate(180deg);
    }

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo">
            <h3>G. Puncak Pasir Ipis</h3>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('admin.dbadmin') }}" class="menu-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>

            <div class="menu-accordion-group">
                <a class="menu-item toggle-accordion {{ request()->is('admin/sos*') || request()->is('admin/satwa*') ? 'active' : '' }}"
                href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="false">
                    <i class="fas fa-folder-open"></i>
                    <span>Manajemen Laporan</span>
                    <i class="fas fa-chevron-down arrow-icon ml-auto"></i>
                </a>
                <div id="collapseLaporan" class="collapse">
                    <div class="sub-menu-box">
                        <a class="sub-item {{ request()->is('admin/sos*') ? 'sub-active' : '' }}" href="{{ route('admin.sos') }}">
                            <i class="fas fa-ambulance mr-2"></i> Riwayat SOS
                        </a>
                        <a class="sub-item {{ request()->is('admin/satwa*') ? 'sub-active' : '' }}" href="{{ route('admin.satwa') }}">
                            <i class="fas fa-paw mr-2"></i> Laporan Satwa
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-accordion-group">
                <a class="menu-item toggle-accordion {{ request()->is('admin/users*') || request()->is('admin/ulasan*') || request()->is('admin/konten*') ? 'active' : '' }}"
                href="#" data-toggle="collapse" data-target="#collapseMaster" aria-expanded="false">
                    <i class="fas fa-database"></i>
                    <span>Manajemen Master</span>
                    <i class="fas fa-chevron-down arrow-icon ml-auto"></i>
                </a>
                <div id="collapseMaster" class="collapse">
                    <div class="sub-menu-box">
                        <a class="sub-item {{ request()->is('admin/users*') ? 'sub-active' : '' }}" href="{{ route('admin.users') }}">
                            <i class="fas fa-users-cog mr-2"></i> Kelola Akun
                        </a>
                        <a class="sub-item {{ request()->is('admin/ulasan*') ? 'sub-active' : '' }}" href="{{ route('admin.ulasan') }}">
                            <i class="fas fa-comments mr-2"></i> Kelola Ulasan
                        </a>
                        <a class="sub-item {{ request()->is('admin/galeri*') ? 'sub-active' : '' }}" href="{{ route('admin.galeri') }}">
                            <i class="fas fa-images mr-2"></i> Kelola Galeri
                        </a>
                        {{-- <a class="sub-item {{ request()->is('admin/konten*') ? 'sub-active' : '' }}" href="{{ route('admin.konten') }}">
                            <i class="fas fa-edit mr-2"></i> Kelola Konten
                        </a> --}}
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.profil') }}" class="menu-item {{ request()->is('admin/profil*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Akun Pribadi
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
            <div style="font-weight: 600; font-size: 18px;">@yield('page_title')</div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-weight: bold;">Admin</span>
                <i class="fas fa-user-shield" style="color: #9aa770; font-size: 20px;"></i>
            </div>
        </div>

        <div class="container-fluid py-4">
            @yield('content')
            <style>
                .gallery-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                    gap: 20px;
                    padding: 15px 0;
                }

                .gallery-card {
                    position: relative;
                    background: #fff;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                    transition: transform 0.2s ease, box-shadow 0.2s ease;
                    border: 1px solid #eef0eb;
                }

                .gallery-card:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
                }

                .gallery-img-wrapper {
                    position: relative;
                    width: 100%;
                    padding-top: 75%;
                    background: #f4f6f0;
                }

                .gallery-img-wrapper img {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .delete-gallery-btn {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background: rgba(220, 53, 69, 0.9);
                    color: #fff;
                    border: none;
                    width: 34px;
                    height: 34px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: background 0.2s, transform 0.2s;
                    cursor: pointer;
                    z-index: 10;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                }

                .delete-gallery-btn:hover {
                    background: rgb(220, 53, 69);
                    transform: scale(1.1);
                    color: #fff;
                }

                .gallery-info {
                    padding: 12px;
                }

                .gallery-title {
                    font-size: 14px;
                    font-weight: 600;
                    color: #333;
                    margin-bottom: 6px;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                .gallery-badge {
                    font-size: 11px;
                    background-color: #eef2e6;
                    color: #414833;
                    padding: 4px 8px;
                    border-radius: 20px;
                    font-weight: 500;
                    display: inline-block;
                }
            </style>

<div class="container-fluid py-4"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // 1. Cek Otomatis Menu Manajemen Laporan
            if ($('#collapseLaporan .sub-item').hasClass('sub-active')) {
                $('#collapseLaporan').addClass('show');
                $('#collapseLaporan').siblings('.toggle-accordion').attr('aria-expanded', 'true');
            }

            // 2. Cek Otomatis Menu Manajemen Master
            if ($('#collapseMaster .sub-item').hasClass('sub-active')) {
                $('#collapseMaster').addClass('show');
                $('#collapseMaster').siblings('.toggle-accordion').attr('aria-expanded', 'true');
            }
        });
    </script>

    @yield('scripts')
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#656D4A'
        });
    </script>
    @endif
</body>
</html>
