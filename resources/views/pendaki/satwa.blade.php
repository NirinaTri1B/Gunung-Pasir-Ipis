@extends('layouts.dbpendaki_master')

@section('page_title', 'Laporan Satwa')

@section('content')
<div class="container py-4">
    <div class="laporan-container">

        <form action="{{ url('/laporan-satwa/simpan') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label>Nama Satwa</label><br>
                <input type="text" name="nama_satwa" class="form-control" placeholder="Contoh: Babi Hutan, Lutung, dll" required>
            </div><br>

            <div class="form-group mb-3">
                <label>Lokasi Terlihat</label><br>
                <select name="lokasi" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Lokasi --</option>
                    <option value="Pos 1">Sekitar Pos 1</option>
                    <option value="Pos 2">Sekitar Pos 2</option>
                    <option value="Pos 3">Sekitar Pos 3</option>
                    <option value="Puncak">Area Puncak</option>
                </select><br>
                <small class="text-muted">*Pilih lokasi terdekat saat kamu melihat satwa tersebut.</small>
            </div><br>

            <div class="form-group mb-3">
                <label>Deskripsi Kejadian</label><br>
                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Ceritakan detailnya (misal: jumlah satwa, perilaku, dan sebagainya)"></textarea>
            </div><br>

            <div class="form-group mb-4">
                <label>Foto Bukti</label><br>
                <input type="file" name="foto" class="form-control" accept="img/satwa" required>
            </div><br>

            <button type="submit" class="btn-kirim">
                <i class="fas fa-paper-plane mr-2"></i> KIRIM LAPORAN
            </button>
        </form>
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#414833', // Warna hijau khas GPPI
                    confirmButtonText: 'Oke!'
                });
            });
        </script>
        @endif
    </div>
</div>
@endsection
