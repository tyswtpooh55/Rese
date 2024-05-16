<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['createFavorite', 'deleteFavorite']);
    }

    public function createFavorite($id)
    {
        Favorite::create([
            'shop_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back();
    }

    public function deleteFavorite($id)
    {
        $favorite = Favorite::where('shop_id', $id)->where('user_id', Auth::id())->first();
        $favorite->delete();

        return redirect()->back();
    }
}
