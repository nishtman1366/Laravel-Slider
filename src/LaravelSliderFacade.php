<?php

namespace Nishtman\LaravelSlider;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nishtman\LaravelSlider\LaravelSlider
 */
class LaravelSliderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-slider';
    }
}
