<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectAreaAndGenre extends Component
{
    public $areas;
    public $genres;
    public $selectedArea;
    public $selectedGenre;
    public $newArea;
    public $newGenre;

    public function mount($areas, $genres)
    {
        $this->areas = $areas;
        $this->genres = $genres;
        $this->selectedArea = '';
        $this->selectedGenre = '';
    }

    public function render()
    {
        return view('livewire.select-area-and-genre');
    }
}
