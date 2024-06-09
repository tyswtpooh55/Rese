<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 過去のReservation取得
        $pastReservation = Reservation::where('date', '<', Carbon::today())
            ->inRandomOrder()
            ->first();

        if (!$pastReservation) {
            return [];
        }

        //一般ユーザーのID取得
        $userIds = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin')
            ->orWhere('name', 'manager');
        })->pluck('id')->toArray();

        return [
            'reservation_id' => $pastReservation->id,
            'shop_id' => $pastReservation->shop_id,
            'rating' => $this->faker->numberBetween(1,5),
            'comment' => $this->faker->realText(100),
        ];
    }
}
