<?php

namespace App\Http\Requests\User\Winery;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class WineryUpdateRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('update', $this->all()['winery'])) || (!$user->can('update-winery'))) {
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
            'name' => 'required|string',
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
