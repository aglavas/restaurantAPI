<?php

use Illuminate\Database\Seeder;

class RestaurantCategoryInventorySeeder extends Seeder
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
                'title' => 'Pizze Hr'
            ],
            'en' => [
                'title' => 'Pizze En'
            ],
            'de' => [
                'title' => 'Pizze De'
            ]
        ];

        \App\Entities\RestaurantInventoryCategory::create($params);

        $params = [
            'hr' => [
                'title' => 'Grill Hr'
            ],
            'en' => [
                'title' => 'Grill En'
            ],
            'de' => [
                'title' => 'Grill De'
            ]
        ];

        \App\Entities\RestaurantInventoryCategory::create($params);

        $params = [
            'hr' => [
                'title' => 'Pivo Hr'
            ],
            'en' => [
                'title' => 'Pivo En'
            ],
            'de' => [
                'title' => 'Pivo De'
            ]
        ];

        \App\Entities\RestaurantInventoryCategory::create($params);

        $params = [
            'hr' => [
                'title' => 'Salata Hr'
            ],
            'en' => [
                'title' => 'Salata En'
            ],
            'de' => [
                'title' => 'Salata De'
            ]
        ];

        \App\Entities\RestaurantInventoryCategory::create($params);

        $params = [
            'hr' => [
                'title' => 'Smoothie Hr'
            ],
            'en' => [
                'title' => 'Smoothie En'
            ],
            'de' => [
                'title' => 'Smoothie De'
            ]
        ];

        \App\Entities\RestaurantInventoryCategory::create($params);
    }
}
