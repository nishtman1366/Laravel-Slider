<?php

namespace Nishtman\LaravelSlider;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nishtman\LaravelSlider\LaravelSlider
 * @method static LaravelSlider setCategoryId(int $id)
 * @method array getItems
 */
class LaravelSliderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LaravelSlider';
    }
}
