<?php

namespace App\Http\Controllers;

use App\Entities\Restaurant;

class RestaurantOrderController extends Controller
{
    /**
     * Return list of restaurant orders
     *
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Restaurant $restaurant)
    {
        $restaurantOrder = $restaurant->with('orders.foods')->paginate(10);

        return $this->respondWithPagination($restaurantOrder, 200);
    }
}
