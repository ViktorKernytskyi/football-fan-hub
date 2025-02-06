<?php

namespace App\Http\Controllers\Auth;


use Illuminate\View\View;
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
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
            'client_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $client = Client::create([
            'client_name' => $request->client_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //Auth::login($client); // Автоматичний вхід після реєстрації

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

        $client = Client::where('email', $request->email)->first();

        if ($client) {

            if (Hash::check($request->password, $client->password)) {
                auth()->loginUsingId($client->id);
                dd($request->password);
                return redirect('/')->with('success', 'Success! You are logged in');
            }
            return back()->with('failed', 'Failed! Invalid password');
        }
        return back()->with('failed', 'Failed! Invalid email');
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
    public function registerForm()
    {
        return view('auth.register');
    }

}
