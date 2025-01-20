<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    /**
     * Register a new user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        return view('auth.register');
    }


//    public function index(): View
//    {
//        return view('index');
//
//    }
    public function login( )
    {
        //\Auth::logout();
        return view('login_1');
    }

    public function forgotPassword( )
    {
        return view('forgot-password');
    }
//    public function forgotPasswordValidate( )
//    {
//        return view('forgot-password');
//    }
    public function updatePassword( )
    {
        return view('reset-password');
    }
}
