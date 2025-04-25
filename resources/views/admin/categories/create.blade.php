@extends('layouts.admin')

@section('title', 'Create category')

@section('content')

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Create category</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                    class="form-steps" autocomplete="off">
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="steparrow-description-info" role="tabpanel"
                            aria-labelledby="steparrow-description-info-tab">
                            <div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category name</label>
                                    <input type="text" name="name"
                                        class="form-control  @error('name') is-invalid @enderror"
                                        placeholder="Enter category name" value="{{ old('name') }}" id="name">
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" name="status" value="{{ old('status') }}"
                                        class="form-control @error('status') is-invalid @enderror"
                                        placeholder="Enter status">
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-3 mt-4">
                                <a href="{{ route('admin.categories.index') }}"
                                    class="btn btn-light btn-label previestab"><i
                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to
                                    General</a>
                                <button type="submit" class="btn btn-success right ms-auto nexttab nexttab">Add
                                    category</button>
                            </div>
                        </div>
                        <!-- end tab pane -->
                    </div>
                    <!-- end tab content -->
                </form>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->

@endsection
