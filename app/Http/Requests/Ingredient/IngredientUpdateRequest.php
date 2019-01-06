<?php

namespace App\Http\Requests\Ingredient;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class IngredientUpdateRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('update-ingredient')) {
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
            'translation.hr.name' => 'required|string',
            'translation.en.name' => 'string',
            'translation.de.name' => 'string',
            'translation.fr.name' => 'string',
        ];
    }
}
