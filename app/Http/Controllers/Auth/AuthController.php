<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password as PasswordFacade;

class AuthController extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */

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
            dd(Auth::user()->name);
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

    public function sendResetLinkEmail(Request $request)
    {
        // Thêm rate limiting
        $key = 'password-reset:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) { // 3 lần/phút
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['email' => "Vui lòng đợi {$seconds} giây trước khi thử lại."]);
        }

        RateLimiter::hit($key, 60); // Tăng số lần thử trong 60 giây

        // Validate đầu vào
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.exists' => 'Email này không tồn tại trong hệ thống'
        ]);

        try {
            // Lấy email từ input của người dùng
            $userEmail = $request->input('email');

            // Gửi link reset password
            $status = PasswordFacade::sendResetLink(
                ['email' => $userEmail]
            );

            // Kiểm tra kết quả và trả về response phù hợp
            if ($status === PasswordFacade::RESET_LINK_SENT) {
                return back()->with('status', 'Chúng tôi đã gửi email khôi phục mật khẩu cho bạn!');
            } else {
                return back()->withErrors(['email' => __($status)]);
            }
        } catch (\Exception $e) {
            Log::error('Password Reset Error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.']);
        }
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.pass-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = PasswordFacade::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === PasswordFacade::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    private function debugMailSetup()
    {
        try {
            Mail::raw('Test email content', function (Message $message) {
                $message->to('namvtph51016@gmail.com')
                    ->subject('Test Email');
            });
            Log::info('Email sent successfully');
            return true;
        } catch (\Exception $e) {
            Log::error('Mail Error: ' . $e->getMessage());
            return false;
        }
    }
}
