<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FoundationRequest;

class WineryStoreRequest extends FoundationRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'address' => 'required|string',
            'open_hours' => 'required|string',
            'translation.hr.description' => 'required|string',
            'translation.en.description' => 'string',
            'translation.de.description' => 'string',
            'translation.fr.description' => 'string',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ];
    }
}
