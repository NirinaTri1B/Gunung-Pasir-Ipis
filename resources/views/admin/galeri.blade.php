@extends('layouts.admin_master')

{{-- @section('page_title', 'Manajemen Master') --}}

@section('content')

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="font-weight: 700; color: #2c3e50;">
        Kelola Galeri Wisata
        </h2>

        <div style="display:flex; gap:10px;">

            {{-- Tombol Recycle --}}
            <button type="button"
                    class="btn btn-warning"
                    onclick="$('#modalRecycle').modal('show')">

                <i class="fas fa-trash-restore"></i>
                Recycle Bin
            </button>

            {{-- Tombol Tambah --}}
            <button type="button"
                    class="btn text-white px-3 py-2"
                    style="background-color: #414833; border-radius: 8px; font-weight: 600;"
                    onclick="bukaModalTambah()">

                <i class="fas fa-plus mr-1"></i>
                Tambah Foto
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
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
            @foreach($galeri->filter(fn($item) => !$item->trashed()) as $g)

            <div class="gallery-card">

                {{-- Tombol Hapus --}}
                <form action="{{ route('admin.galeri.destroy', $g->id_galeri) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus foto ini?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="delete-gallery-btn"
                            title="Hapus Foto">

                        <i class="fas fa-trash"></i>
                    </button>
                </form>

                <div class="gallery-img-wrapper">
                    <img src="{{ asset('storage/galeri/' . $g->foto) }}"
                        class="gallery-img preview-image"
                        data-index="{{ $loop->index }}">
                </div>

                <div class="gallery-info">

                    <div class="gallery-title">
                        {{ $g->judul }}
                    </div>

                    <div class="gallery-badge">
                        {{ $g->kategori }}
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
<div class="modal fade" id="modalRecycle" tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-warning text-dark">

                <h5 class="modal-title">
                    <i class="fas fa-trash-restore"></i>
                    Recycle Bin Galeri
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>
                </button>

            </div>

            <div class="modal-body">
                @php
                    $deletedGaleri = $galeri->filter(function($item){
                        return $item->trashed();
                    });
                @endphp

                {{-- TOMBOL AKSI --}}
                @if($deletedGaleri->count() > 0)

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <span class="badge badge-warning p-2">
                            Total: {{ $deletedGaleri->count() }} Foto
                        </span>
                    </div>

                    <div class="d-flex gap-2">

                        {{-- Pulihkan Semua --}}
                        <form action="{{ route('admin.galeri.restore_all') }}"
                            method="POST"
                            onsubmit="return confirm('Pulihkan semua foto?')">

                            @csrf

                            <button type="submit" class="btn btn-success" style="margin-right: 15px;">
                                <i class="fas fa-trash-restore"></i>
                                Pulihkan Semua
                            </button>
                        </form>

                        {{-- Hapus Permanen Semua --}}
                        <form action="{{ route('admin.galeri.force_delete_all') }}"
                            method="POST"
                            onsubmit="return confirm('Hapus permanen semua foto?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger">

                                <i class="fas fa-trash"></i>
                                Hapus Semua
                            </button>
                        </form>

                    </div>

                </div>

                @endif

                <div class="row">

                    @php
                        $deletedGaleri = $galeri->filter(function($item){
                            return $item->trashed();
                        });
                    @endphp

                    @forelse($deletedGaleri as $g)

                    <div class="col-md-4 mb-4">

                        <div class="card shadow-sm border-0">

                            <img src="{{ asset('storage/galeri/' . $g->foto) }}"
                                style="height:220px; object-fit:cover;">

                            <div class="card-body">

                                <h6 class="font-weight-bold">
                                    {{ $g->judul }}
                                </h6>

                                <span class="badge badge-secondary">
                                    {{ $g->kategori }}
                                </span>

                                <div class="mt-3 d-flex gap-2">

                                    {{-- Restore --}}
                                    <form action="{{ route('admin.galeri.restore', $g->id_galeri) }}"
                                        method="POST">

                                        @csrf

                                        <button type="submit"class="btn btn-success btn-sm" style="margin-right: 15px;">
                                            <i class="fas fa-undo"></i>
                                            Pulihkan
                                        </button>
                                    </form>

                                    {{-- Hapus Permanen --}}
                                    <form action="{{ route('admin.galeri.force_delete', $g->id_galeri) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus permanen foto ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">

                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                    @empty

                    <div class="col-12 text-center text-muted py-5">

                        <i class="fas fa-trash fa-3x mb-3"></i>

                        <p>Tidak ada foto di recycle bin.</p>

                    </div>

                    @endforelse

                </div>

            </div>

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
{{-- MODAL PREVIEW GALERI --}}
<div id="imageModal" class="custom-image-modal">

    <span class="close-modal">&times;</span>

    {{-- Tombol kiri --}}
    <a class="prev-btn">&#10094;</a>

    {{-- Gambar --}}
    <img class="modal-content-img" id="modalImage">

    {{-- Tombol kanan --}}
    <a class="next-btn">&#10095;</a>

</div>
<script>

    const images = document.querySelectorAll('.preview-image');

    const modal = document.getElementById('imageModal');

    const modalImg = document.getElementById('modalImage');

    const closeBtn = document.querySelector('.close-modal');

    const prevBtn = document.querySelector('.prev-btn');

    const nextBtn = document.querySelector('.next-btn');

    let currentIndex = 0;

    // buka modal
    images.forEach((img, index) => {

        img.addEventListener('click', function(){

            modal.style.display = 'block';

            modalImg.src = this.src;

            currentIndex = index;

        });

    });

    // tombol close
    closeBtn.onclick = function(){

        modal.style.display = 'none';

    }

    // next image
    nextBtn.onclick = function(){

        currentIndex++;

        if(currentIndex >= images.length){
            currentIndex = 0;
        }

        modalImg.src = images[currentIndex].src;

    }

    // prev image
    prevBtn.onclick = function(){

        currentIndex--;

        if(currentIndex < 0){
            currentIndex = images.length - 1;
        }

        modalImg.src = images[currentIndex].src;

    }

    // klik luar modal
    modal.onclick = function(e){

        if(e.target === modal){
            modal.style.display = 'none';
        }

    }

</script>
@endsection
