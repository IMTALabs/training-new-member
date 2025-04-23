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
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark">
                                        Trạng thái
                                        @if(request('sort') == 'status')
                                            <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark">
                                        Ngày tạo
                                        @if(request('sort') == 'created_at')
                                            <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'updated_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark">
                                        Ngày cập nhật
                                        @if(request('sort') == 'updated_at')
                                            <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center col-3" style="width: 100px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <th class="text-center" scope="row">{{ $category->id }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $category->status ? 'success' : 'danger' }}">
                                            {{ $category->status ? 'Hoạt động' : 'Không hoạt động' }}
                                        </span>
                                    </td>
                                    <td>{{ $category->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $category->updated_at->format('d/m/Y H:i:s') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.categories.show', $category->id) }}"
                                                class="btn btn-sm btn-secondary" title="Chi tiết">
                                                <i class="fa fa-eye">Chi Tiết</i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                class="btn btn-sm btn-primary" title="Sửa">
                                                <i class="fa fa-pencil">Sửa</i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST"
                                                class="d-inline delete-category"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                    <i class="fa fa-trash">Xóa</i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Không có danh mục nào</td>
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

        // Xử lý xóa danh mục
        document.querySelectorAll('.delete-category').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const url = form.getAttribute('action');

                // Gửi request kiểm tra trước khi xóa
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'confirm') {
                        // Hiển thị hộp thoại xác nhận
                        if (confirm(data.message)) {
                            // Nếu người dùng xác nhận, gửi request xóa với flag xác nhận
                            fetch(url + '?confirm_delete=1', {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    // Reload trang sau khi xóa thành công
                                    window.location.reload();
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                alert('Có lỗi xảy ra khi xóa danh mục');
                            });
                        }
                    } else if (data.status === 'success') {
                        // Nếu không cần xác nhận và xóa thành công
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    alert('Có lỗi xảy ra khi xóa danh mục');
                });
            });
        });
    </script>
@endpush
