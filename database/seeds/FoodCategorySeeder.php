<?php

use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            'hr' => [
                'title' => 'Pasta Hr'
            ],
            'en' => [
                'title' => 'Pasta En'
            ],
            'restaurant_id' => 1
        ];

        \App\Entities\FoodCategory::create($params);

        $params = [
            'hr' => [
                'title' => 'Pizza Hr'
            ],
            'en' => [
                'title' => 'Pizza En'
            ],
            'restaurant_id' => 1
        ];

        \App\Entities\FoodCategory::create($params);
    }
}
