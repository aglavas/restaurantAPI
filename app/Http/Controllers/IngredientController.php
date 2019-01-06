<?php

namespace App\Http\Controllers;

use App\Entities\Ingredient;
use App\Http\Requests\Ingredient\IngredientDestroyRequest;
use App\Http\Requests\Ingredient\IngredientListRequest;
use App\Http\Requests\Ingredient\IngredientShowRequest;
use App\Http\Requests\Ingredient\IngredientStoreRequest;
use App\Http\Requests\Ingredient\FoodCategoryUpdateRequest;
use App\Http\Requests\Ingredient\IngredientUpdateRequest;

class IngredientController extends Controller
{
    /**
     * Return single ingredient resource
     *
     * @param IngredientShowRequest $request
     * @param Ingredient $ingredient
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(IngredientShowRequest $request, Ingredient $ingredient)
    {
        $ingredient = $ingredient->load('translations');

        return $this->successDataResponse($ingredient, 200);
    }

    /**
     * Return list of ingredient resources
     *
     * @param IngredientListRequest $request
     * @param Ingredient $ingredient
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(IngredientListRequest $request, Ingredient $ingredient)
    {
        $ingredients = $ingredient->with('translations')->paginate(10);

        return $this->respondWithPagination($ingredients, 200);
    }

    /**
     * Creates new ingredient
     *
     * @param IngredientStoreRequest $request
     * @param Ingredient $ingredient
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(IngredientStoreRequest $request, Ingredient $ingredient)
    {
        try {
            $ingredient = $ingredient->create($request->input('translation'));
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while saving ingredient', 500);
        }

        return $this->successDataResponse($ingredient, 200);
    }

    /**
     * Delete ingredient resource
     *
     * @param IngredientDestroyRequest $request
     * @param Ingredient $ingredient
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(IngredientDestroyRequest $request, Ingredient $ingredient)
    {
        try {
            $ingredient->delete();
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while deleting ingredient', 500);
        }

        return $this->successMessageResponse('Ingredient deleted successfully', 200);
    }

    /**
     * Update ingredient resource
     *
     * @param IngredientUpdateRequest $request
     * @param Ingredient $ingredient
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(IngredientUpdateRequest $request , Ingredient $ingredient)
    {
        try {
            foreach ($request->input('translation') as $language => $title) {
                foreach ($title as $key => $value) {
                    $query[$key] = $request->input("translation.{$language}.{$key}");
                }
                $ingredient->translations()->where('locale', $language)->update($query);
            }
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Error while updating ingredient', 500);
        }

        return $this->successDataResponse($ingredient, 200);
    }
}
