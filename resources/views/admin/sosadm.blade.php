@extends('layouts.admin_master')

@section('page_title', 'Manajemen Laporan')

@section('content')
<div class="container-fluid mt-2">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h4 class="font-weight-bold" style="color: #414833; margin-bottom: 0px;">
                <i class="fas fa-exclamation-triangle" style="font-size: 20px;"></i> Riwayat Penanganan SOS
            </h4><br>
        </div>
    </div>

    <div class="card shadow-sm border-0 px-3 pt-1 pb-3" style="border-radius: 12px; background: #ffffff;">
        <div class="card-body p-2 pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover" id="tabelSosAdmin" width="100%" cellspacing="0" style="border-collapse: separate; border-spacing: 0 4px;">
                    <thead style="background-color: #656D4A; border-radius: 8px;">
                        <tr class="text-white" style="font-size: 14px; font-weight: 700; height: 45px;">
                            <th class="text-center p-3" style="border: none; border-top-left-radius: 8px; border-bottom-left-radius: 8px; width: 5%;">No</th>
                            <th class="text-center p-3" style="border: none;">Tanggal Kejadian</th>
                            <th class="text-left p-3" style="border: none;">Nama Pendaki</th>
                            <th class="text-center p-3" style="border: none;">Jenis Darurat</th>
                            <th class="text-left p-3" style="border: none;">Petugas Evakuasi</th>
                            <th class="text-center p-3" style="border: none; border-top-right-radius: 8px; border-bottom-right-radius: 8px; width: 15%;">Status Laporan</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px; color: #4a5568;">
                        @forelse($sos as $index => $s)
                            <tr style="border-bottom: 1px solid #f4f6f0;">
                                <td class="text-center p-3 font-weight-bold text-muted">{{ $index + 1 }}</td>
                                <td class="text-center p-3 text-muted">{{ $s->created_at->format('d M Y, H:i') }} WIB</td>

                                <td class="text-left p-3 font-weight-bold" style="color: #2d3748;">
                                    {{ $s->registrasi->user->nama_user ?? 'Pendaki' }}
                                </td>

                                <td class="text-center p-3">
                                    <span class="badge px-3 py-2 text-danger" style="background-color: #fce8e6; border-radius: 6px; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <i class="fas fa-exclamation-triangle mr-1" style="font-size: 11px;"></i> {{ $s->jenis_sos ?? 'SOS' }}
                                    </span>
                                </td>

                                <td class="text-left p-3">
                                    @if($s->status == 'aktif')
                                        <span class="text-danger font-italic small">
                                            <i class="fas fa-spinner fa-spin mr-1"></i> Menunggu Petugas...
                                        </span>
                                    @else
                                        <span style="font-weight: 600; color: #495057;">
                                            <i class="fas fa-user-shield mr-1" style="color: #a4ac86; font-size: 12px;"></i>
                                            {{ $s->petugas->nama_user ?? 'Tim Ranger' }}
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center p-3">
                                    @if($s->status == 'aktif')
                                        <span class="badge badge-danger p-2 shadow-sm" style="border-radius: 6px; font-size: 11px; min-width: 100px; font-weight: 600;">
                                            <i class="fas fa-bell mr-1"></i> SOS Aktif
                                        </span>
                                    @elseif($s->status == 'ditangani')
                                        <span class="badge badge-warning p-2 text-dark shadow-sm" style="border-radius: 6px; font-size: 11px; min-width: 100px; font-weight: 600; background-color: #ffc107;">
                                            <i class="fas fa-running mr-1"></i> Ditangani
                                        </span>
                                    @elseif($s->status == 'selfinished' || $s->status == 'selesai')
                                        <span class="badge text-white p-2 shadow-sm" style="border-radius: 6px; font-size: 11px; min-width: 100px; font-weight: 600; background-color: #4F6F52;">
                                            <i class="fas fa-check-circle mr-1"></i> Selesai
                                        </span>
                                    @else
                                        <span class="badge badge-secondary p-2 shadow-sm" style="border-radius: 6px; font-size: 11px; min-width: 100px; font-weight: 600;">
                                            {{ ucfirst($s->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-4 text-muted" style="font-style: italic;">Belum ada riwayat insiden SOS yang terekam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<style>
    .dataTables_wrapper .dataTables_length select {
        border-radius: 6px;
        padding: 4px 8px;
        border: 1px solid #dcdcdc;
    }
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 6px;
        padding: 5px 12px;
        border: 1px solid #dcdcdc;
        margin-left: 8px;
        outline: none;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #656D4A;
        box-shadow: 0 0 0 0.2rem rgba(101, 109, 74, 0.25);
    }
    .page-item.active .page-link {
        background-color: #656D4A !important;
        border-color: #656D4A !important;
        color: white !important;
    }
    .page-link {
        color: #656D4A;
        border-radius: 6px;
        margin: 0 2px;
    }
    .table-hover tbody tr:hover {
        background-color: #fdfefe;
    }
</style>

<script>
    (function($) {
        $(document).ready(function() {
            if ($.fn.DataTable) {
                // Hancurkan inisialisasi lama jika ada sangkutan cache browser
                if ($.fn.DataTable.isDataTable('#tabelSosAdmin')) {
                    $('#tabelSosAdmin').DataTable().destroy();
                }

                $('#tabelSosAdmin').DataTable({
                    "pageLength": 10,
                    "searching": true,
                    "paging": true,
                    "ordering": true,
                    "info": true,
                    "responsive": true,
                    "language": {
                        "sLengthMenu":   "Tampilkan _MENU_ baris",
                        "sZeroRecords":  "Tidak ditemukan data SOS",
                        "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ insiden",
                        "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 data",
                        "sSearch":       "Cari:",
                        "oPaginate": {
                            "sPrevious": "<i class='fas fa-chevron-left'></i>",
                            "sNext":     "<i class='fas fa-chevron-right'></i>"
                        }
                    }
                });
            }
        });
    })(jQuery);
</script>
@endsection
