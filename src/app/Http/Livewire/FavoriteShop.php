<?php

namespace App\Http\Livewire;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FavoriteShop extends Component
{
    public $favorites;

    public function mount()
    {
        $user = Auth::user();
        $this->favorites = Favorite::where('user_id', $user->id)
            ->with('shop')
            ->get();
    }

    public function deleteFavorite($shopId)
    {
        $user = Auth::user();
        $favorite = Favorite::where('user_id', $user->id)
            ->where('shop_id', $shopId)->first();

        if ($favorite) {
            $favorite->delete();
        }
        $this->favorites = Favorite::where('user_id', $user->id)
            ->with('shop')
            ->get();
    }

    public function render()
    {
        return view('livewire.favorite-shop');
    }
}
