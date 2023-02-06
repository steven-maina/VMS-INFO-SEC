<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthenticationController extends Controller
{
    // Login v1
    public function login_v1()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-login-v1', ['pageConfigs' => $pageConfigs]);
    }

    // Login v2
    public function login_v2()
    {
        $pageConfigs = ['blankPage' => true];

        return view('content.authentication.auth-login-v2', ['pageConfigs' => $pageConfigs]);
    }

    // Register v1
    public function register_v1()
    {
        $pageConfigs = ['blankPage' => true];

        return view('content.authentication.auth-register-v1', ['pageConfigs' => $pageConfigs]);
    }

    // Register v2
    public function register_v2()
    {
        $pageConfigs = ['blankPage' => true];

        return view('content.authentication.auth-register-v2', ['pageConfigs' => $pageConfigs]);
    }

    public function store_user(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    // Forgot Password v1
    public function forgot_password_v1()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-forgot-password-v1', ['pageConfigs' => $pageConfigs]);
    }

    // Forgot Password v2
    public function forgot_password_v2()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-forgot-password-v2', ['pageConfigs' => $pageConfigs]);
    }

    // Reset Password
    public function reset_password_v1()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-reset-password-v1', ['pageConfigs' => $pageConfigs]);
    }

    // Reset Password
    public function reset_password_v2()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-reset-password-v2', ['pageConfigs' => $pageConfigs]);
    }
}
