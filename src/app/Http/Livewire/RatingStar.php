<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RatingStar extends Component
{
    public $averageRating;
    public $countRating;

    public function mount($rating, $countRating)
    {
        $this->averageRating = $rating ?? 0;
        $this->countRating = $countRating ?? 0;
    }

    public function render()
    {
        return view('livewire.rating-star', [
            'averageRating' => $this->averageRating,
            'countRating' => $this->countRating,
        ]);
    }
}
