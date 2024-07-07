<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class S3Controller extends Controller
{
    public function editDetail(Shop $shop)
    {
        $areas = Area::all();
        $genres = Genre::all();
        $storageImages = Storage::files('images');

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
            $path = $request->file('upload_image')->store('images');
            $shop->image_path = $path;
        } else {
            $shop->image_path = $request->input('image_path');
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
        $storageImages = Storage::files('images');

        return view('manager/add_shop', compact(
            'areas',
            'genres',
            'storageImages',
        ));
    }

    public function createShop(ShopRequest $request)
    {
        if ($request->area_id == 'new') {
            $area = Area::create(['name' => $request->newArea]);
            $request->merge(['area_id' => $area->id]);
        }

        if ($request->genre_id == 'new') {
            $genre = Genre::create(['name' => $request->newGenre]);
            $request->merge(['genre_id' => $genre->id]);
        }

        $data = $request->all();

        if ($request->hasFile('upload_image')) {
            $path = $request->file('upload_image')->store('images');
            $data['image_path'] = $path;
        }

        $shop = Shop::create($data);

        $user = Auth::user();

        DB::table('shop_user')->insert([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
        ]);

        return redirect('/');
    }
}
