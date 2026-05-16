@extends('layouts.pendaki_master')

@section('page_title', 'Jalur Tracking')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="card">
    {{-- BAGIAN HEADER JARAK & WAKTU --}}
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

    {{-- AREA PETA --}}
    <div id="map" style="width: 100%; height: 450px; border-radius: 12px; border: 2px solid #414833;"></div>
    <br>

    {{-- LOGIKA STATUS BANTUAN (DITAMPILKAN DI BAWAH PETA) --}}
    @if($isAktif)
        @if(!$sosAktif)
            {{-- Tampilan Normal: Tombol SOS --}}
            <button id="btn-sos" class="btn-logout" style="background-color: #A94442; width: 100%; padding: 15px; font-size: 18px; color: white; border: none; border-radius: 8px; cursor: pointer;">
                <i class="fas fa-exclamation-triangle"></i> KIRIM SOS (DARURAT)
            </button>
        @elseif($sosAktif->status_sos == 'waiting')
            {{-- Status: Basecamp sudah kirim petugas, tapi petugas belum klik 'Berangkat' --}}
            <div style="background-color: #E0F7FA; border: 2px solid #0077B6; padding: 20px; border-radius: 8px; text-align: center; margin-top: 15px;">
                <h4 style="color: #0077B6; font-weight: bold; margin: 0;">BANTUAN SEDANG MENUJU LOKASI!</h4>
                <p style="margin: 5px 0 0 0; color: #333;">Tetap tenang, tim sedang menuju titik koordinat Anda.</p>
            </div>
        @elseif($sosAktif->status_sos == 'on_the_way')
            {{-- Status: Petugas sudah di jalan (Real-time) --}}
            <div style="background-color: #e7f3e8; border: 2px solid #2d6a4f; padding: 20px; border-radius: 8px; text-align: center; margin-top: 15px;">
                <h4 style="color: #2d6a4f; font-weight: bold; margin: 0;">PETUGAS DALAM PERJALANAN!</h4>
                <p style="margin: 5px 0 0 0; color: #333;">Pantau posisi icon biru di peta. Tetap di titik Anda!</p>
            </div>
        @else
            {{-- Status: Baru kirim SOS (Pending di Basecamp) --}}
            <div style="background-color: #ffb703; padding: 20px; border-radius: 8px; text-align: center; margin-top: 15px;">
                <h4 style="color: #d62828; font-weight: bold; margin: 0;">SOS TERKIRIM!</h4>
                <p style="margin: 5px 0 0 0; color: #333;">Laporan Anda telah diterima Basecamp. Mohon tunggu respon petugas.</p>
            </div>
        @endif
    @else
        {{-- Jika tidak dalam masa pendakian --}}
        <div style="background-color: #f8f9fa; border: 2px dashed #ccc; padding: 20px; border-radius: 8px; text-align: center; margin-top: 15px;">
            <i class="fas fa-lock" style="font-size: 24px; color: #aaa; margin-bottom: 10px;"></i>
            <h4 style="color: #666; font-weight: bold; margin: 0;">Fitur Darurat Terkunci</h4>
            <p style="margin: 5px 0 0 0; color: #888; font-size: 14px;">Tombol SOS hanya tersedia saat kamu dalam masa pendakian.</p>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. INISIALISASI PETA
    var map = L.map('map').setView([-6.75, 107.67], 17);

    // 2. LAYER SATELIT (Esri + Labels)
    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri',
        maxNativeZoom: 18,
        maxZoom: 20
    }).addTo(map);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}{r}.png', {
        pane: 'shadowPane'
    }).addTo(map);

    // 3. POSISI USER (PENDAKI)
    // Ditaruh di atas agar bisa diakses oleh semua fungsi di bawahnya
    var userMarker = L.marker([0,0], {
        icon: L.divIcon({
            html: '<i class="fas fa-location-arrow" style="color: #FF460F; font-size: 24px; transform: rotate(45deg);"></i>',
            className: 'user-icon', iconSize: [30, 30]
        })
    }).addTo(map);

    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(function(pos) {
            userMarker.setLatLng([pos.coords.latitude, pos.coords.longitude]);
        }, null, { enableHighAccuracy: true });
    }

    // 4. IKON POS (PENDAKIAN)
    var iconPos = L.divIcon({
        html: '<i class="fas fa-map-marker-alt" style="color: #007bff; font-size: 24px;"></i>',
        className: 'custom-div-icon',
        iconSize: [30, 42],
        iconAnchor: [15, 42]
    });

    const posLocations = [
        [-6.750533, 107.675120, "Pos 1"],
        [-6.751687, 107.673611, "Pos 2"],
        [-6.753086, 107.670519, "Pos 3"],
        [-6.754686, 107.669067, "Pos 4"],
        [-6.755796, 107.665480, "Pos 5"]
    ];
    posLocations.forEach(loc => L.marker([loc[0], loc[1]], {icon: iconPos}).addTo(map).bindPopup(loc[2]));

    // 5. --- LOGIKA REALTIME (HANYA JALAN JIKA PETUGAS OTW) ---
    @if($sosAktif && $sosAktif->status_sos == 'on_the_way')

    var petugasMarker = null;
        function updatePosisiPetugas() {
            fetch("{{ route('karyawan.cek-sos-terbaru') }}")
            .then(response => response.json())
            .then(data => {
                // console.log("Data petugas diterima:", data);
                if(data.lat_petugas && data.lng_petugas) {
                    var lat = parseFloat(data.lat_petugas);
                    var lng = parseFloat(data.lng_petugas);

                    if (!petugasMarker) {
                        petugasMarker = L.circleMarker([lat, lng], {
                            radius: 10, fillColor: "#007bff", color: "#fff", weight: 3, opacity: 1, fillOpacity: 1
                        }).addTo(map).bindPopup("Petugas sedang menuju lokasi");
                    } else {
                        petugasMarker.setLatLng([lat, lng]);
                    }
                    console.log("Posisi petugas terupdate ke: " + lat + "," + lng);
                }
            });
        }

        function laporPosisiPendaki() {
            var currentPos = userMarker.getLatLng();
            // Pastikan koordinat sudah valid (bukan 0,0)
            if (currentPos.lat !== 0) {
                fetch("{{ route('sos.update-lokasi-pendaki') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        lat: currentPos.lat,
                        lng: currentPos.lng
                    })
                })
                .then(response => response.json())
                .then(data => console.log("Laporan Lokasi Berhasil:", data))
                .catch(err => console.error("Gagal Lapor Lokasi:", err));
            }
        }

        // Jalankan interval
        setInterval(updatePosisiPetugas, 5000);
        setInterval(laporPosisiPendaki, 10000);
    @endif

    // 6. LOAD GPX JALUR
    var gpxUrl = "{{ asset('maps/Jalurpasiripis.gpx') }}";

    new L.GPX(gpxUrl, {
        async: true,
        polyline_options: { color: '#FFFFFF', weight: 5, opacity: 0.9 },
        marker_options: {
            startIconUrl: null,
            endIconUrl: null,
            shadowUrl: null
        }
    }).on('loaded', function(e) {
        var gpx = e.target;
        map.fitBounds(gpx.getBounds(), { maxZoom: 18, padding: [50, 50] });

        var layers = gpx.getLayers();
        if (layers.length > 0) {
            var points = layers[0].getLatLngs();
            var startPoint = points[0];
            var endPoint = points[points.length - 1];

            // Marker Start
            L.marker([startPoint.lat, startPoint.lng], {
                icon: L.divIcon({
                    html: '<i class="fas fa-flag" style="color: #ffffff; font-size: 24px; text-shadow: 0 0 3px #000;"></i>',
                    className: 'custom-div-icon',
                    iconSize: [30, 30],
                    iconAnchor: [5, 24] // Kita sesuaikan biar benderanya pas di garis
                })
            }).addTo(map).bindPopup("Titik Awal (Start)");

            // Marker Finish
            L.marker([endPoint.lat, endPoint.lng], {icon: iconPos})
                .addTo(map)
                .bindPopup("Titik Akhir (Finish)");
        }

        var km = gpx.get_distance() / 1000;
        document.getElementById('jarak').innerText = km.toFixed(2);
        document.getElementById('waktu').innerText = Math.round((km / 3) * 60);
    }).addTo(map);

    // 7. TOMBOL SOS (SWEETALERT)
    var btnSos = document.getElementById('btn-sos');
    if (btnSos) {
        btnSos.addEventListener('click', function() {
            Swal.fire({
                title: 'DARURAT (SOS)',
                icon: 'warning',
                html: `
                    <div style="text-align: left; font-family: 'Poppins', sans-serif;">
                        <label style="font-weight: 600; color: #444; margin-bottom: 8px; display: block;">Kategori Kendala:</label>
                        <select id="jenis_sos" class="swal2-select" style="width: 100%; margin: 0 0 15px 0; border-radius: 8px; border: 1px solid #ddd; padding: 10px;">
                            <option value="Tersesat">Tersesat</option>
                            <option value="Cedera / Luka-luka">Cedera / Luka-luka</option>
                            <option value="Bahaya Lainnya">Bahaya Lainnya</option>
                        </select>

                        <div id="box-pesan" style="display: none; transition: all 0.3s ease;">
                            <label style="font-weight: 600; color: #444; margin-bottom: 8px; display: block;">Detail Kendala:</label>
                            <textarea id="pesan" class="swal2-textarea" style="width: 100%; height: 100px; margin: 0; border-radius: 8px; border: 1px solid #ddd;" placeholder="Sebutkan kendala Anda secara detail..."></textarea>
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
                        boxPesan.style.display = (this.value === 'Bahaya Lainnya') ? 'block' : 'none';
                    });
                },
                preConfirm: () => {
                    const lat = userMarker.getLatLng().lat;
                    const lng = userMarker.getLatLng().lng;
                    if (lat === 0) {
                        Swal.showValidationMessage('GPS belum aktif!');
                        return false;
                    }
                    return {
                        jenis: document.getElementById('jenis_sos').value,
                        pesan: document.getElementById('pesan').value,
                        lat, lng
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
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
                            Swal.fire('TERKIRIM!', 'Tetap di posisi Anda, Mohon tunggu respon petugas', 'success')
                            .then(() => window.location.reload());
                        }
                    });
                }
            });
        });
    }
});
</script>
@endsection
