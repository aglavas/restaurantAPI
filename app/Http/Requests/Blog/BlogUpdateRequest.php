<?php

namespace App\Http\Requests\Blog;

use App\Http\Requests\FoundationRequest;
use Illuminate\Support\Facades\Auth;

class BlogUpdateRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('update-blog')) {
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
            'title' => 'required|string',
            'post' => 'required|string',
        ];
    }
}
