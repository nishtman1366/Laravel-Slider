<?php

use Illuminate\Support\Facades\Route;
use Nishtman\LaravelSlider\Http\Controllers\SliderController;

Route::get('', [SliderController::class, 'index'])->name('sliders.list');
