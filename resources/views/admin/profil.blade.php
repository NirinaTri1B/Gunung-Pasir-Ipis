@extends('layouts.admin_master')

@section('content')
<div class="container-fluid mt-4">
    <div class="mb-4">
        <h2 style="font-weight: 700; color: #2c3e50;">Pengaturan Akun Pribadi</h2>
        <p class="text-muted">Kelola informasi profil dan keamanan kata sandi akun Anda.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 8px;">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 12px; background: #ffffff;">
                <div class="card-body">
                    <div class="mb-3 d-inline-block p-2" style="background: #eef0eb; border-radius: 50%;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_user) }}&background=656D4A&color=fff&size=120"
                             alt="Avatar" class="img-fluid rounded-circle shadow-sm" style="width: 110px; height: 110px; object-fit: cover;">
                    </div>

                    <h5 class="font-weight-bold mb-1" style="color: #2d3748;">{{ Auth::user()->nama_user }}</h5>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>

                    <hr style="border-top: 1px solid #f4f6f0;">

                    <div class="text-left mt-3">
                        <div class="mb-2">
                            <small class="text-secondary d-block font-weight-bold">JABATAN SISTEM</small>
                            <span style="color: #556b2f; font-weight: 600; font-size: 14px;">
                                <i class="fas fa-user-tag mr-1" style="font-size: 12px;"></i>
                                {{ Auth::user()->jabatan ?? Auth::user()->role ?? 'Internal Staff' }}
                            </span>
                        </div>
                        <div class="mb-0">
                            <small class="text-secondary d-block font-weight-bold">TERDAFTAR SEJAK</small>
                            <span class="text-muted" style="font-size: 14px;">
                                <i class="fas fa-calendar-alt mr-1" style="font-size: 12px;"></i>
                                {{ Auth::user()->created_at ? \Carbon\Carbon::parse(Auth::user()->created_at)->format('d F Y') : '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 12px; background: #ffffff;">

                <form action="{{ route('admin.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="font-weight-bold" style="color: #4a5568;">Nama Pengguna</label>
                                <input type="text" name="nama" class="form-control" value="{{ Auth::user()->nama_user }}" required style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="font-weight-bold" style="color: #4a5568;">Alamat Email</label>
                                <input type="email" class="form-control text-muted" value="{{ Auth::user()->email }}" disabled style="border-radius: 8px; background-color: #f8f9fa;" title="Email utama tidak dapat diubah">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold" style="color: #4a5568;">Kata Sandi Sekarang <span class="text-danger">*</span></label>
                        <input type="password" name="password_sekarang" class="form-control" placeholder="Masukkan password saat ini untuk validasi" required style="border-radius: 8px;">
                        @error('password_sekarang')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="font-weight-bold" style="color: #4a5568;">Kata Sandi Baru</label>
                                <input type="password" name="password_baru" class="form-control" placeholder="Kosongkan jika tidak ingin diubah" style="border-radius: 8px;">
                                @error('password_baru')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="font-weight-bold" style="color: #4a5568;">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_baru_confirmation" class="form-control" placeholder="Ulangi kata sandi baru" style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn text-white px-4 py-2" style="background-color: #414833; border-radius: 8px; font-weight: 600;">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
