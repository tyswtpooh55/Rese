<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ReviewRequest;
use App\Models\Course;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\ReviewWithImages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function detail($id)
    {
        // 飲食店詳細取得
        $shop = Shop::findOrFail($id);
        $shopName = $shop->name;

        $averageRating = $shop->reviewsWithImages()->avg('rating') ?? 0;
        $countRating = $shop->reviewsWithImages()->count();

        return view('detail', compact(
            'shop',
            'shopName',
            'averageRating',
            'countRating',
        ));
    }

    public function createReservation(ReservationRequest $request)
    {
        $courseUnselectedId = Course::where('price', 0)->first()->id;

        $reservingData = [
            'user_id' => Auth::id(),
            'shop_id' => $request->shop_id,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
            'course_id' => $request->course_id,
        ];

        //支払い不要の場合、予約を作成
        if ($request->course_id == $courseUnselectedId) {
            Reservation::create($reservingData);
            return view('done');
        } else {
            session(['reserving_data' => $reservingData]);
            return redirect()->route('checkout.index');
        }
    }

    // public function reviews($id)
    // {
    //     $shop = Shop::findOrFail($id);
    //     $reviews = $shop->reviews()
    //         ->with('reservation:id,date')
    //         ->select('reviews.id', 'comment', 'rating', 'reservation_id')
    //         ->get();

    //     return view('reviews', compact('shop', 'reviews'));
    // }

    public function allReviews($id)
    {
        $shop = Shop::findOrFail($id);
        $reviews = $shop->reviewsWithImages()
            ->get();

        return view('reviews', compact(
            'shop',
            'reviews',
        ));
    }

    public function reservationData($id)
    {
        $reservation = Reservation::findOrFail($id);

        return view("reservation_data", compact(
            'reservation'
        ));
    }

    //Proテスト
    public function aboutShop($id)
    {
        $user = Auth::user();
        $shop = Shop::findOrFail($id);

        $postedReview = null;

        if ($user) {
            $postedReview = ReviewWithImages::where('user_id', $user->id)
                ->where('shop_id', $id)
                ->first();
        }

        return view('about_shop', compact(
            'shop',
            'postedReview',
        ));
    }

    public function writeReview($id)
    {
        $shop = Shop::findOrFail($id);

        return view('write_comment', compact(
            'shop',
        ));
    }

    public function postReview(ReviewRequest $request)
    {
        $user = Auth::user();

        $review = ReviewWithImages::create([
            'shop_id' => $request->input('shop_id'),
            'user_id' => $user->id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        if ($request->hasFile('img_urls')) {
            foreach ($request->file('img_urls') as $img) {
                $path = $img->store('public/images/reviews');
                ReviewImage::create([
                    'review_id' => $review->id,
                    'img_url' => str_replace('public', '', $path),
                ]);
            }
        }

        return redirect()->route('shop.detail', ['shop_id' => $review->shop_id]);
    }

    public function editReview($review_id)
    {
        $review = ReviewWithImages::find($review_id);
        $shop = $review->shop;

        return view('write_comment', compact([
            'review',
            'shop',
        ]));
    }

    public function updateReview($review_id, ReviewRequest $request)
    {
        $review = ReviewWithImages::find($review_id);

        $review->update([
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        if ($request->hasFile('img_urls')) {
            foreach ($request->file('img_urls') as $img) {
                $path = $img->store('public/images/reviews');
                ReviewImage::create([
                    'review_id' => $review_id,
                    'img_url' => str_replace('public', '', $path),
                ]);
            }
        }

        return redirect()->route('shop.detail', ['shop_id' => $review->shop_id]);
    }

    public function deleteReview($review_id)
    {
        ReviewWithImages::find($review_id)->delete();

        return back();
    }
}
