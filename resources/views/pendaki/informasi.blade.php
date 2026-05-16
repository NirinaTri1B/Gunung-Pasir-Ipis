@extends('layouts.pendaki_master')

@section('page_title', 'Pusat Informasi')

@section('content')
<div class="container-fluid" style="padding: 20px;">
    <div style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; min-height: 500px;">

        <!-- NAVIGASI TAB (DI ATAS) -->
        <div style="display: flex; background: #fdfdfd; border-bottom: 1px solid #eee;">
            <div class="info-tab-top" onclick="bukaTab(event, 'fasilitas')">
                <i class="fas fa-map-marked-alt"></i> Fasilitas & Jalur
            </div>

            <div class="info-tab-top active" onclick="bukaTab(event, 'sop')">
                <i class="fas fa-scroll"></i> Peraturan Pendakian
            </div>

            <div class="info-tab-top" onclick="bukaTab(event, 'tips')">
                <i class="fas fa-shield-alt"></i> Tips Keamanan
            </div>
        </div>

        <!-- ISI KONTEN (DI BAWAH TAB) -->
        <div style="padding: 40px;">

                <!-- TAB 1: FASILITAS -->
            <div id="fasilitas" class="info-panel">
                <h3 style="color: #414833; font-weight: 800; margin-bottom: 20px;">Fasilitas & Jalur Tracking</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <!-- Card Harga Tiket di Tab 3 -->
                    <div style="background: #fff9e6; border-left: 5px solid #ffb703; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        <h5 style="color: #856404; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-ticket-alt"></i> Harga Tiket (HTM)
                        </h5>
                        <div style="margin-top: 10px; font-size: 14px; color: #555;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span>Tektok (Harian)</span>
                                <strong>Rp 15.000 / orang</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Camping (Menginap)</span>
                                <strong>Rp 30.000 / orang</strong>
                            </div>
                            <small style="display: block; margin-top: 10px; color: #888; font-style: italic;">*Harga sudah termasuk akses jalur dan area camp.</small>
                        </div>
                    </div>

                    <!-- Card Sumber Air -->
                    <div style="background: #fdf8f3; border-left: 5px solid #a47148; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        <h5 style="color: #634832; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-exclamation-circle"></i> Jalur Tracking
                        </h5>
                        <p style="color: #555; line-height: 1.8; margin-top: 10px; margin-bottom: 0; font-size: 14px;">
                            Jalur puncak memiliki medan yang terjal dan berbatasan langsung dengan jurang.
                            Selalu perhatikan langkah kaki Anda dan tetap waspada terhadap kondisi medan yang dilalui.
                        </p>
                    </div>

                    <!-- Card Area Camp -->
                    <div style="background: #e6f7ff; border-left: 5px solid #0077b6; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        <h5 style="color: #005073; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-campground"></i> Area Camp Puncak
                        </h5>
                        <p style="color: #555; line-height: 1.8; margin-top: 10px; margin-bottom: 0; font-size: 14px;">
                            Jarak tempuh sekitar 3.04 km dari basecamp dengan estimasi waktu perjalanan normal selama 90 menit.
                        </p>
                    </div>
                </div>
            </div>

            <!-- TAB 2: SOP -->
            <div id="sop" class="info-panel active">
                <h3 style="color: #414833; font-weight: 800; margin-bottom: 20px;">Peraturan Pendakian</h3>
                <p style="color: #777; margin-bottom: 30px;">Harap patuhi seluruh peraturan demi kelestarian alam Gunung Puncak Pasir Ipis.</p>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <!-- Card Manajemen Sampah -->
                    <div style="background: #fff5f5; border-left: 5px solid #d62828; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        <h5 style="color: #414833; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-trash-alt"></i> Manajemen Sampah
                        </h5>
                        <p style="color: #555; line-height: 1.8; margin-top: 10px; margin-bottom: 0; font-size: 14px;">
                            Wajib membawa kembali semua sampah bawaan. Jumlah sampah akan divalidasi saat turun,
                             jika kekurangan akan dikenakan denda atau mengambil kembali sampah yang tertinggal di jalur. <br>
                             <strong style="color: #d62828; font-weight: bold;">Jangan tinggalkan sampah apapun di gunung.</strong>
                        </p>
                    </div>

                    <!-- Card Jam Operasional -->
                    <div style="background: #f0f4e8; border-left: 5px solid #414833; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        <h5 style="color: #414833; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-clock"></i> Waktu Operasional
                        </h5>
                        <ul style="color: #555; line-height: 1.8; margin-top: 10px; padding-left: 20px; font-size: 14px;">
                            <li><strong>Jam Buka:</strong> 06.00 - 16.30 WIB</li>
                            <li><strong>Tutup:</strong> Senin & Kamis</li>
                            <p style="color: #d62828; font-weight: bold;">Penting: Pendaki Tektok atau Pendaki Harian wajib sudah kembali ke basecamp maksimal pukul 17.00 WIB.</p>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- TAB 3: TIPS KEAMANAN -->
            <div id="tips" class="info-panel">
                <h3 style="color: #414833; font-weight: 800; margin-bottom: 20px;">Tips Keamanan di Jalur</h3>

                <div style="background: #e6f7ff; border-left: 5px solid #0077b6; padding: 25px; border-radius: 10px;">
                    <h5 style="color: #005073; font-weight: 700;"><i class="fas fa-exclamation-circle"></i> Kondisi Darurat</h5>
                    <p style="margin-bottom: 0; color: #555;">Tekan <strong>tombol SOS</strong> untuk bantuan evakuasi atau medis segera.</p>
                </div><br>

                <div style="background: #fff9e6; border-left: 5px solid #ffb703; padding: 25px; border-radius: 10px; margin-bottom: 20px;">
                    <h5 style="color: #856404; font-weight: 700;"><i class="fas fa-paw"></i> Interaksi Satwa Liar</h5>
                    <p style="margin-bottom: 0; color: #555;">Tetap tenang jika bertemu satwa. Gunakan menu <strong>Laporan Satwa</strong> jika merasa terancam.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Tab Atas */
    .info-tab-top {
        flex: 1;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        color: #888;
        font-weight: 600;
        transition: 0.3s;
        border-bottom: 3px solid transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .info-tab-top:hover { background: #f8f9fa; color: #656D4A; }

    .info-tab-top.active {
        color: #656D4A;
        border-bottom: 3px solid #656D4A;
        background: white;
    }

    .info-panel {
        display: none;
        animation: slideUp 0.4s ease;
    }

    .info-panel.active { display: block; }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function bukaTab(evt, tabName) {
        var panels = document.getElementsByClassName("info-panel");
        for (var i = 0; i < panels.length; i++) {
            panels[i].classList.remove("active");
        }

        var tabs = document.getElementsByClassName("info-tab-top");
        for (var i = 0; i < tabs.length; i++) {
            tabs[i].classList.remove("active");
        }

        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
</script>
@endsection
