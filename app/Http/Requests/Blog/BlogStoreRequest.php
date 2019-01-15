<?php

namespace App\Http\Requests\Blog;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FoundationRequest;

class BlogStoreRequest extends FoundationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('create-blog')) {
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
