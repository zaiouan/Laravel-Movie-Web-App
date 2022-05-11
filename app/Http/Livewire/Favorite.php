<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Farvorite;
use Auth;
class Favorite extends Component
{
    public $rec;
    public $like = false;
    public $data;
    public $user;

    public function mount()
    {
        $this->user = Auth::User();
        $this->data = Farvorite::where('user_id', $this->user->id)
            ->where('movie_id', $this->rec)->first();
        if ($this->data) {
            if ($this->data->favorite) {
                $this->like = true;
            }
        }
    }

    public function render()
    {
        return view('livewire.favorite');
    }

    public function like()
    {
        if (!$this->data) {
            $createLike = Farvorite::create(
                [
                    'movie_id' => $this->rec,
                    'user_id' => $this->user->id,
                    'favorite' => true
                ]
            );
        } else {
            $updateLike = Farvorite::where('user_id', $this->user->id)
                ->where('movie_id', $this->rec)
                ->update([
                    'favorite' => true
                ]);
        }
    }
    public function dislike()
    {
        $updateLike = Farvorite::where('user_id', $this->user->id)
            ->where('movie_id', $this->rec)
            ->update([
                'favorite' => false
            ]);
    }

    public function getLikedProperty()
    {
        return Farvorite::where('user_id', $this->user->id)
            ->where('movie_id', $this->rec)->where('favorite',true)->exists();
    }


}
