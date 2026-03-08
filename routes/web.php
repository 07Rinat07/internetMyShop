<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SwaggerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/locale/{locale}', function (Request $request, string $locale) {
    abort_unless(in_array($locale, config('app.supported_locales', ['ru']), true), 404);

    $request->session()->put('locale', $locale);

    return redirect()->back();
})->name('locale.switch');

/*
 * Главная страница интернет-магазина
 */
Route::get('/', IndexController::class)->name('index');

/*
 * Swagger UI и OpenAPI-спецификация
 */
if (!app()->environment('production')) {
    Route::get('/swagger', [SwaggerController::class, 'index'])->name('swagger.index');
    Route::get('/swagger/openapi.yaml', [SwaggerController::class, 'spec'])->name('swagger.spec');
}

/*
 * Страницы «Доставка», «Контакты» и прочие
 */
Route::get('/page/{page:slug}', PageController::class)->name('page.show');

/*
 * Каталог товаров: категория, бренд и товар
 */
Route::group([
    'as' => 'catalog.',
    'prefix' => 'catalog',
], function () {
    Route::get('index', [CatalogController::class, 'index'])->name('index');
    Route::get('category/{category:slug}', [CatalogController::class, 'category'])->name('category');
    Route::get('brand/{brand:slug}', [CatalogController::class, 'brand'])->name('brand');
    Route::get('product/{product:slug}', [CatalogController::class, 'product'])->name('product');
    Route::get('search', [CatalogController::class, 'search'])->name('search');
});

/*
 * Корзина покупателя
 */
Route::group([
    'as' => 'basket.',
    'prefix' => 'basket',
], function () {
    Route::get('index', [BasketController::class, 'index'])->name('index');
    Route::get('checkout', [BasketController::class, 'checkout'])->name('checkout');
    Route::post('profile', [BasketController::class, 'profile'])->name('profile');
    Route::post('saveorder', [BasketController::class, 'saveOrder'])->name('saveorder');
    Route::get('success', [BasketController::class, 'success'])->name('success');
    Route::post('add/{id}', [BasketController::class, 'add'])->where('id', '[0-9]+')->name('add');
    Route::post('plus/{id}', [BasketController::class, 'plus'])->where('id', '[0-9]+')->name('plus');
    Route::post('minus/{id}', [BasketController::class, 'minus'])->where('id', '[0-9]+')->name('minus');
    Route::post('remove/{id}', [BasketController::class, 'remove'])->where('id', '[0-9]+')->name('remove');
    Route::post('clear', [BasketController::class, 'clear'])->name('clear');
});

/*
 * Регистрация, вход в ЛК, восстановление пароля
 */
Route::name('user.')->prefix('user')->group(function () {
    Auth::routes();
});

/*
 * Личный кабинет зарегистрированного пользователя
 */
Route::group([
    'as' => 'user.',
    'prefix' => 'user',
    'middleware' => ['auth'],
], function () {
    Route::get('index', [UserController::class, 'index'])->name('index');
    Route::resource('profile', ProfileController::class);
    Route::get('order', [OrderController::class, 'index'])->name('order.index');
    Route::get('order/{order}', [OrderController::class, 'show'])->name('order.show');
});
