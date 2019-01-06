<?php

namespace App\Http\Requests\Food;

use App\Entities\Food;
use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FoodListRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        $food = new Food();

        if(!$user->can('list-food') ||  (!$user->can('list', $food))) {
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
