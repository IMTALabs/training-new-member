<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function edit()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để chỉnh sửa thông tin.');
        }

        return view('user.edit', ['id' => Auth::user()->id]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        // Lấy dữ liệu từ request sau khi đã được xác thực
        $data = $request->only([
            'name',
            'phone_number',
            'address',
            'date_of_birth',
            'gender'
        ]);




        // Kiểm tra và xử lý upload avatar nếu có
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Lưu avatar mới
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        // Cập nhật thông tin người dùng
        $user->update($data);

        // Quay lại trang chỉnh sửa với thông báo thành công
        return redirect()->route('profile.edit')->with('success', 'Cập nhật thông tin thành công!');
    }
}
