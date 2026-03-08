<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BasketController;
use App\Http\Controllers\Api\V1\CatalogController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/me', [AuthController::class, 'me'])->name('auth.me');
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

        Route::apiResource('profiles', ProfileController::class)->except(['create', 'edit']);
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

    Route::get('catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('categories/{category:slug}', [CatalogController::class, 'category'])->name('categories.show');
    Route::get('brands/{brand:slug}', [CatalogController::class, 'brand'])->name('brands.show');
    Route::get('products/{product:slug}', [CatalogController::class, 'product'])->name('products.show');

    Route::middleware('api_stateful')->group(function () {
        Route::get('basket', [BasketController::class, 'show'])->name('basket.show');
        Route::post('basket/items', [BasketController::class, 'storeItem'])->name('basket.items.store');
        Route::patch('basket/items/{product}', [BasketController::class, 'updateItem'])->name('basket.items.update');
        Route::delete('basket/items/{product}', [BasketController::class, 'destroyItem'])->name('basket.items.destroy');
        Route::delete('basket', [BasketController::class, 'clear'])->name('basket.clear');
        Route::post('basket/checkout', [BasketController::class, 'checkout'])->name('basket.checkout');
    });
});
