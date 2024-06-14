<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
/*    public function __construct()
    {
        $this->middleware('permission:edit shop')->only(['editDetail', 'updateDetail']);
        $this->middleware('permission:create shop')->only(['addShop', 'createShop']);
        $this->middleware('permission:check reservations')->only('viewReservations');
    }*/

    public function selectShop($action)
    {
        $user = Auth::user();
        $shops = $user->shops;

        return view('manager/select_shop', [
            'shops' => $shops,
            'action' => $action,
        ]);
    }

    public function viewReservations(Request $request, Shop $shop)
    {
        $thisDate = $request->query('date') ? new Carbon($request->query('date')) : Carbon::today();
        $prevDate = $thisDate->copy()->subDay();
        $nextDate = $thisDate->copy()->addDay();

        $shopReservations = Reservation::where('shop_id', $shop->id);
        $thisDateReservations = $shopReservations
            ->whereDate('date', $thisDate->toDateString())
            ->orderBy('time')
            ->get();

        return view('manager/view_reservations', compact(
            'shop',
            'thisDate',
            'prevDate',
            'nextDate',
            'thisDateReservations'
        ));
    }

    public function editDetail(Shop $shop)
    {
        $areas = Area::all();
        $genres = Genre::all();
        $storageImages = Storage::files('public/images');

        return view('manager/edit_shop_detail', compact(
            'shop',
            'areas',
            'genres',
            'storageImages',
        ));
    }

    public function updateDetail(ShopRequest $request, Shop $shop)
    {
        $shop = $request->shop;

        if ($request->hasFile('upload_image')) {
            $path = $request->file('upload_image')->store('public/images');
            $shop->image_path = str_replace('public', '', $path);
        } else {
            $imagePath = $request->input('image_path');
            if ($imagePath) {
                $shop->image_path = str_replace('public', '', $imagePath);
            }
        }

        $shop->name = $request->input('name');
        $shop->area_id = $request->input('area_id');
        $shop->genre_id = $request->input('genre_id');
        $shop->detail = $request->input('detail');
        $shop->save();

        return redirect()->back();
    }

    public function addShop()
    {
        $areas = Area::all();
        $genres = Genre::all();
        $storageImages = Storage::files('public/images');

        return view('manager/add_shop', compact(
            'areas',
            'genres',
            'storageImages',
        ));
    }

    public function createShop(ShopRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('upload_image')) {
            $path = $request->file('upload_image')->store('public/images');
            $data['image_path'] = $path;
        }

        $data['image_path'] = str_replace('public', '', $data['image_path']);

        $shop = Shop::create($data);

        $user = Auth::user();

        DB::table('shop_user')->insert([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);

        return redirect('/');
    }
}
