<?php

namespace App\Http\Controllers;

use App\Entities\RestaurantCategory;
use App\Http\Requests\RestaurantCategory\RestaurantCategoryAttachRequest;
use App\Http\Requests\RestaurantCategory\RestaurantCategoryDestroyRequest;
use App\Http\Requests\RestaurantCategory\RestaurantCategoryListRequest;
use App\Http\Requests\RestaurantCategory\RestaurantCategoryShowRequest;
use App\Http\Requests\RestaurantCategory\RestaurantCategoryStoreRequest;
use App\Http\Requests\RestaurantCategory\RestaurantCategorySyncRequest;
use App\Http\Requests\RestaurantCategory\RestaurantCategoryUpdateRequest;

class RestaurantCategoryController extends Controller
{
    /**
     * Return single restaurant category instance
     *
     * @param RestaurantCategoryShowRequest $request
     * @param RestaurantCategory $restaurantCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(RestaurantCategoryShowRequest $request, RestaurantCategory $restaurantCategory)
    {
        $restaurantCategory = $restaurantCategory->load(['translations', 'inventoryCategory']);

        return $this->successDataResponse($restaurantCategory, 200);
    }

    /**
     * Returns list of restaurant categories
     *
     * @param RestaurantCategoryListRequest $request
     * @param RestaurantCategory $restaurantCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(RestaurantCategoryListRequest $request, RestaurantCategory $restaurantCategory)
    {
        $restaurantCategory = $restaurantCategory->with(['translations', 'inventoryCategory'])->paginate(10);

        return $this->respondWithPagination($restaurantCategory, 200);
    }

    /**
     * Creates new restaurant category
     *
     * @param RestaurantCategoryStoreRequest $request
     * @param RestaurantCategory $restaurantCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RestaurantCategoryStoreRequest $request, RestaurantCategory $restaurantCategory)
    {
        $request->merge($request->input('translation'));

        try {
            $restaurantCategory = $restaurantCategory->create($request->input());
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return $this->errorMessageResponse('Error while saving restaurant category', 500);
        }

        return $this->successDataResponse($restaurantCategory, 200);
    }

    /**
     * Deletes restaurant category
     *
     * @param RestaurantCategoryDestroyRequest $request
     * @param RestaurantCategory $restaurantCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(RestaurantCategoryDestroyRequest $request, RestaurantCategory $restaurantCategory)
    {
        try {
            $restaurantCategory->delete();
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while deleting restaurant category', 500);
        }

        return $this->successMessageResponse('Restaurant category deleted successfully', 200);
    }

    /**
     * Updates restaurant category entity
     *
     * @param RestaurantCategoryUpdateRequest $request
     * @param RestaurantCategory $restaurantCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RestaurantCategoryUpdateRequest $request, RestaurantCategory $restaurantCategory)
    {
        try {
            foreach ($request->input('translation') as $language => $title) {
                foreach ($title as $key => $value) {
                    $query[$key] = $request->input("translation.{$language}.{$key}");
                }

                $restaurantCategory->translations()->where('locale', $language)->update($query);
            }
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while updating restaurant category.', 500);
        }

        return $this->successDataResponse($restaurantCategory->load('translations'), 200);
    }


    /**
     * Attach restaurant inventory category to restaurant category
     *
     * @param RestaurantCategoryAttachRequest $request
     * @param RestaurantCategory $restaurantCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function attach(RestaurantCategoryAttachRequest $request, RestaurantCategory $restaurantCategory)
    {
        $restaurantCategory = $restaurantCategory->find($request->route('restaurantCategoryId'));

        try {
            $restaurantCategory->inventoryCategory()->attach($request->input('inventory_categories'));
        } catch (\Exception $exception) {

            return $this->errorMessageResponse('Error while associating inventory categories to restaurant categories', 500);
        }

        return $this->successDataResponse($restaurantCategory->load(['inventoryCategory']), 200);
    }


    /**
     * Sync restaurant inventory category to restaurant category
     *
     * @param RestaurantCategorySyncRequest $request
     * @param RestaurantCategory $restaurantCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function sync(RestaurantCategorySyncRequest $request, RestaurantCategory $restaurantCategory)
    {
        $restaurantCategory = $restaurantCategory->find($request->route('restaurantCategoryId'));

        try {
            $restaurantCategory->inventoryCategory()->sync($request->input('inventory_categories'));
        } catch (\Exception $exception) {

            return $this->errorMessageResponse('Error while syncing inventory categories to restaurant categories', 500);
        }

        return $this->successDataResponse($restaurantCategory->load(['inventoryCategory']), 200);
    }
}
