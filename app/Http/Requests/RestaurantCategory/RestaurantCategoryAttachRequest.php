<?php

namespace App\Http\Requests\RestaurantCategory;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class RestaurantCategoryAttachRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('attach-restaurant-category')) {
            return false;
        }

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
            'restaurantCategoryId' => 'required|unique:restaurant_inventory_pivot,restaurant_category_id',
            'inventory_categories' => 'required|array',
            'inventory_categories.*' => 'required|integer|exists:restaurant_inventory_categories,id'
        ];
    }
}
