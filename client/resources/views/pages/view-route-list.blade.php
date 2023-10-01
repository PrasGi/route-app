@extends('partials.index')

@section('script-head')
    <!-- Letakkan script Leaflet di sini -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        #map {
            height: 100vh;
            /* Mengatur tinggi peta sesuai dengan tinggi tampilan layar */
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <!-- Konten halaman Anda di sini -->
    <div id="map"></div>
@endsection

@section('script-body')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Data marker dari controller
        var datas = {!! json_encode($datas) !!};

        // Ambil koordinat pertama dari data
        var firstData = datas[0];
        var firstLat = parseFloat(firstData.latitude);
        var firstLng = parseFloat(firstData.longitude);

        var map = L.map("map").setView([firstLat, firstLng], 15);

        L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map);

        var redIcon = L.icon({
            iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png",
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41],
        });

        // Iterasi melalui data dan membuat marker
        datas.forEach(function(data) {
            var marker = L.marker([parseFloat(data.latitude), parseFloat(data.longitude)], {
                icon: redIcon
            }).addTo(map).bindPopup(
                '<a href="' + data.image + '" target="_blank"><img src="' + data.image +
                '" alt="Mountain" width="200" height="200"></a>'
            );
        });

        // Membuat polyline jika diperlukan
        var latlngs = datas.map(function(data) {
            return [parseFloat(data.latitude), parseFloat(data.longitude)];
        });
        var polyline = L.polyline(latlngs, {
            color: "blue",
        }).addTo(map);
    </script>
@endsection
