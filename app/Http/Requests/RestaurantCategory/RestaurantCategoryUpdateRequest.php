<?php

namespace App\Http\Requests\RestaurantCategory;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class RestaurantCategoryUpdateRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('update-restaurant-category')) {
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
        ];
    }
}
