<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // restaurant
        Permission::create(['name' => 'create-restaurant']);
        Permission::create(['name' => 'update-restaurant']);
        Permission::create(['name' => 'destroy-restaurant']);
        Permission::create(['name' => 'show-restaurant']);
        Permission::create(['name' => 'list-restaurant']);
        Permission::create(['name' => 'upload-avatar-restaurant']);
        Permission::create(['name' => 'upload-image-restaurant']);
        Permission::create(['name' => 'destroy-image-restaurant']);
        Permission::create(['name' => 'attach-restaurant-category-to-restaurant']);
        Permission::create(['name' => 'sync-restaurant-category-to-restaurant']);
        Permission::create(['name' => 'get-menu-restaurant']);

        Permission::create(['name' => 'create-food']);
        Permission::create(['name' => 'update-food']);
        Permission::create(['name' => 'destroy-food']);
        Permission::create(['name' => 'show-food']);
        Permission::create(['name' => 'list-food']);
        Permission::create(['name' => 'upload-image-food']);
        Permission::create(['name' => 'delete-image-food']);

        Permission::create(['name' => 'create-food-category']);
        Permission::create(['name' => 'update-food-category']);
        Permission::create(['name' => 'destroy-food-category']);
        Permission::create(['name' => 'show-food-category']);
        Permission::create(['name' => 'list-food-category']);

        Permission::create(['name' => 'create-food-addition']);
        Permission::create(['name' => 'update-food-addition']);
        Permission::create(['name' => 'destroy-food-addition']);
        Permission::create(['name' => 'show-food-addition']);
        Permission::create(['name' => 'list-food-addition']);

        Permission::create(['name' => 'create-restaurant-category']);
        Permission::create(['name' => 'update-restaurant-category']);
        Permission::create(['name' => 'destroy-restaurant-category']);
        Permission::create(['name' => 'show-restaurant-category']);
        Permission::create(['name' => 'list-restaurant-category']);
        Permission::create(['name' => 'attach-restaurant-category']);
        Permission::create(['name' => 'sync-restaurant-category']);

        Permission::create(['name' => 'create-restaurant-inventory-category']);
        Permission::create(['name' => 'update-restaurant-inventory-category']);
        Permission::create(['name' => 'destroy-restaurant-inventory-category']);
        Permission::create(['name' => 'show-restaurant-inventory-category']);
        Permission::create(['name' => 'list-restaurant-inventory-category']);
        Permission::create(['name' => 'upload-avatar-restaurant-inventory-category']);

        Permission::create(['name' => 'create-ingredient']);
        Permission::create(['name' => 'update-ingredient']);
        Permission::create(['name' => 'destroy-ingredient']);
        Permission::create(['name' => 'show-ingredient']);
        Permission::create(['name' => 'list-ingredients']);

        //@todo

        Permission::create(['name' => 'list-restaurant-orders']);

        Permission::create(['name' => 'list-users']);


        $restaurantRole = \Spatie\Permission\Models\Role::create(['name' => 'restaurant']);
        $restaurantRole->givePermissionTo(
            'update-restaurant',
            'destroy-restaurant',
            'show-restaurant',
            'upload-avatar-restaurant',
            'upload-image-restaurant',
            'destroy-image-restaurant',
            'attach-restaurant-category',
            'sync-restaurant-category',
            'get-menu-restaurant',
            'create-food',
            'update-food',
            'destroy-food',
            'show-food',
            'list-food',
            'upload-image-food',
            'delete-image-food',
            'create-food-category',
            'update-food-category',
            'destroy-food-category',
            'show-food-category',
            'list-food-category',
            'create-food-addition',
            'update-food-addition',
            'destroy-food-addition',
            'show-food-addition',
            'list-food-addition',
            'list-restaurant-orders', //for orders
            'create-ingredient',
            'update-ingredient',
            'destroy-ingredient',
            'show-ingredient',
            'list-ingredients',
            'show-restaurant-category',
            'list-restaurant-category'
        );

        // winery permissions
        Permission::create(['name' => 'create-winery']);
        Permission::create(['name' => 'update-winery']);
        Permission::create(['name' => 'destroy-winery']);
        Permission::create(['name' => 'show-winery']);
        Permission::create(['name' => 'list-winery']);
        Permission::create(['name' => 'upload-avatar-winery']);
        Permission::create(['name' => 'upload-image-winery']);
        Permission::create(['name' => 'destroy-image-winery']);
        Permission::create(['name' => 'get-inventory-winery']);

        $wineryRole = \Spatie\Permission\Models\Role::create(['name' => 'winery']);
        $wineryRole->givePermissionTo(
            'update-winery',
            'destroy-winery',
            'show-winery',
            'upload-avatar-winery',
            'upload-image-winery',
            'destroy-image-winery',
            'get-inventory-winery'
        );

        //Blog

        Permission::create(['name' => 'create-blog']);
        Permission::create(['name' => 'update-blog']);
        Permission::create(['name' => 'show-blog']);
        Permission::create(['name' => 'list-blog']);
        Permission::create(['name' => 'destroy-blog']);
        Permission::create(['name' => 'upload-image-blog']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());
    }
}
