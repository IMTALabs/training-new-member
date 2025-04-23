<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        // Tìm kiếm
        if ($request->has('search')) {
            $search = $request->search;
            if (!empty($search)) {
                $query->where('name', 'like', '%' . $search . '%');
            }
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status == '1' ? 1 : 0);
        }

        // Lọc theo danh mục cha
        if ($request->has('parent_id') && $request->parent_id != '') {
            $query->where('parent_id', $request->parent_id);
        }

        // Sắp xếp
        $sortField = $request->get('sort', 'id');
        $sortDirection = $request->get('direction', 'desc');

        // Validate sort field
        $allowedSortFields = ['id', 'name', 'created_at', 'is_active'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'id';
        }

        $query->orderBy($sortField, $sortDirection);

        $categories = $query->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }
    
}
