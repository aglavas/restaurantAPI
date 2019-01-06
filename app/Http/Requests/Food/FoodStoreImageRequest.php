<?php

namespace App\Http\Requests\Food;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class FoodStoreImageRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('uploadImage', $this->all()['food'])) || (!$user->can('upload-image-food'))) {
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
            'image' => 'required|image'
        ];
    }
}
