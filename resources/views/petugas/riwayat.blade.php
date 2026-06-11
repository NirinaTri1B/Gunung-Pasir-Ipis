@extends('layouts.petugas_master')

@section('page_title', 'Riwayat Penyelamatan SOS')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<div class="container-fluid" style="padding: 20px;">
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
        <h2 style="color: #656D4A; font-weight: 600; margin-bottom: 15px;">Riwayat Penanganan SOS</h2>

        <table id="tabelRiwayat" class="display" style="width:100%">
            <thead>
                <tr style="background: #656D4A; color: white; font-weight: bold;">
                    <th style="padding: 12px;">Tanggal Ditangani</th>
                    <th style="padding: 12px;">Nama Pendaki</th>
                    <th style="padding: 12px;">Kendala</th>
                    <th style="padding: 12px;">Lokasi</th>
                    <th style="padding: 12px;">Pesan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayatTugas as $sos)
                <tr>
                    <td>{{ $sos->updated_at->format('d/m/Y H:i') }}</td>
                    <td style="font-weight: bold; color: #333;">{{ $sos->user->nama_user ?? 'N/A' }}</td>
                    <td>
                        <span style="background: #fff3cd; color: #856404; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">
                            {{ $sos->jenis_sos }}
                        </span>
                    </td>
                    <td>
                        <a href="https://www.google.com/maps?q={{ $sos->latitude }},{{ $sos->longitude }}" target="_blank" style="color: #656D4A; text-decoration: underline;">
                            <small><i class="fas fa-map-marker-alt"></i> Lihat Peta</small>
                        </a>
                    </td>
                    <td style="font-size: 13px; color: #666; font-style: italic;">{{ $sos->pesan_tambahan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabelRiwayat').DataTable({
            "language": {
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "paginate": {
                    "next": "Next",
                    "previous": "Previous"
                }
            },
            "order": [[ 0, "desc" ]]
        });
    });
</script>
@endsection
