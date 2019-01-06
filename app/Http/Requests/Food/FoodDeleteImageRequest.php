<?php

namespace App\Http\Requests\Food;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class FoodDeleteImageRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('deleteImage', $this->all()['food'])) || (!$user->can('delete-image-food'))) {
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
            'image_id' => 'required|numeric|imageExists'
        ];
    }
}
