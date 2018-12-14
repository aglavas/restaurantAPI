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
Route::get('list', 'Auth\AuthController@getUserList');
Route::put('user/restaurant/{restaurant}', 'User\RestaurantController@update');
Route::get('user/restaurant/{restaurant}', 'User\RestaurantController@show');
Route::get('user/restaurant', 'User\RestaurantController@list');

Route::group(['middleware' => 'auth:api'], function(){
    // User
    Route::get('me', 'Auth\AuthController@getMe');
    Route::get('user/list', 'Auth\AuthController@getUserList');
    Route::post('logout', 'Auth\AuthController@logout');
    // Restaurant
    Route::post('user/restaurant', 'User\RestaurantController@store');
    Route::delete('user/restaurant/{restaurant}', 'User\RestaurantController@destroy');
});
