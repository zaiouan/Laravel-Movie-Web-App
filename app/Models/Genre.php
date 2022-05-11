<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function movies() {
        return $this->belongsToMany('App\Models\Movie','genre_movies');
    }
    public function series() {
        return $this->belongsToMany('App\Models\Movie');
    }


}
