<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Coba login otomatis (Hash password dicek otomatis oleh Laravel)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard'); // Redirect ke dashboard jika sukses
        }

        // Jika gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 2. Proses Simpan User Baru
    public function register(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|unique:users,username|alpha_dash', // alpha_dash: hanya huruf, angka, dash, underscore
            'password'  => 'required|string|min:6|confirmed', // confirmed: harus ada input name="password_confirmation"
            'role'      => 'required|in:ADMIN,STAFF', // Opsional: Bisa dipilih saat register
        ]);

        // Simpan ke Database
        $user = User::create([
            'name'      => $validated['name'],
            'username'  => $validated['username'],
            'password'  => Hash::make($validated['password']), // Hashing Password Laravel 12
            'role'      => $validated['role'],
        ]);

        // Opsi A: Langsung Login setelah daftar
        // Auth::login($user);
        // return redirect()->intended('dashboard')->with('success', 'Akun berhasil dibuat dan login.');

        // Opsi B (Lebih aman): Redirect ke login page
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
