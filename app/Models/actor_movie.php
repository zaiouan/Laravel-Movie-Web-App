<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actor_movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'movie_id','serie_id',
        'actor_id','character',
    ];
}
