<?php

namespace App\Policies;

use App\Entities\FoodAddition;
use App\Entities\Restaurant;
use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class FoodAdditionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view food addition.
     *
     * @param User $user
     * @param FoodAddition $foodAddition
     * @return bool
     */
    public function view(User $user, FoodAddition $foodAddition)
    {
        /** @var Restaurant $restaurant */
        $restaurant = $user->userable()->first();

        $foodAddition = $restaurant->foodAdditions()->find($foodAddition->id);

        if($foodAddition) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the food addition list.
     *
     * @param User $user
     * @param FoodAddition $foodAddition
     * @return bool
     */
    public function list(User $user, FoodAddition $foodAddition)
    {
        $request = Request::capture();

        $restaurant_id = $request->input('restaurant_id');

        return $user->userable_id === (int)$restaurant_id;
    }

    /**
     * Determine whether the user can create the food additionj
     *
     * @param User $user
     * @param FoodAddition $foodAddition
     * @return bool
     */
    public function create(User $user, FoodAddition $foodAddition)
    {
        $request = Request::capture();

        $category_id = $request->input('category_id');

        /** @var Restaurant $restaurant */
        $restaurant = $user->userable()->first();

        $category = $restaurant->foodCategories()->where('id', $category_id)->first();

        if($category) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the food addition.
     *
     * @param User $user
     * @param FoodAddition $foodAddition
     * @return bool
     */
    public function update(User $user, FoodAddition $foodAddition)
    {
        /** @var Restaurant $restaurant */
        $restaurant = $user->userable()->first();

        $foodAddition = $restaurant->foodCategories()->where('id', $foodAddition->category_id)->first();

        if($foodAddition) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the food addition.
     *
     * @param User $user
     * @param FoodAddition $foodAddition
     * @return bool
     */
    public function delete(User $user, FoodAddition $foodAddition)
    {
        /** @var Restaurant $restaurant */
        $restaurant = $user->userable()->first();

        $foodAddition = $restaurant->foodCategories()->where('id', $foodAddition->category_id)->first();

        if($foodAddition) {
            return true;
        }

        return false;
    }
}
