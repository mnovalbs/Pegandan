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

Route::get('/report/indicators', 'ReportController@indicators');
Route::get('/report', 'ReportController@list');
Route::post('/report', 'ReportController@create');
Route::delete('/report/{id}', 'ReportController@delete');
// Route::get('/indicator/{id}', 'IndicatorController@show');
Route::patch('/report/{id}', 'ReportController@update');

Route::get('/indicator', 'IndicatorController@index');
Route::post('/indicator', 'IndicatorController@create');
Route::get('/indicator/{id}', 'IndicatorController@show');
Route::patch('/indicator/{id}', 'IndicatorController@update');
Route::delete('/indicator/{id}', 'IndicatorController@delete');

Route::get('/kelurahan', 'KelurahanController@index');
Route::post('/kelurahan', 'KelurahanController@create');
Route::patch('/kelurahan/{id}', 'KelurahanController@update');
Route::delete('/kelurahan/{id}', 'KelurahanController@delete');

Route::get('/indicator-step', 'IndicatorStepController@list');
Route::post('/indicator-step', 'IndicatorStepController@create');
Route::patch('/indicator-step/{id}', 'IndicatorStepController@update');
Route::delete('/indicator-step/{id}', 'IndicatorStepController@delete');

Route::get('/patient', 'PatientController@apiList');
Route::get('/patient/{id}', 'PatientController@apiDetail');
Route::post('/patient', 'PatientController@apiCreate');
Route::patch('/patient/{id}', 'PatientController@apiUpdate');

Route::fallback(function(){
    return response()->api(404, NULL, 'Not Found');
});