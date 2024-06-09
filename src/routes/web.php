<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MypageController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;

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

// 非会員含め
Route::get('/', [ShopController::class, 'index']);
Route::post('/', [ShopController::class, 'index']);
Route::get('/detail/{id}', [ShopController::class, 'detail'])->name('shop.detail');
Route::get('/detail/reviews/{id}', [ShopController::class,  'reviews'])->name('reviews');
Route::get('/thanks', function () {
        return view('/auth/thanks');
    })->name('thanks');
Route::get('/reservation/data/{id}', [ShopController::class, 'reservationData'])->name('reservationData');

// メール認証
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証リンクを送信しました');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// 会員・ログイン済み
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
    Route::post('/favorite/create/{id}', [FavoriteController::class, 'createFavorite'])->name('createFavorite');
    Route::post('/favorite/delete/{id}', [FavoriteController::class, 'deleteFavorite'])->name('deleteFavorite');
    Route::get('/done', function () {
        return view('done');
    })->name('done');
    Route::post('/reservation/delete/{id}', [MypageController::class, 'deleteReservation'])->name('deleteReservation');
    Route::get('/reservation/edit/{id}', [MypageController::class, 'editReservation'])->name('editReservation');
    Route::get('/mypage/visited', [MypageController::class, 'visitedShop'])->name('visitedShop');
    Route::get('/comment/{id}', [MypageController::class, 'comment'])->name('comment');
    Route::post('/createComment', [MypageController::class, 'createComment'])->name('createComment');
    Route::get('/reservation/qr/{id}', [MypageController::class, 'qrCode'])->name('reservationQr');
});

// 管理者用ルートグループ
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/manager', [AdminController::class, 'viewManagers'])->name('viewManagers');
    Route::post('/manager/create', [AdminController::class, 'createManager'])->name('createManager');
    Route::post('/manager/delete', [AdminController::class, 'deleteManager'])->name('deleteManager');
    Route::get('/email', [AdminController::class, 'writeEmail'])->name('writeEmail');
    Route::post('/email/send', [AdminController::class, 'sendEmail'])->name('sendEmail');
});

// 店舗責任者用ルートグループ
Route::prefix('manager')->name('manager.')->middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/select/{action}', [ManagerController::class, 'selectShop'])->name('selectShop');
    Route::get('/add', [ManagerController::class, 'addShop'])->name('addShop');
    Route::post('/create', [ManagerController::class, 'createShop'])->name('createShop');
    Route::middleware('check.shop')->group(function() {
        Route::get('/reservations/{shop}', [ManagerController::class, 'viewReservations'])->name('viewReservations');
        Route::get('/detail/{shop}', [ManagerController::class, 'editDetail'])->name('editDetail');
        Route::post('/update/{shop}', [ManagerController::class, 'updateDetail'])->name('updateDetail');
    });
});
