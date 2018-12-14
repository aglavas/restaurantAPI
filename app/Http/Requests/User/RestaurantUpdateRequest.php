<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FoundationRequest;

class RestaurantUpdateRequest extends FoundationRequest
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
            'name' => 'required|string',
            'address' => 'required|string',
            'open_hours' => 'required|string',
            'translation.en.description' => 'string',
            'translation.de.description' => 'string',
            'translation.fr.description' => 'string',
            'translation.it.description' => 'string',
            'delivery' => 'required|in:0,1',
            'delivery_price' => 'required|string',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ];
    }
}
