<?php

use Illuminate\Database\Seeder;

class RestaurantCategoriesConnectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurantCategory = \App\Entities\RestaurantCategory::find(1);
        $restaurantCategory->inventoryCategory()->attach([1,2,3]);

        $restaurantCategory = \App\Entities\RestaurantCategory::find(2);
        $restaurantCategory->inventoryCategory()->attach([4,5]);
    }
}
