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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::middleware('auth:api')->get('/list/{list}', 'ListCOntroller@show');
//Route::post('/login', 'UserController@login');
//Route::middleware('auth:api')::post('/logout', 'UserController@logout');

Route::post('/user', 'UserController@store');
Route::get('/user', 'UserController@index');
Route::get('/user/{user}', 'UserController@show');
Route::post('/login', 'UserController@login');

Route::middleware('auth:api')->group(function () {
    Route::post('/list', 'ListController@store');
    Route::get('/list', 'ListController@index');
    Route::get('/list/{list}', 'ListController@show');
    Route::delete('/list/{list}', 'ListController@destroy');

    Route::post('/task', 'TaskController@store');
    Route::get('/task', 'TaskController@index');
    Route::put('/task/{task}', 'TaskController@mark');
    Route::delete('/task/{task}', 'TaskController@destroy');
});


