<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
