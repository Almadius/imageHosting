@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Image Hosting</h1>

        {{-- Форма для загрузки изображений --}}
        <div class="upload-form mb-4">
            <h2 class="h4">Upload New Images</h2>
            <form action="{{ route('images.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" class="form-control-file" id="images" name="images[]" multiple>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>

        {{-- Сортировка --}}
        <div class="sorting mb-4">
            <form action="{{ url('/images') }}" method="GET" class="form-inline">
                <div class="form-group mr-2">
                    <select name="sortBy" class="form-control">
                        <option value="name">Name</option>
                        <option value="created_at">Date and Time</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-secondary">Sort</button>
            </form>
        </div>

        {{-- Форма для скачивания изображений в ZIP --}}
        <form action="{{ url('/images/download/multiple') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                @foreach($images as $image)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('storage/images/' . $image->name) }}" alt="{{ $image->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $image->name }}</h5>
                                {{-- Обновлено: отображение даты и времени --}}
                                <p class="card-text">Uploaded: {{ $image->created_at->format('d.m.Y H:i:s') }}</p>
                                <a href="{{ asset('storage/images/' . $image->name) }}" target="_blank" class="btn btn-sm btn-info mb-2">View Original</a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ url('/images/download/' . $image->id) }}" class="btn btn-primary btn-sm">Download</a>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="ids[]" value="{{ $image->id }}" id="image{{ $image->id }}">
                                        <label class="custom-control-label" for="image{{ $image->id }}">Select for ZIP</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">Download Selected in ZIP</button>
        </form>
    </div>
@endsection
