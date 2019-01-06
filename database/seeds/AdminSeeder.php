<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = \Spatie\Permission\Models\Role::findByName('admin');

        $admin = \App\Entities\User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'pass',
        ]);

        $admin->assignRole($role);
    }
}
