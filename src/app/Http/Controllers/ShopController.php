<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // 検索
        $areas = Area::all();
        $genres = Genre::all();

        // 検索条件のセットアップ
        $searchQuery = Shop::with(['area', 'genre', 'favorites' => function ($query) {
            $query->where('user_id', Auth::id());
        }]);

        if (!empty($request->area_id)) {
            $searchQuery->where('area_id', $request->area_id);
        }
        if (!empty($request->genre_id)) {
            $searchQuery->where('genre_id', $request->genre_id);
        }
        if (!empty($request->keyword)) {
            $searchQuery->where('name', 'LIKE', "%{$request->keyword}%");
        }
        // 検索結果
        $shops = $searchQuery->get()->map(function ($shop) {
            $shop->isFavorited =$shop->favorites->isNotEmpty();
            $shop->averageRating = $shop->reviews->avg('rating') ?? 0;
            return $shop;

        });

        return view('index', compact(
            'shops',
            'areas',
            'genres',
        ));
    }

    public function detail($id)
    {
        // 飲食店詳細取得
        $shop = Shop::findOrFail($id);
        $shopName = $shop->name;

        $averageRating = $shop->reviews()->avg('rating') ?? 0;
        $countRating = $shop->reviews()->count();

        return view('detail', compact(
            'shop',
            'shopName',
            'averageRating',
            'countRating',
        ));
    }

    public function createReservation(ReservationRequest $request)
    {
        Reservation::create([
            'user_id' => Auth::id(),
            'shop_id' => $request->shop_id,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
        ]);

        return view('done');
    }

    public function reviews($id)
    {
        $shop = Shop::findOrFail($id);
        $reviews = $shop->reviews()
            ->with('reservation:id,date')
            ->select('id', 'comment', 'rating', 'reservation_id')
            ->get();

        return view('reviews', compact('shop', 'reviews'));
    }

    public function reservationData($id)
    {
        $reservation = Reservation::findOrFail($id);

        return view("reservation_data", compact(
            'reservation'
        ));
    }
}
