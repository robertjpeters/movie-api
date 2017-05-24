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

Route::get('/v1/movie', 'Movies@index');
Route::get('/v1/movie/{id}', 'Movies@get');
Route::put('/v1/movie/{id}', 'Movies@update');
Route::post('/v1/movie', 'Movies@create');
Route::delete('/v1/movie/{id}', 'Movies@delete');