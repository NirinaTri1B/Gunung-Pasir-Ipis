@extends('layouts.dbpendaki_master')

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

    /* Gaya Card Komentar ala Shopee */
    .ulasan-item { border-bottom: 1px solid #eee; padding: 15px 0; }
    .ulasan-item:last-child { border-bottom: none; }
    .user-name { font-weight: 600; color: #414833; margin-bottom: 2px; }
    .star-yellow { color: #ffca08; font-size: 12px; }
    .comment-text { font-size: 14px; color: #555; margin-top: 5px; }
    .comment-date { font-size: 11px; color: #999; }
    .star-edit:hover {
    transform: scale(1.2);
    transition: 0.2s;
}
</style>

<div class="container-fluid">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <button id="btn-tambah-ulasan" class="btn-kirim" style="width: auto; padding: 10px 20px; margin: 0;">
            <i class="fas fa-plus"></i> Berikan Ulasan
        </button>

        <div class="card-rating-summary" style="background: #fff; padding: 10px 20px; border-radius: 12px; border: 1px solid #eee; display: flex; align-items: center; gap: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            <div style="text-align: right;">
                <small class="text-muted d-block" style="font-size: 11px; margin-bottom: -5px;"></small>
                <strong style="font-size: 24px; color: #414833;">{{ $rataRata }}</strong>
                <span class="text-muted" style="font-size: 14px;">/ 5.0</span>
            </div>
            <div style="font-size: 18px;">
                @php $stars = floor($rataRata); @endphp
                @for($i=1; $i<=5; $i++)
                    {{-- Di sini kita pakai style color langsung kalau mau aman --}}
                    <i class="fas fa-star"
                    style="color: {{ $i <= $stars ? '#ffca08' : '#ddd' }}; opacity: {{ $i <= $stars ? '1' : '0.5' }}"></i>
                @endfor
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div id="form-ulasan" class="card" style="display: none; position: relative;">
                <button type="button" id="btn-tutup-form" style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 20px; color: #999; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>

                <h4 class="mb-4 text-center fw-bold" style="color: #414833;">Berikan Ulasan</h4><br>

                <form action="{{ route('ulasan.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="fw-bold mb-1">Rating Kamu:</label>
                        <div class="rating-container" style="display: flex; flex-direction: row-reverse; justify-content: flex-end;">
                            <input type="radio" name="rating" value="5" id="star5"><label for="star5" style="font-size: 25px; cursor:pointer;">★</label>
                            <input type="radio" name="rating" value="4" id="star4"><label for="star4" style="font-size: 25px; cursor:pointer;">★</label>
                            <input type="radio" name="rating" value="3" id="star3"><label for="star3" style="font-size: 25px; cursor:pointer;">★</label>
                            <input type="radio" name="rating" value="2" id="star2"><label for="star2" style="font-size: 25px; cursor:pointer;">★</label>
                            <input type="radio" name="rating" value="1" id="star1"><label for="star1" style="font-size: 25px; cursor:pointer;">★</label>
                        </div>
                    </div><br>
                    <div class="form-group mb-3">
                        <label class="fw-bold mb-1">Komentar:</label><br>
                        <textarea name="komentar" class="form-control" rows="4" placeholder="Ceritakan pengalamanmu..." required></textarea>
                    </div>
                    <button type="submit" class="btn-kirim w-100">Kirim Ulasan</button>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card" style="max-height: 600px; overflow-y: auto;">
                <h4 class="mb-3">Ulasan Pendaki ({{ $ulasan->count() }})</h4>
                <hr>
                @foreach($ulasan as $u)
                    <div class="ulasan-item mb-3">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <div class="user-name" style="font-weight: bold;">{{ $u->user->nama_user ?? 'Pendaki' }}</div>
                            @if($u->id_user == auth()->id())
                                <div style="font-size: 12px;">
                                    <a href="javascript:void(0)" onclick="editUlasan({{ $u->id_ulasan }}, '{{ $u->komentar }}', {{ $u->rating }})" class="text-primary me-2"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0)" onclick="confirmDelete({{ $u->id_ulasan }})" class="text-danger"><i class="fas fa-trash"></i> Hapus</a>
                                    <form id="delete-form-{{ $u->id_ulasan }}" action="{{ route('ulasan.destroy', $u->id_ulasan) }}" method="POST" style="display: none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex align-items-center mb-1" style="gap: 8px;">
                            {{-- Hapus style color kuning dari div pembungkusnya --}}
                            <div style="font-size: 10px;">
                                @for($i=1; $i<=5; $i++)
                                    {{-- Gunakan class star-yellow untuk yang aktif, dan text-muted untuk yang mati --}}
                                    <i class="fas fa-star {{ $i <= $u->rating ? 'star-yellow' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                            <small class="text-muted italic">{{ $u->created_at->diffForHumans() }}</small>
                        </div>
                        <p style="font-size: 14px; margin: 0;">{{ $u->komentar }}</p>
                        <hr>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    // Cek apakah ada session success dari Controller
    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#414833',
            timer: 3000, // Hilang sendiri dalam 3 detik
            showConfirmButton: false
        });
    @endif

    // Cek juga kalau ada error (misal rating lupa diisi)
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
            popup: 'swal2-popup-sos' // Biar radiusnya sama kayak pop-up SOS kemarin
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
            // Logika ganti bintang di dalam pop-up
            const stars = document.querySelectorAll('.star-edit');
            const inputRating = document.getElementById('edit-rating');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const val = this.getAttribute('data-value');
                    inputRating.value = val;

                    // Update warna bintang secara visual
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
    const formBox = document.getElementById('form-ulasan');

    // Klik tombol +Berikan Ulasan
    btnBuka.addEventListener('click', function() {
        formBox.style.display = 'block';
        btnBuka.style.display = 'none';
    });

    // Klik tanda X
    btnTutup.addEventListener('click', function() {
        formBox.style.display = 'none';
        btnBuka.style.display = 'block';
    });
});
</script>
@endsection
