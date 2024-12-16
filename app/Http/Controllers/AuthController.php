<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('Auth.register');
    }

    public function showLoginForm()
    {
        return view('Auth.login');
    }

    // Register
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,kasir',
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai Admin!');
        } elseif ($user->role === 'kasir') {
            return redirect()->route('kasir.dashboard')->with('success', 'Login berhasil sebagai Kasir!');
        }

        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }

    // Login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Cek kredensial pengguna
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user(); // Ambil data pengguna yang login
        
            // Cek role pengguna
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai Admin!');
            } elseif ($user->role === 'kasir') {
                return redirect()->route('kasir.dashboard')->with('success', 'Login berhasil sebagai Kasir!');
            } else {
                // Jika role tidak sesuai, Anda bisa redirect ke halaman lain atau logout
                return redirect()->route('login')->withErrors(['error' => 'Role tidak valid.']);
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
