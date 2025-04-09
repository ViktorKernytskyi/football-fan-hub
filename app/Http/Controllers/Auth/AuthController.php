<?php

namespace App\Http\Controllers\Auth;


use Illuminate\View\View;
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Psy\Util\Str;

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
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|min:6|confirmed'
        ]);

        Client::create([
            'client_name' => $request->client_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //Auth::login($client); // Автоматичний вхід після реєстрації

        return redirect()->route('login')->withErrors('success', 'Registration successful! You are logged in.');
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
                //auth()->login($client);
               // auth()->loginUsingId($client->id);
                //dd(Auth::guard('client')->user());

                auth()->guard('client')->loginUsingId($client->id);

                session(['client' => $client]);
             //   dd(session('client')); // додайте для перевірки, чи зберігаються дані користувача

                // dd($request->password);
                return redirect()->route('login')->with('success',  'Привіт, ' . $client->client_name . '! Ви успішно увійшли' . 'Success! You are logged in');
            }
            return back()->with('failed', 'Failed! Invalid password');
        }
        return back()->with('failed', 'Failed! Invalid email');
    }


    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function storeForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $status = Password::broker('clients')->sendResetLink(
            $request->only('email')
        );
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', trans($status));
        }
        return back()->withInput()->with($request->only('email'))
                     ->withErrors(['email' => __($status)]);
    }



//    public function forgotPasswordValidate($token)
//    {
//        $client = Client::where('token', $token)->where('is_verified', 0)->first();
//        dd($token);
//        if ($client) {
//            $email = $client->email;
//            return view('auth.change-password',  ['email' => $client->email]);
//        }
//        return redirect()->route('auth.forgot-password')->with('failed', 'Password reset link is expired');
//    }
    public function resetPassword($token, $email = null)
    {
        return view('auth.password.reset', [
            'token' => $token,
            'email' => $email
        ]);
    }
    public function storeResetPassword(Request $request, $token, $email)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        if ($request->email !== $email) {
            return back()->withErrors(['email' => 'Email does not match the token.']);
        }
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation') + ['token' => $token],
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => bcrypt($request->password),
                ])->save();
            }
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect()->route('login')->with('success', 'Success! Password reset link has been sent to your email.')
            : back()->withErrors(['email' => [__($status)]]);
    }

//    public function storeResetPassword(Request $request)
//    {
//        $request->validate([
//            'email' => 'required|email',
//        ]);
//
//        $status = Password::sendResetLink($request->only('email'));
//
//        return $status === Password::RESET_LINK_SENT
//            ? back()->with(['success' => __($status)])
//            : back()->withErrors(['email' => __($status)]);
//        }


    public function updatePassword(Request $request, $token)
    {
        // Валідація введених даних
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Оновлення пароля
        $status = Password::reset(
            [
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'token' => $token
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        // Перевіряємо результат
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Success! Password has been changed.')
            : back()->with('failed', 'Failed! Unable to reset password.');
        //return view('auth.reset-password');
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }


    public function registerForm()
    {
        return view('auth.register');
    }
    public function showResetPasswordForm($token, $email)
    {
        return view('auth.password.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

}
