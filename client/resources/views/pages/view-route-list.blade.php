<!DOCTYPE html>
<html>

<head>
    <!-- Atur meta-tag, tautan gaya CSS, dan lainnya sesuai kebutuhan Anda -->
    <meta charset="utf-8">
    <title>Map</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Letakkan script Leaflet di sini -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        #map {
            height: 480px;
        }
    </style>

    @vite('resources/js/leaflet.js')
</head>

<body>
    <!-- Konten halaman Anda di sini -->
    <div id="map"></div>

    <script>
        var map = L.map("map").setView([51.505, -0.09], 15);

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

        // Marker pertama (berwarna merah)
        var marker1 = L.marker([51.5, -0.09], {
                icon: redIcon
            })
            .addTo(map)
            .bindPopup(
                '<a href="https://source.unsplash.com/400x400/?mountain" target="_blank"><img src="https://source.unsplash.com/400x400/?mountain" alt="Mountain" width="200" height="200"></a>'
            );

        // Marker ketiga (berwarna merah)
        var marker2 = L.marker([51.503, -0.09], {
                icon: redIcon
            })
            .addTo(map)
            .bindPopup(
                '<a href="https://source.unsplash.com/400x400/?mountain" target="_blank"><img src="https://source.unsplash.com/400x400/?mountain" alt="Mountain" width="200" height="200"></a>'
            );

        // Marker kedua (berwarna merah)
        var marker3 = L.marker([51.505, -0.085], {
                icon: redIcon
            })
            .addTo(map)
            .bindPopup(
                '<a href="https://source.unsplash.com/400x400/?mountain" target="_blank"><img src="https://source.unsplash.com/400x400/?mountain" alt="Mountain" width="200" height="200"></a>'
            );

        // Membuat polyline yang menghubungkan marker 1, marker 2, dan marker 3 dalam urutan tertentu
        var latlngs = [marker1.getLatLng(), marker2.getLatLng(), marker3.getLatLng()];
        var polyline = L.polyline(latlngs, {
            color: "blue",
        }).addTo(map);
    </script>

</body>

</html>
