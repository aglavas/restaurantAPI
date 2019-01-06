<?php

namespace App\Http\Requests\Food;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class FoodDestroyRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('delete', $this->all()['food'])) || (!$user->can('destroy-food'))) {
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
