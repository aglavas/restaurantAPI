<?php

namespace App\Http\Controllers;

use App\Entities\FoodCategory;
use App\Http\Requests\FoodCategory\FoodCategoryStoreRequest;
use App\Http\Requests\FoodCategory\FoodCategoryUpdateRequest;

class FoodCategoryController extends Controller
{
    /**
     * Return single food category instance
     *
     * @param FoodCategory $foodCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FoodCategory $foodCategory)
    {
        $foodCategory = $foodCategory->load('translations');

        return $this->successDataResponse($foodCategory, 200);
    }

    /**
     * Return list of food categories
     *
     * @param FoodCategory $foodCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(FoodCategory $foodCategory)
    {
        $foodCategory = $foodCategory->with('translations')->paginate(10);

        return $this->respondWithPagination($foodCategory, 200);
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
            dd($exception->getMessage());
            return $this->errorMessageResponse('Error while saving food category', 500);
        }

        return $this->successDataResponse($foodCategory, 200);
    }

    /**
     * Delete food category
     *
     * @param FoodCategory $foodCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FoodCategory $foodCategory)
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
            $foodCategory->update([
                'restaurant_id' => $request->input('restaurant_id')
            ]);

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
