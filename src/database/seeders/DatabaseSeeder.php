<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AreasTableSeeder::class,
            GenresTableSeeder::class,
            ShopsTableSeeder::class,
            MasterDatabaseSeeder::class,
            ReservationsTableSeeder::class,
            FavoritesTableSeeder::class,
            CommentsTableSeeder::class,
        ]);
    }
}
