<?php

namespace App\Http\Controllers;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{


    public function index(Request $request)
    {
        $query = Team::where('nama_team', '!=', 'Individu');

    // Filter pencarian berdasarkan nama_team
    if ($request->has('search') && $request->search != '') {
        $query->where('nama_team', 'like', '%' . $request->search . '%');
    }

    // Ambil data tim dan paginate
    $teams = $query->paginate(10);

    return view('team.index', compact('teams'));
    }

    public function create()
    {
       
        return view('team.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_team' => 'required|string|max:100|unique:team,nama_team',
        ], [
            'nama_team.required' => 'Nama team tidak boleh kosong',
            'nama_team.max' => 'Nama team tidak boleh lebih dari 100 karakter.',
            'nama_team.unique' => 'Nama team sudah digunakan',
        ]);
        

        Team::create($request->all());
        return redirect()->route('team.index')
                        ->with('success', 'Team berhasil ditambahkan.');
    }

    public function edit(Team $team)
    {
        return view('team.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'nama_team' => 'required|string|max:100|unique:team,nama_team,' . $team->id,
        ], [
            'nama_team.max' => 'Nama team tidak boleh lebih dari 100 karakter.',
            'nama_team.unique' => 'Nama team sudah digunakan',
        ]);
        

        $team->update($request->all());
        return redirect()->route('team.index')
                        ->with('success', 'Team berhasil diperbarui.');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('team.index')
                        ->with('success', 'Team berhasil dihapus.');
    }
}
