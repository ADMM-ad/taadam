<?php

namespace App\Http\Controllers;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{


    public function index()
    {
        $teams = Team::all();
        return view('team.index', compact('teams'));
    }

    public function create()
    {
        $userIp = request()->ip();  
        return view('team.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_team' => 'required|string|max:255',
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
            'nama_team' => 'required|string|max:255',
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
