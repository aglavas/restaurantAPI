<?php

use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Entities\User::create([
            'name' => 'restaurant',
            'email' => 'restaurant@mail.com',
            'password' => 'pass',
        ]);

        $role = \Spatie\Permission\Models\Role::findByName('restaurant');

        $params = [
            'address' => 'Adresa 1',
            'open_hours' => '0-24',
            'delivery' => '1',
            'delivery_price' => '44',
            'lat' => '44.22',
            'long' => '44.55',
            'hr' => [
                'description' => 'Opis Hr'
            ],
            'en' => [
                'description' => 'Opis En'
            ]
        ];

        $restaurant = \App\Entities\Restaurant::create($params);

        $user->assignRole($role);

        $restaurant->user()->save($user);
    }
}
