<?php

namespace App\Http\Livewire;

use App\Models\Favorite;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ToggleFavorite extends Component
{
    public $shop;
    public $isFavorited;

    public function mount($shopId)
    {
        $this->shop = Shop::findOrFail($shopId);
        $this->isFavorited = Favorite::where('user_id', Auth::id())
            ->where('shop_id', $shopId)
            ->exists();
    }

    public function toggleFavorite()
    {
        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('shop_id', $this->shop->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $this->isFavorited = false;
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'shop_id' => $this->shop->id,
            ]);
            $this->isFavorited = true;
        }
    }

    public function render()
    {
        return view('livewire.toggle-favorite');
    }
}
