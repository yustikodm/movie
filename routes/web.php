<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']); // Redirect root to /movies
Route::get('/home', [HomeController::class, 'index']);

Auth::routes();

Route::match(['get', 'post'], '/movies', [MovieController::class, 'index'])->name('movies.index'); // Allow both GET and POST
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});
Route::get('/language/{lang}', [LanguageController::class, 'switchLang'])->name('language.switch');
