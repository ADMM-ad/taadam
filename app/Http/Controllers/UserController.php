<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function indexKaryawan(Request $request)
    {
        // Ambil query pencarian dan filter status
        $search = $request->input('search');
        $status = $request->input('status');
    
        // Query dasar untuk role karyawan
        $users = User::where('role', 'karyawan');
    
        // Jika ada pencarian nama
        if ($search) {
            $users->where('name', 'LIKE', "%{$search}%");
        }
    
        // Jika ada filter status
        if ($status) {
            $users->where('status', $status);
        }
    
        // Ambil data dengan pagination (10 per halaman)
        $users = $users->paginate(2);
    
        return view('users.indexkaryawan', compact('users', 'search', 'status'));
    }
    


    public function indexTeamleader(Request $request)
    {
        // Ambil query pencarian dan filter status
        $search = $request->input('search');
        $status = $request->input('status');
    
        // Query dasar untuk role teamleader
        $users = User::where('role', 'teamleader');
    
        // Jika ada pencarian nama
        if ($search) {
            $users->where('name', 'LIKE', "%{$search}%");
        }
    
        // Jika ada filter status
        if ($status) {
            $users->where('status', $status);
        }
    
        // Ambil data dengan pagination (10 per halaman)
        $users = $users->paginate(2);
    
        return view('users.indexteamleader', compact('users', 'search', 'status'));
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

    public function changeStatus($id)
{
    $user = User::findOrFail($id);

    // Ubah status
    $user->status = ($user->status == 'aktif') ? 'tidakaktif' : 'aktif';
    $user->save();

    // Redirect dengan pesan sukses
    return redirect()->route('users.indexkaryawan')->with('success', 'Status berhasil diubah!');
}
public function changeStatustl($id)
{
    $user = User::findOrFail($id);

    // Ubah status berdasarkan kondisi saat ini
    $user->status = ($user->status == 'aktif') ? 'tidakaktif' : 'aktif';
    $user->save();

    return redirect()->route('users.indexteamleader')->with('success', 'Status teamleader berhasil diperbarui.');
}

}
