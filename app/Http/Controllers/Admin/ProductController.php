<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'import_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'quantity' => 'required|integer|min:0',
            'views' => 'nullable|integer|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'status' => 'required|in:active,inactive',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

    // Validate dữ liệu
    $request->validate([
        'name'           => 'required|string|max:255',
        'category_id'    => 'required|exists:categories,id',
        'price'          => 'required|numeric',
        'import_price'   => 'nullable|numeric',
        'discount_price' => 'nullable|numeric',
        'quantity'       => 'required|integer|min:0',
        'status'         => 'required|string',
        'description'    => 'nullable|string',
        'image'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Cập nhật thông tin
    $product->name           = $request->name;
    $product->category_id    = $request->category_id;
    $product->price          = $request->price;
    $product->import_price   = $request->import_price;
    $product->discount_price = $request->discount_price;
    $product->quantity       = $request->quantity;
    $product->status         = $request->status;
    $product->description    = $request->description;

    // Xử lý ảnh nếu có upload mới
    if ($request->hasFile('image')) {
        // Xóa ảnh cũ nếu tồn tại
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }

        // Lưu ảnh mới
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
    }

    $product->save();

    return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
