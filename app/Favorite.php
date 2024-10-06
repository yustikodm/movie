<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    // Specify the fields that can be mass-assigned
    protected $fillable = [
        'user_id',
        'imdbID',
        'title',
        'year',
        'rated',
        'released',
        'runtime',
        'genre',
        'director',
        'writer',
        'actors',
        'plot',
        'language',
        'country',
        'awards',
        'poster',
        'imdbRating',
        'imdbVotes',
        'type'
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
