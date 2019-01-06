<?php

namespace App\Http\Requests\FoodAddition;

use App\Entities\FoodAddition;
use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class FoodAdditionListRequest extends FoundationRequest
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

        if(!$user->can('list-food-addition') ||  (!$user->can('list', $foodAddition))) {
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
