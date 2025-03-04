<?php

namespace App\Http\Controllers;
use App\Models\Team;
use App\Models\User;
use App\Models\Jobdesk;
use App\Models\DetailJobdesk;
use Illuminate\Http\Request;

class JobdeskController extends Controller
{
    public function create()
    {
        $teams = Team::all(); // Ambil semua tim untuk dropdown
        return view('jobdesk.create', compact('teams'));
    }

    /**
     * Menyimpan jobdesk baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'team_id' => 'required|exists:team,id',
            'nama_pekerjaan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tenggat_waktu' => 'required|date',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        // Simpan data ke tabel jobdesk
        $jobdesk = Jobdesk::create([
            'team_id' => $request->team_id,
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'deskripsi' => $request->deskripsi,
            'tenggat_waktu' => $request->tenggat_waktu,
            'status' => 'ditugaskan',
            'hasil' => null
        ]);

        // Simpan user yang mengerjakan ke tabel detail_jobdesk
        foreach ($request->user_ids as $user_id) {
            DetailJobdesk::create([
                'jobdesk_id' => $jobdesk->id,
                'user_id' => $user_id
            ]);
        }

        return redirect()->route('jobdesk.create')->with('success', 'Jobdesk berhasil dibuat!');
    }

    /**
     * Mengambil daftar user berdasarkan team_id (AJAX)
     */
    public function getUsersByTeam($team_id)
    {
        // Ambil user yang tergabung dalam team berdasarkan tabel detail_team
        $users = User::whereIn('id', function ($query) use ($team_id) {
            $query->select('user_id')->from('detail_team')->where('team_id', $team_id);
        })->get();

        return response()->json($users);
    }
    
}
