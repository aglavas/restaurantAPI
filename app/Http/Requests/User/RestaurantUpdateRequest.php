<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class RestaurantUpdateRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('update', $this->all()['restaurant'])) || (!$user->can('update-restaurant'))) {
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
            'name' => 'required|string',
            'address' => 'required|string',
            'open_hours' => 'required|string',
            'translation.hr.description' => 'required|string',
            'translation.en.description' => 'string',
            'translation.de.description' => 'string',
            'translation.fr.description' => 'string',
            'delivery' => 'required|in:0,1',
            'delivery_price' => 'required|string',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ];
    }
}
