<?php

namespace App\Http\Controllers\Auth;

use App\Entities\Restaurant;
use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserListResource;
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
     * Return user informations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMe()
    {
        $user = Auth::user();

        $userResource = UserListResource::make($user);

        return $this->successDataResponse($userResource,200);
    }

    /**
     * Get list of all users with pagination and relations
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserList(User $user)
    {
        $users = $user->with('userable')->paginate(10);

        $userResource = UserListResource::collection($users);

        return $this->respondWithPagination($userResource,200);
    }
}
