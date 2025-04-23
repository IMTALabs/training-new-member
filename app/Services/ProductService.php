<?php

namespace App\Services;

use App\Models\admin\Product;

class ProductService{
    public function getAllProduct($request) {
        $query = Product::with('category');

        if (!empty($request->filled('name'))) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        if (!empty($request->filled('category'))) {
            $query->where('category_id', $request->category);
        }
    
        if (!empty($request->filled('status'))) {
            $query->where('status', $request->status);
        }
    
        if (!empty($request->filled('sort'))) {
            $query->orderBy('price', $request->sort);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function deleteProduct($id)
    {
        return Product::destroy($id);
    }
}