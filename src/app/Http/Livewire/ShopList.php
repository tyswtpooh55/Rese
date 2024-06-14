<?php

namespace App\Http\Livewire;

use App\Models\Favorite;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShopList extends Component
{
    public $shops;

    protected $listeners = ['search'];

    public function mount()
    {
        $this->search();
    }

    public function search($criteria = null)
    {
        $query = Shop::with([
            'area',
            'genre',
            'favorites' => function ($query) {
                $query->where('user_id', Auth::id());
            }
        ]);

        if ($criteria) {
            if (!empty($criteria['area_id'])) {
                $query->where('area_id', $criteria['area_id']);
            }
            if (!empty($criteria['genre_id'])) {
                $query->where('genre_id', $criteria['genre_id']);
            }
            if (!empty($criteria['keyword'])) {
                $query->where('name', 'LIKE', "%{$criteria['keyword']}%");
            }
        }

        $this->shops = $query->get()->map(function ($shop) {
            $shop->isFavorited = $shop->favorites->isNotEmpty();
            $shop->averageRating = $shop->reviews->avg('rating') ?? 0;
            return $shop;
        });
    }

    public function toggleFavorite($shopId)
    {
        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('shop_id', $shopId)
            ->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'shop_id' => $shopId,
            ]);
        }

        $this->search();

    }

    public function render()
    {
        return view('livewire.shop-list');
    }
}
