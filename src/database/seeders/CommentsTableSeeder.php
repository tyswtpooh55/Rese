<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 過去のReservationの数をカウント
        $countPastReservations = Reservation::where('reservation_date', '<', today())->count();

        if ($countPastReservations === 0) {
            return;
        }

        $commentsToCreate = intval($countPastReservations * 0.8);

        Comment::factory()->count($commentsToCreate)->create();
    }
}
