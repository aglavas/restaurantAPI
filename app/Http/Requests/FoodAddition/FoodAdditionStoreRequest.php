<?php

namespace App\Http\Requests\FoodAddition;

use App\Entities\FoodAddition;
use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class FoodAdditionStoreRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        $foodAddition = new FoodAddition();

        if((!$user->can('create', $foodAddition)) || (!$user->can('create-food-addition'))) {
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
            'translation.hr.title' => 'required|string',
            'translation.en.title' => 'string',
            'translation.de.title' => 'string',
            'translation.fr.title' => 'string',
            'category_id' => 'required|integer|exists:restaurants,id',
            'price' => 'required|numeric',
        ];
    }
}
