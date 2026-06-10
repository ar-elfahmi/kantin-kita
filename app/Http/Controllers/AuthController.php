<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        $user = Auth::user();

        if (! $user || ! in_array($user->role, ['admin', 'vendor'], true)) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Akun Anda tidak memiliki akses ke dashboard.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $redirectTo = $user->role === 'admin' ? '/admin' : '/dashboard';

        return redirect()->intended($redirectTo);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
