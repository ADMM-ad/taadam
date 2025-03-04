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
        return view('profil.index', compact('user'));
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
        'name' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'no_hp' => 'nullable|string|max:15',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Update data user
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'no_hp' => $request->no_hp,
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
