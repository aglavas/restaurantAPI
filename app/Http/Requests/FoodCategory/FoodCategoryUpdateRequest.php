<?php

namespace App\Http\Requests\FoodCategory;

use App\Http\Requests\FoundationRequest;

class FoodCategoryUpdateRequest extends FoundationRequest
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
            'translation.hr.title' => 'string',
            'translation.en.title' => 'string',
            'translation.de.title' => 'string',
            'translation.fr.title' => 'string',
            'restaurant_id' => 'required|integer|exists:restaurants,id'
        ];
    }
}
