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
            'username' => 'required|string', // Ganti email menjadi username
            'password' => 'required|string',
        ]);
    
        // Kredensial login
        $credentials = [
            'username' => $request->username, // Ganti email menjadi username
            'password' => $request->password,
        ];
    
        // Cek kredensial dan autentikasi pengguna
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            if ($user->status == 'tidakaktif') {
                return redirect()->route('profil.edit')->with('message', 'Silahkan mengubah Username dan Password untuk mengaktifkan akun');
            }
    
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
        return redirect()->back()->withErrors(['username' => 'Username atau password salah']); // Ganti email menjadi username
    }
    
    public function register(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'name' => 'nullable|string|max:255', // Name opsional
            'username' => 'required|string|max:255|unique:users', // Ganti email menjadi username
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:karyawan,teamleader,pimpinan',
        ]);
    
        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username, // Ganti email menjadi username
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_hp' => $request->no_hp, // No HP opsional
            'status' => 'tidakaktif',
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

    public function checkUsername(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if ($user) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    // Simpan password baru
    public function updatePassword(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('username', $request->username)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password berhasil diubah!');
    }
}
