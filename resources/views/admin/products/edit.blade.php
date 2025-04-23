@extends('layouts.admin')

@section('title')
    <title>Edit Product</title>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg p-4">
            <h2 class="text-center mb-4">Edit Product</h2>
            <form action="{{ route('admin.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Tên Sản Phẩm</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Danh Mục</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Giá Gốc</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price', $product->price) }}">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Giá Nhập</label>
                        <input type="number" name="import_price" class="form-control"
                            value="{{ old('import_price', $product->import_price) }}">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Giá Khuyến Mãi</label>
                        <input type="number" name="discount_price" class="form-control"
                            value="{{ old('discount_price', $product->discount_price) }}">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Số Lượng</label>
                        <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                            value="{{ old('quantity', $product->quantity) }}">
                        @error('quantity')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Trạng Thái</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Hiện
                            </option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                                Ẩn</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Hình Ảnh Hiện Tại</label><br>
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Ảnh hiện tại" width="100">
                        @endif
                        <input type="file" name="image" class="form-control mt-2">
                    </div>

                    <div class="mb-3 col-12">
                        <label class="form-label">Mô Tả</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="" class="btn btn-warning">Quay Lại</a>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
@endsection
