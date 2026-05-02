@extends('layouts.karyawan_master')

@section('page_title', 'Registrasi Pendaki')

@section('content')
<div class="container-fluid" style="padding: 20px;">
    <!-- 1. STATISTIK -->
    <div style="display: flex; gap: 20px; margin-bottom: 25px;">
        <div style="flex: 1; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-left: 6px solid #414833; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <small style="color: #888; font-weight: 500; text-transform: uppercase; font-size: 11px;">Status Pendaki Aktif</small>
                <h3 style="margin: 0; color: #414833; font-size: 24px; font-weight: 700;">{{ $totalAktif ?? 0 }} Orang</h3>
            </div>
            <i class="fas fa-hiking" style="font-size: 35px; color: #A4AC86; opacity: 0.5;"></i>
        </div>
        <div style="flex: 1; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-left: 6px solid #656D4A; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <small style="color: #888; font-weight: 500; text-transform: uppercase; font-size: 11px;">Notifikasi Baru</small>
                <h3 style="margin: 0; color: #656D4A; font-size: 24px; font-weight: 700;">{{ $totalNotif ?? 0 }} Notif</h3>
            </div>
            <i class="fas fa-bell" style="font-size: 35px; color: #A4AC86; opacity: 0.5;"></i>
        </div>
    </div>

    <!-- 2. SEARCH -->
    <div class="card" style="margin-bottom: 25px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-radius: 12px;">
        <div class="card-body" style="padding: 20px;">
            <form action="{{ route('karyawan.db') }}" method="GET" style="display: flex; gap: 15px;">
                <div style="flex: 1; max-width: 500px; position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 15px; top: 15px; color: #aaa;"></i>
                    <input type="text" id="searchInput" name="search" class="form-control" placeholder="Cari Nama, Telepon, dll..." value="{{ request('search') }}" style="border-radius: 10px; padding: 12px 12px 12px 45px; border: 1px solid #ddd; width: 100%;">
                </div>
                <button type="submit" class="btn" style="background: #414833; color: white; border-radius: 10px; padding: 0 35px; font-weight: 600;">Cari Data</button>
            </form>
        </div>
    </div>

    <!-- 3. TABEL -->
    <div class="card" style="border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-radius: 15px; overflow: hidden;">
        <!-- Kasih batas tinggi (max-height) dan scroll otomatis (overflow-y: auto) -->
        <div class="table-responsive" style="max-height: 55vh; overflow-y: auto;">

            <table class="table" style="width: 100%; border-collapse: collapse; background: white; table-layout: fixed;">

                <!-- Bikin thead diam di atas (position: sticky; top: 0; z-index: 10;) -->
                <thead style="background: #fdfdfd; position: sticky; top: 0; z-index: 10; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    <tr style="color: #414833; font-size: 13px;">
                        <th style="padding: 20px; text-align: left; width: 18%;">NAMA</th>
                        <th style="padding: 20px; text-align: left; width: 15%;">TELEPON</th>
                        <th style="padding: 20px; text-align: left; width: 22%;">ALAMAT</th>
                        <th style="padding: 20px; text-align: center; width: 15%;">PROSES REGISTRASI</th>
                        <th style="padding: 20px; text-align: center; width: 15%;">VALIDASI SAMPAH</th>
                        <th style="padding: 20px; text-align: center; width: 15%;">STATUS</th>
                    </tr>
                </thead>
                <tbody id="tabel-pendaki">
                    @forelse($pendakis as $p)
                        @php
                            $registrasiAktif = $p->registrasi->where('status_pendakian', 'aktif')->first();
                            $sedangMendaki = !empty($registrasiAktif);
                        @endphp
                        <tr style="border-bottom: 1px solid #f9f9f9;">
                            <td style="padding: 20px; font-weight: 600;">{{ $p->nama_user }}</td>
                            <td style="padding: 20px;">{{ $p->no_telp ?? '-' }}</td>
                            <td style="padding: 20px;">{{ $p->alamat ?? '-' }}</td>
                            <td style="padding: 20px; text-align: center;">
                            {{-- 1. Cek dulu apakah dia sedang mendaki atau tidak --}}
                                @if($sedangMendaki)
                                    {{-- Jika sedang mendaki, tombol dimatikan (Disabled) --}}
                                    <button disabled style="background-color: #ccc; color: #666; border: none; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 12px; cursor: not-allowed; opacity: 0.7;">
                                        REGISTRASI
                                    </button>

                                @elseif(empty($p->no_telp) || empty($p->alamat))
                                    {{-- 2. Jika tidak mendaki tapi data belum lengkap --}}
                                    <button style="background-color: #ffb703; color: #fff; border: none; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 12px; cursor: pointer;"
                                            onclick="Swal.fire('Data Belum Lengkap!', 'Minta pendaki {{ $p->nama_user }} melengkapi profil dulu.', 'warning')">
                                        PROFIL KOSONG
                                    </button>

                                @else
                                    {{-- 3. Jika data lengkap dan tidak sedang mendaki, baru boleh Registrasi --}}
                                    <button class="btn-regis" style="background-color: #656D4A; color: #fff; border: none; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 12px; cursor: pointer;"
                                            data-id="{{ $p->id_user }}"
                                            data-nama="{{ $p->nama_user }}">
                                        REGISTRASI
                                    </button>
                                @endif
                            </td>
                            <td style="padding: 20px; text-align: center;">
                                <button class="btn-action btn-validasi" data-id="{{ $p->id_user }}" data-nama="{{ $p->nama_user }}"
                                    data-sampah-awal="{{ $sedangMendaki ? $registrasiAktif->jumlah_sampah : 0 }}"
                                    data-sampah-akhir="{{ $sedangMendaki ? $registrasiAktif->jumlah_sampah_akhir : 0 }}"
                                    data-status-lama="{{ $sedangMendaki ? $registrasiAktif->status_sampah : 'proses' }}"
                                    data-desc-lama="{{ $sedangMendaki ? $registrasiAktif->deskripsi : '' }}"
                                    {{ !$sedangMendaki ? 'disabled' : '' }} style="background: #414833; color: white;">VALIDASI</button>
                            </td>
                            <td style="padding: 20px; text-align: center;">
                                @if($sedangMendaki)
                                    <span style="background: #f0f4e8; color: #414833; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;">Sedang mendaki</span>
                                @else
                                    <span style="background: #fff0f0; color: #a94442; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;">Tidak mendaki</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align: center; padding: 40px; color: #888;">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- 4. PAGINATION (Tombol Halaman) -->
    <div id="pagination-container" style="margin-top: 20px;">
        {{ $pendakis->links('pagination::bootstrap-4') }}
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    const body = $('body');

    // ==========================================
    // 4. POP-UP REGISTRASI
    // ==========================================
    body.on('click', '.btn-regis', function() {
        let userId = $(this).data('id');
        let namaUser = $(this).data('nama');

        Swal.fire({
            title: `<div style="padding-top:20px; font-weight:800; color:#333D29;">Form Registrasi: ${namaUser}</div>`,
            width: '850px', showConfirmButton: false,
            customClass: { popup: 'puncak-pasir-ipis-modal' },
            html: `
                <div class="reg-container">
                    <div class="reg-left">
                        <div class="reg-title">DATA PERJALANAN</div>
                        <label class="reg-label">Jenis Pendakian</label>
                        <div class="pill-group">
                            <label class="pill-item"><input type="radio" name="jenis" value="tektok" class="calc-trigger"> <span>Tektok</span></label>
                            <label class="pill-item"><input type="radio" name="jenis" value="camping" class="calc-trigger" checked> <span>Camping</span></label>
                        </div>

                        <!-- BUNGKUS LAMA MENGINAP DENGAN ID -->
                        <div id="div-lama-menginap">
                            <label class="reg-label">Lama Menginap (Hari)</label>
                            <input type="number" id="hari" class="reg-input calc-trigger" value="1" min="1">
                        </div>

                        <label class="reg-label">Jumlah Pendaki</label><input type="number" id="jumlah" class="reg-input calc-trigger" value="1" min="1">

                        <div class="reg-title" style="margin-top:30px;">LINGKUNGAN</div>
                        <label class="reg-label">Jumlah Barang Bawaan (Sampah)</label><input type="number" id="sampah" class="reg-input" value="1" min="1">
                    </div>
                    <div class="reg-right">
                        <div class="reg-title">RINCIAN TIKET</div>
                        <label class="reg-label">Harga per Orang</label><input type="text" id="harga_satuan" class="reg-readonly" value="Rp 30.000" readonly>
                        <label class="reg-label">Total Pembayaran</label>
                        <div class="price-tag-box"><input type="text" id="total_harga_display" class="price-val" style="border:none; background:transparent; width:100%; text-align:center;" value="Rp 30.000" readonly></div>
                        <div class="reg-title" style="margin-top:30px;">PEMBAYARAN</div>
                        <div style="display:flex; gap:20px; font-weight:700; color:#333D29; font-size:14px; margin-top:10px;">
                            <label style="cursor:pointer;"><input type="radio" name="pay" value="Cash"> Cash</label>
                            <label style="cursor:pointer;"><input type="radio" name="pay" value="Qris" checked> Qris</label>
                        </div>
                    </div>
                </div>
                <div class="reg-footer">
                    <button id="btn-submit-reg-final" class="btn-reg-submit">REGISTRASI</button>
                    <button onclick="Swal.close()" class="btn-reg-cancel">CANCEL</button>
                </div>
            `,
            didOpen: () => {
                const calculate = () => {
                    const jenis = document.querySelector('input[name="jenis"]:checked').value;
                    const divHari = document.getElementById('div-lama-menginap');
                    const inputHari = document.getElementById('hari');

                    // LOGIKA SEMBUNYI & MUNCUL LAMA MENGINAP
                    if (jenis === 'tektok') {
                        divHari.style.display = 'none'; // Sembunyikan form
                        inputHari.value = 0; // Tektok = 0 hari menginap
                    } else {
                        divHari.style.display = 'block'; // Munculkan form
                        if (inputHari.value == 0) inputHari.value = 1; // Kembalikan minimal 1 hari jika camping
                    }

                    const jumlah = parseInt(document.getElementById('jumlah').value) || 0;
                    const harga = (jenis === 'tektok' ? 15000 : 30000);
                    const total = harga * jumlah;

                    document.getElementById('harga_satuan').value = "Rp " + harga.toLocaleString('id-ID');
                    document.getElementById('total_harga_display').value = "Rp " + total.toLocaleString('id-ID');
                };

                document.querySelectorAll('.calc-trigger').forEach(i => {
                    i.addEventListener('change', calculate);
                    i.addEventListener('input', calculate);
                    i.addEventListener('keyup', calculate);
                });
                calculate();

                document.getElementById('btn-submit-reg-final').addEventListener('click', () => {
                    let totalMurni = document.getElementById('total_harga_display').value.replace(/[^0-9]/g, '');
                    let radioMetode = document.querySelector('input[name="pay"]:checked');
                    let metodePilihan = radioMetode ? radioMetode.value : 'Cash';

                    fetch("{{ route('karyawan.registrasi_proses') }}", {
                        method: "POST", headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({
                            id_user: userId,
                            jenis: document.querySelector('input[name="jenis"]:checked').value,
                            hari: document.getElementById('hari').value,
                            jumlah: document.getElementById('jumlah').value,
                            sampah: document.getElementById('sampah').value,
                            total: totalMurni,
                            pay: metodePilihan,
                            metode_pembayaran: metodePilihan,
                            pembayaran: metodePilihan
                        })
                    }).then(res => res.json()).then(res => {
                        if(res.success) {
                            Swal.fire('Berhasil!', 'Pendaki resmi terdaftar.', 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Gagal!', res.message || 'Terjadi kesalahan sistem.', 'error');
                        }
                    }).catch(err => {
                        Swal.fire('Error 500', 'Gagal memproses data ke server.', 'error');
                    });
                });
            }
        });
    });

    // ==========================================
    // 5. POP-UP VALIDASI (Update Fitur Bayar Denda)
    // ==========================================
    body.on('click', '.btn-validasi', function() {
        let userId = $(this).data('id'); let namaUser = $(this).data('nama');
        let sampahAwalData = parseInt($(this).data('sampah-awal'));
        let sampahAkhirLama = parseInt($(this).data('sampah-akhir')) || 0;
        let statusLama = $(this).data('status-lama') || 'proses';
        let descLama = $(this).data('desc-lama') || '';

        Swal.fire({
            title: `Validasi Sampah: ${namaUser}`, width: '850px', showConfirmButton: false,
            customClass: { popup: 'puncak-pasir-ipis-modal' },
            html: `
                <div class="modal-grid-validasi">
                    <button onclick="Swal.close()" class="close-btn-top">✖</button>
                    <div class="col-left">
                        <label class="form-label-custom">Sampah Awal</label><input type="text" class="form-input-readonly" value="${sampahAwalData}" readonly>
                        <label class="form-label-custom">Sampah Akhir</label><input type="number" id="akhir_v" class="reg-input" value="${sampahAkhirLama > 0 ? sampahAkhirLama : sampahAwalData}">
                        <button id="btn-hit-v" class="btn-reg-submit" style="width:100%; margin-top:15px;">CEK KESESUAIAN</button>

                        <div id="opsi-pelanggaran" style="display:none; margin-top:15px; padding:15px; border:1px dashed red; background:#fff5f5; border-radius:10px;">
                            <label style="color:red; font-weight:bold; font-size:12px;">Solusi:</label>
                            <select id="pilihan_solusi" class="reg-input">
                                <option value="ambil_kembali">Ambil Kembali</option>
                                <option value="denda">Bayar Denda</option>
                            </select>

                            <!-- TAMBAHAN: Pilihan Cash/Qris Khusus Denda -->
                            <div id="opsi-bayar-denda" style="display:none; margin-top:15px;">
                                <label style="color:#333D29; font-weight:bold; font-size:12px;">Metode Pembayaran Denda:</label>
                                <div style="display:flex; gap:15px; font-size:13px; margin-top:5px;">
                                    <label><input type="radio" name="pay_denda" value="Cash" checked> Cash</label>
                                    <label><input type="radio" name="pay_denda" value="Qris"> Qris</label>
                                </div>
                            </div>

                            <div id="info-denda" style="font-weight:bold; color:red; margin-top:10px;"></div>
                            <button id="btn-save-pelanggaran" class="btn-reg-cancel" style="width:100%; margin-top:10px;">SIMPAN RIWAYAT</button>
                        </div>
                    </div>
                    <div class="col-right">
                        <label class="form-label-custom">Status Akhir</label><input type="text" id="hasil_v" class="form-input-readonly status-display" value="Belum divalidasi" readonly>
                        <label class="reg-label">Deskripsi</label><textarea id="desc_v" class="reg-input" style="height:100px;">${descLama}</textarea>
                        <button id="btn-done-v" class="btn-reg-submit" style="width:100%; margin-top:20px; background:#414833;">SIMPAN & SELESAI</button>
                    </div>
                </div>
            `,
            didOpen: () => {
                const btnHit = document.getElementById('btn-hit-v');
                const hasilV = document.getElementById('hasil_v');
                const divOpsi = document.getElementById('opsi-pelanggaran');
                const selectSolusi = document.getElementById('pilihan_solusi');
                const opsiBayarDenda = document.getElementById('opsi-bayar-denda');
                const infoDenda = document.getElementById('info-denda');

                // Tampilan awal
                if (statusLama !== 'proses' && statusLama !== 'sesuai') {
                    divOpsi.style.display = 'block';
                    selectSolusi.value = statusLama;
                    hasilV.value = "Tidak Sesuai";
                    hasilV.style.color = "red";
                    if (statusLama === 'denda') opsiBayarDenda.style.display = 'block';
                } else if (statusLama === 'sesuai') {
                    hasilV.value = "Sesuai"; hasilV.style.color = "green";
                }

                // Efek milih solusi denda -> munculin pilihan Cash/Qris
                selectSolusi.addEventListener('change', function() {
                    if (this.value === 'denda') {
                        opsiBayarDenda.style.display = 'block';
                    } else {
                        opsiBayarDenda.style.display = 'none';
                    }
                });

                btnHit.addEventListener('click', () => {
                    let akhir = parseInt(document.getElementById('akhir_v').value) || 0;
                    if (akhir >= sampahAwalData) {
                        hasilV.value = "Sesuai"; hasilV.style.color = "green"; divOpsi.style.display = 'none';
                    } else {
                        hasilV.value = "Tidak Sesuai"; hasilV.style.color = "red"; divOpsi.style.display = 'block';
                        infoDenda.innerText = `Denda: Rp ${(sampahAwalData - akhir) * 50000}`;
                        if (selectSolusi.value === 'denda') opsiBayarDenda.style.display = 'block';
                    }
                });

                document.getElementById('btn-save-pelanggaran').addEventListener('click', () => {
                    fetch(`/karyawan/validasi-proses/${userId}`, {
                        method: "POST", headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({ akhir: document.getElementById('akhir_v').value, status_sampah: selectSolusi.value, simpan_sementara: true, deskripsi: document.getElementById('desc_v').value })
                    }).then(res => res.json()).then(res => { if(res.success) Swal.fire('Tersimpan', 'Riwayat pelanggaran dicatat.', 'info').then(() => location.reload()); });
                });

                document.getElementById('btn-done-v').addEventListener('click', () => {
                    let akhir = parseInt(document.getElementById('akhir_v').value) || 0;
                    let finalStatus = (akhir >= sampahAwalData) ? 'sesuai' : 'denda';

                    if (akhir < sampahAwalData && selectSolusi.value === 'ambil_kembali') {
                        return Swal.fire('Gagal', 'Selesaikan sampah atau pilih denda!', 'error');
                    }

                    // Ambil metode bayar denda (kalau ada)
                    let radioDenda = document.querySelector('input[name="pay_denda"]:checked');
                    let metodeDendaPilihan = radioDenda ? radioDenda.value : 'Cash';

                    fetch(`/karyawan/validasi-proses/${userId}`, {
                        method: "POST", headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({
                            akhir: akhir,
                            status_sampah: finalStatus,
                            denda: (akhir < sampahAwalData) ? (sampahAwalData - akhir) * 50000 : 0,
                            deskripsi: document.getElementById('desc_v').value,
                            status_pendakian: 'tidak aktif',
                            selesai: true,
                            metode_pembayaran_denda: metodeDendaPilihan // <-- NGIRIM KE CONTROLLER
                        })
                    }).then(res => res.json()).then(res => {
                        if(res.success) Swal.fire('Selesai!', 'Status pendaki diperbarui.', 'success').then(() => location.reload());
                    });
                });
            }
        });
    });
// ==========================================
    // FITUR REAL-TIME SEARCH (SUPER AJAX)
    // ==========================================
    let searchTimer;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimer);
        let keyword = $(this).val();

        // Kasih jeda 0.3 detik setelah berhenti ngetik biar ga nge-spam server
        searchTimer = setTimeout(function() {
            // Kirim kurir bayangan ke Controller
            $.ajax({
                url: "{{ route('karyawan.db') }}",
                type: "GET",
                data: { search: keyword },
                success: function(data) {
                    // Bikin penampung sementara buat data yang dikirim balik sama Controller
                    let tempDiv = $('<div>').html(data);

                    // Ambil bagian tabel dan paginasi dari hasil pencarian, lalu tempel ke layar
                    $('#tabel-pendaki').html(tempDiv.find('#tabel-pendaki').html());
                    $('#pagination-container').html(tempDiv.find('#pagination-container').html());
                },
                error: function() {
                    console.error("Gagal melakukan pencarian.");
                }
            });
        }, 300);
    });
});
</script>
@endsection
