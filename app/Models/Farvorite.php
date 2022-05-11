<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farvorite extends Model
{
    use HasFactory;
    protected $fillable = [
        'actor_id',
        'favorite',
        'user_id'
    ];
    public function movie()
    {
        return $this->belongsTo('App\Models\Movie');
    }
    public function serie()
    {
        return $this->belongsTo('App\Models\Serie');
    }
    public function actor()
    {
        return $this->belongsTo('App\Models\Actor');
    }
}
