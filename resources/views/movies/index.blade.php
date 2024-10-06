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
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="mb-4">{{ __('messages.movie_search') }}</h1>
        <form method="GET" action="{{ route('movies.index') }}" id="searchForm" class="mb-4">
            <div class="input-group">
                <input type="text" name="title" placeholder="{{ __('messages.search_placeholder') }}" required class="form-control">
                <input type="hidden" name="search_type" value="title">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> {{ __('messages.search') }}
                </button>
            </div>
        </form>

        @if ($message)
            <div class="alert alert-danger">{{ $message }}</div>
        @endif

        <div id="moviesContainer" class="row">
            @foreach (array_slice($movies, 0, 8) as $movie) <!-- Limit to 8 movies -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ $movie['Poster'] }}" class="card-img-top" alt="{{ $movie['Title'] }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $movie['Title'] }}</h5>
                        <p class="card-text">Year: {{ $movie['Year'] }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('movies.show', $movie['imdbID']) }}" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-eye"></i> {{ __('messages.view_details') }}
                            </a>
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

    <!-- Login/Register Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">{{ __('messages.login_required') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('messages.login_message') }}</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('login') }}" class="btn btn-primary">{{ __('messages.login') }}</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">{{ __('messages.register') }}</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let page = 1; // Initialize the page number
            const searchType = '{{ request()->input('search_type') }}'; // Get search type from the server
            const title = '{{ request()->input('title') }}'; // Get title from the server
            const limit = 8; // Number of movies to load per request

            // Function to load more movies
            function loadMovies() {
                page++; // Increment the page number
                $('#loadingIndicator').show(); // Show loading indicator

                $.get('{{ route('movies.index') }}', {
                    search_type: searchType,
                    title: title,
                    page: page
                }, function(response) {
                    $('#loadingIndicator').hide(); // Hide loading indicator

                    if (response.movies.length > 0) {
                        response.movies.forEach(movie => {
                            // Append new movie data to the list
                            $('#moviesContainer').append(`
                            <div class="col-md-3 mb-4">
                                <div class="card">
                                    <img src="${movie.Poster}" class="card-img-top" alt="${movie.Title}">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">${movie.Title}</h5>
                                        <p class="card-text">Year: ${movie.Year}</p>
                                        <div class="mt-auto">
                                            <a href="/movies/${movie.imdbID}" class="btn btn-primary w-100 mb-2">
                                                <i class="fas fa-eye"></i> {{ __('messages.view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
`);
                        });
                    } else {
                        // No more movies to load
                        $(window).off("scroll"); // Stop loading more movies
                    }
                });
            }

            // Infinite scroll event
            $(window).on("scroll", function() {
                // Check if we are near the bottom of the page
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    loadMovies();
                }
            });

            // No favorite button logic needed anymore
        });
    </script>
@endsection
