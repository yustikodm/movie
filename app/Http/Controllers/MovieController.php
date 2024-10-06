<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    private $apiKey;
    private $client;

    public function __construct()
    {
        $this->apiKey = env('API_KEY', 'f82d0113'); // Get API key from .env
        if (is_null($this->apiKey)) {
            dd('OMDB_API_KEY is not set or not found');
        }
        $this->client = new Client();
    }

    // Show the movie search page
    public function index(Request $request)
    {
        $movies = [];
        $message = '';
        $page = $request->input('page', 1); // Get the current page or default to 1
        $searchType = $request->input('search_type', 'title'); // Default to title search

        // Check if there is a search query
        if ($request->isMethod('get') && $request->has('title')) {
            // Search by title
            $response = $this->client->get('http://www.omdbapi.com/', [
                'query' => [
                    'apikey' => $this->apiKey,
                    's' => $request->input('title'), // Use title from input
                    'page' => $page, // Include page number for pagination
                    'r' => 'json',
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            // Debug: Log the API response
            Log::info("API Response: " . json_encode($result));

            if ($result['Response'] === 'True') {
                $movies = $result['Search']; // Get the movies
            } else {
                $message = $result['Error']; // Handle error
            }
        }

        // For the initial page load, return the view
        if ($request->ajax()) {
            // If the request is AJAX, return JSON
            return response()->json(compact('movies', 'message', 'page'));
        }

        // If not an AJAX request, return the view with the movies data
        return view('movies.index', compact('movies', 'message'));
    }


    // Show the movie details page
    public function show($id)
    {
        // Fetch movie details using IMDb ID
        $response = $this->client->get('http://www.omdbapi.com/', [
            'query' => [
                'apikey' => $this->apiKey,
                'i' => $id,
                'plot' => 'full',
                'r' => 'json',
            ]
        ]);

        $movie = json_decode($response->getBody(), true);

        if ($movie['Response'] === 'True') {
            return view('movies.show', compact('movie')); // Show movie details
        } else {
            return redirect()->route('movies.index')->with('error', $movie['Error']); // Handle error
        }
    }
}
