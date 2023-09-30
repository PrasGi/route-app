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
            height: 180px;
        }
    </style>

    {{-- @vite('resources/js/leaflet.js') --}}
</head>

<body>
    <!-- Konten halaman Anda di sini -->
    <div class="row justify-content-center">
        <div class="col-5">
            <div id="map" style="height: 400px;"></div>
        </div>
    </div>

    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);
    </script>

</body>

</html>
