<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $oneHourBefore = Carbon::now()->subHour();
        $oneHourAfter = Carbon::now()->addHour();

        $reservations = Reservation::where('user_id', $user->id)
            ->with('shop')
            ->get();

        $displayReservations = $reservations->filter(function ($reservation) use ($oneHourBefore) {
            $reservationDateTime = Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
            return $reservationDateTime->greaterThan($oneHourBefore);
        })->sortBy(function ($reservation) {
            return Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
        });


        $favorites = Favorite::where('user_id', $user->id)
            ->with('shop')
            ->get();

        return view('mypage', compact(
            'user',
            'displayReservations',
            'favorites',
        ));
    }

    public function deleteReservation($id)
    {
        Reservation::find($id)->delete();

        return back();
    }

    public function editReservation($id)
    {
        $reservation = Reservation::findOrFail($id);

        $shop = Shop::findOrFail($reservation->shop_id);

        $shopName = $shop->name;

        return view('edit', compact(
            'shop',
            'shopName',
            'reservation',
        ));
    }

    public function visitedShop()
    {
        $user = Auth::user();
        $oneHourBefore = Carbon::now()->subHour();

        $reservations = Reservation::where('user_id', $user->id)
            ->with('shop')
            ->get();

        $pastReservations = $reservations->filter(function ($reservation) use ($oneHourBefore) {
            $reservationDateTime = Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
            return $reservationDateTime->lessThan($oneHourBefore);
        })->sortBy(function ($reservation) {
            return Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
        });


        return view('visited_shop', compact(
            'pastReservations'
        ));
    }

    public function comment($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        return view('comment', compact(
            'reservation',
        ));
    }

    public function createComment(Request $request)
    {
        $reservation = Reservation::find($request->input('reservation_id'));
        Comment::create([
            'reservation_id' =>  $request->input('reservation_id'),
            'shop_id' => $reservation->shop_id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('mypage.index');
    }

    public function qrCode($id)
    {
        $reservation = Reservation::findOrFail($id);

        return view('qr_code', compact(
            'reservation'
        ));
    }
}
