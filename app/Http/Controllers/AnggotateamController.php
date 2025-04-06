<?php

namespace App\Http\Controllers;

use App\Models\DetailTeam;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class AnggotateamController extends Controller
{
    // Menampilkan daftar tim dalam box dengan jumlah anggota
    public function index(Request $request)
    {
        // Query untuk mengambil tim dan menghitung jumlah anggotanya
    $query = Team::withCount('detailTeams')
    ->where('nama_team', '!=', 'Individu');

// Filter pencarian berdasarkan nama tim
if ($request->has('search') && $request->search != '') {
    $query->where('nama_team', 'like', '%' . $request->search . '%');
}

// Paginasi dengan 10 data per halaman
$teams = $query->paginate(10);

return view('anggotateam.index', compact('teams'));
    }

    public function daftar($team_id)
    {
        $team = Team::findOrFail($team_id);
        $anggota = DetailTeam::where('team_id', $team_id)->with('user')->get();

        return view('anggotateam.daftar', compact('team', 'anggota'));
    }
    
    // Menampilkan form tambah anggota
    public function create()
    {
        $users = User::whereIn('role', ['karyawan', 'teamleader'])
             ->where('status', 'aktif')
             ->get();

             $teams = Team::where('nama_team', '!=', 'Individu')->get();

        return view('anggotateam.create', compact('users', 'teams'));
    }

    // Menyimpan anggota ke dalam tim
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) use ($request) {
                    $user = User::find($value);
                    if (!$user || !in_array($user->role, ['karyawan', 'teamleader'])) {
                        $fail('User harus memiliki role karyawan atau team leader.');
                    }

                    if (DetailTeam::where('user_id', $value)->where('team_id', $request->team_id)->exists()) {
                        $fail('User ini sudah tergabung di tim ini.');
                    }
                },
            ],
            'team_id' => 'required|exists:team,id',
        ]);

        DetailTeam::create($request->all());

        return redirect()->route('anggotateam.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    

    // Menghapus anggota dari tim
    public function destroy(DetailTeam $anggotateam)
    {
        $team_id = $anggotateam->team_id;  // Ambil team_id dari detail_team yang akan dihapus
    $anggotateam->delete();

    return redirect()->route('anggotateam.daftar', ['team' => $team_id])
                     ->with('success', 'Anggota berhasil dikeluarkan dari team.');
    }
}
