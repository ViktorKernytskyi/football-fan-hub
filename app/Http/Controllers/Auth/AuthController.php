<?php

namespace App\Http\Controllers\Auth;


use Illuminate\View\View;
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user); // Автоматичний вхід після реєстрації

        return redirect('/')->with('success', 'Registration successful! You are logged in.');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginValidate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/')->with('success', 'Success! You are logged in.');
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function updatePassword()
    {
        return view('auth.reset-password');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'You have been logged out.');
    }
}
