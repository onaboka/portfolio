<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'], // Это универсальное поле
            'password' => ['required', 'string'],
        ]);

        // Определяем, что ввел пользователь: email или username
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Пытаемся аутентифицировать пользователя
        if (Auth::attempt([$loginField => $request->login, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Если аутентификация не удалась
        return back()->withErrors([
            'login' => __('The provided credentials do not match our records.'),
        ])->onlyInput('login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
