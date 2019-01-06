<?php

namespace App\Http\Controllers;

use App\Entities\FoodAddition;
use App\Entities\Restaurant;
use App\Http\Requests\FoodAddition\FoodAdditionDestroyRequest;
use App\Http\Requests\FoodAddition\FoodAdditionShowRequest;
use App\Http\Requests\FoodAddition\FoodAdditionStoreRequest;
use App\Http\Requests\FoodAddition\FoodAdditionUpdateRequest;
use App\Http\Requests\FoodAddition\FoodAdditionListRequest;

class FoodAdditionController extends Controller
{
    /**
     * Return single food addition instance
     *
     * @param FoodAdditionShowRequest $request
     * @param FoodAddition $foodAddition
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FoodAdditionShowRequest $request, FoodAddition $foodAddition)
    {
        $foodAddition = $foodAddition->load(['translations', 'category']);

        return $this->successDataResponse($foodAddition, 200);
    }

    /**
     * Return list of food additions
     *
     * @param FoodAdditionListRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(FoodAdditionListRequest $request, Restaurant $restaurant)
    {
        $restaurant = $restaurant->find($request->input('restaurant_id'));

        $foodAdditions = $restaurant->load(['foodAdditions' => function($q) {
            $q->with(['translations', 'category']);
        }]);

        return $this->successDataResponse($foodAdditions, 200);
    }

    /**
     * Creates new food addition
     *
     * @param FoodAdditionStoreRequest $request
     * @param FoodAddition $foodAddition
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FoodAdditionStoreRequest $request, FoodAddition $foodAddition)
    {
        $request->merge($request->input('translation'));

        try {
            $foodAddition = $foodAddition->create($request->input());
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while saving food addition', 500);
        }

        return $this->successDataResponse($foodAddition, 200);
    }

    /**
     * Delete food addition
     *
     * @param FoodAdditionDestroyRequest $request
     * @param FoodAddition $foodAddition
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FoodAdditionDestroyRequest $request, FoodAddition $foodAddition)
    {
        try {
            $foodAddition->delete();
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while deleting food addition', 500);
        }

        return $this->successMessageResponse('Food addition deleted successfully', 200);
    }

    /**
     * Update food addition entity
     *
     * @param FoodAdditionUpdateRequest $request
     * @param FoodAddition $foodAddition
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FoodAdditionUpdateRequest $request, FoodAddition $foodAddition)
    {
        try {
            $foodAddition->update([
                'price' => $request->input('price')
            ]);

            foreach ($request->input('translation') as $language => $title) {
                foreach ($title as $key => $value) {
                    $query[$key] = $request->input("translation.{$language}.{$key}");
                }

                $foodAddition->translations()->where('locale', $language)->update($query);
            }
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while updating food category.', 500);
        }

        return $this->successDataResponse($foodAddition->load('translations'), 200);
    }
}
