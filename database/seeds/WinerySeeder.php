<?php

use Illuminate\Database\Seeder;

class WinerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Entities\User::create([
            'name' => 'winery',
            'email' => 'winery@mail.com',
            'password' => 'pass',
        ]);

        $role = \Spatie\Permission\Models\Role::findByName('winery');

        $params = [
            'address' => 'Adresa 1',
            'open_hours' => '0-24',
            'lat' => '44.22',
            'long' => '44.55',
            'hr' => [
                'description' => 'Opis Hr'
            ],
            'en' => [
                'description' => 'Opis En'
            ]
        ];

        $restaurant = \App\Entities\Winery::create($params);

        $user->assignRole($role);

        $restaurant->user()->save($user);
    }
}
