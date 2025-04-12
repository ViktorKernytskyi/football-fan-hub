<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**
     * Показати форму входу
     */
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

        return redirect()->route('login')->withErrors('success', 'Registration successful! You are logged in.');
    }
    /**
     * Показати форму для входу
     */
    public function login()
    {
        return view('auth.login');
    }
    /**
     * Валідація даних для входу
     */
    public function loginValidate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $client = Client::where('email', $request->email)->first();

        if ($client) {

            if (Hash::check($request->password, $client->password)) {

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

    /**
     * Показати форму для відновлення пароля
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }
    /**
     * Відправити посилання для скидання пароля
     */
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

    /**
     * Показати форму для скидання пароля
     */
    public function resetPassword($token, $email = null)
    {
        return view('auth.password.reset', [
            'token' => $token,
            'email' => $email
        ]);
    }
    /**
     * Зберегти новий пароль після скидання
     */
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
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect()->route('login')->with('success', 'Success! Password reset link has been sent to your email.')
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Оновити пароль
     */
    public function updatePassword(Request $request)
    {
        // Валідація введених даних
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Оновлення пароля
        $status = Password::broker('clients')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
//        $status = Password::reset(
//            [
//                'email' => $request->email,
//                'password' => $request->password,
//                'password_confirmation' => $request->password_confirmation,
//                'token' => $token
//            ],
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
          }
    /**
     * Вийти з акаунту
     */
    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Показати форму реєстрації
     */
    public function registerForm()
    {
        return view('auth.register');
    }
    /**
     * Показати форму для скидання пароля
     */
//    public function showResetPasswordForm($token, $email)
//    {
//        return view('auth.password.reset', [
//            'token' => $token,
//            'email' => $email,
//        ]);
//    }
    public function showResetPasswordForm(string $token)
    {
        $email = request()->query('email'); // Отримуємо email з URL (наприклад: ?email=user@example.com)

        return view('auth.reset-password', compact('token', 'email'));
    }

}
