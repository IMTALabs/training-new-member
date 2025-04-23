@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
    <main id="main-container">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fs-4 fw-bold">Quản lý danh mục</h2>
                <a class="btn btn-success" href="{{ route('admin.categories.create') }}">
                    <i class="fa fa-plus me-1"></i> Thêm danh mục
                </a>
            </div>

            <!-- Bộ lọc -->
            <div class="block block-rounded mb-4">
                <div class="block-content">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm danh mục..."
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="parent_id" class="form-select">
                                <option value="">Tất cả danh mục cha</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ request('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search me-1"></i> Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bảng danh sách -->
            <div class="block block-rounded">
                <div class="block-content">
                    <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark">
                                        ID
                                        @if(request('sort') == 'id')
                                            <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark">
                                        Tên danh mục
                                        @if(request('sort') == 'name')
                                            <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Ảnh</th>
                                <th>Slug</th>
                                <th>Mô tả</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'is_active', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark">
                                        Trạng thái
                                        @if(request('sort') == 'is_active')
                                            <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Danh mục con</th>
                                <th>Danh mục cha</th>
                                <th class="text-center" style="width: 100px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <th class="text-center" scope="row">{{ $category->id }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->image)
                                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                                style="width: 50px; height: auto;">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ Str::limit($category->description, 50) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $category->is_active ? 'success' : 'danger' }}">
                                            {{ $category->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($category->children->count() > 0)
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($category->children as $child)
                                                    <li>{{ $child->name }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted">Không có</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($category->parent)
                                            {{ $category->parent->name }}
                                        @else
                                            <span class="text-muted">Không có</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.categories.show', $category->slug) }}"
                                                class="btn btn-sm btn-secondary" title="Chi tiết">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category->slug) }}"
                                                class="btn btn-sm btn-primary" title="Sửa">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category->slug) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Không có danh mục nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Phân trang -->
            <div class="d-flex justify-content-end my-4">
                {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script>
        // Xử lý sắp xếp
        document.querySelectorAll('th a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = this.href;
            });
        });
    </script>
@endpush
