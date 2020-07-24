<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');

Route::prefix('v1')-> group(function() {
    Route::get('books', 'BookController@index');
    Route::get('book/{id}', 'BookController@view')->where('id', '[0-9]+');

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    Route::get('categories/', 'CategoryController@index');
    Route::get('categories/random/{count}', 'CategoryController@random');
    Route::get('categories/slug/{slug}', 'CategoryController@slug');

    Route::get('books/', 'BookController@index');
    Route::get('books/top/{count}', 'BookController@top');
    Route::get('books/slug/{slug}', 'BookController@slug');
    Route::get('books/search/{keyword}', 'BookController@search');

    Route::get('provinces/', 'ShopController@provinces');
    Route::get('cities/', 'ShopController@cities');
    Route::get('couriers', 'ShopController@couriers');
    
    Route::middleware('auth:api')->group(function() {
        Route::post('logout', 'AuthController@logout');
        Route::post('services', 'ShopController@services');
        Route::post('shipping', 'ShopController@shipping');
        Route::post('payment', 'ShopController@payment');
        Route::get('my-order', 'ShopController@myOrder');
    });
});

Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});