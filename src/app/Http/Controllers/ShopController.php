<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index()
    {
        return view('index');
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
