<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            [
                'name' => '来店時に注文',
                'description' => '来店時にご注文',
                'price' => 0,
            ],
            [
                'name' => '松',
                'description' => '最高級コースの料理',
                'price' => 10000,
            ],
            [
                'name' => '竹',
                'description' => '中級コースの料理',
                'price' => 6000,
            ],
            [
                'name' => '梅',
                'description' => '基本のコース料理',
                'price' => 4000,
            ],
        ]);
    }
}
