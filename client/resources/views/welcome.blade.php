@extends('partials.index')

@section('content')
    <form action="{{ route('dashboard') }}" method="GET">
        <div class="row mb-3">
            <div class="col-md-3">
                <select class="form-select" aria-label="Select Category" name="category_id">
                    <option value="" selected>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                    <!-- Tambahkan opsi sesuai dengan kategori yang sesuai -->
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" aria-label="Select Level" name="level">
                    <option value="" selected>Select Level</option>
                    <option value="easy">easy</option>
                    <option value="medium">medium</option>
                    <option value="hard">hard</option>
                    <!-- Tambahkan opsi sesuai dengan level yang sesuai -->
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="category" name="village_id">
                    <!-- Tambahkan pilihan kategori di sini -->
                    <option value="" selected>Select Village</option>
                    @foreach ($villages as $village)
                        <option value="{{ $village['id'] }}">{{ $village['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    @foreach ($datas as $data)
        <div class="card shadow">
            <div class="card-header">
                History route
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $data['name'] }}</h5>
                <p class="card-text">{{ $data['description'] }}</p>
                <div class="row">
                    <div class="col-3">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @if (empty($data['galeries']))
                                    <img src="{{ asset('img/empty.jpg') }}" class="d-block w-100" alt="...">
                                @else
                                    @foreach ($data['galeries'] as $image)
                                        <div class="carousel-item active">
                                            <img src="{{ $image['image'] }}" class="d-block w-100" alt="...">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-3 pt-3">
                        <p> <b>Height Start</b>: {{ $data['height_start'] }}</p>
                        <p> <b>Height End</b>: {{ $data['height_end'] }}</p>
                        <div class="mt-4">
                            <a href="{{ route('map.index', $data['id']) }}" class="btn btn-primary"><i
                                    class="bi bi-map"></i> Go maps</a>
                        </div>
                    </div>
                    <div class="col pt-3">
                        <p> <b>Category</b>: {{ $data['category'] }}</p>
                        <p> <b>Level</b>: {{ $data['level'] }}</p>
                    </div>
                    <div class="col pt-3">
                        <p> <b>Long Route</b>: {{ $data['long_route'] }}</p>
                        <p> <b>Village</b>: {{ $data['village_name'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
