@extends('layouts.admin_master')

@section('page_title', 'Kelola Konten')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-weight: 700; color: #2c3e50;">Kelola Konten Website</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <form action="{{ route('admin.konten.update') }}" method="POST">
        @csrf

        {{-- ===================== PROFIL WISATA ===================== --}}
        <div class="card mb-4" style="border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.06);">
            <div class="card-header" style="background: #414833; color: white; border-radius: 12px 12px 0 0; padding: 15px 20px;">
                <h5 class="mb-0 font-weight-bold"><i class="fas fa-mountain mr-2"></i> Profil Wisata</h5>
            </div>
            <div class="card-body p-4">
                @foreach($konten->get('profil', collect()) as $item)
                <div class="form-group">
                    <label class="font-weight-bold" style="color: #414833;">{{ $item->label }}</label>
                    <textarea name="konten[{{ $item->key }}]"
                              class="form-control"
                              rows="4"
                              style="border-radius: 8px; border: 1px solid #ccc; resize: vertical;">{{ $item->value }}</textarea>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ===================== WAKTU OPERASIONAL ===================== --}}
        <div class="card mb-4" style="border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.06);">
            <div class="card-header" style="background: #656D4A; color: white; border-radius: 12px 12px 0 0; padding: 15px 20px;">
                <h5 class="mb-0 font-weight-bold"><i class="fas fa-clock mr-2"></i> Waktu Operasional</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    @foreach($konten->get('operasional', collect()) as $item)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold" style="color: #414833;">{{ $item->label }}</label>
                            <input type="text"
                                   name="konten[{{ $item->key }}]"
                                   class="form-control"
                                   value="{{ $item->value }}"
                                   style="border-radius: 8px; border: 1px solid #ccc;">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ===================== HARGA TIKET ===================== --}}
        <div class="card mb-4" style="border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.06);">
            <div class="card-header" style="background: #936639; color: white; border-radius: 12px 12px 0 0; padding: 15px 20px;">
                <h5 class="mb-0 font-weight-bold"><i class="fas fa-ticket-alt mr-2"></i> Harga Tiket & Denda</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    @foreach($konten->get('tiket', collect()) as $item)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold" style="color: #414833;">{{ $item->label }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="border-radius: 8px 0 0 8px; background: #f0f4e8; border-color: #ccc;">Rp</span>
                                </div>
                                <input type="number"
                                       name="konten[{{ $item->key }}]"
                                       class="form-control"
                                       value="{{ $item->value }}"
                                       style="border-radius: 0 8px 8px 0; border-color: #ccc;">
                            </div>
                            <small class="text-muted">Contoh: 15000 (tanpa titik/koma)</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ===================== INFORMASI PENDAKI ===================== --}}
        <div class="card mb-4" style="border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.06);">
            <div class="card-header" style="background: #2c6fad; color: white; border-radius: 12px 12px 0 0; padding: 15px 20px;">
                <h5 class="mb-0 font-weight-bold"><i class="fas fa-info-circle mr-2"></i> Informasi untuk Pendaki</h5>
            </div>
            <div class="card-body p-4">
                @foreach($konten->get('informasi', collect()) as $item)
                <div class="form-group">
                    <label class="font-weight-bold" style="color: #414833;">{{ $item->label }}</label>
                    <textarea name="konten[{{ $item->key }}]"
                              class="form-control"
                              rows="3"
                              style="border-radius: 8px; border: 1px solid #ccc; resize: vertical;">{{ $item->value }}</textarea>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TOMBOL SIMPAN --}}
        <div class="d-flex justify-content-end mb-5">
            <button type="submit"
                    class="btn text-white px-5 py-2"
                    style="background: #414833; border-radius: 10px; font-weight: 700; font-size: 15px;">
                <i class="fas fa-save mr-2"></i> Simpan Semua Perubahan
            </button>
        </div>

    </form>
</div>
@endsection
