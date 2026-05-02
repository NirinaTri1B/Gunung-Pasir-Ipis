@extends('layouts.dbpendaki_master')

@section('page_title', 'Jalur Tracking')

@section('content')
<div class="card">
    <div style="display: flex; gap: 15px; margin-bottom: 15px;">
        <div style="flex: 1; background: #414833; color: white; padding: 10px; border-radius: 8px; text-align: center;">
            <small>Jarak Tempuh</small><br>
            <strong id="jarak">0</strong> km
        </div>
        <div style="flex: 1; background: #656D4A; color: white; padding: 10px; border-radius: 8px; text-align: center;">
            <small>Estimasi Waktu</small><br>
            <strong id="waktu">0</strong> Menit
        </div>
    </div>

    <div id="map" style="width: 100%; height: 450px; border-radius: 12px; border: 2px solid #414833;"></div>
    <br>

    {{-- 1. CEK STATUS AKTIF MENDAKI (PEMBUNGKUS UTAMA) --}}
    @if($isAktif)
        {{-- Jika sedang mendaki, tampilkan tombol SOS atau status bantuannya --}}
        @if(!$sosAktif)
            <button id="btn-sos" class="btn-logout" style="background-color: #A94442; width: 100%; padding: 15px; font-size: 18px; color: white; border: none; border-radius: 8px; cursor: pointer;">
                <i class="fas fa-exclamation-triangle"></i> KIRIM SOS (DARURAT)
            </button>
        @elseif($sosAktif->status == 'aktif')
            <div style="background-color: #ffb703; padding: 20px; border-radius: 8px; text-align: center; margin-top: 15px;">
                <h4 style="color: #d62828; font-weight: bold; margin: 0;">Laporan Terkirim!</h4>
                <p style="margin: 5px 0 0 0; color: #333;">Menunggu petugas Basecamp merespon laporan Anda...</p>
            </div>
        @elseif($sosAktif->status == 'ditangani')
            <div style="background-color: #E0F7FA; border: 2px solid #0077B6; padding: 20px; border-radius: 8px; text-align: center; margin-top: 15px;">
                <h4 style="color: #0077B6; font-weight: bold; margin: 0;">BANTUAN SEDANG MENUJU LOKASI!</h4>
                <p style="margin: 5px 0 0 0; color: #333;">Tetap tenang, tim sedang menuju titik koordinat Anda.</p>
            </div>
        @endif
    @else
        {{-- 2. TAMPILAN JIKA TIDAK SEDANG MENDAKI --}}
        <div style="background-color: #f8f9fa; border: 2px dashed #ccc; padding: 20px; border-radius: 8px; text-align: center; margin-top: 15px;">
            <i class="fas fa-lock" style="font-size: 24px; color: #aaa; margin-bottom: 10px;"></i>
            <h4 style="color: #666; font-weight: bold; margin: 0;">Fitur Darurat Terkunci</h4>
            <p style="margin: 5px 0 0 0; color: #888; font-size: 14px;">Tombol SOS hanya aktif saat kamu dalam masa pendakian di Puncak Pasir Ipis.</p>
        </div>
    @endif
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. INISIALISASI PETA
    var map = L.map('map').setView([-6.75, 107.67], 17);

    // 2. LAYER SATELIT
    var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri',
        maxNativeZoom: 18,
        maxZoom: 20
    }).addTo(map);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}{r}.png', {
        pane: 'shadowPane'
    }).addTo(map);

    // 3. IKON POS
    var iconPos = L.divIcon({
        html: '<i class="fas fa-map-marker-alt" style="color: #007bff; font-size: 24px;"></i>',
        className: 'custom-div-icon',
        iconSize: [30, 42],
        iconAnchor: [15, 42]
    });

    L.marker([-6.750533, 107.675120], {icon: iconPos}).addTo(map).bindPopup("Pos 1");
    L.marker([-6.751687, 107.673611], {icon: iconPos}).addTo(map).bindPopup("Pos 2");
    L.marker([-6.753086, 107.670519], {icon: iconPos}).addTo(map).bindPopup("Pos 3");
    L.marker([-6.754686, 107.669067], {icon: iconPos}).addTo(map).bindPopup("Pos 4");
    L.marker([-6.755796, 107.665480], {icon: iconPos}).addTo(map).bindPopup("Pos 5");

    // 4. LOAD GPX JALUR
    var gpxUrl = "{{ asset('maps/Jalurpasiripis.gpx') }}";
    new L.GPX(gpxUrl, {
        async: true,
        marker_options: {
            startIconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            endIconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png'
        },
        polyline_options: {
            color: '#FFFFFF',
            weight: 5,
            opacity: 0.9
        }
    }).on('loaded', function(e) {
        var gpx = e.target;
        map.fitBounds(gpx.getBounds(), {
            maxZoom: 18,
            padding: [50, 50]
        });

        var km = gpx.get_distance() / 1000;
        document.getElementById('jarak').innerText = km.toFixed(2);
        document.getElementById('waktu').innerText = Math.round((km / 3) * 60);

        gpx.getLayers().forEach(function(layer) {
            if (layer instanceof L.Polyline) {
                L.polylineDecorator(layer, {
                    patterns: [
                        {
                            offset: 25,
                            repeat: 60,
                            symbol: L.Symbol.arrowHead({
                                pixelSize: 10,
                                polygon: false,
                                pathOptions: {stroke: true, color: '#007bff', weight: 3}
                            })
                        }
                    ]
                }).addTo(map);
            }
        });
    }).addTo(map);

    // 5. TRACKING POSISI USER
    var userIcon = L.divIcon({
        html: '<i class="fas fa-location-arrow" style="color: #FF460F; font-size: 24px; transform: rotate(45deg);"></i>',
        className: 'user-icon', iconSize: [30, 30]
    });
    var userMarker = L.marker([0,0], {icon: userIcon}).addTo(map);

    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(function(pos) {
            userMarker.setLatLng([pos.coords.latitude, pos.coords.longitude]);
        }, null, { enableHighAccuracy: true });
    }

    // --- LOGIKA TOMBOL SOS (DATABASE) ---
    var btnSos = document.getElementById('btn-sos');

    // Cek apakah tombol SOS sedang muncul di layar
    if (btnSos) {
        btnSos.addEventListener('click', function() {
            Swal.fire({
                title: 'DARURAT (SOS)',
                icon: 'warning',
                iconColor: '#A94442',
                customClass: { popup: 'swal2-popup-sos' },
                html: `
                    <div style="text-align: left;">
                        <label style="font-weight:600; font-size:14px; color:#555;">Kategori Kendala:</label>
                        <select id="jenis_sos" class="swal2-select swal-input-sos">
                            <option value="Tersesat">Tersesat</option>
                            <option value="Cedera / Luka-luka">Cedera / Luka-luka</option>
                            <option value="Bahaya Lainnya">Bahaya Lainnya (Tuliskan...)</option>
                        </select>

                        <div id="box-pesan" style="display: none;"> <label style="font-weight:600; font-size:14px; color:#555; margin-top:10px; display:block;">Pesan Tambahan:</label>
                            <textarea id="pesan" class="swal2-textarea swal-input-sos" placeholder="Sebutkan kendala kamu..."></textarea>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'KIRIM BANTUAN',
                confirmButtonColor: '#A94442',

                didOpen: () => {
                    const select = document.getElementById('jenis_sos');
                    const boxPesan = document.getElementById('box-pesan');

                    select.addEventListener('change', function() {
                        if (this.value === 'Bahaya Lainnya') {
                            boxPesan.style.display = 'block';
                        } else {
                            boxPesan.style.display = 'none';
                            document.getElementById('pesan').value = '';
                        }
                    });
                },

                preConfirm: () => {
                    const jenis = document.getElementById('jenis_sos').value;
                    const pesan = document.getElementById('pesan').value;
                    const lat = userMarker.getLatLng().lat;
                    const lng = userMarker.getLatLng().lng;

                    if (lat === 0 && lng === 0) {
                        Swal.showValidationMessage('GPS belum aktif! Pastikan izin lokasi aktif.');
                        return false;
                    }

                    return { jenis, pesan, lat, lng };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Mengirim Sinyal...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    fetch("{{ route('sos.kirim') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            jenis_sos: result.value.jenis,
                            latitude: result.value.lat,
                            longitude: result.value.lng,
                            pesan_tambahan: result.value.pesan
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire({
                                title: 'TERKIRIM!',
                                // text: data.message, <--- BAGIAN INI DIHAPUS ATAU DIKOMENTAR
                                icon: 'success',
                                confirmButtonColor: '#414833'
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    })
                    .catch(err => {
                        Swal.fire('Gagal', 'Koneksi bermasalah, coba lagi!', 'error');
                    });
                }
            });
        });
    } // Akhir dari pengecekan tombol SOS
});
</script>

<!-- SCRIPT AUTO REFRESH -->
{{-- @if($sosAktif && $sosAktif->status == 'aktif')
<script>
    setTimeout(function() {
        window.location.reload();
    }, 5000); // Otomatis refresh tiap 5 detik
</script>
@endif --}}
@endsection
