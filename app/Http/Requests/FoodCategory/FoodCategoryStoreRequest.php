<?php

namespace App\Http\Requests\FoodCategory;

use App\Entities\FoodCategory;
use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class FoodCategoryStoreRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $foodCategory = new FoodCategory();

        $user = Auth::user();

        if((!$user->can('create', $foodCategory)) ||  !$user->can('create-food-category')) {
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
            'restaurant_id' => 'required|integer|exists:restaurants,id',
        ];
    }
}
