<?php

use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
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
                'name' => 'Eggs hr'
            ],
            'en' => [
                'name' => 'Eggs en'
            ]
        ];

        \App\Entities\Ingredient::create($params);

        $params = [
            'hr' => [
                'name' => 'Flour hr'
            ],
            'en' => [
                'name' => 'Flour en'
            ]
        ];

        \App\Entities\Ingredient::create($params);
    }
}
