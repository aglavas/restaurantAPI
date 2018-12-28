<?php

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
        \Illuminate\Database\Eloquent\Model::reguard();

        $this->call(AdminSeeder::class);
        $this->call(RestaurantSeeder::class);
        $this->call(FoodCategorySeeder::class);
        $this->call(FoodAdditionSeeder::class);
        $this->call(IngredientSeeder::class);
        $this->call(FoodSeeder::class);
    }
}
