<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Services\ProductService;
use Illuminate\Http\Request;

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
}
