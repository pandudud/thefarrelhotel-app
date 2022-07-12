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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => '', 'namespace' => 'Api'], function()
{
    Route::get('galleries', 'GalleryController@index');

    Route::get('arounds', 'AroundController@index');

    Route::get('facilities', 'FacilityController@index');
    Route::get('facility/{slug}', 'FacilityController@show');

    Route::get('events', 'EventController@index');
    Route::get('event/{slug}', 'EventController@show');

    Route::get('rooms', 'RoomController@index');
    Route::get('room/{slug}', 'RoomController@show');

    Route::get('promotions', 'PromotionController@index');
    Route::get('promotion/{slug}', 'PromotionController@show');

    Route::get('social-media', 'GeneralsController@socialMedia');
    Route::get('banner', 'GeneralsController@banner');

    Route::group(['prefix' => 'home'], function()
    {
        Route::get('facility', 'HomeController@facility');
        Route::get('room', 'HomeController@room');
    });
});
