<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 過去のReservation取得
        $pastReservation = Reservation::where('reservation_date', '<', Carbon::today())
            ->inRandomOrder()
            ->first();

        if (!$pastReservation) {
            return [];
        }
        return [
            'reservation_id' => $pastReservation->id,
            'shop_id' => $pastReservation->shop_id,
            'rating' => $this->faker->numberBetween(1,5),
            'comment' => $this->faker->realText(100),
        ];
    }
}
