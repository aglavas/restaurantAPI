<?php

namespace App\Http\Requests\FoodCategory;

use App\Entities\FoodCategory;
use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class FoodCategoryListRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        $foodCategory = new FoodCategory();

        if(!$user->can('list-food-category') || (!$user->can('list', $foodCategory))) {
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
            'restaurant_id' => 'required|integer|exists:restaurants,id'
        ];
    }
}
