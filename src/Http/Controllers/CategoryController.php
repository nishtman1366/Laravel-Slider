<?php

namespace Nishtman\LaravelSlider\Http\Controllers;

use Illuminate\Http\Request;
use Nishtman\LaravelSlider\Models\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('sliders')->orderBy('id', 'DESC')
            ->paginate();

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function create(Request $request)
    {
        return response()
            ->json([
                'statuses' => [
                    'SLIDER_CATEGORY_CREATED' => 'ایجاد شده',
                    'SLIDER_CATEGORY_ACTIVE' => 'فعال',
                    'SLIDER_CATEGORY_INACTIVE' => 'غیرفعال',
                    'SLIDER_CATEGORY_DELETED' => 'حذف شده',
                ],
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:SLIDER_CATEGORY_CREATED,SLIDER_CATEGORY_ACTIVE,SLIDER_CATEGORY_INACTIVE,SLIDER_CATEGORY_DELETED',
        ]);

        $category = Category::create($request->all());

        return response()->json($category);
    }

    public function edit(Request $request)
    {
        $id = (int)$request->route('categoryId');
        $category = Category::find($id);
        if (is_null($category)) {
            throw new NotFoundHttpException('دسته بندی اسلایدر تصویر یافت نشد.');
        }

        return response()->json([
            'category' => $category,
            'statuses' => [
                'SLIDER_CATEGORY_CREATED' => 'ایجاد شده',
                'SLIDER_CATEGORY_ACTIVE' => 'فعال',
                'SLIDER_CATEGORY_INACTIVE' => 'غیرفعال',
                'SLIDER_CATEGORY_DELETED' => 'حذف شده',
            ],
        ]);
    }

    public function update(Request $request)
    {
        $id = (int)$request->route('categoryId');
        $category = Category::find($id);
        if (is_null($category)) {
            throw new NotFoundHttpException('دسته بندی اسلایدر تصویر یافت نشد.');
        }

        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:SLIDER_CATEGORY_CREATED,SLIDER_CATEGORY_ACTIVE,SLIDER_CATEGORY_INACTIVE,SLIDER_CATEGORY_DELETED',
        ]);

        $category->fill($request->all());
        $category->save();

        return response()->json($category);
    }

    public function destroy(Request $request)
    {
        $id = (int)$request->route('categoryId');
        $category = Category::find($id);
        if (is_null($category)) {
            throw new NotFoundHttpException('دسته بندی اسلایدر تصویر یافت نشد.');
        }
        $category->delete();

        return response()->json();
    }
}
