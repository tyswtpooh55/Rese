<?php

namespace App\Http\Livewire;

use App\Models\Favorite;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShopList extends Component
{
    public $shops;

    protected $listeners = ['sortAndSearch'];

    public function mount()
    {
        $this->sortAndSearch();
    }

    public function sortAndSearch($criteria = null)
    {
        $query = Shop::with([
            'area',
            'genre',
            'favorites' => function ($query) {
                $query->where('user_id', Auth::id());
            },
            'reviewsWithImages',
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

            switch ($criteria['sort']) {
                case 'random':
                    $query->inRandomOrder();
                    break;
                case 'high-rating':
                    $query->withAvg('reviewsWithImages', 'rating')
                        ->orderByRaw('COALESCE(reviews_with_images_avg_rating, 0) DESC');
                    break;
                case 'low-rating':
                    $query->withAvg('reviewsWithImages', 'rating')
                        ->orderByRaw('COALESCE(reviews_with_images_avg_rating, 10) ASC');
                    break;
            }
        }

        $this->shops = $query->get()->map(function ($shop) {
            $shop->isFavorited = $shop->favorites->isNotEmpty();
            $shop->averageRating = $shop->reviewsWithImages->avg('rating') ?? 0;
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
