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
    public $sort = '';
    public $sortDisplay = '並び替え:';

    public function mount()
    {
        $this->areas = Area::all();
        $this->genres = Genre::all();
    }

    public function updatedSort()
    {
        switch ($this->sort) {
            case 'random':
                $this->sortDisplay = '並び替え: ランダム';
                break;
            case 'high-rating':
                $this->sortDisplay = '並び替え: 評価高/低';
                break;
            case 'low-rating':
                $this->sortDisplay = '並び替え: 評価低/高';
                break;
            default:
                $this->sortDisplay = '並び替え:';
                break;
        }

    }

    public function updated()
    {
        $this->emit('sortAndSearch', [
            'sort' => $this->sort,
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
