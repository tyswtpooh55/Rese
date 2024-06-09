<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 過去のReservationの数をカウント
        $countPastReservations = Reservation::where('date', '<', today())->count();

        if ($countPastReservations === 0) {
            return;
        }

        $reviewToCreate = intval($countPastReservations * 0.8);

        Review::factory()->count($reviewToCreate)->create();
    }
}
