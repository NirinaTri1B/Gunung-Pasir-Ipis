@extends('layouts.dbpendaki_master')

@section('page_title', 'Kelola Akun')

@section('content')
<style>
    .form-label { font-weight: 600; color: #414833; margin-bottom: 5px; display: block; }
    .form-control-custom {
        width: 100%; padding: 12px; border: 1px solid #E0E5D8; border-radius: 10px;
        transition: 0.3s; background-color: #f9fdf5;
    }
    .form-control-custom:focus {
        border-color: #728156; outline: none; box-shadow: 0 0 0 3px rgba(114, 129, 86, 0.1);
    }
    .btn-save {
        background-color: #414833; color: white; padding: 12px 25px; border: none;
        border-radius: 10px; cursor: pointer; font-weight: bold; width: 100%; transition: 0.3s;
    }
    .btn-save:hover { background-color: #2d3324; transform: translateY(-2px); }
    .input-disabled { background-color: #eee !important; cursor: not-allowed; color: #888; }
</style>

<div class="container-fluid" style="padding-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="padding: 40px; border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <div class="text-center mb-4">
                    <h2 class="fw-bold" style="color: #414833;">Halo, {{ $user->nama_user }}!</h2>
                    <p style="color: #728156;">Lengkapi atau perbarui informasi akun pendaki kamu di sini.</p>
                </div>
                <hr style="border-top: 2px solid #f0f4e9; margin-bottom: 30px;">

                <form action="{{ route('pendaki.update') }}" method="POST" id="formUpdateAkun">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-envelope me-1"></i> Email</label>
                            <input type="text" value="{{ $user->email }}" disabled class="form-control-custom input-disabled">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-user me-1"></i> Nama Lengkap</label>
                            <input type="text" name="nama_user" value="{{ $user->nama_user }}" class="form-control-custom" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label"><i class="fas fa-phone me-1"></i> Nomor Telepon</label>
                            <input type="text" name="no_telp" value="{{ $user->no_telp }}" class="form-control-custom" placeholder="Contoh: 0812xxxx">
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i> Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control-custom" rows="3" placeholder="Masukan alamat lengkap kamu...">{{ $user->alamat }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save me-2"></i> SIMPAN PERUBAHAN
                        </button>
                    </div>
                </form>

                <div class="text-center mt-5" style="border-top: 1px dashed #ddd; padding-top: 20px;">
                    <form action="{{ route('pendaki.destroy.account') }}" method="POST" id="formHapusAkun">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDeleteAccount()" style="background: #fff5f5; color: #dc3545; border: 1px solid #f8d7da; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-weight: 600; transition: 0.3s;">
                            <i class="fas fa-user-slash me-1"></i> HAPUS AKUN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Alert Sukses Update
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#414833'
        });
    @endif

    // Konfirmasi hapus akun
    function confirmDeleteAccount() {
    Swal.fire({
        title: 'Yakin mau hapus akun?',
        text: "Semua riwayat pendakian dan ulasan kamu di Puncak Pasir Ipis bakal hilang selamanya. Tindakan ini tidak bisa dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545', // Merah tanda bahaya
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus Akun Saya',
        cancelButtonText: 'Batal',
        backdrop: `rgba(220, 53, 69, 0.1)` // Kasih efek merah tipis di layar
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Sedang memproses...',
                text: 'Menghapus semua kenangan pendakian kamu...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading() }
            });
            document.getElementById('formHapusAkun').submit();
        }
    })
}
</script>
@endsection
