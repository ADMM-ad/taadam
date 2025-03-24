<?php

namespace App\Http\Controllers;
use App\Models\Team;
use App\Models\DetailTeam;
use App\Models\User;
use App\Models\Jobdesk;
use App\Models\DetailJobdesk;
use Illuminate\Support\Facades\Auth;
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
    

//individu
public function createindividu()
{
    $users = User::where('role', '!=', 'pimpinan')->get();
    return view('jobdesk.createindividu', compact('users'));
}

public function storeindividu(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'nama_pekerjaan' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'tenggat_waktu' => 'required|date',
    ]);

    // Cari ID dari tim dengan nama 'Individu'
    $teamIndividu = Team::where('nama_team', 'Individu')->first();

    if (!$teamIndividu) {
        return redirect()->back()->with('error', 'Tim Individu tidak ditemukan.');
    }

    // Buat Jobdesk Baru dengan team_id dari tim Individu
    $jobdesk = Jobdesk::create([
        'team_id' => $teamIndividu->id, // Set team_id berdasarkan tim Individu
        'nama_pekerjaan' => $request->nama_pekerjaan,
        'deskripsi' => $request->deskripsi,
        'tenggat_waktu' => $request->tenggat_waktu,
        'status' => 'ditugaskan',
    ]);

    // Simpan ke tabel detail_jobdesk
    DetailJobdesk::create([
        'user_id' => $request->user_id,
        'jobdesk_id' => $jobdesk->id,
    ]);

    return redirect()->route('jobdesk.createindividu')->with('success', 'Jobdesk berhasil ditambahkan!');
}




     // Menampilkan jobdesk yang masih "ditugaskan" milik pengguna yang sedang login
     public function indexpengguna()
     {
         $jobdesks = Jobdesk::whereHas('detailJobdesk', function ($query) {
             $query->where('user_id', Auth::id());
         })->where('status', 'ditugaskan')->get();
 
         return view('jobdesk.indexpengguna', compact('jobdesks'));
     }

     // Menampilkan jobdesk yang sudah "selesai" milik pengguna yang sedang login
    public function indexpenggunaselesai()
    {
        $jobdesks = Jobdesk::whereHas('detailJobdesk', function ($query) {
            $query->where('user_id', Auth::id());
        })->where('status', 'selesai')->get();

        return view('jobdesk.indexpenggunaselesai', compact('jobdesks'));
    }
    // Menampilkan form edit hasil pekerjaan
    public function editpengguna($id)
    {
        $jobdesk = Jobdesk::whereHas('detailJobdesk', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        return view('jobdesk.editpengguna', compact('jobdesk'));
    }

    // Menyimpan hasil pekerjaan dan memperbarui status serta waktu selesai
    public function updatepengguna(Request $request, $id)
    {
        $request->validate([
            'hasil' => 'required|string',
        ]);

        $jobdesk = Jobdesk::whereHas('detailJobdesk', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $jobdesk->update([
            'hasil' => $request->hasil,
            'waktu_selesai' => now(),
            'status' => 'selesai',
        ]);

        return redirect()->route('jobdesk.indexpenggunaselesai')->with('success', 'Pekerjaan berhasil diperbarui!');

    }


//ini untuk laporan pimpinan
public function indexpimpinan()
{
    $jobdesks = Jobdesk::with('team')->get();
    return view('jobdesk.indexpimpinan', compact('jobdesks'));
}

public function detailpimpinan($id)
{
    $jobdesk = Jobdesk::with('team')->findOrFail($id);

    // Ambil daftar user dari tabel detail_jobdesk yang memiliki jobdesk_id yang sama
    $users = DetailJobdesk::where('jobdesk_id', $id)
        ->with('user') // Pastikan ada relasi ke model User
        ->get()
        ->pluck('user');

    return view('jobdesk.detailpimpinan', compact('jobdesk', 'users'));
}
public function editpimpinan($id)
{
    $jobdesk = Jobdesk::with('team', 'detailJobdesk.user')->findOrFail($id);
    
    // Ambil semua tim
    $teams = Team::all();
    
    // Ambil daftar user dari team_id yang sesuai dengan jobdesk yang dipilih
    $teamUsers = DetailTeam::where('team_id', $jobdesk->team_id)
        ->with('user')
        ->get()
        ->pluck('user');

    // Ambil user yang sudah terlibat dalam jobdesk ini
    $selectedUsers = $jobdesk->users; // Menggunakan relasi yang telah dibuat

    return view('jobdesk.editpimpinan', compact('jobdesk', 'teams', 'teamUsers', 'selectedUsers'));
}


public function updatepimpinan(Request $request, $id)
{
    

    $jobdesk = Jobdesk::findOrFail($id);

    $request->validate([
        'nama_pekerjaan' => 'required',
        'deskripsi' => 'required',
        'tenggat_waktu' => 'required|date',
        'status' => 'required|in:ditugaskan,selesai',
    ]);

    $jobdesk->update([
        'nama_pekerjaan' => $request->nama_pekerjaan,
        'deskripsi' => $request->deskripsi,
        'tenggat_waktu' => $request->tenggat_waktu,
        'status' => $request->status,
    ]);

    return redirect()->route('jobdesk.indexpimpinan')->with('success', 'Data berhasil diperbarui');
}




public function destroy($id)
{
    $jobdesk = Jobdesk::findOrFail($id);
    $jobdesk->delete();

    return redirect()->route('jobdesk.indexpimpinan')->with('success', 'Jobdesk berhasil dihapus.');
}

public function editkelolajob($id)
{
    $jobdesk = Jobdesk::with('users')->findOrFail($id);
    
    if ($jobdesk->team->nama_team == 'Individu') {
        // Jika timnya "Individu", ambil semua user kecuali yang memiliki role "Pimpinan"
        $teamUsers = User::where('role', '!=', 'Pimpinan')->get();
    } else {
        // Jika bukan "Individu", ambil user berdasarkan team_id, kecuali role "Pimpinan"
        $teamUsers = DetailTeam::where('team_id', $jobdesk->team_id)
            ->with(['user' => function ($query) {
                $query->where('role', '!=', 'Pimpinan');
            }])
            ->get()
            ->pluck('user');
    }

    return view('jobdesk.editkelolajob', compact('jobdesk', 'teamUsers'));
}



public function removeUser($jobdesk_id, $user_id)
{
    DetailJobdesk::where('jobdesk_id', $jobdesk_id)->where('user_id', $user_id)->delete();
    return back()->with('success', 'Pengguna berhasil dihapus.');
}

public function addUser(Request $request, $jobdesk_id)
{
    $jobdesk = Jobdesk::findOrFail($jobdesk_id);
    
    // Cek apakah user sudah ada di jobdesk
    $exists = DetailJobdesk::where('jobdesk_id', $jobdesk_id)->where('user_id', $request->user_id)->exists();
    if ($exists) {
        return back()->with('error', 'Pengguna sudah ada di dalam jobdesk.');
    }

    DetailJobdesk::create([
        'jobdesk_id' => $jobdesk_id,
        'user_id' => $request->user_id
    ]);

    return back()->with('success', 'Pengguna berhasil ditambahkan.');
}


}
