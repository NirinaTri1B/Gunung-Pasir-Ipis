@extends('layouts.pendaki_master')

@section('page_title', 'Laporan Satwa')

@section('content')
<div class="container py-2">
    <div class="laporan-container">

        <div class="laporan-header" style="text-align: center">
            <h2><i class="fas fa-paw mr-2"></i> Laporan Satwa</h2>
        </div>

        <form action="{{ url('/laporan-satwa/simpan') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label>Nama Satwa</label>
                <input type="text" name="nama_satwa" class="form-control" placeholder="Contoh: Babi Hutan, Lutung, dll" required value="{{ old('nama_satwa') }}">
            </div>

            <div class="form-group mb-3">
                <label>Lokasi Terlihat</label>
                <select name="lokasi" class="form-control" required style="height: auto; padding: 10px 12px;">
                    <option value="" disabled selected>-- Pilih Lokasi --</option>
                    <option value="Pos 1" {{ old('lokasi') == 'Pos 1' ? 'selected' : '' }}>Sekitar Pos 1</option>
                    <option value="Pos 2" {{ old('lokasi') == 'Pos 2' ? 'selected' : '' }}>Sekitar Pos 2</option>
                    <option value="Pos 3" {{ old('lokasi') == 'Pos 3' ? 'selected' : '' }}>Sekitar Pos 3</option>
                    <option value="Pos 4" {{ old('lokasi') == 'Pos 4' ? 'selected' : '' }}>Sekitar Pos 4</option>
                    <option value="Pos 5" {{ old('lokasi') == 'Pos 5' ? 'selected' : '' }}>Sekitar Pos 5</option>
                    <option value="Puncak" {{ old('lokasi') == 'Puncak' ? 'selected' : '' }}>Area Puncak</option>
                </select>
                <small class="text-muted d-block mt-1">*Pilih lokasi terdekat saat kamu melihat satwa tersebut.</small>
            </div>

            <div class="form-group mb-3">
                <label>Deskripsi Kejadian</label>
                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Ceritakan detailnya (misal: jumlah satwa, perilaku, dan sebagainya)">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-group mb-4">
                <label>Foto Bukti</label>
                <input type="file" name="foto" class="form-control" style="padding: 6px 12px; height: auto;" accept="image/*">
            </div>

            <button type="submit" class="btn-kirim">
                <i class="fas fa-paper-plane mr-2"></i> KIRIM LAPORAN
            </button>
        </form>

        {{-- 1. ALERT JIKA BERHASIL --}}
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#414833',
                    confirmButtonText: 'Oke!'
                });
            });
        </script>
        @endif

        {{-- 2. TAMBAHKAN BLOK INI: ALERT JIKA VALIDATION GAGAL (BIAR KETAHUAN SALAHNYA) --}}
        @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Gagal Mengirim Laporan!',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    icon: 'error',
                    confirmButtonColor: '#A94442',
                    confirmButtonText: 'Cek Kembali'
                });
            });
        </script>
        @endif
    </div>
</div>
@endsection
