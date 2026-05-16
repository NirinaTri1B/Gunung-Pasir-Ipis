@extends('layouts.pendaki_master')

@section('page_title', 'Ulasan & Saran')

@section('content')
<style>
    /* CSS Rating Bintang */
    .rating-container { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 5px; }
    .rating-container input { display: none; }
    .rating-container label { cursor: pointer; width: 30px; height: 30px; font-size: 30px; color: #ddd; transition: 0.2s; }
    .rating-container input:checked ~ label,
    .rating-container label:hover,
    .rating-container label:hover ~ label { color: #ffca08; }

    /* Gaya Card Komentar Kotak Mandiri (Sama Seperti Sisi Admin) */
    .ulasan-card-box {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px; /* Kita samakan padding p-4 milik admin */
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        position: relative;
    }

    /* PENGAMAN BIAR KURSOR LANGSUNG BERUBAH JADI JARI TELUNJUK (POINTER) */
    .btn-pemicu-balasan {
        cursor: pointer !important;
        transition: color 0.2s;
    }

    .btn-pemicu-balasan:hover {
        color: #414833 !important; /* Warna agak gelap pas disorot biar interaktif */
    }
    .user-name { font-weight: 600; color: #414833; margin-bottom: 2px; }
    .star-yellow { color: #ffca08; font-size: 12px; }
    .star-edit:hover {
        transform: scale(1.2);
        transition: 0.2s;
    }

    /* CSS Pintar memutar panah "Lihat Balasan" saat statusnya terbuka */
    .btn-lihat-balasan[aria-expanded="true"] .arrow-balasan {
        transform: rotate(180deg);
    }

</style>

<div class="container-fluid">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <button id="btn-tambah-ulasan" class="btn-kirim" style="width: auto; padding: 10px 20px; margin: 0;">
            <i class="fas fa-plus"></i> Berikan Ulasan
        </button>

        <div class="card-rating-summary" style="background: #fff; padding: 10px 20px; border-radius: 12px; border: 1px solid #eee; display: flex; align-items: center; gap: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            <div style="text-align: right;">
                <strong style="font-size: 24px; color: #414833;">{{ $rataRata }}</strong>
                <span class="text-muted" style="font-size: 14px;">/ 5.0</span>
            </div>
            <div style="font-size: 18px;">
                @php $stars = floor($rataRata); @endphp
                @for($i=1; $i<=5; $i++)
                    <i class="fas fa-star" style="color: {{ $i <= $stars ? '#ffca08' : '#ddd' }}; opacity: {{ $i <= $stars ? '1' : '0.5' }}"></i>
                @endfor
            </div>
        </div>
    </div>

    <div id="modal-overlay-ulasan" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; justify-content: center; align-items: center; padding: 20px;">

        <div id="form-ulasan" class="card shadow-lg p-4" style="position: relative; border-radius: 16px; border: none; width: 100%; max-width: 550px; background: #fff; animation: fadeInModal 0.3s ease-in-out;">

            <button type="button" id="btn-tutup-form" style="position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 22px; color: #aaa; cursor: pointer; transition: 0.2s;">
                <i class="fas fa-times"></i>
            </button>

            <h5 class="text-center mb-2" style="color: #414833; font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 700 !important;">Berikan Ulasan</h5><br>

            <form action="{{ route('ulasan.store') }}" method="POST" style="width: 100%;">
                @csrf

                <div class="form-group mb-3">
                    <label class="fw-bold mb-2" style="color: #414833;">Rating Kamu:</label>
                    <div class="rating-container" style="display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 5px;">
                        <input type="radio" name="rating" value="5" id="star5" style="display: none;"><label for="star5" style="font-size: 30px; cursor:pointer; color: #ddd;">★</label>
                        <input type="radio" name="rating" value="4" id="star4" style="display: none;"><label for="star4" style="font-size: 30px; cursor:pointer; color: #ddd;">★</label>
                        <input type="radio" name="rating" value="3" id="star3" style="display: none;"><label for="star3" style="font-size: 30px; cursor:pointer; color: #ddd;">★</label>
                        <input type="radio" name="rating" value="2" id="star2" style="display: none;"><label for="star2" style="font-size: 30px; cursor:pointer; color: #ddd;">★</label>
                        <input type="radio" name="rating" value="1" id="star1" style="display: none;"><label for="star1" style="font-size: 30px; cursor:pointer; color: #ddd;">★</label>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="fw-bold mb-2" style="color: #414833;">Komentar:</label>
                    <textarea name="komentar" class="form-control" rows="4" placeholder="Ceritakan pengalamanmu mendaki..." required style="width: 100%; border-radius: 8px; padding: 12px 15px; border: 1px solid #ced4da;"></textarea>
                </div>

                <button type="submit" class="btn-kirim w-100" style="background-color: #414833; color: white; padding: 12px; border-radius: 8px; font-weight: bold; border: none; font-size: 15px; cursor: pointer;">
                    Kirim Ulasan
                </button>
            </form>
        </div>
    </div>

            <div class="p-0">
                @foreach($ulasan as $u)
                    <div class="ulasan-card-box">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 4px;">
                            <div class="user-name" style="font-weight: bold; color: #333D29; font-size: 15px;">
                                {{ $u->user->nama_user ?? 'Pendaki' }}
                                @if($u->user && $u->user->role == 'admin')
                                    <span class="badge badge-dark ml-1" style="font-size: 9px; padding: 3px 6px; background-color: #333 !important; color: #fff; border-radius: 4px;">Admin</span>
                                @endif
                            </div>

                            @if($u->id_user == auth()->id())
                                <div style="font-size: 12px;">
                                    <a href="javascript:void(0)" onclick="editUlasan({{ $u->id_ulasan }}, '{{ $u->komentar }}', {{ $u->rating }})" style="text-decoration:none; font-weight: 600;" style="color: #414833"><i class="fas fa-edit" style="color: #414833"></i> Edit</a>
                                    <a href="javascript:void(0)" onclick="confirmDelete({{ $u->id_ulasan }})" class="text-danger" style="text-decoration:none; font-weight: 600;"><i class="fas fa-trash"></i> Hapus</a>
                                    <form id="delete-form-{{ $u->id_ulasan }}" action="{{ route('ulasan.destroy', $u->id_ulasan) }}" method="POST" style="display: none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center mb-2" style="gap: 8px;">
                            <div style="font-size: 10px;">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fas fa-star" style="color: {{ $i <= $u->rating ? '#ffca08' : '#ddd' }}"></i>
                                @endfor
                            </div>
                            <small class="text-muted font-italic" style="font-size: 11px;">{{ $u->created_at->diffForHumans() }}</small>
                        </div>

                        <p class="text-secondary" style="font-size: 14px; margin: 0; color: #555; line-height: 1.6;">{{ $u->komentar }}</p>

                        @if($u->balasan)
                            <div class="mt-4 pt-2" style="border-top: 1px dashed #eee;">
                                <button class="btn btn-sm font-weight-bold p-0 d-flex align-items-center btn-pemicu-balasan mb-2"
                                        type="button"
                                        data-id="{{ $u->id_ulasan }}"
                                        style="color: #656D4A; font-size: 13px; gap: 6px; background: transparent; border: none; outline: none; box-shadow: none;">
                                    <i class="fas fa-comment-dots"></i>
                                    <span>Lihat Balasan</span>
                                    <i class="fas fa-chevron-down arrow-balasan-{{ $u->id_ulasan }}" style="font-size: 10px; transition: transform 0.2s;"></i>
                                </button>

                                <div id="kotakBalasan{{ $u->id_ulasan }}" class="mt-2" style="display: none;">
                                    <div class="py-3 px-4 rounded border-left shadow-sm"
                                        style="background-color: #F4F7F0; border-left: 4px solid #656D4A; border-radius: 8px !important; display: inline-block; max-width: 100%;">
                                        <div class="mb-2">
                                            <span class="font-weight-bold" style="font-size: 12px; color: #333D29;">
                                                <i class="fas fa-reply fa-flip-horizontal mr-1" style="color: #656D4A;"></i> Tanggapan Resmi
                                                <span class="badge badge-dark ml-1" style="font-size: 9px; background-color: #333 !important; color: #fff; padding: 2px 5px; border-radius: 4px; vertical-align: middle;">Admin</span> :
                                            </span>
                                        </div>
                                        <p class="mb-0 text-muted font-italic" style="font-size: 13px; line-height: 1.6; color: #555D42 !important;">
                                            "{{ $u->balasan }}"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<style>
    @keyframes fadeInModal {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
    /* Style untuk mewarnai radio button bintang saat di-hover/dipilih */
    .rating-container input:checked ~ label,
    .rating-container label:hover,
    .rating-container label:hover ~ label {
        color: #ffca08 !important;
    }
</style>
<script>
    // Cek apakah ada session success dari Controller
    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#414833',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // Cek juga kalau ada error
    @if($errors->any())
        Swal.fire({
            title: 'Aduh!',
            text: 'Pastikan rating dan komentar sudah terisi ya, Sa!',
            icon: 'error',
            confirmButtonColor: '#A94442'
        });
    @endif

    // Fungsi Hapus dengan Konfirmasi
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Ulasan kamu bakal hilang selamanya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#A94442',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }

    // Fungsi Edit pakai Pop-up
    function editUlasan(id, komentar, ratingAwal) {
        Swal.fire({
            title: 'Edit Ulasan Kamu',
            customClass: {
                popup: 'swal2-popup-sos'
            },
            html: `
                <div style="text-align: left;">
                    <label style="font-weight:600; font-size:14px; color:#555;">Rating:</label>
                    <div class="rating-edit-container" style="display: flex; gap: 5px; margin-bottom: 15px;">
                        ${[1, 2, 3, 4, 5].map(num => `
                            <i class="fas fa-star star-edit" data-value="${num}" style="cursor:pointer; font-size:25px; color: ${num <= ratingAwal ? '#ffca08' : '#ddd'}"></i>
                        `).join('')}
                    </div>
                    <input type="hidden" id="edit-rating" value="${ratingAwal}">

                    <label style="font-weight:600; font-size:14px; color:#555;">Komentar:</label>
                    <textarea id="edit-komentar" class="swal2-textarea" style="width:100%; margin: 10px 0; border-radius: 10px;">${komentar}</textarea>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Simpan Perubahan',
            confirmButtonColor: '#414833',
            cancelButtonText: 'Batal',
            didOpen: () => {
                const stars = document.querySelectorAll('.star-edit');
                const inputRating = document.getElementById('edit-rating');

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const val = this.getAttribute('data-value');
                        inputRating.value = val;

                        stars.forEach(s => {
                            s.style.color = s.getAttribute('data-value') <= val ? '#ffca08' : '#ddd';
                        });
                    });
                });
            },
            preConfirm: () => {
                return {
                    komentar: document.getElementById('edit-komentar').value,
                    rating: document.getElementById('edit-rating').value
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.action = `/pendaki/ulasan/${id}`;
                form.method = 'POST';
                form.innerHTML = `
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="komentar" value="${result.value.komentar}">
                    <input type="hidden" name="rating" value="${result.value.rating}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const btnBuka = document.getElementById('btn-tambah-ulasan');
        const btnTutup = document.getElementById('btn-tutup-form');
        const modalOverlay = document.getElementById('modal-overlay-ulasan');

        // Buka Modal (Ubah display jadi flex supaya konten pas di tengah)
        btnBuka.addEventListener('click', function() {
            modalOverlay.style.display = 'flex';
        });

        // Tutup Modal
        btnTutup.addEventListener('click', function() {
            modalOverlay.style.display = 'none';
        });

        // Klik di luar kotak form ulasan juga akan otomatis menutup modal
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) {
                modalOverlay.style.display = 'none';
            }
        });

        // Efek hover untuk tombol Close (X)
        btnTutup.addEventListener('mouseover', function() { this.style.color = '#333'; });
        btnTutup.addEventListener('mouseout', function() { this.style.color = '#aaa'; });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Kita bungkus pakai isolasi NoConflict ($) biar aman dari bentrokan template
    (function($) {
        $(document).ready(function() {
            // Kita pakai Selector Body Delegation biar biarpun halaman ke-render ulang, kliknya tetep kekunci aktif
            $(document).on('click', '.btn-pemicu-balasan', function(e) {
                e.preventDefault();

                var idUlasan = $(this).attr('data-id');
                var targetKotak = $('#kotakBalasan' + idUlasan);
                var targetPanah = $('.arrow-balasan-' + idUlasan);

                // Eksekusi meluncur naik turun secara instan dan halus
                targetKotak.slideToggle(200, function() {
                    if (targetKotak.is(':visible')) {
                        targetPanah.css('transform', 'rotate(180deg)');
                    } else {
                        targetPanah.css('transform', 'rotate(0deg)');
                    }
                });
            });
        });
    })(jQuery);
</script>
@endsection
