@extends('layouts.admin')

@section('title', 'Sửa Tài Khoản')

@section('css')
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="auth-page-wrapper pt-5">
        

        <!-- auth page content -->
        

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Sửa Tài Khoản</h5>
                                </div>

                                <div class="p-2 mt-4">
                                    <form method="POST" action="{{ route('admin.user.update', ['id' => Auth::user()->id]) }}" class="needs-validation" novalidate>
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                placeholder="Enter email address" required value="{{ old('email', Auth::user()->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Tên người dùng <span class="text-danger">*</span></label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                placeholder="Enter name" required value="{{ old('name', Auth::user()->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        

                                        {{-- Ngày sinh --}}
                                        <div class="mb-3">
                                            <label for="date_of_birth" class="form-label">Ngày sinh</label>
                                            <input type="date" name="date_of_birth" class="form-control"
                                                value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}">
                                        </div>

                                        {{-- Giới tính --}}
                                        <div class="mb-3">
                                            <label class="form-label">Giới tính</label>
                                            <select name="gender" class="form-select">
                                                <option value="">Chọn giới tính</option>
                                                <option value="male" {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                                                <option value="female" {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                                            </select>
                                        </div>

                                        {{-- Số điện thoại --}}
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Số điện thoại</label>
                                            <input type="text" name="phone_number" class="form-control"
                                                value="{{ old('phone_number', Auth::user()->phone_number) }}">
                                        </div>

                                        {{-- Địa chỉ --}}
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Địa chỉ</label>
                                            <textarea name="address" class="form-control" rows="2">{{ old('address', Auth::user()->address) }}</textarea>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Lưu thay đổi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                       
                    </div>
                </div>
            </div>
        </div>

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="mb-0 text-muted">&copy; {{ date('Y') }} Crafted with <i
                                class="mdi mdi-heart text-danger"></i> </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/passowrd-create.init.js') }}"></script>
@endsection
