<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin')
                ->orWhere('name', 'shop_manager');
        })->pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'shop_id' => Shop::inRandomOrder()->first()->id,
        ];
    }
}
