<?php

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

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::post('auth/register', 'Api\V1\AuthController@register')->name('auth.register');
    Route::post('auth/login', 'Api\V1\AuthController@login')->name('auth.login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/me', 'Api\V1\AuthController@me')->name('auth.me');
        Route::post('auth/logout', 'Api\V1\AuthController@logout')->name('auth.logout');

        Route::apiResource('profiles', 'Api\V1\ProfileController')->except(['create', 'edit']);
        Route::get('orders', 'Api\V1\OrderController@index')->name('orders.index');
        Route::get('orders/{order}', 'Api\V1\OrderController@show')->name('orders.show');
    });

    Route::get('catalog', 'Api\V1\CatalogController@index')->name('catalog.index');
    Route::get('categories/{category:slug}', 'Api\V1\CatalogController@category')->name('categories.show');
    Route::get('brands/{brand:slug}', 'Api\V1\CatalogController@brand')->name('brands.show');
    Route::get('products/{product:slug}', 'Api\V1\CatalogController@product')->name('products.show');

    Route::middleware('api_stateful')->group(function () {
        Route::get('basket', 'Api\V1\BasketController@show')->name('basket.show');
        Route::post('basket/items', 'Api\V1\BasketController@storeItem')->name('basket.items.store');
        Route::patch('basket/items/{product}', 'Api\V1\BasketController@updateItem')->name('basket.items.update');
        Route::delete('basket/items/{product}', 'Api\V1\BasketController@destroyItem')->name('basket.items.destroy');
        Route::delete('basket', 'Api\V1\BasketController@clear')->name('basket.clear');
        Route::post('basket/checkout', 'Api\V1\BasketController@checkout')->name('basket.checkout');
    });
});
