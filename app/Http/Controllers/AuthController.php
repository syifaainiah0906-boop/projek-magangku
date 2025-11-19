<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // 2. Buat akun baru dengan role default "user"
        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'password' => Hash::make($request->password),
            'role' => 'user', // 🔹 default bukan alumni lagi
        ]);

        // 3. Redirect ke login setelah berhasil daftar
        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 2. Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 3. Redirect sesuai role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard');
                case 'user':
                    return redirect()->route('dashboard'); // 🔹 bisa ke halaman user biasa
                case 'alumni':
                    return redirect()->route('alumni_data.index');
                default:
                    return redirect()->route('dashboard');
            }
        }

        // 4. Jika gagal login
        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
