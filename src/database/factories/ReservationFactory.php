<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //17:00-23:00の30分おきの時間を生成
        $times = [];
        for ($hour=17; $hour <= 22; $hour++) {
            $times[] = sprintf('%02d:00:00', $hour);
            $times[] = sprintf('%02d:30:00', $hour);
        }
        $times[] = '23:00:00';

        //一般ユーザーのID取得
        $userIds = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin')
            ->orWhere('name', 'manager');
        })->pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'date' => $this->faker->dateTimeBetween('2024-01-01', '2025-01-01')->format('Y-m-d'),
            'time' => $this->faker->randomElement($times),
            'number' => $this->faker->numberBetween(1,10),
        ];
    }
}
