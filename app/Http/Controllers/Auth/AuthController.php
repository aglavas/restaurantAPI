<?php

namespace App\Http\Controllers\Auth;

use App\Entities\Restaurant;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Authenticates user using credentials and returns token
     *
     * @param AuthLoginRequest $request
     * @param AuthManager $authManager
     * @return AuthController|\Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $request, AuthManager $authManager, Restaurant $restaurant)
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = $authManager->user();
            $userResource = AuthResource::make($user);

            return $this->successDataResponse($userResource,200);
        }

        return $this->errorMessageResponse('Unauthorised',401);
    }


    /**
     * Invalidate token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $token = Auth::user()->token();
        $token->revoke();

        return $this->successMessageResponse('Token invalidated',200);
    }

    /**
     * @return AuthController
     */
    public function getMe()
    {
        $user = Auth::user();

        return $this->successDataResponse($user,200);
    }
}
