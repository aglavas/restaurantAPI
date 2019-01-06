<?php

namespace App\Policies;

use App\Entities\Food;
use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;


class FoodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the food.
     *
     * @param User $user
     * @param Food $food
     * @return bool
     */
    public function view(User $user, Food $food)
    {
        return $user->userable_id === $food->restaurant_id;
    }

    /**
     * Determine whether the user can view the food.
     *
     * @param User $user
     * @param Food $food
     * @return bool
     */
    public function list(User $user, Food $food)
    {
        $request = Request::capture();

        $restaurant_id = $request->input('restaurant_id');

        return $user->userable_id === (int)$restaurant_id;
    }

    /**
     * Determine whether the user can create the food
     *
     * @param User $user
     * @param Food $food
     * @return bool
     */
    public function create(User $user, Food $food)
    {
        $request = Request::capture();

        $restaurant_id = $request->input('restaurant_id');

        return $user->userable_id === (int)$restaurant_id;
    }

    /**
     * Determine whether the user can update the restaurant.
     *
     * @param User $user
     * @param Food $food
     * @return bool
     */
    public function update(User $user, Food $food)
    {
        return $user->userable_id === $food->restaurant_id;
    }

    /**
     * Determine whether the user can delete the food.
     *
     * @param User $user
     * @param Food $food
     * @return bool
     */
    public function delete(User $user, Food $food)
    {
        return $user->userable_id === $food->restaurant_id;
    }

    /**
     * Determine whether the user can upload food image.
     *
     * @param User $user
     * @param Food $food
     * @return bool
     */
    public function uploadImage(User $user, Food $food)
    {
        return $user->userable_id === $food->restaurant_id;
    }

    /**
     * Determine whether the user can delete food image.
     *
     * @param User $user
     * @param Food $food
     * @return bool
     */
    public function deleteImage(User $user, Food $food)
    {
        return $user->userable_id === $food->restaurant_id;
    }
}
