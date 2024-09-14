<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\S3Controller;
use App\Http\Controllers\StripeController;
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

//Proテスト～
Route::get('/about/{shop_id}', [ShopController::class, 'aboutShop'])->name('shop.detail');

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/post/review/{shop_id}', [ShopController::class, 'writeReview'])->name('write.review');
    Route::post('/post/review/{shop_id}', [ShopController::class, 'postReview'])->name('post.review');
    Route::get('/edit/review/{review_id}', [ShopController::class, 'editReview'])->name('edit.review');
    Route::post('edit/review/{review_id}', [ShopController::class, 'updateReview'])->name('update.review');
    Route::post('/delete/review/{review_id}', [ShopController::class, 'deleteReview'])->name('delete.review');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('admin/add/shop', [AdminController::class, 'addShop'])->name('admin.add.shop');
        Route::post('admin/add/shop/check', [AdminController::class, 'checkCsv'])->name('admin.check.csv');
        Route::post('/admin/add/shop', [AdminController::class, 'importCsv'])->name('admin.import.csv');
    });
});

Route::get('/all/reviews/{shop_id}', [ShopController::class, 'allReviews'])->name('all.reviews');


//～Proテスト

// 非会員含め
Route::get('/', [ShopController::class, 'index']);
// Route::get('/detail/{id}', [ShopController::class, 'detail'])->name('shop.detail');
// Route::get('/detail/reviews/{shop_id}', [ShopController::class,  'reviews'])->name('reviews');
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
    Route::get('/thanks', function () {
        return view('/auth/thanks');
    })->name('thanks');
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
    Route::post('/reservation/create', [ShopController::class, 'createReservation'])->name('createReservation');
    Route::post('/reservation/delete/{id}', [MypageController::class, 'deleteReservation'])->name('deleteReservation');
    Route::get('/reservation/edit/{id}', [MypageController::class, 'editReservation'])->name('editReservation');
    Route::post('/reservation/update/{id}', [MypageController::class, 'updateReservation'])->name('updateReservation');
    Route::get('/mypage/visited', [MypageController::class, 'visitedShop'])->name('visitedShop');
    Route::get('/comment/{id}', [MypageController::class, 'comment'])->name('comment');
    Route::post('/review/create', [MypageController::class, 'writeReview'])->name('writeReview');
    Route::get('/reservation/qr/{id}', [MypageController::class, 'qrCode'])->name('reservationQr');
    //StripeCheckout
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/index', [StripeController::class, 'index'])->name('index');
        Route::post('/session', [StripeController::class, 'checkout'])->name('session');
        Route::get('/done', [StripeController::class, 'paid'])->name('paid');
        Route::get('/failed', [StripeController::class, 'failed'])->name('failed');
    });
});

// 管理者用ルートグループ
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/managers', [AdminController::class, 'viewManagers'])->name('viewManagers');
    Route::post('/manager/create', [AdminController::class, 'createManager'])->name('createManager');
    Route::post('/manager/delete', [AdminController::class, 'deleteManager'])->name('deleteManager');
    Route::get('/email', [AdminController::class, 'writeEmail'])->name('writeEmail');
    Route::post('/email/send', [AdminController::class, 'sendEmail'])->name('sendEmail');
});

// 店舗責任者用ルートグループ
if (app()->environment(['local'])) {
    $managerController = ManagerController::class;
} else {
    $managerController = S3Controller::class;
}
Route::prefix('manager')->name('manager.')->middleware(['auth', 'role:manager'])->group(function () use($managerController) {
    Route::get('/select/{action}', [ManagerController::class, 'selectShop'])->name('selectShop');
    Route::get('/add', [$managerController, 'addShop'])->name('addShop');
    Route::post('/create', [$managerController, 'createShop'])->name('createShop');
    Route::middleware('check.shop')->group(function() use($managerController) {
        Route::get('/reservations/{shop}', [ManagerController::class, 'viewReservations'])->name('viewReservations');
        Route::get('/detail/{shop}', [$managerController, 'editDetail'])->name('editDetail');
        Route::post('/update/{shop}', [$managerController, 'updateDetail'])->name('updateDetail');
    });
});
