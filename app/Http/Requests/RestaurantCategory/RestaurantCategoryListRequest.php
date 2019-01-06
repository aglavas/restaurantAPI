<?php

namespace App\Http\Requests\RestaurantCategory;

use App\Entities\FoodCategory;
use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class RestaurantCategoryListRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('list-restaurant-category')) {
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
        ];
    }
}
