<?php

use Illuminate\Database\Seeder;

class RestaurantOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order = \App\Entities\RestaurantOrder::create([
            'price' => 100,
            'status' => 'finished',
            'restaurant_id' => 1,
            'name' => 'Ime Prezime',
            'address' => 'Adresa 10, Osijek',
        ]);

        $order->foods()->attach([1,2]);

        $order = \App\Entities\RestaurantOrder::create([
            'price' => 200,
            'status' => 'pending',
            'restaurant_id' => 1,
            'name' => 'Ime Prezime',
            'address' => 'Adresa 10, Osijek',
        ]);

        $order->foods()->attach([2]);
    }
}
