<?php

namespace App\Http\Requests\User;

use App\Entities\Restaurant;
use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class RestaurantAttachRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        $restaurant = new Restaurant();

        if((!$user->can('attach', $restaurant)) || (!$user->can('attach-restaurant-category-to-restaurant'))) {
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
            'restaurant_id' => 'required|unique:restaurant_category_pivot,restaurant_id',
            'restaurant_categories' => 'required|array',
            'restaurant_categories.*' => 'required|integer|exists:restaurant_categories,id'
        ];
    }
}
