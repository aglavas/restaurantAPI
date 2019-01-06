<?php

namespace App\Http\Requests\RestaurantInventoryCategory;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class RestaurantInventoryCategoryListRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('list-restaurant-inventory-category')) {
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
