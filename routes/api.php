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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/indicator', 'IndicatorController@index');
Route::post('/indicator', 'IndicatorController@create');
Route::get('/indicator/{id}', 'IndicatorController@show');
Route::patch('/indicator/{id}', 'IndicatorController@update');
Route::delete('/indicator/{id}', 'IndicatorController@delete');

Route::get('/indicator-step', 'IndicatorStepController@list');
Route::post('/indicator-step', 'IndicatorStepController@create');
Route::patch('/indicator-step/{id}', 'IndicatorStepController@update');
Route::delete('/indicator-step/{id}', 'IndicatorStepController@delete');

Route::fallback(function(){
    return response()->api(404, NULL, 'Not Found');
});