@extends('layouts.app')

@section('content')
    <style>
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #007bff; /* Change this color as needed */
            border-radius: 50%;
            width: 40px; /* Size of the spinner */
            height: 40px; /* Size of the spinner */
            animation: spin 1s linear infinite;
            margin: auto; /* Center the spinner */
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="container">
        <h1 class="mb-4">{{ __('messages.favorite_movies') }}</h1>

        @if (session('message'))
            <div class="alert alert-danger">{{ session('message') }}</div>
        @endif

        <div id="favoritesContainer" class="row">
            @foreach ($favorites as $favorite)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="{{ $favorite->poster }}" class="card-img-top" alt="{{ $favorite->title }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $favorite->title }}</h5>
                            <p class="card-text">Year: {{ $favorite->year }}</p>
                            <div class="mt-auto">
                                <a href="{{ route('movies.show', $favorite->imdbID) }}" class="btn btn-primary w-100 mb-2">
                                    <i class="fas fa-eye"></i> {{ __('messages.view_details') }}
                                </a>
                                <form method="POST" action="{{ route('favorites.destroy', $favorite->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger w-100">
                                        <i class="fas fa-trash-alt"></i> {{ __('messages.remove_favorite') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="loadingIndicator" style="display: none; text-align: center;">
            <p>{{ __('messages.loading_more') }}</p>
            <div class="spinner"></div> <!-- Custom spinner -->
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let page = 1; // Initialize the page number
            const limit = 8; // Number of movies to load per request

            // Function to load more favorite movies
            function loadFavorites() {
                page++; // Increment the page number
                $('#loadingIndicator').show(); // Show loading indicator

                $.get('{{ route('favorites.index') }}', {
                    page: page
                }, function(response) {
                    $('#loadingIndicator').hide(); // Hide loading indicator

                    if (response.favorites.length > 0) {
                        response.favorites.forEach(favorite => {
                            // Append new favorite movie data to the list
                            $('#favoritesContainer').append(`
                            <div class="col-md-3 mb-4">
                                <div class="card">
                                    <img src="${favorite.poster}" class="card-img-top" alt="${favorite.title}">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">${favorite.title}</h5>
                                        <p class="card-text">Year: ${favorite.year}</p>
                                        <div class="mt-auto">
                                            <a href="/movies/${favorite.imdbID}" class="btn btn-primary w-100 mb-2">
                                                <i class="fas fa-eye"></i> {{ __('messages.view_details') }}
                            </a>
                            <form method="POST" action="/favorites/${favorite.id}">
                                                @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-100">
                                <i class="fas fa-trash-alt"></i> {{ __('messages.remove_favorite') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
`);
                        });
                    } else {
                        // No more favorites to load
                        $(window).off("scroll"); // Stop loading more movies
                    }
                });
            }

            // Infinite scroll event
            $(window).on("scroll", function() {
                // Check if we are near the bottom of the page
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    loadFavorites();
                }
            });
        });
    </script>
@endsection
