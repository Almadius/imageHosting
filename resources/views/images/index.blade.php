@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Uploaded Images</h1>

        {{-- Сортировка --}}
        <div class="sorting">
            <form action="{{ url('/images') }}" method="GET">
                <label>
                    <select name="sortBy">
                        <option value="name">Name</option>
                        <option value="created_at">Date</option>
                    </select>
                </label>
                <button type="submit">Sort</button>
            </form>
        </div>

        {{-- Форма для скачивания изображений в ZIP --}}
        <form action="{{ url('/images/download/multiple') }}" method="POST">
            @csrf
            <div class="images">
                @foreach($images as $image)
                    <div class="image">
                        <h3>{{ $image->name }}</h3>
                        <p>Uploaded: {{ $image->created_at->toFormattedDateString() }}</p>
                        <a href="{{ asset('storage/images/' . $image->name) }}" target="_blank">View Original</a>
                        {{-- Превью изображения --}}
                        <div>
                            <img src="{{ asset('storage/images/' . $image->name) }}" alt="{{ $image->name }}" style="width: 100px; height: auto;">
                        </div>
                        <br>
                        {{-- Отдельная кнопка для скачивания каждого изображения --}}
                        <a href="{{ url('/images/download/' . $image->id) }}" class="btn btn-primary">Download</a>
                        {{-- Чекбокс для выбора изображений для скачивания в ZIP --}}
                        <label>
                            <input type="checkbox" name="ids[]" value="{{ $image->id }}">
                        </label> Select for ZIP
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">Download Selected in ZIP</button>
        </form>
    </div>
@endsection
