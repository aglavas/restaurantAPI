<?php

namespace App\Http\Controllers\User;

use App\Entities\Restaurant;
use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RestaurantAttachInventoryRequest;
use App\Http\Requests\User\RestaurantAttachRequest;
use App\Http\Requests\User\RestaurantDeleteImageRequest;
use App\Http\Requests\User\RestaurantDestroyRequest;
use App\Http\Requests\User\RestaurantListRequest;
use App\Http\Requests\User\RestaurantMenuRequest;
use App\Http\Requests\User\RestaurantShowRequest;
use App\Http\Requests\User\RestaurantStoreImageRequest;
use App\Http\Requests\User\RestaurantStoreRequest;
use App\Http\Requests\User\RestaurantSyncInventoryRequest;
use App\Http\Requests\User\RestaurantSyncRequest;
use App\Http\Requests\User\RestaurantUpdateRequest;
use App\Http\Requests\User\RestaurantUploadAvatarRequest;
use App\Http\Requests\User\UploadAvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class RestaurantController extends Controller
{

    /**
     * Create new restaurant resource
     *
     * @param RestaurantStoreRequest $request
     * @param User $user
     * @param Restaurant $restaurant
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RestaurantStoreRequest $request, User $user, Restaurant $restaurant, Role $role)
    {
        $request->merge($request->input('translation'));

        $role = $role->findByName('restaurant', 'web');

        try {
            $user = $user->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);

            $user->assignRole($role);

            $restaurant = $restaurant->create($request->input());

            $restaurant->user()->save($user);

        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while saving restaurant', 500);
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

        return $this->successDataResponse($restaurant->load('translations'), 200);
    }


    /**
     * Delete restaurant resource
     *
     * @param RestaurantDestroyRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(RestaurantDestroyRequest $request, Restaurant $restaurant)
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
     * @param RestaurantShowRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(RestaurantShowRequest $request, Restaurant $restaurant)
    {
        $restaurant = $restaurant->load('translations' , 'categories', 'inventory');

        return $this->successDataResponse($restaurant, 200);
    }

    /**
     * Return list of restaurant resources
     *
     * @param RestaurantListRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(RestaurantListRequest $request, Restaurant $restaurant)
    {
        $restaurant = $restaurant->with('translations','categories', 'inventory')->paginate(10);

        return $this->respondWithPagination($restaurant, 200);
    }

    /**
     * Upload restaurant avatar
     *
     * @param RestaurantUploadAvatarRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAvatar(RestaurantUploadAvatarRequest $request, Restaurant $restaurant)
    {
        $delete = 'restaurants/avatars' . '/' . $restaurant->id;

        Storage::disk('s3')->delete($delete);

        $request->avatar->storeAs('restaurants/avatars' , $restaurant->id, 's3', "public");

        $url = Storage::cloud()->url('api-test-v2/restaurants/avatars/'. $restaurant->id);

        return $this->successDataResponse($url, 200);
    }


    /**
     * Get restaurant menu
     *
     * @param RestaurantMenuRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenu(RestaurantMenuRequest $request, Restaurant $restaurant)
    {
        $foods = $restaurant->foods()->with(['category', 'ingredients'])->get();

        return $this->successDataResponse($foods, 200);
    }


    /**
     * Upload restaurant image
     *
     * @param RestaurantStoreImageRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function postImage(RestaurantStoreImageRequest $request, Restaurant $restaurant)
    {
        $lastActive = '';
        $currentActive = '';

        for($i = 1; $i <= 6; $i++) {
            $id = 'image_' . $i;

            if($restaurant->{$id}) {
                $lastActive = $id;
            }

            if ($restaurant->{$id} && $i === 6) {
                $lastActive = null;
            }
        }

        if($lastActive === null) {
            return $this->errorMessageResponse('Maximum image number uploaded', 400);
        }

        if($lastActive === '') {
            $currentActive = 'image_1';
        } else {
            $lastActiveArray = explode('_', $lastActive);
            $lastActiveArray[1]++;

            $currentActive = implode('_', $lastActiveArray);
        }

        $restaurantImgId = rand();

        $restaurant->{$currentActive} = $restaurantImgId;
        $restaurant->save();

        $request->image->storeAs('restaurants/gallery/' . $restaurant->id . '/' , $restaurantImgId, 's3', "public");

        $url = Storage::cloud()->url('api-test-v2/restaurants/gallery/'. $restaurant->id . '/' . $restaurantImgId);

        return $this->successDataResponse($url, 200);
    }

    /**
     * Delete restaurant image
     *
     * @param RestaurantDeleteImageRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyImage(RestaurantDeleteImageRequest $request, Restaurant $restaurant)
    {
        for($i = 1; $i <= 6; $i++) {
            $id = 'image_' . $i;
            if($restaurant->{$id} == $request->input('image_id')) {
                $restaurant->{$id} = '';
                $restaurant->save();
                break;
            }
        }

        $delete = 'restaurants/gallery/' . $restaurant->id . '/' . $request->input('image_id');

        Storage::disk('s3')->delete($delete);

        return $this->successDataResponse('Image deleted successfully', 200);
    }

    /**
     * Attach restaurant categories to restaurant
     *
     * @param RestaurantAttachRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachCategories(RestaurantAttachRequest $request, Restaurant $restaurant)
    {
        $restaurant = $restaurant->find($request->input('restaurant_id'));

        try {
            $restaurant->categories()->attach($request->input('restaurant_categories'));
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while associating restaurant categories to restaurant.', 500);
        }

        return $this->successDataResponse($restaurant->load(['categories']), 200);
    }

    /**
     * Sync restaurant categories to restaurant
     *
     * @param RestaurantSyncRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncCategories(RestaurantSyncRequest $request, Restaurant $restaurant)
    {
        $restaurant = $restaurant->find($request->input('restaurant_id'));

        try {
            $restaurant->categories()->sync($request->input('restaurant_categories'));
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while syncing restaurant categories to restaurant.', 500);
        }

        return $this->successDataResponse($restaurant->load(['categories']), 200);
    }

    /**
     * Attach restaurant inventory to restaurant
     *
     * @param RestaurantAttachInventoryRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachInventory(RestaurantAttachInventoryRequest $request, Restaurant $restaurant)
    {
        $restaurant = $restaurant->find($request->input('restaurant_id'));

        try {
            $restaurant->inventory()->attach($request->input('restaurant_inventory'));
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while associating restaurant inventory categories to restaurant.', 500);
        }

        return $this->successDataResponse($restaurant->load(['categories', 'inventory']), 200);
    }

    /**
     * Sync restaurant inventory to restaurant
     *
     * @param RestaurantSyncInventoryRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncInventory(RestaurantSyncInventoryRequest $request , Restaurant $restaurant)
    {
        $restaurant = $restaurant->find($request->input('restaurant_id'));

        try {
            $restaurant->inventory()->sync($request->input('restaurant_inventory'));
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while syncing restaurant inventory to restaurant.', 500);
        }

        return $this->successDataResponse($restaurant->load(['categories', 'inventory']), 200);
    }
}
