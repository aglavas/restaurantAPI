<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Restaurant;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

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

    /**
     * Determine whether the user can upload restaurant avatar
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return bool
     */
    public function uploadAvatar(User $user, Restaurant $restaurant)
    {
        return $user->userable_id === $restaurant->id;
    }

    /**
     * Determine whether the user can upload restaurant image
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return bool
     */
    public function uploadImage(User $user, Restaurant $restaurant)
    {
        return $user->userable_id === $restaurant->id;
    }

    /**
     * Determine whether the user can delete restaurant image
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return bool
     */
    public function deleteImage(User $user, Restaurant $restaurant)
    {
        return $user->userable_id === $restaurant->id;
    }

    /**
     * Determine whether the user can attach restaurant categories
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return bool
     */
    public function attach(User $user, Restaurant $restaurant)
    {
        $request = Request::capture();

        $restaurant_id = $request->input('restaurant_id');

        return $user->userable_id === (int)$restaurant_id;
    }

    /**
     * Determine whether the user can attach restaurant inventory
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return bool
     */
    public function attachInventory(User $user, Restaurant $restaurant)
    {
        $request = Request::capture();

        $restaurant_id = $request->input('restaurant_id');

        return $user->userable_id === (int)$restaurant_id;
    }

    /**
     * Determine whether the user can sync restaurant inventory
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return bool
     */
    public function syncInventory(User $user, Restaurant $restaurant)
    {
        $request = Request::capture();

        $restaurant_id = $request->input('restaurant_id');

        return $user->userable_id === (int)$restaurant_id;
    }

}
