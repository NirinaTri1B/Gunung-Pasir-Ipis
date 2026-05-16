@extends('layouts.admin_master')

@section('page_title', 'Manajemen Master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold" style="color: #333D29;"><i class="fas fa-comments mr-2"></i> Ulasan Pendaki</h4>
    <button type="button" class="btn text-white font-weight-bold shadow-sm"
            style="background-color: #936639; border-radius: 8px;"
            data-toggle="modal" data-target="#modalTambahUlasan">
        <i class="fas fa-plus mr-2"></i> Tulis Ulasan Admin
    </button>
    @if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 8px;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</div>

<div class="d-flex flex-column" style="gap: 20px;">
    @forelse($ulasan as $ul)
        <div class="card shadow-sm border-0 p-4 position-relative" style="border-radius: 12px; background-color: #ffffff;">

            <div class="position-absolute" style="top: 20px; right: 20px; display: flex; gap: 8px;">
                @if($ul->user && $ul->user->role == 'admin')
                    <button type="button" class="btn btn-sm btn-link text-warning p-0 font-weight-bold" style="color: #656D4A !important;"
                            onclick="bukaModalEditUlasan('{{ $ul->id_ulasan }}', '{{ $ul->komentar }}', '{{ $ul->rating }}')">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </button>
                @else
                    <button type="button" class="btn btn-sm btn-link text-success p-0 font-weight-bold" style="color: #656D4A !important;"
                            onclick="bukaModalBalas('{{ $ul->id_ulasan }}', '{{ $ul->komentar }}')">
                        <i class="fas fa-reply mr-1"></i> Balas
                    </button>
                @endif

                <span class="text-muted">|</span>

                <form action="{{ route('admin.ulasan.delete', $ul->id_ulasan) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-link text-danger p-0 font-weight-bold">
                        <i class="fas fa-trash border-0"></i> Hapus
                    </button>
                </form>
            </div>

            <div class="d-flex align-items-start">
                <div class="w-100">
                    <h6 class="font-weight-bold mb-1" style="color: #333D29;">
                        {{ $ul->user->nama_user ?? 'Pendaki' }}
                        @if($ul->user && $ul->user->role == 'admin')
                            <span class="badge badge-dark ml-2" style="font-size: 10px; padding: 4px 8px; border-radius: 4px;">Admin</span>
                        @endif
                    </h6>

                    <div class="mb-2" style="color: #ffc107; font-size: 13px;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $ul->rating ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                        <span class="text-muted ml-2 font-italic" style="font-size: 11px;">{{ $ul->created_at->diffForHumans() }}</span>
                    </div>

                    <p class="mb-0 text-secondary" style="font-size: 14px; line-height: 1.6;">
                        {{ $ul->komentar }}
                    </p>
                </div>
            </div>

            @if($ul->balasan)
                <div class="mt-3">
                    <button class="btn btn-sm font-weight-bold p-0 d-flex align-items-center"
                            type="button"
                            data-toggle="collapse"
                            data-target="#collapseBalasan{{ $ul->id_ulasan }}"
                            aria-expanded="false"
                            aria-controls="collapseBalasan{{ $ul->id_ulasan }}"
                            style="color: #656D4A; font-size: 13px; gap: 6px; background: transparent; border: none; outline: none; box-shadow: none;">
                        <i class="fas fa-comment-dots"></i>
                        <span>Lihat Balasan</span>
                        <i class="fas fa-chevron-down arrow-balasan" style="font-size: 10px; transition: transform 0.2s;"></i>
                    </button>

                    <div class="collapse mt-2" id="collapseBalasan{{ $ul->id_ulasan }}">
                        <div class="p-3 rounded border-left" style="background-color: #F4F7F0; border-left: 4px solid #656D4A; margin-left: 5px;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="font-weight-bold" style="font-size: 12px; color: #333D29;">
                                    <i class="fas fa-reply fa-flip-horizontal mr-1" style="color: #656D4A;"></i> Tanggapan Pengelola Basecamp:
                                </span>
                                <button type="button" class="btn btn-sm btn-link text-muted p-0" style="font-size: 11px;"
                                        onclick="bukaModalEditBalasan('{{ $ul->id_ulasan }}', '{{ $ul->komentar }}', '{{ $ul->balasan }}')">
                                    <i class="fas fa-pencil-alt"></i> Ubah Balasan
                                </button>
                            </div>
                            <p class="mb-0 text-muted font-italic" style="font-size: 13px;">
                                "{{ $ul->balasan }}"
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    @empty
        <div class="card shadow-sm border-0 p-5 text-center" style="border-radius: 12px;">
            <p class="text-muted font-italic mb-0">Belum ada ulasan atau saran yang masuk ke sistem.</p>
        </div>
    @endforelse
</div>

<div class="modal fade" id="modalTambahUlasan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header text-white" style="background-color: #936639; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-comments mr-2"></i> Tulis Ulasan Baru Admin</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('admin.ulasan.store') }}" method="POST">
                @csrf
                <div class="modal-body bg-light">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold" style="color: #414833;">Berikan Rating Skor</label>
                        <div class="rating-container-admin" style="display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 5px;">
                            <input type="radio" name="rating" value="5" id="admin_star5" style="display: none;" required>
                            <label for="admin_star5" style="font-size: 28px; cursor:pointer; color: #ddd;">★</label>

                            <input type="radio" name="rating" value="4" id="admin_star4" style="display: none;">
                            <label for="admin_star4" style="font-size: 28px; cursor:pointer; color: #ddd;">★</label>

                            <input type="radio" name="rating" value="3" id="admin_star3" style="display: none;">
                            <label for="admin_star3" style="font-size: 28px; cursor:pointer; color: #ddd;">★</label>

                            <input type="radio" name="rating" value="2" id="admin_star2" style="display: none;">
                            <label for="admin_star2" style="font-size: 28px; cursor:pointer; color: #ddd;">★</label>

                            <input type="radio" name="rating" value="1" id="admin_star1" style="display: none;">
                            <label for="admin_star1" style="font-size: 28px; cursor:pointer; color: #ddd;">★</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Isi Komentar</label>
                        <textarea name="komentar" rows="4" class="form-control" placeholder="Tulis komentar ulasan internal di sini..." required style="border-radius: 8px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-white" style="border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn text-white font-weight-bold" style="background-color: #936639; border-radius: 8px;">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditUlasan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header text-white" style="background-color: #414833; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i> Edit Ulasan Admin</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="formEditUlasan" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body bg-light">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold" style="color: #414833;">Ubah Rating Skor</label>
                        <div class="rating-container-admin-edit" style="display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 5px;">
                            <input type="radio" name="rating" value="5" id="edit_star5" style="display: none;" required>
                            <label for="edit_star5" style="font-size: 28px; cursor:pointer; color: #ddd;">★</label>

                            <input type="radio" name="rating" value="4" id="edit_star4" style="display: none;">
                            <label for="edit_star4" style="font-size: 28px; cursor:pointer; color: #ddd;">★</label>

                            <input type="radio" name="rating" value="3" id="edit_star3" style="display: none;">
                            <label for="edit_star3" style="font-size: 28px; cursor:pointer; color: #ddd;">★</label>

                            <input type="radio" name="rating" value="2" id="edit_star2" style="display: none;">
                            <label for="edit_star2" style="font-size: 28px; cursor:pointer; color: #ddd;">★</label>

                            <input type="radio" name="rating" value="1" id="edit_star1" style="display: none;">
                            <label for="edit_star1" style="font-size: 28px; cursor:pointer; color: #ddd;">★</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Ubah Isi Komentar</label>
                        <textarea id="edit_isi" name="komentar" rows="4" class="form-control" required style="border-radius: 8px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-white" style="border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn text-white font-weight-bold" style="background-color: #414833; border-radius: 8px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBalasUlasan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header text-white" style="background-color: #414833; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-reply mr-2"></i> Respon Balasan Admin</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="formBalasUlasan" method="POST">
                @csrf
                <div class="modal-body bg-light">
                    <div class="form-group">
                        <label class="text-muted">Ulasan Pendaki:</label>
                        <blockquote id="teks_ulasan_pendaki" class="font-italic p-3 bg-white border-left border-success rounded" style="font-size: 13px; color: #555;"></blockquote>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Ketik Balasan Anda</label>
                        <textarea name="balasan" rows="4" class="form-control" placeholder="Tulis tanggapan resmi pengelola basecamp di sini..." required style="border-radius: 8px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-white" style="border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn text-white font-weight-bold" style="background-color: #656D4A; border-radius: 8px;">Kirim Balasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Fungsi Pemicu Modal Balas Ulasan Pendaki
    function bukaModalBalas(id, isiUlasan) {
        document.getElementById('teks_ulasan_pendaki').innerText = `"${isiUlasan}"`;
        document.getElementById('formBalasUlasan').action = `/admin/ulasan/reply/${id}`;

        // Kosongkan textarea kalau admin baru mau membalas ulasan pertama kali
        document.querySelector('#formBalasUlasan textarea[name="balasan"]').value = '';

        jQuery('#modalBalasUlasan').modal('show');
    }

    // Fungsi Pemicu Modal Edit Ulasan Admin Sendiri
    function bukaModalEditUlasan(id, isiUlasan, rating) {
        document.getElementById('edit_isi').value = isiUlasan;
        document.getElementById('edit_star' + rating).checked = true;
        document.getElementById('formEditUlasan').action = `/admin/ulasan/update/${id}`;
        jQuery('#modalEditUlasan').modal('show');
    }

    function bukaModalEditBalasan(id, isiUlasan, balasanLama) {
        // 1. Tampilkan kutipan ulasan asli pendaki seperti biasa
        document.getElementById('teks_ulasan_pendaki').innerText = `"${isiUlasan}"`;

        // 2. Set action form-nya menuju route reply ID tersebut
        document.getElementById('formBalasUlasan').action = `/admin/ulasan/reply/${id}`;

        // 3. NAH INI KUNCINYA! Inject balasan lama ke dalam textarea modal balas
        // Kita cari textarea di dalam #formBalasUlasan menggunakan selector name="balasan"
        document.querySelector('#formBalasUlasan textarea[name="balasan"]').value = balasanLama;

        // 4. Munculkan modalnya
        jQuery('#modalBalasUlasan').modal('show');
    }
</script>
@endsection
