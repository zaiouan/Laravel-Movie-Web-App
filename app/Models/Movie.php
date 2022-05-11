<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'vote',
        'overview',
        'genre_id',
        'date',
        'poster',
        'trailer_link'
    ];

    public function genres() {
        return $this->belongsToMany('App\Models\Genre','genre_movies');
    }
    public function crews()
    {
        return $this->hasMany('App\Models\Crew');
    }
    public function actors()
    {
        return $this->belongsToMany('App\Models\Actor','actor_movies');
    }
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
}
