<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * @method validate(Request $request, string[] $array)
 */
class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view(view: 'auth.login');
    }
    /**
     * Register a new user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
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
public function loginValidate(Request $request)
{
    $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:6'
    ]);

    $user = User::where('email', $request->email)->first();
    if ($user) {
        if (Hash::check($request->password, $user->password)) {
            auth()->loginUsingId($user->id);
            return redirect('/')->with('success', 'Success! You are logged in');
        }
        return back()->with('failed', 'Failed! Invalid password');
    }
    return back()->with('failed', 'Failed! Invalid email');

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
