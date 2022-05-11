<?php

namespace App\Http\Livewire;

use App\Models\Movie;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class SearchMv extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = [];

        if (strlen($this->search) >= 2) {
            $searchResults = Movie::where('title','like','%'.$this->search.'%')->get();
        }
        return view('livewire.search-mv', [
            'searchResults' => $searchResults,
        ]);
    }
}
