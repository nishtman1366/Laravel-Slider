<?php

namespace Nishtman\LaravelSlider\Http\Controllers;

use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([1, 2, 3]);
    }
}
