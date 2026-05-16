@extends('layouts.karyawan_master')

@section('page_title', 'Laporan Data Satwa')

@section('content')
<div style="padding: 20px;">

    <!-- 1. BAGIAN DATA AKTIF (Dengan Tombol Sampah & Selesai) -->
    <h2 style="color: #d62828; margin-bottom: 20px; font-weight: bold;">
        <i class="fas fa-exclamation-triangle"></i> Laporan Satwa Aktif
    </h2>

    <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 50px;">
        @forelse($satwaAktif as $satwa)
            <div style="display: flex; align-items: center; background: white; border-radius: 10px; padding: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 5px solid #d62828;">
                <div style="flex-grow: 1;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <h4 style="margin: 0; color: #333; text-transform: uppercase; font-weight: bold;">{{ $satwa->nama_satwa }}</h4>
                        <span style="background: #f0f0f0; padding: 2px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; color: #555;">{{ $satwa->lokasi }}</span>
                    </div>
                    <p style="margin: 5px 0; font-size: 14px; color: #666;">
                        Oleh: <strong>{{ $satwa->nama_user }}</strong> | {{ date('H:i', strtotime($satwa->created_at)) }} WIB
                    </p>
                    <p style="margin: 0; font-size: 13px; color: #444; font-style: italic;">"{{ $satwa->deskripsi }}"</p>
                </div>

                <div style="display: flex; gap: 10px; align-items: center;">
                    {{-- Tombol Lihat Foto --}}
                    @if($satwa->foto)
                        <button onclick="showFoto('{{ asset('img/satwa/' . $satwa->foto) }}', '{{ $satwa->nama_satwa }}')" style="background: #0077B6; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer;">
                            <i class="fas fa-camera"></i> Lihat Foto
                        </button>
                    @endif

                    {{-- Tombol Selesai --}}
                    <form action="{{ route('karyawan.satwa.selesai', $satwa->id_laporan) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #656D4A; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                            Selesai
                        </button>
                    </form>

                    {{-- Tombol Sampah (Hapus Laporan Palsu) --}}
                    <form action="{{ route('karyawan.satwa.hapus', $satwa->id_laporan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #d62828; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 20px; background: #fff; border-radius: 10px; color: #999;">
                <p>Tidak ada gangguan satwa aktif saat ini.</p>
            </div>
        @endforelse
    </div>

    <!-- 2. BAGIAN RIWAYAT (Tanpa Kolom Status) -->
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
        <h2 style="color: #414833; margin-bottom: 20px; font-weight: bold;">
            Riwayat Penanganan Satwa
        </h2>

        <table id="tabelRiwayat" class="display" style="width:100%">
            <thead>
                <tr style="background: #656D4A; color: white;">
                    <th class="text-center" style="vertical-align: middle; border: none;">No</th>
                    <th class="text-center" style="vertical-align: middle; border: none;">Tanggal</th>
                    <th class="text-center" style="vertical-align: middle; border: none;">Pelapor</th>
                    <th class="text-center" style="vertical-align: middle; border: none;">Nama Satwa</th>
                    <th class="text-center" style="vertical-align: middle; border: none;">Lokasi</th>
                    <th class="text-center" style="vertical-align: middle; border: none;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($satwaSelesai as $selesai)
                <tr>
                    <td class="text-center font-weight-bold" style="color: #936639; vertical-align: middle;">{{ $loop->iteration }}</td>
                    <td>{{ date('d/m/Y', strtotime($selesai->updated_at)) }}</td>
                    <td style="font-weight: bold; color: #414833;">{{ $selesai->nama_user }}</td>
                    <td style="font-weight: bold; color: #414833;">{{ $selesai->nama_satwa }}</td>
                    <td><span style="background: #eee; padding: 2px 8px; border-radius: 4px;">{{ $selesai->lokasi }}</span></td>
                    <td style="font-size: 13px; color: #666;">{{ $selesai->deskripsi }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Pop-up Foto -->
<div id="fotoModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); align-items: center; justify-content: center;">
    <div style="background: white; padding: 20px; border-radius: 12px; max-width: 90%; text-align: center; position: relative;">
        <span onclick="closeModal()" style="position: absolute; top: -15px; right: -15px; background: #d62828; color: white; width: 35px; height: 35px; border-radius: 50%; line-height: 35px; cursor: pointer; font-weight: bold; border: 3px solid white;">✕</span>
        <img id="modalImg" src="" style="max-width: 100%; max-height: 75vh; border-radius: 8px;">
    </div>
</div>

<!-- CSS & JS DATATABLES -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#tabelRiwayat').DataTable({
        "order": [[0, "desc"]], // Otomatis urutkan dari tanggal terbaru
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        }
    });
});

function showFoto(url, title) {
    document.getElementById('modalImg').src = url;
    document.getElementById('fotoModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('fotoModal').style.display = 'none';
}
</script>

<style>
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #656D4A !important;
        border-radius: 8px !important;
        padding: 5px 15px !important;
        margin-bottom: 15px !important;
    }
    table.dataTable thead th {
        padding: 15px !important;
        border: none !important;
    }
    table.dataTable tbody td {
        padding: 12px !important;
        border-bottom: 1px solid #eee !important;
    }
</style>
@endsection
