<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Reservation;
use App\Models\Shop;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function index()
    {
        $reservingData = session('reserving_data');

        $shop = Shop::find($reservingData['shop_id']);
        $course = Course::find($reservingData['course_id']);

        $amount = $course->price * $reservingData['number'];

        return view('checkout/index', compact(
            'reservingData',
            'shop',
            'course',
            'amount',
        ));
    }

    public function checkout()
    {
        $reservingData = session('reserving_data');

        $course = Course::find($reservingData['course_id']);

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $course->name,
                        'description' => $course->description,
                    ],
                    'unit_amount' => $course->price,
                ],
                'quantity' => $reservingData['number'],
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.paid'),
            'cancel_url' => route('checkout.failed'),
        ]);

        return redirect($session->url);
    }

    public function paid()
    {
        $reservingData = session('reserving_data');

        if ($reservingData) {
            Reservation::create($reservingData);

            session()->forget('reserving_data');
        }
        return view('done');
    }

    public function failed()
    {
        session()->forget('reserving_data');
        return view('checkout/failed');
    }
}
