@extends('layouts.admin')
@section('title')
    <title>Create Product</title>
@endsection
@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg p-4">
            <h2 class="text-center mb-4">Create Product</h2>
            <form action="{{ route('admin.products.store') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Tên Sản Phẩm</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Nhập tên sản phẩm" value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Danh Mục</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">Chọn danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Giá Nhập</label>
                        <input type="number" name="import_price" step="0.01"
                            class="form-control @error('import_price') is-invalid @enderror"
                            value="{{ old('import_price') }}">
                        @error('import_price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Giá Bán</label>
                        <input type="number" name="price" step="0.01"
                            class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Giá Khuyến Mãi</label>
                        <input type="number" name="discount_price" step="0.01" class="form-control"
                            value="{{ old('discount_price') }}">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Số Lượng</label>
                        <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                            value="{{ old('quantity') }}">
                        @error('quantity')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Lượt Xem</label>
                        <input type="number" name="views" class="form-control" value="{{ old('views', 0) }}">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Đánh Giá (1-5)</label>
                        <input type="number" name="rating" class="form-control" step="0.1" min="0"
                            max="5" value="{{ old('rating', 0) }}">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Trạng Thái</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="">Chọn trạng thái</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hiển thị</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Hình Ảnh</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="mb-3 col-12">
                        <label class="form-label">Mô Tả</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="" class="btn btn-warning">Quay Lại</a>
                    <button type="submit" class="btn btn-primary">Tạo Mới</button>
                </div>
            </form>
        </div>
    </div>
@endsection
