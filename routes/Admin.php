<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SubCategoryController;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class);
Route::resource('subcategory', SubCategoryController::class);
Route::resource('products', ProductController::class);
Route::group([
    'controller' => SizeController::class,
    'prefix' => '/product/size',
], function () {
    Route::get('/', 'index')->name('size.index');
    Route::post('/store', 'store')->name('size.store');
    Route::delete('/destroy/{size}', 'destroy')->name('size.destroy');
});
Route::group([
    'controller' => ColorController::class,
    'prefix' => '/product/color',
], function () {
    Route::get('/', 'index')->name('color.index');
    Route::post('/store', 'store')->name('color.store');
    Route::delete('/destroy/{color}', 'destroy')->name('color.destroy');
});
Route::delete('/images/{image_id}', [ProductController::class, 'deleteProductImage'])->name('product.image.delete');;
Route::get('/', [LoginController::class, 'adminDashboard'])->name('admin.dashboard');
