@extends('layouts.karyawan_master')

@section('page_title', 'Laporan SOS')
@section('content')
<div class="container-fluid" style="padding: 20px;">

    <!-- ==========================================
         BAGIAN 1: SOS BARU (AKTIF)
         ========================================== -->
    <h2 style="color: #d62828; font-weight: 600; margin-bottom: 15px;">SOS Baru</h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 20px; margin-bottom: 40px;">
        @forelse($sosBaru as $sos)
        <!-- Kartu SOS Aktif -->
        <div class="card" style="border: 2px solid #ffb703; border-radius: 12px; padding: 20px; background-color: #fff9e6; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <h4 style="font-weight: bold; color: #333; margin-bottom: 5px;">
                        <i class="fas fa-exclamation-triangle" style="color: #d62828; margin-right: 8px;"></i>
                        {{ $sos->user->nama_user ?? 'Nama Tidak Diketahui' }}
                    </h4>
                    <p style="margin: 2px 0; font-size: 14px;"><strong>Status:</strong> {{ $sos->jenis_sos }}</p>
                    <!-- TAMBAHAN: Tampilkan deskripsi kalau ada isi pesan_tambahan -->
                    @if($sos->pesan_tambahan)
                        <div style="background: #fff3cd; padding: 10px; border-radius: 6px; border-left: 4px solid #ffc107; margin-top: 10px;">
                            <small style="font-weight: bold; color: #856404; display: block; margin-bottom: 2px;">PESAN TAMBAHAN:</small>
                            <p style="margin: 0; font-size: 14px; color: #555; font-style: italic;">
                                "{{ $sos->pesan_tambahan }}"
                            </p>
                        </div>
                    @endif
                    <p style="margin: 2px 0; font-size: 14px;"><strong>Lokasi:</strong> {{ $sos->latitude }}, {{ $sos->longitude }}</p>
                    <p style="margin: 2px 0; font-size: 14px; color: #d62828;"><strong>Jarak:</strong> ± {{ $sos->jarak }} KM dari Basecamp</p>
                    <p style="margin: 2px 0; font-size: 14px;"><strong>Waktu:</strong> {{ $sos->created_at->format('d M Y, H:i') }}</p>
                </div>
                <!-- Mini Map Google (Embed) -->
                <div style="width: 120px; height: 120px; border-radius: 8px; overflow: hidden; border: 1px solid #ccc; flex-shrink: 0;">
                    <iframe
                        width="100%"
                        height="100%"
                        frameborder="0"
                        scrolling="no"
                        marginheight="0"
                        marginwidth="0"
                        src="https://maps.google.com/maps?q={{ $sos->latitude }},{{ $sos->longitude }}&t=k&z=15&output=embed">
                    </iframe>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div style="margin-top: 20px; display: flex; gap: 10px;">

                <!-- Form Tombol Selesai (Hanya aktif kalau statusnya ditangani) -->
                <form action="{{ route('karyawan.sos.selesai', $sos->id_sos) }}" method="POST" style="flex: 1; margin: 0;">
                    @csrf
                    <button type="submit" style="width: 100%; background-color: #656D4A; color: white; border: none; padding: 8px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                        Selesai
                    </button>
                </form>

                <!-- Logika Tombol Respon -->
                @if($sos->status == 'aktif')
                    <form action="{{ route('karyawan.sos.respon', $sos->id_sos) }}" method="POST" style="flex: 1; margin: 0;">
                        @csrf
                        <button type="button" onclick="konfirmasiRespon(this)" style="width: 100%; background-color: #656D4A; color: white; border: none; padding: 8px; border-radius: 6px; font-weight: bold; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            Respon
                        </button>
                    </form>
                @else
                    <!-- Jika sudah ditangani, tombol respon jadi pudar dan gak bisa diklik -->
                    <button disabled style="flex: 1; background-color: #ccc; color: #666; border: none; padding: 8px; border-radius: 6px; font-weight: bold; cursor: not-allowed;">
                        Menuju Lokasi
                    </button>
                @endif

                <a href="https://maps.google.com/maps?q={{ $sos->latitude }},{{ $sos->longitude }}" target="_blank" style="flex: 1; background-color: #333D29; color: white; border: none; padding: 7px; border-radius: 4px; font-size: 14px; font-weight: bold; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">Lihat Lokasi</a>
            </div>
        </div>
        @empty
        <p style="color: #666; font-style: italic;">Tidak ada laporan darurat baru saat ini.</p>
        @endforelse
    </div>

    <!-- ==========================================
         BAGIAN 2: SUDAH DITANGANI (SELESAI)
         ========================================== -->
    <h2 style="color: #656D4A; font-weight: 600; margin-bottom: 15px;">Sudah Ditangani</h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 20px;">
        @forelse($sosSelesai as $sos)
        <!-- Kartu SOS Selesai -->
        <div class="card" style="border: 1px solid #ddd; border-radius: 12px; padding: 20px; background-color: #f9f9f9;">
            <h4 style="font-weight: bold; color: #555; margin-bottom: 5px;">
                <i class="fas fa-check-circle" style="color: #656D4A; margin-right: 8px;"></i>
                {{ $sos->user->nama_user ?? 'Nama Tidak Diketahui' }}
            </h4>
            <p style="margin: 2px 0; font-size: 14px; color: #666;"><strong>Status:</strong> {{ $sos->jenis_sos }}</p>
            <p style="margin: 2px 0; font-size: 14px; color: #666;"><strong>Lokasi:</strong> {{ $sos->latitude }}, {{ $sos->longitude }}</p>
            <p style="margin: 2px 0; font-size: 14px; color: #666;"><strong>Waktu Ditangani:</strong> {{ $sos->updated_at->format('d M Y, H:i') }}</p>
        </div>
        @empty
        <p style="color: #666; font-style: italic;">Belum ada riwayat penanganan SOS.</p>
        @endforelse
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiRespon(button) {
        Swal.fire({
            title: 'Berangkatkan Tim Rescue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0077B6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Berangkatkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form otomatis kalau diklik Ya
                button.closest('form').submit();
            }
        })
    }
</script>
@endsection
