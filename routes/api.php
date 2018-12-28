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

Route::post('food', 'FoodController@store');
Route::delete('food/{food}', 'FoodController@destroy');
Route::get('food/{food}', 'FoodController@show');
Route::get('food', 'FoodController@list');
Route::put('food/{food}', 'FoodController@update');


Route::post('foodCategory', 'FoodCategoryController@store');
Route::delete('foodCategory/{foodCategory}', 'FoodCategoryController@destroy');
Route::get('foodCategory/{foodCategory}', 'FoodCategoryController@show');
Route::get('foodCategory', 'FoodCategoryController@list');
Route::put('foodCategory/{foodCategory}', 'FoodCategoryController@update');

Route::post('foodAddition', 'FoodAdditionController@store');
Route::delete('foodAddition/{foodAddition}', 'FoodAdditionController@destroy');
Route::get('foodAddition/{foodAddition}', 'FoodAdditionController@show');
Route::get('foodAddition', 'FoodAdditionController@list');
Route::put('foodAddition/{foodAddition}', 'FoodAdditionController@update');




Route::group(['middleware' => 'auth:api'], function(){

    Route::get('user/restaurant/menu', 'User\RestaurantController@getMenu');

    // User
    Route::get('me', 'Auth\AuthController@getMe');
    Route::get('user/list', 'Auth\AuthController@getUserList');
    Route::post('logout', 'Auth\AuthController@logout');

    // Restaurant
    Route::post('user/restaurant', 'User\RestaurantController@store');
    Route::delete('user/restaurant/{restaurant}', 'User\RestaurantController@destroy');
    Route::post('user/restaurant/avatar', 'User\RestaurantController@uploadAvatar');
    Route::put('user/restaurant/{restaurant}', 'User\RestaurantController@update');
    Route::get('user/restaurant/{restaurant}', 'User\RestaurantController@show');
    Route::get('user/restaurant', 'User\RestaurantController@list');


    // Winery
    Route::post('user/winery', 'User\WineryController@store');
    Route::delete('user/winery/{winery}', 'User\WineryController@destroy');
    Route::post('user/winery/avatar', 'User\WineryController@uploadAvatar');
    Route::get('user/winery/{winery}', 'User\WineryController@show');
    Route::get('user/winery', 'User\WineryController@list');
    Route::put('user/winery/{winery}', 'User\WineryController@update');

    //Ingredient

    Route::get('ingredient/{ingredient}', 'IngredientController@show');
    Route::get('ingredient', 'IngredientController@list');
    Route::post('ingredient', 'IngredientController@store');
    Route::delete('ingredient/{ingredient}', 'IngredientController@destroy');
    Route::put('ingredient/{ingredient}', 'IngredientController@update');

});
