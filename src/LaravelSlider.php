<?php

namespace Nishtman\LaravelSlider;

use Illuminate\Database\Eloquent\Collection;
use Nishtman\LaravelSlider\Models\Slider;

class LaravelSlider
{
    private int $categoryId;
    private Collection $items;

    public function setCategoryId(int $id)
    {
        $this->items = Slider::where('category_id', $id)->get();

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }
}
