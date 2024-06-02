<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function viewReservations(Request $request, Shop $shop)
    {
        $thisDate = $request->query('date') ? new Carbon($request->query('date')) : Carbon::today();
        $prevDate = $thisDate->copy()->subDay();
        $nextDate = $thisDate->copy()->addDay();

        //担当しているすべての店舗を取得
        $manager = Auth::user();
        $managedShops = $manager->shops;

        $shopReservations = Reservation::where('shop_id', $shop->id);
        $thisDateReservations = $shopReservations
            ->whereDate('reservation_date', $thisDate->toDateString())
            ->orderBy('reservation_time')
            ->get();

        return view('manager/view_reservations', compact(
        'shop',
        'thisDate',
        'prevDate',
        'nextDate',
        'managedShops',
        'thisDateReservations'));
    }

    public function editDetail(Shop $shop)
    {
        //担当しているすべての店舗を取得
        $manager = Auth::user();
        $managedShops = $manager->shops;

        $areas = Area::all();
        $genres = Genre::all();

        return view('manager/edit_shop_detail',compact(
            'managedShops',
            'shop',
            'areas',
            'genres',
        ));
    }

    public function updateDetail(Request $request, Shop $shop)
    {
        $shop->name = $request->input('name');
        $shop->area_id = $request->input('area_id');
        $shop->genre_id = $request->input('genre_id');
        $shop->detail = $request->input('shop_detail');
        $shop->save();

        return redirect()->back();
    }
}
