<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
/// go to RouteServiceProvider and change Home to
Route::get('/firstpage', [LoginController::class, 'login']);

Route::group(['prefix' => '/homepage'], function () {

    Route::group(['controller' => HomeController::class], function () {
        Route::get('/', 'userHome')->name('home');
        Route::get('/products', 'indexProducts')->name('products');
        Route::get('/products/{id}', 'viewProduct')->name('product');
    });

    Route::group([
        'controller' => CartController::class,
        'prefix' => '/Cart'
    ], function () {
        Route::post('/{product_id}',  'add')->name('cart.add');
        Route::get('',  'index')->name('cart');
        Route::delete('/{cartItemId}',  'destory')->name('cart.delete');
        Route::patch('/{cartItemId}',  'update')->name('cart.update');
    });
    Route::get('order',[OrderController::class, 'create'])->name('order.view');
    Route::post('order',[OrderController::class, 'store'])->name('order.store');

});
