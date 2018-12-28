<?php

namespace App\Http\Requests\FoodAddition;

use App\Http\Requests\FoundationRequest;

class FoodAdditionStoreRequest extends FoundationRequest
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
            'translation.hr.title' => 'required|string',
            'translation.en.title' => 'string',
            'translation.de.title' => 'string',
            'translation.fr.title' => 'string',
            'category_id' => 'required|integer|exists:restaurants,id',
            'price' => 'required|numeric',
        ];
    }
}
