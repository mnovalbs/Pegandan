<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('/welcome');
});

Route::get('/indicator', 'IndicatorController@view');
Route::get('/user','UserController@index');
Route::post('/user/create','UserController@create');
Route::get('/user/{id}/edit','UserController@edit');
Route::post('/user/{id}/update','UserController@update');
Route::get('/user/{id}/delete','UserController@delete');
Route::get('/pasien','PatientController@index');
Route::POST('/pasien/create','PatientController@create');
Route::get('/pasien/{id_pasien}/edit','PatientController@edit');