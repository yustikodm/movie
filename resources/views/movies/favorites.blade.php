@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Favorite Movies</h1>

        @if ($favorites->isEmpty())
            <p>You have no favorite movies.</p>
        @else
            @foreach ($favorites as $favorite)
                <div class="movie-item">
                    <h3>{{ $favorite->movie->Title }}</h3>
                    <img src="{{ $favorite->movie->Poster }}" alt="{{ $favorite->movie->Title }}">
                    <form action="{{ route('favorites.remove', $favorite->movie_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Remove from Favorites</button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>
@endsection
