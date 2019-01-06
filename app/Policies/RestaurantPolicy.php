<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Restaurant;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the restaurant.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return bool
     */
    public function view(User $user, Restaurant $restaurant)
    {
        return $user->userable_id === $restaurant->id;
    }

    /**
     * Determine whether the user can delete the restaurant.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return bool
     */
    public function viewMenu(User $user, Restaurant $restaurant)
    {
        return $user->userable_id === $restaurant->id;
    }

    /**
     * Determine whether the user can update the restaurant.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return bool
     */
    public function update(User $user, Restaurant $restaurant)
    {
        return $user->userable_id === $restaurant->id;
    }

    /**
     * Determine whether the user can delete the restaurant.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return bool
     */
    public function delete(User $user, Restaurant $restaurant)
    {
        return $user->userable_id === $restaurant->id;
    }
}
