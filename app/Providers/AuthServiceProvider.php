<?php

namespace App\Providers;

use App\Entities\Food;
use App\Entities\FoodAddition;
use App\Entities\FoodCategory;
use App\Entities\Restaurant;
use App\Entities\Winery;
use App\Policies\FoodAdditionPolicy;
use App\Policies\FoodCategoryPolicy;
use App\Policies\FoodPolicy;
use App\Policies\RestaurantPolicy;
use App\Policies\WineryPolicy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Restaurant::class => RestaurantPolicy::class,
        Winery::class => WineryPolicy::class,
        Food::class => FoodPolicy::class,
        FoodCategory::class => FoodCategoryPolicy::class,
        FoodAddition::class => FoodAdditionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::tokensExpireIn(Carbon::now()->addDays(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(60));
        //

        // Implicitly grant "Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });
    }
}
