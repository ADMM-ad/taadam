<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Tambahkan domain ke email jika diperlukan
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Cek kredensial dan autentikasi pengguna
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role == 'pimpinan') {
                return redirect()->route('dashboardpimpinan');
            } elseif ($user->role == 'teamleader') {
                return redirect()->route('dashboardteamleader');
            } elseif ($user->role == 'karyawan') {
                return redirect()->route('dashboardkaryawan');
            }
        }

        // Jika gagal login
        return redirect()->back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function register(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'name' => 'nullable|string|max:255', // Name opsional
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:pimpinan,teamleader,karyawan',
        ]);

        // Tambahkan domain ke email jika diperlukan
       
        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, // Email dengan domain
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_hp' => $request->no_hp, // No HP opsional
        ]);

        return redirect()->route('register')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout pengguna saat ini

        $request->session()->invalidate(); // Hapus sesi pengguna

        $request->session()->regenerateToken(); // Regenerasi token sesi

        return redirect('/login'); // Redirect ke halaman login
    }
}
