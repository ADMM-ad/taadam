<?php

namespace App\Http\Controllers;

use App\Models\DetailTeam;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class AnggotateamController extends Controller
{
    // Menampilkan daftar tim dalam box dengan jumlah anggota
    public function index()
    {
        // Ambil semua tim dan hitung jumlah anggota di setiap tim
        $teams = Team::withCount('detailTeams')
             ->where('nama_team', '!=', 'Individu')
             ->get();

        return view('anggotateam.index', compact('teams'));
    }

    // Menampilkan daftar anggota dalam satu tim yang diklik
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

        $teams = Team::all();

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

    // Menampilkan halaman edit anggota tim
    public function edit(DetailTeam $anggotateam)
    {
        $users = User::whereIn('role', ['karyawan', 'teamleader'])->get();
        $teams = Team::all();

        return view('anggotateam.edit', compact('anggotateam', 'users', 'teams'));
    }

    // Memperbarui anggota tim
    public function update(Request $request, DetailTeam $anggotateam)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) use ($request, $anggotateam) {
                    $user = User::find($value);
                    if (!$user || !in_array($user->role, ['karyawan', 'teamleader'])) {
                        $fail('User harus memiliki role karyawan atau team leader.');
                    }

                    if (DetailTeam::where('user_id', $value)
                        ->where('team_id', $request->team_id)
                        ->where('id', '!=', $anggotateam->id)
                        ->exists()) {
                        $fail('User ini sudah tergabung di tim ini.');
                    }
                },
            ],
            'team_id' => 'required|exists:team,id',
        ]);

        $anggotateam->update($request->all());

        return redirect()->route('anggotateam.index')->with('success', 'Detail anggota berhasil diperbarui.');
    }

    // Menghapus anggota dari tim
    public function destroy(DetailTeam $anggotateam)
    {
        $anggotateam->delete();

        return redirect()->route('anggotateam.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
