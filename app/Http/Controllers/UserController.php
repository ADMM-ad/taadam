<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function indexKaryawan()
    {
        $users = User::where('role', 'karyawan')->get();
        return view('users.indexkaryawan', compact('users'));
    }

    public function indexTeamleader()
    {
        $users = User::where('role', 'teamleader')->get();
        return view('users.indexteamleader', compact('users'));
    }

    // Menghapus user berdasarkan ID
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.indexkaryawan')->with('success', 'Karyawan berhasil dihapus.');
    }

    // Menghapus user berdasarkan ID
    public function destroytl($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.indexteamleader')->with('success', 'Tealeader berhasil dihapus.');
    }
}
