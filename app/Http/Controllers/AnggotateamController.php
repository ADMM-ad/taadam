<?php

namespace App\Http\Controllers;
use App\Models\DetailTeam;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class AnggotateamController extends Controller
{
    public function index()
    {
        $details = DetailTeam::with('user', 'team')->get();
        return view('anggotateam.index', compact('details'));
    }

    public function create()
    {
        $users = User::whereIn('role', ['karyawan', 'teamleader'])->get();
        $teams = Team::all();
        return view('anggotateam.create', compact('users', 'teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
            'required',
            'exists:users,id',
            function ($attribute, $value, $fail) use ($request) {
                // Pastikan user memiliki role karyawan atau team leader
                $user = User::find($value);
                if (!$user || !in_array($user->role, ['karyawan', 'teamleader'])) {
                    $fail('User yang dipilih harus memiliki role karyawan atau team leader.');
                }

                // Pastikan user belum tergabung di tim yang sama
                if (DetailTeam::where('user_id', $value)->where('team_id', $request->team_id)->exists()) {
                    $fail('User ini sudah tergabung di tim yang sama.');
                }
            },
        ],
            'team_id' => 'required|exists:team,id',
        ]);

        DetailTeam::create($request->all());

        return redirect()->route('anggotateam.index')->with('success', 'Detail Team berhasil ditambahkan.');
    }

    public function edit(DetailTeam $anggotateam)
    {
        $users = User::whereIn('role', ['karyawan', 'teamleader'])->get();
        $teams = Team::all();
        return view('anggotateam.edit', compact('anggotateam', 'users', 'teams'));
    }

    public function update(Request $request, DetailTeam $anggotateam)
    {
        $request->validate([
            'user_id' => [
            'required',
            'exists:users,id',
            function ($attribute, $value, $fail) use ($request, $anggotateam) {
                // Pastikan user memiliki role karyawan atau team leader
                $user = User::find($value);
                if (!$user || !in_array($user->role, ['karyawan', 'teamleader'])) {
                    $fail('User yang dipilih harus memiliki role karyawan atau team leader.');
                }

                // Pastikan user belum tergabung di tim yang sama kecuali data yang sedang diupdate
                if (DetailTeam::where('user_id', $value)
                              ->where('team_id', $request->team_id)
                              ->where('id', '!=', $anggotateam->id)
                              ->exists()) {
                    $fail('User ini sudah tergabung di tim yang sama.');
                }
            },
        ],
            'team_id' => 'required|exists:team,id',
        ]);

        $anggotateam->update($request->all());

        return redirect()->route('anggotateam.index')->with('success', 'Detail Team berhasil diperbarui.');
    }

    public function destroy(DetailTeam $anggotateam)
    {
        $anggotateam->delete();
        return redirect()->route('anggotateam.index')->with('success', 'Detail Team berhasil dihapus.');
    }
}
