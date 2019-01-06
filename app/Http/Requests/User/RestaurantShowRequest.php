<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FoundationRequest;

class RestaurantShowRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('view', $this->all()['restaurant'])) || (!$user->can('show-restaurant'))) {
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
