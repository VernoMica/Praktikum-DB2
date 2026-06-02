<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login admin
    public function showLoginForm() {
        return view('admin.auth.login');
    }
    
    // Memproses login admin
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard'); //Arahkan ke dashboard admin setelah login sukses
        }

        return back()->withErrors([
            'email' => 'Email atau password yang anda berikan tidak terdaftar di rekaman kami.'
            ]);
    }

    // Memproses logout admin
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
