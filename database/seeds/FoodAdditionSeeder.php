<?php

use Illuminate\Database\Seeder;

class FoodAdditionSeeder extends Seeder
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
                'title' => 'Kechup Hr'
            ],
            'en' => [
                'title' => 'Kechup En'
            ],
            'price' => 5,
            'category_id' => 1
        ];

        \App\Entities\FoodAddition::create($params);

        $params = [
            'hr' => [
                'title' => 'Majonez Hr'
            ],
            'en' => [
                'title' => 'Majonez En'
            ],
            'price' => 6,
            'category_id' => 1
        ];

        \App\Entities\FoodAddition::create($params);
    }
}
