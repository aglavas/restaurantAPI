<?php

namespace App\Http\Controllers;

use App\Entities\Food;
use App\Entities\Restaurant;
use App\Http\Requests\Food\FoodDeleteImageRequest;
use App\Http\Requests\Food\FoodDestroyRequest;
use App\Http\Requests\Food\FoodListRequest;
use App\Http\Requests\Food\FoodStoreImageRequest;
use App\Http\Requests\Food\FoodStoreRequest;
use App\Http\Requests\Food\FoodUpdateRequest;
use App\Http\Requests\Food\FoodShowRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    /**
     * Return single food resource
     *
     * @param FoodShowRequest $request
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FoodShowRequest $request, Restaurant $restaurant, Food $food)
    {
        $food = $food->load(['translations', 'ingredients', 'category']);

        return $this->successDataResponse($food, 200);
    }

    /**
     * Return list of food resources
     *
     * @param FoodListRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(FoodListRequest $request, Restaurant $restaurant)
    {
        $restaurant = $restaurant->find($request->input('restaurant_id'));

        $foods = $restaurant->load(['foods' => function($q) {
            $q->with(['translations', 'ingredients', 'category']);
        }]);

        return $this->successDataResponse($foods, 200);
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
     * @param FoodDestroyRequest $request
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FoodDestroyRequest $request, Food $food)
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


    /**
     * Upload food images
     *
     * @param FoodStoreImageRequest $request
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeFoodImage(FoodStoreImageRequest $request, Food $food)
    {
        $lastActive = '';
        $currentActive = '';

        for($i = 1; $i <= 6; $i++) {
            $id = 'image_' . $i;

            if($food->{$id}) {
                $lastActive = $id;
            }

            if ($food->{$id} && $i === 6) {
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

        $foodImgId = rand();

        $food->{$currentActive} = $foodImgId;
        $food->save();

        $request->image->storeAs('foods/' . $food->id . '/' , $foodImgId, 's3', "public");

        $url = Storage::cloud()->url('api-test-v2/foods/'. $food->id . '/' . $foodImgId);

        return $this->successDataResponse($url, 200);
    }


    /**
     * Delete food image
     *
     * @param FoodDeleteImageRequest $request
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyFoodImage(FoodDeleteImageRequest $request, Food $food)
    {
        for($i = 1; $i <= 6; $i++) {
            $id = 'image_' . $i;
            if($food->{$id} == $request->input('image_id')) {
                $food->{$id} = '';
                $food->save();
                break;
            }
        }

        $delete = 'foods/' . $food->id . '/' . $request->input('image_id');

        Storage::disk('s3')->delete($delete);

        return $this->successDataResponse('Image deleted successfully', 200);
    }
}
