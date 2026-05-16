@extends('layouts.karyawan_master')

@section('page_title', 'Laporan SOS')
@section('content')
<div class="container-fluid" style="padding: 20px;">

    <h2 style="color: #d62828; margin-bottom: 20px; font-weight: bold;">
        <i class="fas fa-exclamation-triangle"></i> Laporan SOS Aktif
    </h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 20px; margin-bottom: 40px;">
        @forelse($sosBaru as $sos)
        <div class="card" style="border: 2px solid #ffb703; border-radius: 12px; padding: 20px; background-color: #fff9e6; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <h4 style="font-weight: bold; color: #333; margin-bottom: 5px;">
                        <i class="fas fa-exclamation-triangle" style="color: #d62828; margin-right: 8px;"></i>
                        {{ $sos->user->nama_user ?? 'Nama Tidak Diketahui' }}
                    </h4>
                    <p style="margin: 2px 0; font-size: 14px;"><strong>Status:</strong> {{ $sos->jenis_sos }}</p>

                    @if($sos->id_petugas)
                        <p style="margin: 2px 0; font-size: 14px; color: #2a9d8f;">
                            <strong>Petugas:</strong> {{ $sos->petugas->nama_user ?? 'Ditugaskan' }}
                            ({{ array_key_exists($sos->status_sos, [
                                'waiting' => 'Menunggu Konfirmasi',
                                'on_the_way' => 'Dalam Perjalanan',
                                'selesai' => 'Selesai'
                            ]) ? array_key_exists($sos->status_sos, [
                                'waiting' => 'Menunggu Konfirmasi',
                                'on_the_way' => 'Dalam Perjalanan',
                                'selesai' => 'Selesai'
                            ]) : 'Status Tidak Diketahui' }})
                        </p>
                    @endif

                    @if($sos->pesan_tambahan)
                        <div style="background: #fff3cd; padding: 10px; border-radius: 6px; border-left: 4px solid #ffc107; margin-top: 10px;">
                            <small style="font-weight: bold; color: #856404; display: block; margin-bottom: 2px;">PESAN TAMBAHAN:</small>
                            <p style="margin: 0; font-size: 14px; color: #555; font-style: italic;">"{{ $sos->pesan_tambahan }}"</p>
                        </div>
                    @endif
                    <p style="margin: 2px 0; font-size: 14px;"><strong>Lokasi:</strong> {{ $sos->latitude }}, {{ $sos->longitude }}</p>
                    <p style="margin: 2px 0; font-size: 14px; color: #d62828;"><strong>Jarak:</strong> ± {{ $sos->jarak }} KM dari Basecamp</p>
                    <p style="margin: 2px 0; font-size: 14px;"><strong>Waktu:</strong> {{ $sos->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div style="width: 120px; height: 120px; border-radius: 8px; overflow: hidden; border: 1px solid #ccc; flex-shrink: 0;">
                    <iframe width="100%" height="100%" frameborder="0" scrolling="no" src="https://maps.google.com/maps?q={{ $sos->latitude }},{{ $sos->longitude }}&t=k&z=15&output=embed"></iframe>
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 10px;">
                @if(!$sos->id_petugas)
                    <button type="button" onclick="bukaModalTugaskan('{{ $sos->id_sos }}')" style="flex: 1; min-width: 120px; background-color: #f3722c; color: white; border: none; padding: 8px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                        <i class="fas fa-user-shield"></i> Tugaskan
                    </button>
                @endif

                <form action="{{ route('karyawan.sos.selesai', $sos->id_sos) }}" method="POST" style="flex: 1; margin: 0;">
                    @csrf
                    <button type="submit" style="width: 100%; background-color: #656D4A; color: white; border: none; padding: 8px; border-radius: 6px; font-weight: bold; cursor: pointer;">Selesai</button>
                </form>

                <a href="https://maps.google.com/maps?q={{ $sos->latitude }},{{ $sos->longitude }}" target="_blank" style="flex: 1; background-color: #333D29; color: white; border: none; padding: 7px; border-radius: 4px; font-size: 14px; font-weight: bold; text-align: center; text-decoration: none;">Lihat Lokasi</a>
            </div>
        </div>
        @empty
        <p style="color: #666; font-style: italic;">Tidak ada laporan darurat baru saat ini.</p>
        @endforelse
    </div>

    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
        <h2 style="color: #656D4A; font-weight: 600; margin-bottom: 20px;">Riwayat Penanganan SOS</h2>
        <table id="tabelRiwayatSos" class="display" style="width:100%">
            <thead>
                <tr style="background: #656D4A; color: white; font-weight: bold;">
                    <th>Tanggal Ditangani</th>
                    <th>Nama Pendaki</th>
                    <th>Kendala</th>
                    <th>Lokasi</th>
                    <th>Pesan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sosSelesai as $sos)
                <tr>
                    <td>{{ $sos->updated_at->format('d/m/Y H:i') }}</td>
                    <td style="font-weight: bold; color: #333;">{{ $sos->user->nama_user ?? 'N/A' }}</td>
                    <td><span style="background: #fff3cd; color: #856404; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">{{ $sos->jenis_sos }}</span></td>
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

<div id="modalTugaskan" style="display: none;">
    <form id="formKirimPetugas" action="{{ route('basecamp.kirim_petugas') }}" method="POST">
        @csrf
        <input type="hidden" name="id_sos" id="modal_id_sos">
        <div style="text-align: left; padding: 10px;">
            <label style="font-weight: bold; display: block; margin-bottom: 10px;">Pilih Petugas Lapangan:</label>
            <select name="id_petugas" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;" required>
                <option value="">-- Pilih Petugas --</option>
                @foreach($petugas_lapangan as $p)
                    <option value="{{ $p->id_user }}">{{ $p->nama_user }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        $('#tabelRiwayatSos').DataTable({
            "order": [[0, "desc"]],
            "language": {
                // Glenn ganti jadi lokal aja biar nggak kena error CORS lagi
                "emptyTable": "Tidak ada riwayat penanganan"
            }
        });

        // Tampilkan alert sukses kalau ada session dari Controller
        @if(session('success'))
            Swal.fire('Berhasil!', '{{ session("success") }}', 'success');
        @endif
        @if(session('error'))
            Swal.fire('Oops!', '{{ session("error") }}', 'error');
        @endif
    });

    function bukaModalTugaskan(idSos) {
        // Set ID SOS ke input hidden di dalam modal
        document.getElementById('modal_id_sos').value = idSos;

        // Ambil HTML dari div modalTugaskan
        const modalHtml = document.getElementById('modalTugaskan').innerHTML;

        Swal.fire({
            title: 'Tugaskan Tim Lapangan',
            html: modalHtml,
            showCancelButton: true,
            confirmButtonColor: '#f3722c',
            confirmButtonText: 'Kirim Bantuan',
            cancelButtonText: 'Batal',
            preConfirm: () => {
                // Ambil nilai select dari dalam popup SweetAlert
                const select = Swal.getPopup().querySelector('select');
                if (!select.value) {
                    Swal.showValidationMessage('Silakan pilih petugas lapangan!');
                }
                return { id_petugas: select.value };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Masukkan id_petugas yang dipilih ke form asli
                const form = document.getElementById('formKirimPetugas');
                form.querySelector('select').value = result.value.id_petugas;

                // Submit form
                form.submit();
            }
        });
    }
</script>

<style>
    .dataTables_wrapper .dataTables_filter input { border: 1px solid #656D4A !important; border-radius: 8px !important; padding: 5px 15px !important; margin-bottom: 15px !important; }
    table.dataTable thead th { padding: 15px !important; border: none !important; }
    table.dataTable tbody td { padding: 12px !important; border-bottom: 1px solid #eee !important; }
</style>
@endsection
