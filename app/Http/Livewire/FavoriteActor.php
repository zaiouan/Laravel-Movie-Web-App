<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Farvorite;
use Livewire\Component;
use Auth;

class FavoriteActor extends Component
{
    public $rec;
    public $like = false;
    public $data;
    public $user;

    public function mount()
    {
        $this->user = Auth::User();
        $this->data = Farvorite::where('user_id', $this->user->id)
            ->where('actor_id', $this->rec)->first();
        if ($this->data) {
            if ($this->data->favorite) {
                $this->like = true;
            }
        }
    }

    public function like()
    {
        if (!$this->data) {
            $createLike = Farvorite::create(
                [
                    'actor_id' => $this->rec,
                    'user_id' => $this->user->id,
                    'favorite' => true
                ]
            );
        } else {
            $updateLike = Farvorite::where('user_id', $this->user->id)
                ->where('actor_id', $this->rec)
                ->update([
                    'favorite' => true
                ]);
        }
    }
    public function dislike()
    {
        $updateLike = Farvorite::where('user_id', $this->user->id)
            ->where('actor_id', $this->rec)
            ->update([
                'favorite' => false
            ]);
    }

    public function getLikedProperty()
    {
        return Farvorite::where('user_id', $this->user->id)
            ->where('actor_id', $this->rec)->where('favorite',true)->exists();
    }

    public function render()
    {
        return view('livewire.favorite-actor');
    }
}
