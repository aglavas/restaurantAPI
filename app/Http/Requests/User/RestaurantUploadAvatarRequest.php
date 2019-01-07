<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FoundationRequest;

class RestaurantUploadAvatarRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('uploadAvatar', $this->all()['restaurant'])) || (!$user->can('upload-avatar-restaurant'))) {
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
            'avatar' => 'required|image'
        ];
    }

}
