<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLogin()
    {
        // Jika sudah login, langsung arahkan ke dashboard
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    /**
     * Memproses autentikasi login.
     */
    public function login(Request $request)
    {
        // 1. Validasi input dari form login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba autentikasi dengan email & password
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // 3. Regenerasi session untuk keamanan (mencegah Session Fixation Attack)
            $request->session()->regenerate();

            // 4. Redirect ke dashboard dengan pesan selamat datang
            $user = Auth::user();
            $roleName = $user->role === 'admin' ? 'Admin' : 'Barista';

            return redirect()->intended('/dashboard')
                ->with('success', 'Selamat datang, ' . $user->name . '! Anda login sebagai ' . $roleName . '.');
        }

        // 5. Jika gagal, kembalikan ke form login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session & regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
