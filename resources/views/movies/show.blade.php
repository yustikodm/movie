@extends('layouts.app')

@section('content')
    <div class="container my-5">
        @if ($movie['Response'] === 'True')
            <h1 class="mb-4">{{ $movie['Title'] }} ({{ $movie['Year'] }})</h1>
            <div class="row mb-4">
                <div class="col-md-4">
                    <img src="{{ $movie['Poster'] }}" alt="{{ $movie['Title'] }}" class="img-fluid rounded">
                </div>
                <div class="col-md-8">
                    <h3>{{ __('messages.plot') }}</h3>
                    <p>{{ $movie['Plot'] }}</p>
                    <h3>{{ __('messages.director') }}</h3>
                    <p>{{ $movie['Director'] }}</p>
                    <h3>{{ __('messages.cast') }}</h3>
                    <p>{{ $movie['Actors'] }}</p>
                    <h3>{{ __('messages.genre') }}</h3>
                    <p>{{ $movie['Genre'] }}</p>
                    <h3>{{ __('messages.rating') }}</h3>
                    <p>{{ $movie['imdbRating'] }}</p>

                    <!-- Back to previous page button -->
                    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-2">
                        <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
                    </a>

                    <!-- Add to favorites button -->
                    <button class="btn btn-primary favorite-btn mb-2" data-id="{{ $movie['imdbID'] }}">
                        <i class="fas fa-heart"></i> {{ __('messages.add_to_favorites') }}
                    </button>
                </div>
            </div>
        @else
            <div class="alert alert-danger">{{ $movie['Error'] }}</div>
        @endif
    </div>

    <style>
        .btn {
            font-weight: bold;
            padding: 10px 20px;
            transition: background-color 0.3s, transform 0.3s;
            border-radius: 30px;
            border: 2px solid transparent;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
        }
    </style>

    <!-- Login/Register Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">{{ __('messages.login_required') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('messages.close') }}"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('messages.login_prompt') }}</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('login') }}" class="btn btn-primary">{{ __('messages.log_in') }}</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">{{ __('messages.register') }}</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Add to Favorite Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.favorite-btn').addEventListener('click', function() {
                @if(Auth::guest())
                // Show login modal if not authenticated
                var modal = new bootstrap.Modal(document.getElementById('loginModal'));
                modal.show();
                @else
                const movieId = this.getAttribute('data-id');

                // Make an AJAX request to add the movie to favorites
                fetch('/favorites', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        imdbID: movieId,
                        Title: "{{ $movie['Title'] }}",
                        Year: "{{ $movie['Year'] }}",
                        Rated: "{{ $movie['Rated'] }}",
                        Released: "{{ $movie['Released'] }}",
                        Runtime: "{{ $movie['Runtime'] }}",
                        Genre: "{{ $movie['Genre'] }}",
                        Director: "{{ $movie['Director'] }}",
                        Writer: "{{ $movie['Writer'] }}",
                        Actors: "{{ $movie['Actors'] }}",
                        Plot: "{{ $movie['Plot'] }}",
                        Language: "{{ $movie['Language'] }}",
                        Country: "{{ $movie['Country'] }}",
                        Awards: "{{ $movie['Awards'] }}",
                        Poster: "{{ $movie['Poster'] }}",
                        imdbRating: "{{ $movie['imdbRating'] }}",
                        imdbVotes: "{{ $movie['imdbVotes'] }}",
                        Type: "{{ $movie['Type'] }}"
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'error') {
                            alert(data.message); // Movie already added
                        } else {
                            alert(data.message); // Movie added successfully
                        }
                    })
                    .catch(error => console.error('Error:', error));
                @endif
            });
        });
    </script>
@endsection
