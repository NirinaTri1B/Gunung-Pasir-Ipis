@extends('layouts.admin_master')

@section('page_title', 'Manajemen Laporan')

@section('content')
<div class="container-fluid mt-2">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h4 class="font-weight-bold" style="color: #414833; margin-bottom: 0px;">
                <i class="fas fa-paw mr-2" style="font-size: 20px;"></i> Riwayat Laporan Satwa keliaran
            </h4><br>
        </div>
    </div>

    <div class="card shadow-sm border-0 px-3 pt-1 pb-3" style="border-radius: 12px; background: #ffffff;">
        <div class="card-body p-2 pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover" id="tabelSatwaAdmin" width="100%" cellspacing="0" style="border-collapse: separate; border-spacing: 0 4px;">
                    <thead style="background-color: #656D4A; border-radius: 8px;">
                        <tr class="text-white" style="font-size: 14px; font-weight: 700; height: 45px;">
                            <th class="text-center p-3" style="border: none; border-top-left-radius: 8px; border-bottom-left-radius: 8px; width: 5%;">No</th>
                            <th class="text-center p-3" style="border: none; width: 18%;">Tanggal Laporan</th>
                            <th class="text-left p-3" style="border: none; width: 15%;">Pelapor</th>
                            <th class="text-left p-3" style="border: none; width: 15%;">Nama Satwa</th>
                            <th class="text-center p-3" style="border: none; width: 10%;">Lokasi</th>
                            <th class="text-left p-3" style="border: none; width: 22%;">Keterangan</th>
                            <th class="text-center p-3" style="border: none; border-top-right-radius: 8px; border-bottom-right-radius: 8px; width: 15%;">Bukti Foto</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px; color: #4a5568;">
                        @forelse($satwa as $index => $st)
                            <tr style="border-bottom: 1px solid #f4f6f0;">
                                <td class="text-center p-3 font-weight-bold text-muted">{{ $index + 1 }}</td>
                                <td class="text-center p-3 text-muted">{{ $st->created_at->format('d M Y, H:i') }} WIB</td>
                                <td class="text-left p-3 font-weight-bold" style="color: #414833">{{ $st->user->nama_user ?? 'Pendaki' }}</td>
                                <td class="text-left p-3 font-weight-bold text-capitalize" style="color: #2d3748;">{{ $st->nama_satwa }}</td>

                                <td class="text-center p-3">
                                    <span class="badge px-2 py-1 text-secondary border bg-light text-capitalize" style="font-size: 12px; font-weight: 600; border-radius: 6px;">
                                        <i class="fas fa-map-marker-alt text-muted mr-1" style="font-size: 11px;"></i> {{ $st->lokasi ?? '-' }}
                                    </span>
                                </td>

                                <td class="text-left p-3 text-truncate" style="max-width: 200px;" title="{{ $st->deskripsi }}">
                                    {{ $st->deskripsi ?? '-' }}
                                </td>

                                <td class="text-center p-3">
                                    @if($st->foto)
                                        <button type="button" class="btn btn-sm text-white font-weight-bold p-2 shadow-sm"
                                                style="background-color: #656D4A; border-radius: 6px; border: none; font-size: 12px; min-width: 100px;"
                                                onclick="previewFotoSatwa('{{ asset('img/satwa/' . $st->foto) }}', '{{ $st->nama_satwa }}')">
                                            <i class="fas fa-image mr-1"></i> Lihat Foto
                                        </button>
                                    @else
                                        <span class="text-muted font-italic small">Tidak ada foto</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center p-4 text-muted" style="font-style: italic;">Belum ada data laporan satwa yang terekam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFotoSatwa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
            <div class="modal-header text-white" style="background-color: #414833; border: none;">
                <h5 class="modal-title font-weight-bold" id="judulModalSatwa" style="font-size: 16px;">Foto Satwa</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-3" style="background-color: #f8f9fa;">
                <img id="frameFotoSatwa" src="" alt="Bukti Satwa" class="img-fluid rounded shadow-sm" style="max-height: 450px; width: 100%; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<style>

</style>

<script>
    (function($) {
        $(document).ready(function() {
            if ($.fn.DataTable) {
                if ($.fn.DataTable.isDataTable('#tabelSatwaAdmin')) {
                    $('#tabelSatwaAdmin').DataTable().destroy();
                }

                $('#tabelSatwaAdmin').DataTable({
                    "pageLength": 10,
                    "searching": true,
                    "paging": true,
                    "ordering": true,
                    "info": true,
                    "responsive": true,
                    "language": {
                        "sLengthMenu":   "Tampilkan _MENU_ data",
                        "sZeroRecords":  "Tidak ditemukan laporan satwa",
                        "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 data",
                        "sSearch":       "Cari Satwa:",
                        "oPaginate": {
                            "sPrevious": "<i class='fas fa-chevron-left'></i>",
                            "sNext":     "<i class='fas fa-chevron-right'></i>"
                        }
                    }
                });
            }
        });
    })(jQuery);

    function previewFotoSatwa(urlGambar, namaSatwa) {
        document.getElementById('frameFotoSatwa').src = urlGambar;
        document.getElementById('judulModalSatwa').innerHTML = `<i class="fas fa-paw mr-2"></i> Bukti Temuan: ${namaSatwa.toUpperCase()}`;
        jQuery('#modalFotoSatwa').modal('show');
    }
</script>
@endsection
