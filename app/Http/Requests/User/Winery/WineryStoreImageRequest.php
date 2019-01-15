<?php

namespace App\Http\Requests\User\Winery;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class WineryStoreImageRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('uploadImage', $this->all()['winery'])) || (!$user->can('upload-image-winery'))) {
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
