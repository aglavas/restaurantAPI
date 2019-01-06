<?php

namespace App\Http\Requests\Food;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class FoodUpdateRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('update', $this->all()['food'])) || (!$user->can('update-food'))) {
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
