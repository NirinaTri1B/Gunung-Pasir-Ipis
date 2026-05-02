@extends('layouts.karyawan_master')

@section('page_title', 'Laporan Satwa')

@section('content')
<div style="padding: 20px;">

    <!-- BAGIAN 1: LAPORAN AKTIF -->
    <h2 style="color: #d62828; margin-bottom: 20px; font-weight: bold;">Laporan Satwa Aktif</h2>

    <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 40px;">
        @forelse($satwaAktif as $satwa)
            <div style="display: flex; align-items: center; background: white; border-radius: 10px; padding: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 5px solid #d62828;">

                <!-- Info Utama -->
                <div style="flex-grow: 1;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <h4 style="margin: 0; color: #333; text-transform: uppercase; font-weight: bold;">{{ $satwa->nama_satwa }}</h4>
                        <span style="background: #f0f0f0; padding: 2px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; color: #555;">{{ $satwa->lokasi }}</span>
                    </div>
                    <p style="margin: 5px 0; font-size: 14px; color: #666;">
                        Dilaporkan oleh <strong>{{ $satwa->nama_user }}</strong> | {{ date('H:i', strtotime($satwa->created_at)) }} WIB
                    </p>
                    <p style="margin: 0; font-size: 14px; color: #444; font-style: italic; background: #fff9f9; padding: 5px; border-radius: 4px;">"{{ $satwa->deskripsi }}"</p>
                </div>

                <!-- Tombol Aksi -->
                <div style="display: flex; gap: 10px; align-items: center; margin-left: 20px;">
                    @if($satwa->foto)
                        <button type="button" onclick="showFoto('{{ asset('img/satwa/' . $satwa->foto) }}', '{{ $satwa->nama_satwa }}')" style="background: #0077B6; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; font-weight: bold; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-camera"></i> Lihat Foto
                        </button>
                    @endif

                    <form action="{{ route('karyawan.satwa.selesai', $satwa->id_laporan) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #656D4A; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                            Selesai
                        </button>
                    </form>

                    <!-- Tombol Hapus (Warna Merah) -->
                    <form action="{{ route('karyawan.satwa.hapus', $satwa->id_laporan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini? (Gunakan jika laporan palsu!')" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #d62828; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 30px; background: #f9f9f9; border-radius: 10px; color: #999; border: 2px dashed #eee;">
                <p>Semua lokasi terpantau aman dari gangguan satwa.</p>
            </div>
        @endforelse
    </div>

    <hr style="border: 0; border-top: 2px solid #eee; margin: 40px 0;">

    <!-- BAGIAN 2: RIWAYAT SELESAI -->
    <h2 style="color: #666; margin-bottom: 20px; font-weight: bold;">Riwayat Penanganan Selesai</h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px; opacity: 0.8;">
        @foreach($satwaSelesai as $selesai)
            <div style="background: #fafafa; border-radius: 8px; padding: 12px; border: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong style="color: #444; text-transform: uppercase; font-size: 13px;">{{ $selesai->nama_satwa }}</strong><br>
                    <small style="color: #888;">{{ $selesai->lokasi }} • {{ date('d/m/Y', strtotime($selesai->updated_at)) }}</small>
                </div>
                <i class="fas fa-check-circle" style="color: #656D4A; font-size: 20px;"></i>
            </div>
        @endforeach
    </div>

</div>

<!-- Modal Pop-up Foto -->
<div id="fotoModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); align-items: center; justify-content: center;">
    <div style="background: white; padding: 20px; border-radius: 12px; max-width: 90%; text-align: center; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
        <span onclick="closeModal()" style="position: absolute; top: -15px; right: -15px; background: #d62828; color: white; width: 35px; height: 35px; border-radius: 50%; line-height: 35px; cursor: pointer; font-weight: bold; border: 3px solid white;">✕</span>
        <h3 id="modalTitle" style="margin-top: 0; color: #333; text-transform: uppercase;"></h3>
        <img id="modalImg" src="" style="max-width: 100%; max-height: 75vh; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
    </div>
</div>

<script>
function showFoto(url, title) {
    document.getElementById('modalImg').src = url;
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('fotoModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('fotoModal').style.display = 'none';
}

// Tutup modal kalau klik di luar gambar
window.onclick = function(event) {
    let modal = document.getElementById('fotoModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>
@endsection
