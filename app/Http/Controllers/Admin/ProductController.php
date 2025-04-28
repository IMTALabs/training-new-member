<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    
    public function index(Request $request){
        $products = $this->productService->getAllProduct($request);
        $categories = Category::all(); 
        return view('admin.products.listProduct', compact('products', 'categories'));
    }

    public function destroy($id)
    {
        $result = $this->productService->deleteProduct($id);

        if ($result) {
            return redirect()->back()->with('success', 'Product delete successfully.');
        } else {
            return redirect()->back()->with('error', 'Product delete failed.');
        }
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('admin.product.listProducts')->with('success', 'Thêm sản phẩm thành công!');
    }
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);

        // Validate dữ liệu
        $validated = $request->validated();

        $product->fill($validated);
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

            $image = $request->file('image');

            // Kiểm tra kích thước ảnh
            if ($image->getSize() > 2048 * 1024) {
                return back()->withErrors(['image' => 'Ảnh vượt quá dung lượng cho phép (2MB).']);
            }

            // Lưu ảnh mới
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }
        $product->save();
        return redirect()->route('admin.product.listProducts')->with('success', 'Cập nhật sản phẩm thành công!');
    }



}
