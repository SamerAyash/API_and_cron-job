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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::group(['middleware' => 'auth:api'], function() {
///////////////////////////////////////////////
    Route::get('/user', 'UserController@index');
    Route::get('/user/{id}', 'UserController@show');
    Route::put('/user/{id}', 'UserController@update');
    Route::delete('/user/{id}', 'UserController@destroy');
    Route::post('/user', 'UserController@store');
/////////////////////////////////////////////////
    Route::get('/post', 'PostController@index');
    Route::get('/mypost', 'PostController@myPost');
    Route::post('/post', 'PostController@store');
    Route::put('/post/{id}', 'PostController@update');
    Route::get('/post/{id}', 'PostController@show');
    Route::delete('/post/{id}', 'PostController@destroy');
////////////////////////////////////////////////////
});


