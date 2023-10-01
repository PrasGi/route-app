@extends('partials.index')

@section('content')
    <div class="row mb-3 p-2">
        <div class="col">
            <h5 class="card-title">Tracking Route <span>| now</span></h5>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-dark mt-3" data-bs-toggle="modal" data-bs-target="#addModal">Add new</button>
        </div>
    </div>
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
                            <a href="{{ route('list.routes.index', $data['id']) }}" class="btn btn-success"><i
                                    class="bi bi-plus"></i> Add marker</a>
                            <a href="{{ route('map.index', $data['id']) }}" class="btn btn-primary">Go maps</a>
                        </div>
                    </div>
                    <div class="col pt-3">
                        <p> <b>Category</b>: {{ $data['category'] }}</p>
                        <p> <b>Level</b>: {{ $data['level'] }}</p>
                    </div>
                    <div class="col pt-3">
                        <p> <b>Long Route</b>: {{ $data['long_route'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal add --}}
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Route</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('routes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="long_route" class="form-label">Long Route</label>
                            <input type="text" class="form-control" id="long_route" name="long_route">
                        </div>
                        <div class="mb-3">
                            <label for="height_start" class="form-label">Height Start</label>
                            <input type="text" class="form-control" id="height_start" name="height_start">
                        </div>
                        <div class="mb-3">
                            <label for="height_end" class="form-label">Height End</label>
                            <input type="text" class="form-control" id="height_end" name="height_end">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image[]" multiple>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category_id">
                                <!-- Tambahkan pilihan kategori di sini -->
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select class="form-select" id="level" name="level">
                                <option value="easy">Easy</option>
                                <option value="medium">Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save route</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script-body')
@endsection
