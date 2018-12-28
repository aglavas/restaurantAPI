<?php

namespace App\Http\Controllers\User;

use App\Entities\Restaurant;
use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RestaurantStoreRequest;
use App\Http\Requests\User\RestaurantUpdateRequest;
use App\Http\Requests\User\UploadAvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{

    /**
     * Create new restaurant resource
     *
     * @param RestaurantStoreRequest $request
     * @param User $user
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RestaurantStoreRequest $request, User $user, Restaurant $restaurant)
    {
        $request->merge($request->input('translation'));

        try {
            $user = $user->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);

            $restaurant = $restaurant->create($request->input());

            $restaurant->user()->save($user);
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while updating restaurant', 500);
        }

        return $this->successDataResponse($restaurant, 200);
    }

    /**
     * Update restaurant resource
     *
     * @param RestaurantUpdateRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RestaurantUpdateRequest $request, Restaurant $restaurant)
    {
        try {
            $restaurant->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'open_hours' => $request->input('open_hours'),
                'delivery' => $request->input('delivery'),
                'delivery_price' => $request->input('delivery_price'),
                'lat' => $request->input('lat'),
                'long' => $request->input('long')
            ]);

            foreach ($request->input('translation') as $language => $title) {
                foreach ($title as $key => $value) {
                    $query[$key] = $request->input("translation.{$language}.{$key}");
                }
                $restaurant->translations()->where('locale', $language)->update($query);
            }
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while updating restaurant', 500);
        }

        return $this->successDataResponse($restaurant, 200);
    }


    /**
     * Delete restaurant resource
     *
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Restaurant $restaurant)
    {
        try {
            $restaurant->delete();
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Restaurant deleted successfully', 500);
        }

        return $this->successMessageResponse('Restaurant deleted successfully', 200);
    }

    /**
     * Return single restaurant resource
     *
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant = $restaurant->load('translations');

        return $this->successDataResponse($restaurant, 200);
    }

    /**
     * Return list of restaurant resources
     *
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Restaurant $restaurant)
    {
        $restaurant = $restaurant->with('translations')->paginate(10);

        return $this->respondWithPagination($restaurant, 200);
    }

    /**
     * Upload profile picture
     *
     * @param UploadAvatarRequest $request
     * @return mixed
     */
    public function uploadAvatar(UploadAvatarRequest $request)
    {
        $restaurant = Auth::user();

        $delete = 'restaurants/avatars' . '/' . $restaurant->id;

        Storage::disk('s3')->delete($delete);

        $request->avatar->storeAs('restaurants/avatars' , $restaurant->id, 's3', "public");

        $url = Storage::cloud()->url('api-test-v2/restaurants/avatars/'. $restaurant->id);

        return $this->successDataResponse($url, 200);
    }


    public function getMenu()
    {
        /** @var Restaurant $restaurant */
        $restaurant = Auth::user()->userable;

        $foods = $restaurant->foods()->with(['category', 'ingredients'])->get();

        return $this->successDataResponse($foods, 200);
    }

}
