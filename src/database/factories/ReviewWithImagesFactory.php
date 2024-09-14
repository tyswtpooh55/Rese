<?php

namespace Database\Factories;

use App\Models\ReviewWithImages;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewWithImagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'admin')
                ->orWhere('name', 'manager');
        })->pluck('id')->toArray();


        do {
            $shopId = Shop::inRandomOrder()->first()->id;
            $userId = $this->faker->randomElement($userIds);
        } while (ReviewWithImages::where('shop_id', $shopId)->where('user_id', $userId)->exists());

        return [
            'shop_id' => $shopId,
            'user_id' => $userId,
            'rating' => $this->faker->numberBetween(1,5),
            'comment' => $this->faker->realText(400),
        ];
    }
}
