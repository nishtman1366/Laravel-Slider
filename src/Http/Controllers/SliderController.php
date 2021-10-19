<?php

namespace Nishtman\LaravelSlider\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nishtman\LaravelSlider\Models\Slider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = (int)$request->route('categoryId');
        $sliders = Slider::with('category')
            ->where('category_id', $categoryId)
            ->orderBy('id', 'DESC')
            ->paginate();

        return response()->json([
            'sliders' => $sliders,
            'statuses' => [
                'SLIDER_CREATED' => 'ایجاد شده',
                'SLIDER_ACTIVE' => 'فعال',
                'SLIDER_INACTIVE' => 'غیرفعال',
                'SLIDER_DELETED' => 'حذف شده',
            ],
        ]);
    }

    public function create(Request $request)
    {
        return response()
            ->json([
                'statuses' => [
                    'SLIDER_CREATED' => 'ایجاد شده',
                    'SLIDER_ACTIVE' => 'فعال',
                    'SLIDER_INACTIVE' => 'غیرفعال',
                    'SLIDER_DELETED' => 'حذف شده',
                ],
            ]);
    }

    public function store(Request $request)
    {
        $categoryId = (int)$request->route('categoryId');
        $request->merge(['category_id' => $categoryId]);
        $request->validate([
            'category_id' => 'required|exists:sliders_categories,id',
            'title' => 'required',
            'image' => 'required|file|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml',
            'status' => 'required|in:SLIDER_CREATED,SLIDER_ACTIVE,SLIDER_INACTIVE,SLIDER_DELETED',
        ]);

        $slider = Slider::create($request->except(['image']));

        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $ext;
        $file->storeAs(sprintf('sliders/%s/%s', $slider->category_id, $slider->id), $fileName, 'public');
        $slider->image = $fileName;
        $slider->save();

        return response()->json($slider);
    }

    public function edit(Request $request)
    {
        $id = (int)$request->route('sliderId');
        $slider = Slider::find($id);
        if (is_null($slider)) {
            throw new NotFoundHttpException('اسلایدر تصویر یافت نشد.');
        }

        return response()->json([
            'slider' => $slider,
            'statuses' => [
                'SLIDER_CREATED' => 'ایجاد شده',
                'SLIDER_ACTIVE' => 'فعال',
                'SLIDER_INACTIVE' => 'غیرفعال',
                'SLIDER_DELETED' => 'حذف شده',
            ],
        ]);
    }

    public function update(Request $request)
    {
        $id = (int)$request->route('sliderId');
        $slider = Slider::find($id);
        if (is_null($slider)) {
            throw new NotFoundHttpException('اسلایدر تصویر یافت نشد.');
        }
        $categoryId = (int)$request->route('categoryId');
        $request->merge(['category_id' => $categoryId]);
        $request->validate([
            'category_id' => 'required|exists:sliders_categories,id',
            'title' => 'required',
            'image' => 'nullable|file|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml',
            'status' => 'required|in:SLIDER_CREATED,SLIDER_ACTIVE,SLIDER_INACTIVE,SLIDER_DELETED',

        ]);

        $slider->fill($request->except(['image']));
        if ($request->hasFile('image')) {
            Storage::disk('public')
                ->delete(sprintf(
                    'sliders/%s/%s/%s',
                    $slider->category_id,
                    $slider->id,
                    $slider->image
                ));

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $ext;
            $file->storeAs(sprintf('sliders/%s/%s', $slider->category_id, $slider->id), $fileName, 'public');
            $slider->image = $fileName;
        }
        $slider->save();

        return response()->json($slider);
    }

    public function destroy(Request $request)
    {
        $id = (int)$request->route('sliderId');
        $slider = Slider::find($id);
        if (is_null($slider)) {
            throw new NotFoundHttpException('اسلایدر تصویر یافت نشد.');
        }
        Storage::disk('public')
            ->delete(sprintf(
                'sliders/%s/%s/%s',
                $slider->category_id,
                $slider->id,
                $slider->image
            ));
        $slider->delete();

        return response()->json();
    }
}
