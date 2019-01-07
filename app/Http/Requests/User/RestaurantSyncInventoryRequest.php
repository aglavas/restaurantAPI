<?php

namespace App\Http\Requests\User;

use App\Entities\Restaurant;
use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class RestaurantSyncInventoryRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        $user = Auth::user();
//
//        $restaurant = new Restaurant();
//
//        if((!$user->can('syncInventory', $restaurant)) || (!$user->can('sync-restaurant-category-to-restaurant'))) {
//            return false;
//        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'restaurant_id' => 'required|exists:restaurant_category_inventory_pivot,restaurant_id|exists:restaurants,id',
            'restaurant_inventory' => 'required|array|allowedInventory:' . $this->input('restaurant_id'),
            'restaurant_inventory.*' => 'required|integer|exists:restaurant_inventory_categories,id'
        ];
    }
}
