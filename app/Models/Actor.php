<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',

        'movie_id',
        'serie_id',
        'picture'
    ];

    public function movies(){
        return $this->belongsToMany('App\Models\Movie','actor_movies');
    }

    public function series(){
        return $this->belongsToMany('App\Models\Serie','actor_movies');
    }

}
