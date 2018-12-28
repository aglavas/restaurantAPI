<?php

use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            'category_id' => 1,
            'restaurant_id' => 1,
            'price' => 11,
            'calories' => 111,
            'hr' => [
                'name' => 'Omlet hr',
                'description' => 'Opis hr'
            ],
            'en' => [
                'name' => 'Omlet en',
                'description' => 'Opis en'
            ]
        ];

        $food = \App\Entities\Food::create($params);

        $food->ingredients()->attach([1,2]);

        $params = [
            'category_id' => 2,
            'restaurant_id' => 1,
            'price' => 111,
            'calories' => 1211,
            'hr' => [
                'name' => 'Pire hr',
                'description' => 'Opis hr'
            ],
            'en' => [
                'name' => 'Pire en',
                'description' => 'Opis en'
            ]
        ];


        $food = \App\Entities\Food::create($params);

        $food->ingredients()->attach([1,2]);
    }
}
