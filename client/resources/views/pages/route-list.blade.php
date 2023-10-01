@extends('partials.index')
@section('script-head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        #map {
            height: 50vh;
            /* Mengatur tinggi peta sesuai dengan tinggi tampilan layar */
            width: 100%;
        }
    </style>
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @error('failed')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror

    <div class="row mb-3 p-2">
        <div class="col">
            <h5 class="card-title">Tracking Route <span>| now</span></h5>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-dark mt-3" data-bs-toggle="modal" data-bs-target="#addModal">Add
                new</button>
        </div>
    </div>

    <div class="row mb-3 p-3">
        <div class="col">
            <form action="{{ route('list.routes.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" required readonly>
                            <input type="hidden" class="form-control" id="latitude" name="route_id"
                                value="{{ $id }}">
                        </div>
                        <div class="col-md-6">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" required readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 shadow">
                            <div id="map"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success" id="getLocation">Get My Location</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary ms-2" data-bs-dismiss="modal">Save</button>
                </div>
            </form>
        </div>
    </div>

    @foreach ($datas as $key => $data)
        <div class="card shadow">
            <div class="card-header">
                route {{ $key + 1 }}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <img src="{{ $data['image'] }}" class="img-fluid" alt="...">
                    </div>
                    <div class="col-3 pt-3">
                        <p> <b>Latitude </b>: {{ $data['latitude'] }}</p>
                        <p> <b>Longitude </b>: {{ $data['longitude'] }}</p>
                        <div class="mt-4">
                            <form action="{{ route('list.routes.destroy', $data['id']) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script-body')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map;
        var marker;

        // Fungsi untuk memindahkan marker saat mengklik pada peta
        function initMap() {
            map = L.map('map').setView([-6.206090498573885, 106.8222655914724], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                if (marker) {
                    marker.setLatLng([lat, lng]); // Pindahkan marker ke lokasi yang dipilih
                } else {
                    marker = L.marker([lat, lng]).addTo(
                        map); // Tambahkan marker pada lokasi yang dipilih jika belum ada
                }

                // Update nilai input latitude dan longitude
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            });
        }

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

            // Update nilai input latitude dan longitude
            document.getElementById('latitude').value = latitude;
            document.getElementById('longitude').value = longitude;
        }

        // Menangani klik tombol "Get My Location"
        document.getElementById('getLocation').addEventListener('click', function() {
            getLocation(); // Panggil fungsi getLocation() saat tombol diklik
        });

        initMap();
    </script>
@endsection
