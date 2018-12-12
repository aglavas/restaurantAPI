<?php

namespace App\Http\Controllers\User;


use App\Entities\Restaurant;
use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RestaurantStoreRequest;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{

    public function store(RestaurantStoreRequest $request, User $user, Restaurant $restaurant)
    {
        $user = $user->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('email'),
        ]);

        $restaurant = $restaurant->create($request->input());

//        $restaurant = $restaurant->create([
//            'address' => $request->input('address'),
//            'open_hours' => $request->input('open_hours'),
//            $request->input('translation'),
//            'delivery' =>  $request->input('delivery'),
//            'delivery_price' => $request->input('delivery_price'),
//            'lat' => $request->input('lat'),
//            'long' => $request->input('long'),
//        ]);


        $restaurant->user()->save($user);

        return $this->successMessageResponse('uspjeh',200);
    }


    public function destroy(Restaurant $restaurant, Request $request)
    {
        try {
            $restaurant->delete();
        } catch (\Exception $exception) {
            return $this->errorMessageResponse('Restaurant deleted successfully',500);
        }

        return $this->successMessageResponse('Restaurant deleted successfully',200);
    }

}
