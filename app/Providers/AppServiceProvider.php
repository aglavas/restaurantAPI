<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('restaurantImageExists', 'App\Validators\CustomValidator@restaurantImageExists');
        Validator::replacer('restaurantImageExists', 'App\Validators\CustomValidator@restaurantImageExistsReplacer');

        Validator::extend('wineryImageExists', 'App\Validators\CustomValidator@wineryImageExists');
        Validator::replacer('wineryImageExists', 'App\Validators\CustomValidator@wineryImageExistsReplacer');

        Validator::extend('imageExists', 'App\Validators\CustomValidator@imageExists');
        Validator::replacer('imageExists', 'App\Validators\CustomValidator@imageExistsReplacer');

        Validator::extend('existsWith', 'App\Validators\CustomValidator@existsWith');
        Validator::replacer('existsWith', 'App\Validators\CustomValidator@existsWithReplacer');

        Validator::extend('allowedInventory', 'App\Validators\CustomValidator@AllowedInventory');
        Validator::replacer('allowedInventory', 'App\Validators\CustomValidator@AllowedInventoryReplacer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
