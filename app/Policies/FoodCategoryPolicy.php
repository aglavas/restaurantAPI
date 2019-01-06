<?php

namespace App\Policies;

use App\Entities\FoodCategory;
use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Request;

class FoodCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view food category.
     *
     * @param User $user
     * @param FoodCategory $foodCategory
     * @return bool
     */
    public function view(User $user, FoodCategory $foodCategory)
    {
        return $user->userable_id === $foodCategory->restaurant_id;
    }

    /**
     * Determine whether the user can view the food category.
     *
     * @param User $user
     * @param FoodCategory $foodCategory
     * @return bool
     */
    public function list(User $user, FoodCategory $foodCategory)
    {
        $request = Request::capture();

        $restaurant_id = $request->input('restaurant_id');

        return $user->userable_id === (int)$restaurant_id;
    }

    /**
     * Determine whether the user can create the food
     *
     * @param User $user
     * @param FoodCategory $foodCategory
     * @return bool
     */
    public function create(User $user, FoodCategory $foodCategory)
    {
        $request = Request::capture();

        $restaurant_id = $request->input('restaurant_id');

        return $user->userable_id === (int)$restaurant_id;
    }

    /**
     * Determine whether the user can update the food category.
     *
     * @param User $user
     * @param FoodCategory $foodCategory
     * @return bool
     */
    public function update(User $user, FoodCategory $foodCategory)
    {
        return $user->userable_id === $foodCategory->restaurant_id;
    }

    /**
     * Determine whether the user can delete the food category.
     *
     * @param User $user
     * @param FoodCategory $foodCategory
     * @return bool
     */
    public function delete(User $user, FoodCategory $foodCategory)
    {
        return $user->userable_id === $foodCategory->restaurant_id;
    }
}
