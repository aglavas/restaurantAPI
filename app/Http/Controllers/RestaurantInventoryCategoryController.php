<?php

namespace App\Http\Controllers;

use App\Entities\RestaurantInventoryCategory;
use App\Http\Requests\RestaurantCategory\RestaurantCategoryListRequest;
use App\Http\Requests\RestaurantInventoryCategory\RestaurantInventoryCategoryDestroyRequest;
use App\Http\Requests\RestaurantInventoryCategory\RestaurantInventoryCategoryShowRequest;
use App\Http\Requests\RestaurantInventoryCategory\RestaurantInventoryCategoryStoreRequest;
use App\Http\Requests\RestaurantInventoryCategory\RestaurantInventoryCategoryUpdateRequest;
use App\Http\Requests\RestaurantInventoryCategory\RestaurantInventoryUploadAvatarRequest;
use Illuminate\Support\Facades\Storage;

class RestaurantInventoryCategoryController extends Controller
{
    /**
     * Return restaurant inventory category entity
     *
     * @param RestaurantInventoryCategoryShowRequest $request
     * @param RestaurantInventoryCategory $restaurantInventoryCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(RestaurantInventoryCategoryShowRequest $request,  RestaurantInventoryCategory $restaurantInventoryCategory)
    {
        $restaurantInventoryCategory = $restaurantInventoryCategory->load(['translations']);

        return $this->successDataResponse($restaurantInventoryCategory, 200);
    }

    /**
     * Returns list of restaurant inventory category
     *
     * @param RestaurantCategoryListRequest $request
     * @param RestaurantInventoryCategory $restaurantInventoryCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(RestaurantCategoryListRequest $request, RestaurantInventoryCategory $restaurantInventoryCategory)
    {
        $restaurantInventoryCategory = $restaurantInventoryCategory->with(['translations'])->paginate(10);

        return $this->respondWithPagination($restaurantInventoryCategory, 200);
    }

    /**
     * Store new restaurant inventory category
     *
     * @param RestaurantInventoryCategoryStoreRequest $request
     * @param RestaurantInventoryCategory $restaurantInventoryCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RestaurantInventoryCategoryStoreRequest $request, RestaurantInventoryCategory $restaurantInventoryCategory)
    {
        $request->merge($request->input('translation'));

        try {
            $restaurantInventoryCategory = $restaurantInventoryCategory->create($request->input());
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return $this->errorMessageResponse('Error while saving restaurant inventory category', 500);
        }

        return $this->successDataResponse($restaurantInventoryCategory, 200);
    }

    /**
     * Deletes restaurant inventory category
     *
     * @param RestaurantInventoryCategoryDestroyRequest $request
     * @param RestaurantInventoryCategory $restaurantInventoryCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(RestaurantInventoryCategoryDestroyRequest $request, RestaurantInventoryCategory $restaurantInventoryCategory)
    {
        try {
            $restaurantInventoryCategory->delete();
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while deleting restaurant inventory category', 500);
        }

        return $this->successMessageResponse('Restaurant inventory category deleted successfully', 200);
    }


    /**
     * Updates restaurant inventory category entity
     *
     * @param RestaurantInventoryCategoryUpdateRequest $request
     * @param RestaurantInventoryCategory $restaurantInventoryCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RestaurantInventoryCategoryUpdateRequest $request, RestaurantInventoryCategory $restaurantInventoryCategory)
    {
        try {
            foreach ($request->input('translation') as $language => $title) {
                foreach ($title as $key => $value) {
                    $query[$key] = $request->input("translation.{$language}.{$key}");
                }

                $restaurantInventoryCategory->translations()->where('locale', $language)->update($query);
            }
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while updating restaurant inventory category.', 500);
        }

        return $this->successDataResponse($restaurantInventoryCategory->load('translations'), 200);
    }

    /**
     * Upload inventory avatar
     *
     * @param RestaurantInventoryUploadAvatarRequest $request
     * @param RestaurantInventoryCategory $restaurantInventoryCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAvatar(RestaurantInventoryUploadAvatarRequest $request, RestaurantInventoryCategory $restaurantInventoryCategory)
    {
        $delete = 'restaurants/inventory/avatars' . '/' . $restaurantInventoryCategory->id;

        Storage::disk('s3')->delete($delete);

        $request->avatar->storeAs('restaurants/inventory/avatars' , $restaurantInventoryCategory->id, 's3', "public");

        $url = Storage::cloud()->url('api-test-v2/restaurants/inventory/avatars/'. $restaurantInventoryCategory->id);

        return $this->successDataResponse($url, 200);
    }
}
