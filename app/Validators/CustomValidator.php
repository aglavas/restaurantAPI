<?php

namespace App\Validators;

use App\Entities\Restaurant;
use App\Models\Meal\Meal;
use App\Models\Pivot\BmiPhysiquePlanModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomValidator
{

    /**
     * Validation rule for checking does restaurant image exists
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function restaurantImageExists($message, $attribute, $rule, $parameters)
    {
        $count = DB::table('restaurants')
            ->where('image_1', $attribute)
            ->orWhere('image_2', $attribute)
            ->orWhere('image_3', $attribute)
            ->orWhere('image_4', $attribute)
            ->orWhere('image_5', $attribute)
            ->orWhere('image_6', $attribute)
            ->count();

        if (!$count) {
            return false;
        }
        return true;
    }
    /**
     *
     * Replacer for custom message
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function restaurantImageExistsReplacer($message, $attribute, $rule, $parameters)
    {
        $message = "Image with that id does not exists.";
        return $message;
    }


    /**
     * Validation rule for checking does food image exists
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function imageExists($message, $attribute, $rule, $parameters)
    {
        $count = DB::table('foods')
            ->where('image_1', $attribute)
            ->orWhere('image_2', $attribute)
            ->orWhere('image_3', $attribute)
            ->orWhere('image_4', $attribute)
            ->orWhere('image_5', $attribute)
            ->orWhere('image_6', $attribute)
            ->count();

        if (!$count) {
            return false;
        }
        return true;
    }
    /**
     *
     * Replacer for custom message
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function imageExistsReplacer($message, $attribute, $rule, $parameters)
    {
        $message = "Image with that id does not exists.";
        return $message;
    }


    /**
     * Validation rule for checking timestamp that need to be equal or after specified timestamp
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function existsWith($message, $attribute, $rule, $parameters)
    {
        $count = DB::table($rule[0])->where($rule[1], $attribute)->where($rule[2], $rule[3])->count();

        if (!$count) {
            return false;
        }

        return true;
    }

    /**
     *
     * Replacer for custom message
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function existsWithReplacer($message, $attribute, $rule, $parameters)
    {
        $message = "Key " . $parameters[1] . " must exists in combination with " . $parameters[2] . ".";

        return $message;
    }


    /**
     * Check if there is category for that inventory category
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function AllowedInventory($message, $attribute, $rule, $parameters)
    {
        /** @var Restaurant $restaurant */
        $restaurant =  Restaurant::find($rule[0]);

        if(!$restaurant) {
            return false;
        }

        $categoryIdsCollection = $restaurant->categories()->pluck('restaurant_categories.id');

        $categoryIds = $categoryIdsCollection->toArray();
        $data = $parameters->getData();

        $inventoryCount1 = count($data['restaurant_inventory']);

        $inventoryCount2 = DB::table('restaurant_inventory_pivot')->whereIn('restaurant_category_id', $categoryIds)->whereIn('restaurant_inventory_id', $data['restaurant_inventory'])->count();


        if($inventoryCount1 == $inventoryCount2) {
            return true;
        }

        return false;
    }

    /**
     *
     * Replacer for custom message
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function AllowedInventoryReplacer($message, $attribute, $rule, $parameters)
    {
        $message = "Inventory category does is not fit for that restaurant.";

        return $message;
    }


}
