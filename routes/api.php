<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('login', 'Auth\AuthController@login');



Route::group(['middleware' => 'auth:api'], function(){

    // User
    Route::get('me', 'Auth\AuthController@getMe');
    Route::get('user/list', 'Auth\AuthController@getUserList');
    Route::post('logout', 'Auth\AuthController@logout');

    // Restaurant
    Route::post('user/restaurant', 'User\RestaurantController@store');
    Route::delete('user/restaurant/{restaurant}', 'User\RestaurantController@destroy');
    Route::post('user/restaurant/{restaurant}/avatar', 'User\RestaurantController@uploadAvatar');
    Route::put('user/restaurant/{restaurant}', 'User\RestaurantController@update')->where('restaurant', '[0-9]+');
    Route::get('user/restaurant/{restaurant}', 'User\RestaurantController@show');
    Route::get('user/restaurant', 'User\RestaurantController@list');
    Route::get('user/restaurant/{restaurant}/menu', 'User\RestaurantController@getMenu');
    Route::post('user/restaurant/{restaurant}/image', 'User\RestaurantController@postImage');
    Route::delete('user/restaurant/{restaurant}/image', 'User\RestaurantController@destroyImage');
    Route::post('user/restaurant/categories', 'User\RestaurantController@attachCategories');
    Route::put('user/restaurant/categories', 'User\RestaurantController@syncCategories');
    Route::post('user/restaurant/inventory', 'User\RestaurantController@attachInventory');
    Route::put('user/restaurant/inventory', 'User\RestaurantController@syncInventory');


    // Winery
    Route::post('user/winery', 'User\WineryController@store');
    Route::delete('user/winery/{winery}', 'User\WineryController@destroy');
    Route::post('user/winery/{winery}/avatar', 'User\WineryController@uploadAvatar');
    Route::get('user/winery/{winery}', 'User\WineryController@show');
    Route::get('user/winery', 'User\WineryController@list');
    Route::put('user/winery/{winery}', 'User\WineryController@update');
    Route::post('user/winery/{winery}/image', 'User\WineryController@postImage');
    Route::delete('user/winery/{winery}/image', 'User\WineryController@destroyImage');

    //Ingredient

    Route::get('ingredient/{ingredient}', 'IngredientController@show');
    Route::get('ingredient', 'IngredientController@list');
    Route::post('ingredient', 'IngredientController@store');
    Route::delete('ingredient/{ingredient}', 'IngredientController@destroy');
    Route::put('ingredient/{ingredient}', 'IngredientController@update');

    //Food

    Route::post('food', 'FoodController@store');
    Route::delete('food/{food}', 'FoodController@destroy');
    Route::get('food/{food}', 'FoodController@show');
    Route::get('/food', 'FoodController@list');
    Route::put('food/{food}', 'FoodController@update');
    Route::post('food/{food}/image', 'FoodController@storeFoodImage');
    Route::delete('food/{food}/image', 'FoodController@destroyFoodImage');

    //Food category

    Route::post('foodCategory', 'FoodCategoryController@store');
    Route::delete('foodCategory/{foodCategory}', 'FoodCategoryController@destroy');
    Route::get('foodCategory/{foodCategory}', 'FoodCategoryController@show');
    Route::get('foodCategory', 'FoodCategoryController@list');
    Route::put('foodCategory/{foodCategory}', 'FoodCategoryController@update');

    //Food addition

    Route::post('foodAddition', 'FoodAdditionController@store');
    Route::delete('foodAddition/{foodAddition}', 'FoodAdditionController@destroy');
    Route::get('foodAddition/{foodAddition}', 'FoodAdditionController@show');
    Route::get('foodAddition', 'FoodAdditionController@list');
    Route::put('foodAddition/{foodAddition}', 'FoodAdditionController@update');

    //Restaurant category

    Route::post('restaurantCategory', 'RestaurantCategoryController@store');
    Route::delete('restaurantCategory/{restaurantCategory}', 'RestaurantCategoryController@destroy');
    Route::get('restaurantCategory/{restaurantCategory}', 'RestaurantCategoryController@show');
    Route::get('restaurantCategory', 'RestaurantCategoryController@list');
    Route::put('restaurantCategory/{restaurantCategory}', 'RestaurantCategoryController@update');
    Route::post('restaurantCategory/{restaurantCategoryId}/restaurantInventoryCategory', 'RestaurantCategoryController@attach');
    Route::put('restaurantCategory/{restaurantCategoryId}/restaurantInventoryCategory', 'RestaurantCategoryController@sync');

    //Restaurant inventory category

    Route::post('restaurantInventoryCategory', 'RestaurantInventoryCategoryController@store');
    Route::delete('restaurantInventoryCategory/{restaurantInventoryCategory}', 'RestaurantInventoryCategoryController@destroy');
    Route::get('restaurantInventoryCategory/{restaurantInventoryCategory}', 'RestaurantInventoryCategoryController@show');
    Route::get('restaurantInventoryCategory', 'RestaurantInventoryCategoryController@list');
    Route::put('restaurantInventoryCategory/{restaurantInventoryCategory}', 'RestaurantInventoryCategoryController@update');
    Route::post('restaurantInventoryCategory/{restaurantInventoryCategory}/avatar', 'RestaurantInventoryCategoryController@uploadAvatar');

    //Restaurant orders

    Route::get('restaurant/{restaurant}/orders', 'RestaurantOrderController@list');


});
