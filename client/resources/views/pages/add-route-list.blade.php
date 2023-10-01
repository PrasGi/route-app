<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Picker</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-8">
            <form action="{{ route('routes.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image[]" multiple>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 shadow">
                            <div id="map"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" onclick="getLocation()">Get My Location</button>
                            <button class="btn btn-success" id="pickLocation">Pick Location</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (popper.js and jquery are required dependencies) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-6.206090498573885, 106.8222655914724], 13);
        var marker;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Fungsi untuk mendapatkan lokasi pengguna saat ini
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        // Fungsi untuk menampilkan lokasi pengguna saat ini pada peta
        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            if (marker) {
                map.removeLayer(marker); // Hapus marker sebelumnya jika ada
            }
            marker = L.marker([latitude, longitude]).addTo(map); // Tambahkan marker pada lokasi saat ini
            map.setView([latitude, longitude], 13); // Pindahkan peta ke lokasi saat ini
        }

        // Fungsi untuk memilih lokasi secara manual saat mengklik pada peta
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (marker) {
                map.removeLayer(marker); // Hapus marker sebelumnya jika ada
            }
            marker = L.marker([lat, lng]).addTo(map); // Tambahkan marker pada lokasi yang dipilih
        });

        // Mengirim data ke log saat tombol "Pick Location" diklik
        document.getElementById('pickLocation').addEventListener('click', function() {
            if (marker) {
                console.log('Latitude: ' + marker.getLatLng().lat + ', Longitude: ' + marker.getLatLng().lng);
            } else {
                alert(
                    'Pilih lokasi terlebih dahulu dengan tombol "Get My Location" atau dengan mengklik pada peta.'
                );
            }
        });
    </script>
</body>

</html>
