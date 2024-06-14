<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\Genre;
use Livewire\Component;

class ShopSearch extends Component
{
    public $areas;
    public $genres;
    public $area_id;
    public $genre_id;
    public $keyword;

    public function mount()
    {
        $this->areas = Area::all();
        $this->genres = Genre::all();
    }

    public function updated()
    {
        $this->emit('search', [
            'area_id' => $this->area_id,
            'genre_id' => $this->genre_id,
            'keyword' => $this->keyword,
        ]);
    }

    public function render()
    {
        return view('livewire.shop-search');
    }
}
