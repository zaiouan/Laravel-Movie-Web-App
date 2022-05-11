<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class genre_movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id','serie_id',
        'genre_id',
    ];

}
