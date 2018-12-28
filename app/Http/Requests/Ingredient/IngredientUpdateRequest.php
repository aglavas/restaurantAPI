<?php

namespace App\Http\Requests\Ingredient;

use App\Http\Requests\FoundationRequest;

class IngredientUpdateRequest extends FoundationRequest
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
            'translation.hr.name' => 'string',
            'translation.en.name' => 'string',
            'translation.de.name' => 'string',
            'translation.fr.name' => 'string',
        ];
    }
}
