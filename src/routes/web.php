<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MypageController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
Route::get('/detail/reviews/{id}', [ShopController::class,  'reviews'])->name('reviews');
Route::get('/thanks', function () {
        return view('auth/thanks');
    })->name('thanks');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/mypage');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証リンクを送信しました');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
    Route::post('/favorite/create/{id}', [FavoriteController::class, 'createFavorite'])->name('createFavorite');
    Route::post('/favorite/delete/{id}', [FavoriteController::class, 'deleteFavorite'])->name('deleteFavorite');
    Route::get('/done', function () {
        return view('done');
    })->name('done');
    Route::post('/deleteReservation/{id}', [MypageController::class, 'deleteReservation'])->name('deleteReservation');
    Route::get('/reservation/edit/{id}', [MypageController::class, 'editReservation'])->name('editReservation');
    Route::get('/mypage/visited', [MypageController::class, 'visitedShop'])->name('visitedShop');
    Route::get('/comment/{id}', [MypageController::class, 'comment'])->name('comment');
    Route::post('/createComment', [MypageController::class, 'createComment'])->name('createComment');
});