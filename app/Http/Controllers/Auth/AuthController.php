<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showResetForm()
    {
        return view('auth.pass-reset');
    }

    public function showForgotPassword()
    {
        return view('auth.pass-forgot');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Giới hạn 6 lần/phút
        $key = 'login-attempts:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 6)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => ["Too many login attempts. Please try again in $seconds seconds."]
            ]);
        }

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($key); // Xóa đếm khi đăng nhập thành công
            $request->session()->regenerate(); // Bảo mật session
            return redirect()->intended('/');
            // dd(Auth::user()->name);
        }
        RateLimiter::hit($key, 60);
        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'confirmed',
                Password::min(8) // độ dài tối thiểu
                    ->mixedCase() // chữ hoa, chữ thường
                    ->letters() // chứa chữ
                    ->numbers() // chứa số
                    ->symbols() // chứa ký tự đặc biệt
            ],
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => null,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role' => $request->role ?? 'user',
            'status' => '1',
        ]);
        //  dd($user);
        Auth::attempt([
            'email' => $user->email,
            'password' => $user->password,

        ]);
        // dd($user);
        $key = 'login-attempts:' . $request->ip();
        RateLimiter::clear($key); // Xóa đếm khi đăng nhập thành công
        $request->session()->regenerate(); // Bảo mật session
        return redirect()->intended('/');
        // dd(Auth::user()->name);

    }
}
