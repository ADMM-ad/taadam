<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        $user = Auth::user(); // Mendapatkan data user yang sedang login
        $teams = $user->teams; // Mengambil tim yang diikuti oleh user dari relasi
        return view('profil.index', compact('user', 'teams'));
    }
    public function edit()
    {
        $user = Auth::user(); // Mendapatkan data user yang sedang login
        return view('profil.edit', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user(); // Mendapatkan data user yang sedang login
    
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id, // Ganti email menjadi username
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 50 karakter.',
            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.required' => 'Username tidak boleh lebih dari 50 karakter',
            'username.unique' => 'Username sudah digunakan. Silakan pilih yang lain.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.max' => 'Nomor HP tidak boleh lebih dari 15 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    
        // Update data user
        $user->update([
            'name' => $request->name,
            'username' => $request->username, 
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'status' => 'aktif',
        ]);
    
        // Jika password tidak kosong, maka diperbarui
        if ($request->password) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }
    
        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui!');
    }
    
}
