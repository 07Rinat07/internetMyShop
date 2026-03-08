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

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('catalog', 'Api\V1\CatalogController@index')->name('catalog.index');
    Route::get('categories/{category:slug}', 'Api\V1\CatalogController@category')->name('categories.show');
    Route::get('brands/{brand:slug}', 'Api\V1\CatalogController@brand')->name('brands.show');
    Route::get('products/{product:slug}', 'Api\V1\CatalogController@product')->name('products.show');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
