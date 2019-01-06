<?php

namespace App\Http\Requests\FoodAddition;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FoundationRequest;

class FoodAdditionDestroyRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('delete', $this->all()['foodAddition'])) || (!$user->can('destroy-food-addition'))) {
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
        ];
    }
}
