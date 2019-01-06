<?php

namespace App\Http\Requests\Food;

use App\Entities\Food;
use App\Http\Requests\FoundationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodStoreRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $food = new Food();

        $user = Auth::user();

        if((!$user->can('create', $food)) || !$user->can('create-food')) {
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
            'restaurant_id' => 'required|integer|exists:restaurants,id',
            'category_id' => 'required|integer|existsWith:food_categories,id,restaurant_id,'. Request::capture()->input('restaurant_id'),
            'price' => 'required|numeric',
            'calories' => 'required|numeric',
            'ingredients' => 'required|array',
            'ingredients.*' => 'required|integer|exists:ingredients,id',
            'translation.hr.name' => 'required|string',
            'translation.en.name' => 'string',
            'translation.de.name' => 'string',
            'translation.fr.name' => 'string',
        ];
    }
}
