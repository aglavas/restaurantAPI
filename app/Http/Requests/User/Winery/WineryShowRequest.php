<?php

namespace App\Http\Requests\User\Winery;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FoundationRequest;

class WineryShowRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('view', $this->all()['winery'])) || (!$user->can('show-winery'))) {
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
