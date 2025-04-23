<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;

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
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Category has been updated successfully');
    }
}
