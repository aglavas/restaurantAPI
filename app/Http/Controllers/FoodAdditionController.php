<?php

namespace App\Http\Controllers;

use App\Entities\FoodAddition;
use App\Http\Requests\FoodAddition\FoodAdditionStoreRequest;
use App\Http\Requests\FoodAddition\FoodAdditionUpdateRequest;

class FoodAdditionController extends Controller
{
    /**
     * Return single food addition instance
     *
     * @param FoodAddition $foodAddition
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FoodAddition $foodAddition)
    {
        $foodAddition = $foodAddition->load('translations');

        return $this->successDataResponse($foodAddition, 200);
    }

    /**
     * Return list of food additions
     *
     * @param FoodAddition $foodAddition
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(FoodAddition $foodAddition)
    {
        $foodAddition = $foodAddition->with('translations')->paginate(10);

        return $this->respondWithPagination($foodAddition, 200);
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
            dd($exception->getMessage());
            return $this->errorMessageResponse('Error while saving food addition', 500);
        }

        return $this->successDataResponse($foodAddition, 200);
    }

    /**
     * Delete food addition
     *
     * @param FoodAddition $foodAddition
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FoodAddition $foodAddition)
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
                'category_id' => $request->input('category_id'),
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
