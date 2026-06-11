@extends('layouts.petugas_master')

@section('page_title', 'Dashboard Petugas')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: calc(100vh - 60px);
        width: 100%;
    }
    .info-panel {
        padding: 20px;
        background: white;
        position: fixed;
        bottom: 20px;
        right: 20px;
        left: 280px;
        border-radius: 20px;
        box-shadow: 0 -5px 20px rgba(0,0,0,0.1);
        z-index: 1000;
    }

    @media (max-width: 768px) {
        .info-panel {
            left: 20px;
        }
    }
</style>

<div id="map"></div>

<div class="info-panel">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
        <div style="background: #656D4A; color: white; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-hiking"></i>
        </div>
        <div>
            <h4 style="margin:0; font-size: 16px;">Menuju: {{ $sos->user->nama_user }}</h4>
            <small style="color: #888;">GPS aktif. Klik selesai jika pendaki sudah aman.</small>
        </div>
    </div>

    <form action="{{ route('karyawan.sos.selesai', $sos->id_sos) }}" method="POST">
        @csrf
        <button type="submit" style="width: 100%; background: #d62828; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer;">
            <i class="fas fa-check-circle"></i> SELESAI PENANGANAN
        </button>
    </form>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // 1. Inisialisasi Map (Set ke lokasi awal Pendaki)
    var map = L.map('map').setView([{{ $sos->latitude }}, {{ $sos->longitude }}], 16);
    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri'
    }).addTo(map);

    // 2. Marker Pendaki (Titik yang dikejar)
    var pendakiMarker = L.marker([{{ $sos->latitude }}, {{ $sos->longitude }}]).addTo(map)
                        .bindPopup("<b>Lokasi Pendaki: {{ $sos->user->nama_user }}</b>").openPopup();

    // 3. Marker Petugas (Posisi Kamu saat ini)
    var markerPetugas = L.circleMarker([0, 0], {
        radius: 10,
        fillColor: "#007bff",
        color: "#fff",
        weight: 3,
        opacity: 1,
        fillOpacity: 1
    }).addTo(map).bindPopup("Posisi Kamu");

    // 4. LOGIKA A: Kirim Posisi Petugas ke Server (Agar Pendaki bisa liat)
    if ("geolocation" in navigator) {
        navigator.geolocation.watchPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;

            markerPetugas.setLatLng([lat, lng]);

            fetch('{{ route("petugas.update_lokasi") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id_sos: "{{ $sos->id_sos }}",
                    lat: lat,
                    lng: lng
                })
            });
        }, function(err) {
            console.warn('GPS Error: ' + err.message);
        }, { enableHighAccuracy: true });
    }

    // 5. LOGIKA B: Pantau Pergerakan Pendaki
    function pantauPendaki() {
        console.log("--- Mesin nanya ke server jalan... ---");
        fetch("{{ route('karyawan.cek-sos-terbaru') }}")
        .then(response => response.json())
        .then(data => {
            console.log("Data mentah dari server:", data);
            if(data.lat_pendaki && data.lng_pendaki) {
                var latP = parseFloat(data.lat_pendaki);
                var lngP = parseFloat(data.lng_pendaki);
                pendakiMarker.setLatLng([latP, lngP]);
                console.log("5. Posisi pendaki BERHASIL diupdate ke peta!");
            }
        })
        .catch(err => console.error("Ada error di fetch:", err));
    }

    // Jalankan pertama kali
    pantauPendaki();

    // Jalankan rutin
    setInterval(pantauPendaki, 5000);
    // console.log("6. Mesin interval sudah dipasang!");
    </script>
@endsection
