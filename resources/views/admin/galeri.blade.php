@extends('layouts.admin_master')

{{-- @section('page_title', 'Manajemen Master') --}}

@section('content')

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="font-weight: 700; color: #2c3e50;">Kelola Galeri Wisata</h2>
        <button type="button" class="btn btn-sm text-white px-3 py-2" style="background-color: #414833; border-radius: 8px; font-weight: 600;" onclick="bukaModalTambah()">
            <i class="fas fa-plus mr-1"></i> Tambah Foto
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
    @endif

    @if($galeri->isEmpty())
        <div class="card text-center p-5 shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body">
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-0">Belum ada data foto galeri. Silakan tambah foto baru.</p>
            </div>
        </div>
    @else
        <div class="gallery-grid">
            @foreach($galeri as $g)
                <div class="gallery-card">
                    <form action="{{ route('admin.galeri.destroy', $g->id_galeri) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini?')" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-gallery-btn" title="Hapus Foto">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>

                    <div class="gallery-img-wrapper">
                        <img src="{{ asset('storage/galeri/' . $g->foto) }}" alt="{{ $g->judul }}">
                    </div>

                    <div class="gallery-info">
                        <div class="gallery-title" title="{{ $g->judul }}">{{ $g->judul }}</div>
                        <div class="gallery-badge">
                            <i class="fas fa-tag mr-1" style="font-size: 10px;"></i>{{ $g->kategori }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="modal fade" id="modalTambahGaleri" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 14px; border: none;">
            <div class="modal-header" style="background: #f8f9fa; border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title" style="font-weight: 700; color: #333;">Tambah Foto Galeri Baru</h5>
                <button type="button" class="close" onclick="tutupModalTambah()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold" style="color: #4a5568;">Judul Foto</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Sunrise Puncak Pasir Ipis" required style="border-radius: 8px;">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold" style="color: #4a5568;">Kategori Kluster</label>
                        <select name="kategori" class="form-control" required style="border-radius: 8px;">
                            <option value="">-- Pilih Kelompok Tampilan --</option>
                            <option value="Puncak">Puncak Gunung</option>
                            <option value="Jalur Pendakian">Medan / Jalur Pendakian</option>
                            <option value="Fasilitas">Fasilitas Area Camping & Pos</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label font-weight-bold" style="color: #4a5568;">File Gambar</label>
                        <input type="file" name="foto" class="form-control-file" accept="image/*" required>
                        <small class="form-text text-muted mt-1">Format: JPG, JPEG, PNG. Maksimal ukuran 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8f9fa; border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                    <button type="button" class="btn btn-light px-4" onclick="tutupModalTambah()" style="border-radius: 8px; font-weight: 600;">Batal</button>
                    <button type="submit" class="btn text-white px-4" style="background-color: #414833; border-radius: 8px; font-weight: 600;">Unggah Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function bukaModalTambah() {
        // Solusi jika bootstrap modal bawaan macet, kita paksa pakai jQuery trigger bawaan admin layout
        $('#modalTambahGaleri').modal('show');
    }

    function tutupModalTambah() {
        $('#modalTambahGaleri').modal('hide');
    }
</script>
@endsection
