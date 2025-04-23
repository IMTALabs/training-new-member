<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Admin\Category;

class CategoryController extends Controller
{
    public function index() {}

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        // Thêm dữ liệu
        Category::create($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Category has been created successfully');
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        if (!$category) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Category not found');
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Category has been updated successfully');
    }
}
