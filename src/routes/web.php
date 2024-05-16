<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MypageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ShopController::class, 'index']);
Route::post('/', [ShopController::class, 'index']);
Route::get('/detail/{id}', [ShopController::class, 'detail'])->name('shop.detail');

Route::middleware(['auth'])->group(function(){
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
    Route::post('/favorite/create/{id}', [FavoriteController::class, 'createFavorite'])->name('createFavorite');
    Route::post('/favorite/delete/{id}', [FavoriteController::class, 'deleteFavorite'])->name('deleteFavorite');
    Route::get('/done', function () {
        return view('done');
    })->name('done');
    Route::post('/deleteReservation/{id}', [MypageController::class, 'deleteReservation'])->name('deleteReservation');
    Route::get('/reservation/edit/{id}', [MypageController::class, 'editReservation'])->name('editReservation');
    Route::get('/thanks', function () {
        return view('auth/thanks');
    })->name('thanks');
});