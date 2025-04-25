<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
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

    public function login(LoginRequest $request)
    {
        $key = 'login-attempts:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 6)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => ["Too many login attempts. Please try again in $seconds seconds."]
            ]);
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            RateLimiter::clear($key); // Xóa đếm khi đăng nhập thành công
            $request->session()->regenerate(); // Bảo mật session

            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($key, 60);
        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'avatar' => null,
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'role' => $request->role ?? 'user',
            'status' => '1',
        ]);

        Auth::attempt([
            'email' => $user->email,
            'password' => $validated['password'],
        ]);

        $key = 'login-attempts:' . $request->ip();
        RateLimiter::clear($key);
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $key = 'password-reset:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['email' => "Vui lòng đợi {$seconds} giây trước khi thử lại."]);
        }

        RateLimiter::hit($key, 60);

        try {
            $status = PasswordFacade::sendResetLink(
                ['email' => $request->email]
            );

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

    public function reset(ResetPasswordRequest $request)
    {
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
