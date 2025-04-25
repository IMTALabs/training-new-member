@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products > index')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">List Products</h4>
            </div><!-- end card header -->

            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2 mx-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2 mx-2" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                <div class="listjs-table" id="customerList">
                    <div class="card p-3 shadow-sm mb-4 border-0">
                        <form method="GET" action="" class="row gy-2 gx-3 align-items-center">
                            <!-- Tìm theo tên -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Search Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter product name"
                                    value="{{ request('name') }}">
                            </div>

                            <!-- Lọc theo danh mục -->
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category')==$category->id ?
                                        'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Lọc theo trạng thái -->
                            <div class="col-md-2">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All</option>
                                    <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                            <!-- Sắp xếp theo giá -->
                            <div class="col-md-2">
                                <label class="form-label fw-bold">Sort by Price</label>
                                <select name="sort" class="form-select">
                                    <option value="">Default</option>
                                    <option value="asc" {{ request('sort')=='asc' ? 'selected' : '' }}>Low to High
                                    </option>
                                    <option value="desc" {{ request('sort')=='desc' ? 'selected' : '' }}>High to Low
                                    </option>
                                </select>
                            </div>

                            <!-- Nút lọc -->
                            <div class="col-md-2 d-grid align-self-end">
                                <button type="submit" class="btn btn-primary"><i class="ri-search-line me-1"></i>
                                    Filter</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light mb-3">
                                <tr>
                                    <th class="sort">Serial</th>
                                    <th class="sort">Name</th>
                                    <th class="sort">Categories</th>
                                    <th class="sort">Price</th>
                                    <th class="sort">Image</th>
                                    <th class="sort">Status</th>
                                    <th class="sort">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($products as $key=>$item)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->category->name}}</td>
                                    <td>{{number_format($item->price)}}</td>
                                    <td><img src="{{asset('storage/' . $item->image)}}" alt="{{$item->name}}"></td>
                                    <td><span
                                            class="badge bg-success-subtle text-success text-uppercase">{{$item->status}}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('admin.product.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <div class="remove">
                                                    <button type="submit" class="btn btn-sm btn-danger remove-item-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteRecordModal">Remove</button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            {{$products->links()}}
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>

@endsection