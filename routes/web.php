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
    return view('auth/login');
});

Route::get('/login','authController@login')->name('login');
Route::post('/postlogin','authController@postlogin');
Route::get('/logout','authController@logout');

Route::get('/home','homeController@index');

Route::group(['middleware'=>['auth','occupation:Admin']], function()
{
	Route::get('/user','UserController@index');
	Route::post('/user/create','UserController@create');
	Route::get('/user/{id}/edit','UserController@edit');
	Route::post('/user/{id}/update','UserController@update');
	Route::get('/user/{id}/delete','UserController@delete');
	Route::get('/kelurahan','KelurahanController@view');
	Route::get('/patient/{vue_capture?}', 'PatientController@index')
			->where('vue_capture', '[\/\w\.-]*');
	Route::get('/report-download', 'ReportController@indicators_download');
	Route::get('/report','ReportController@view');
	Route::get('/indicator/{vue_capture?}', 'IndicatorController@view')
			->where('vue_capture', '[\/\w\.-]*');
});
	