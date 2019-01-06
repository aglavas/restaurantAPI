<?php

namespace App\Http\Controllers;

use App\Entities\FoodCategory;
use App\Entities\Restaurant;
use App\Http\Requests\FoodCategory\FoodCategoryDestroyRequest;
use App\Http\Requests\FoodCategory\FoodCategoryListRequest;
use App\Http\Requests\FoodCategory\FoodCategoryShowRequest;
use App\Http\Requests\FoodCategory\FoodCategoryStoreRequest;
use App\Http\Requests\FoodCategory\FoodCategoryUpdateRequest;
use Illuminate\Support\Facades\Auth;

class FoodCategoryController extends Controller
{
    /**
     * Return single food category instance
     *
     * @param FoodCategoryShowRequest $request
     * @param FoodCategory $foodCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FoodCategoryShowRequest $request, FoodCategory $foodCategory)
    {
        $foodCategory = $foodCategory->load(['translations', 'foods', 'additions']);

        return $this->successDataResponse($foodCategory, 200);
    }

    /**
     * Returns list of food categories
     *
     * @param FoodCategoryListRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(FoodCategoryListRequest $request, Restaurant $restaurant)
    {
        $restaurant = $restaurant->find($request->input('restaurant_id'));

        $foodCategory = $restaurant->load(['foodCategories' => function($q) {
            $q->with(['translations', 'foods', 'additions']);
        }]);

        return $this->successDataResponse($foodCategory, 200);
    }

    /**
     * Creates new food category
     *
     * @param FoodCategoryStoreRequest $request
     * @param FoodCategory $foodCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FoodCategoryStoreRequest $request, FoodCategory $foodCategory)
    {
        $request->merge($request->input('translation'));

        try {
            $foodCategory = $foodCategory->create($request->input());
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while saving food category', 500);
        }

        return $this->successDataResponse($foodCategory, 200);
    }

    /**
     * Delete food category
     *
     * @param FoodCategoryDestroyRequest $request
     * @param FoodCategory $foodCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FoodCategoryDestroyRequest $request, FoodCategory $foodCategory)
    {
        try {
            $foodCategory->delete();
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while deleting food category', 500);
        }

        return $this->successMessageResponse('Food category deleted successfully', 200);
    }

    /**
     * Update food category entity
     *
     * @param FoodCategoryUpdateRequest $request
     * @param FoodCategory $foodCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FoodCategoryUpdateRequest $request, FoodCategory $foodCategory)
    {
        try {
            foreach ($request->input('translation') as $language => $title) {
                foreach ($title as $key => $value) {
                    $query[$key] = $request->input("translation.{$language}.{$key}");
                }

                $foodCategory->translations()->where('locale', $language)->update($query);
            }
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while updating food category.', 500);
        }

        return $this->successDataResponse($foodCategory->load('translations'), 200);
    }
}
