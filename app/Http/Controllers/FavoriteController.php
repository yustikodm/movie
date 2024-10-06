<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Store favorite movie
    public function store(Request $request)
    {
        $user = Auth::user();
        $movieId = $request->imdbID;

        // Check if the movie is already in the user's favorites
        $favoriteExists = Favorite::where('user_id', $user->id)
            ->where('imdbID', $movieId)
            ->exists();

        if ($favoriteExists) {
            return response()->json(['status' => 'error', 'message' => 'Movie already added to favorites!'], 400);
        }

        // Save the new favorite movie
        $favorite = new Favorite([
            'user_id' => $user->id,
            'imdbID' => $request->imdbID,
            'title' => $request->Title,
            'year' => $request->Year,
            'rated' => $request->Rated,
            'released' => $request->Released,
            'runtime' => $request->Runtime,
            'genre' => $request->Genre,
            'director' => $request->Director,
            'writer' => $request->Writer,
            'actors' => $request->Actors,
            'plot' => $request->Plot,
            'language' => $request->Language,
            'country' => $request->Country,
            'awards' => $request->Awards,
            'poster' => $request->Poster,
            'imdbRating' => $request->imdbRating,
            'imdbVotes' => $request->imdbVotes,
            'type' => $request->Type,
        ]);

        $favorite->save();

        return response()->json(['status' => 'success', 'message' => 'Movie added to favorites!'], 200);
    }

    // Show list of favorite movies
    public function index(Request $request)
    {
        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)
            ->paginate(8); // Paginate favorites 8 per page

        if ($request->ajax()) {
            return response()->json(['favorites' => $favorites]);
        }

        return view('favorites.index', compact('favorites'));
    }

    public function destroy($id)
    {
        $favorite = Favorite::find($id);

        if ($favorite) {
            $favorite->delete();
            return back()->with('message', 'Favorite movie removed.');
        }

        return back()->with('message', 'Error! Favorite movie not found.');
    }

}
