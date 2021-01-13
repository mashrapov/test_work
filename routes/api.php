<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('register', 'RegisterController@register');
Route::get('/products', 'ProductController@index');
Route::get('/tags', 'TagController@index');
Route::get('/categories', 'CategoryController@index');
Route::get('/products/{id}', 'ProductController@show');

Route::middleware('auth:api')->group( function () {
    Route::resource('/products', 'ProductController')->only([
        'store', 'update', 'destroy'
    ]);
});