<?php

use Illuminate\Database\Seeder;

class RestaurantCategorySeeder extends Seeder
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
                'title' => 'Pizzerija Hr'
            ],
            'en' => [
                'title' => 'Pizzerija En'
            ],
            'de' => [
                'title' => 'Pizzerija En'
            ]
        ];

        \App\Entities\RestaurantCategory::create($params);

        $params = [
            'hr' => [
                'title' => 'Vege bar Hr'
            ],
            'en' => [
                'title' => 'Vege bar En'
            ],
            'de' => [
                'title' => 'Vege bar De'
            ]
        ];

        \App\Entities\RestaurantCategory::create($params);
    }
}
