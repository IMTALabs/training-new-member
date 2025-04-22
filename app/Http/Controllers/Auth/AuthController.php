<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

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
            $status = Password::sendResetLink(
                ['email' => $userEmail]
            );

            // Kiểm tra kết quả và trả về response phù hợp
            if ($status === Password::RESET_LINK_SENT) {
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

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
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
