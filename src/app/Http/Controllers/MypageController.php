<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $reservations = Reservation::where('user_id', $user->id)
            ->with('shop')
            ->get();

        $favorites = Favorite::where('user_id', $user->id)
            ->with('shop')
            ->get();

        $shops = Shop::with(['favorites' => function ($query) {
            $query->where('user_id', Auth::id());
        }])->get();

        return view('mypage', compact(
            'user',
            'reservations',
            'favorites',
            'shops',
        ));
    }

    public function deleteReservation($id)
    {
        Reservation::find($id)->delete();

        return back();
    }


}
