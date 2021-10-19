<?php

use Illuminate\Support\Facades\Route;
use Nishtman\LaravelSlider\Http\Controllers\CategoryController;
use Nishtman\LaravelSlider\Http\Controllers\SliderController;

Route::pattern('categoryId', '[0-9]+');
Route::pattern('sliderId', '[0-9]+');

Route::get('categories', [CategoryController::class, 'index'])->name('sliders.categories.list');
Route::get('categories/new', [CategoryController::class, 'create'])->name('sliders.categories.create');
Route::post('categories/', [CategoryController::class, 'store'])->name('sliders.categories.store');
Route::get('categories/{categoryId}', [CategoryController::class, 'edit'])->name('sliders.categories.edit');
Route::put('categories/{categoryId}', [CategoryController::class, 'update'])->name('sliders.categories.update');
Route::delete('categories/{categoryId}', [CategoryController::class, 'destroy'])->name('sliders.categories.destroy');

Route::prefix('{categoryId}')->group(function () {
    Route::get('', [SliderController::class, 'index'])->name('sliders.list');
    Route::get('new', [SliderController::class, 'create'])->name('sliders.create');
    Route::post('', [SliderController::class, 'store'])->name('sliders.store');
    Route::get('{sliderId}', [SliderController::class, 'edit'])->name('sliders.edit');
    Route::post('{sliderId}', [SliderController::class, 'update'])->name('sliders.update');
    Route::delete('{sliderId}', [SliderController::class, 'destroy'])->name('sliders.destroy');
});
