<?php

namespace App\Http\Requests\Food;

use App\Http\Requests\FoundationRequest;

class FoodUpdateRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'category_id' => 'required|integer|exists:food_categories,id',
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
