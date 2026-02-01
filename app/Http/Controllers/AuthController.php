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
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'username.required' => 'Username wajib diisi, jangan dikosongkan ya.',
            'password.required' => 'Password harus diisi untuk masuk.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

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

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|unique:users,username|alpha_dash',
            'password'  => 'required|string|min:6|confirmed',
            // 'role'      => 'required|in:ADMIN,STAFF',
        ], [
            'name.required'      => 'Nama Lengkap wajib diisi.',
            'name.max'           => 'Nama terlalu panjang, maksimal 255 karakter.',

            'username.required'  => 'Username tidak boleh kosong.',
            'username.unique'    => 'Username ini sudah dipakai orang lain, coba cari yang lain.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip (-), dan garis bawah (_).',

            'password.required'  => 'Password wajib dibuat.',
            'password.min'       => 'Password minimal harus 6 karakter agar aman.',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password baru.',

            // 'role.required'      => 'Silakan pilih Role (Peran) terlebih dahulu.',
            // 'role.in'            => 'Role yang dipilih tidak valid.',
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'username'  => $validated['username'],
            'password'  => Hash::make($validated['password']),
            // 'role'      => $validated['role'],
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
