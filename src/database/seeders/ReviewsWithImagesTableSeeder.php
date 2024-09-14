<?php

namespace Database\Seeders;

use App\Models\ReviewWithImages;
use Illuminate\Database\Seeder;

class ReviewsWithImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReviewWithImages::factory()->count(50)->create();
    }
}
