<?php

namespace App\Http\Controllers;

use App\Entities\Food;
use App\Http\Requests\Food\FoodStoreRequest;
use App\Http\Requests\Food\FoodUpdateRequest;

class FoodController extends Controller
{
    /**
     * Return single food resource
     *
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Food $food)
    {
        $food = $food->load(['translations', 'ingredients', 'category']);

        return $this->successDataResponse($food, 200);
    }

    /**
     * Return list of food resources
     *
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Food $food)
    {
        $foods = $food->with(['translations', 'ingredients', 'category'])->paginate(10);

        return $this->respondWithPagination($foods, 200);
    }

    /**
     * Creates new food
     *
     * @param FoodStoreRequest $request
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FoodStoreRequest $request, Food $food)
    {
        $request->merge($request->input('translation'));

        try {
            /** @var Food $food */
            $food = $food->create($request->input());

            $food->ingredients()->attach($request->input('ingredients'));
        } catch (\Exception $exception) {

            return $this->errorMessageResponse('Error while saving food', 500);
        }

        return $this->successDataResponse($food->load(['ingredients', 'category']), 200);
    }

    /**
     * Delete food resource
     *
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Food $food)
    {
        try {
            $food->delete();
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while deleting food', 500);
        }

        return $this->successMessageResponse('Food deleted successfully', 200);
    }

    /**
     * Update food resource
     *
     * @param FoodUpdateRequest $request
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FoodUpdateRequest $request, Food $food)
    {
        try {
            $food->update([
                'restaurant_id' => $request->input('restaurant_id'),
                'category_id' => $request->input('category_id'),
                'price' => $request->input('price'),
                'calories' => $request->input('calories'),
            ]);

            foreach ($request->input('translation') as $language => $title) {
                foreach ($title as $key => $value) {
                    $query[$key] = $request->input("translation.{$language}.{$key}");
                }
                $food->translations()->where('locale', $language)->update($query);
            }

            $food->ingredients()->sync($request->input('ingredients'));
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while updating restaurant', 500);
        }

        return $this->successDataResponse($food->load(['ingredients', 'translations', 'category']), 200);
    }
}
