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
        $teams = Team::where('nama_team', '!=', 'Individu')->get();
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
            'deskripsi' => 'required|string|max:255',
            'tenggat_waktu' => 'required|date',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ], [
            'team_id.required' => 'Tim harus dipilih.',
            'team_id.exists' => 'Tim yang dipilih tidak valid.',
            'nama_pekerjaan.required' => 'Nama pekerjaan harus diisi.',
            'nama_pekerjaan.string' => 'Nama pekerjaan harus berupa teks.',
            'nama_pekerjaan.max' => 'Nama pekerjaan maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi pekerjaan harus diisi.',
            'deskripsi.string' => 'Deskripsi pekerjaan harus berupa teks.',
            'deskripsi.max' => 'Nama pekerjaan maksimal 255 karakter.',
            'tenggat_waktu.required' => 'Tenggat waktu harus diisi.',
            'tenggat_waktu.date' => 'Tenggat waktu harus berupa format tanggal yang valid.',
            'user_ids.required' => 'Anggota tim harus dipilih.',
            'user_ids.array' => 'Anggota tim harus berupa array.',
            'user_ids.*.exists' => 'Anggota tim yang dipilih tidak valid.',
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

        if (auth()->user()->role === 'pimpinan') {
            return redirect()->route('jobdesk.indexpimpinan')->with('success', 'Jobdesk berhasil dibuat!');
        } else {
            return redirect()->route('jobdesk.indexteamleader')->with('success', 'Jobdesk berhasil dibuat!');
        }
        
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
    
    public function createteamleader()
    {
        // Ambil user yang sedang login
        $loggedInUser = auth()->user();
    
        // Ambil team yang terkait dengan user yang sedang login
        $teams = Team::whereIn('id', function ($query) use ($loggedInUser) {
            $query->select('team_id')
                  ->from('detail_team')
                  ->where('user_id', $loggedInUser->id);
        })->get();
    
        return view('jobdesk.createteamleader', compact('teams'));
    }    




//individu
public function createindividu()
{
    $users = User::where('role', '!=', 'pimpinan')
             ->where('status', 'aktif') // Hanya user dengan status aktif
             ->get();

    return view('jobdesk.createindividu', compact('users'));
}

public function storeindividu(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'nama_pekerjaan' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'tenggat_waktu' => 'required|date',
    ], [
        'user_id.required' => 'Pengguna wajib dipilih.',
        'user_id.exists'   => 'Pengguna yang dipilih tidak ditemukan dalam sistem.',
        
        'nama_pekerjaan.required' => 'Nama pekerjaan wajib diisi.',
        'nama_pekerjaan.string'   => 'Nama pekerjaan harus berupa teks.',
        'nama_pekerjaan.max'      => 'Nama pekerjaan tidak boleh lebih dari 255 karakter.',
    
        'deskripsi.required' => 'Deskripsi pekerjaan wajib diisi.',
        'deskripsi.string'   => 'Deskripsi harus berupa teks.',
    
        'tenggat_waktu.required' => 'Tenggat waktu wajib diisi.',
        'tenggat_waktu.date'     => 'Tenggat waktu harus berupa tanggal yang valid.',
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

    return redirect()->route('jobdesk.indexpimpinan')->with('success', 'Jobdesk berhasil ditambahkan!');
}




     // Menampilkan jobdesk yang masih "ditugaskan" milik pengguna yang sedang login
     public function indexpengguna()
     {
         $jobdesks = Jobdesk::whereHas('detailJobdesk', function ($query) {
             $query->where('user_id', Auth::id());
         })->where('status', 'ditugaskan')->paginate(2);
 
         return view('jobdesk.indexpengguna', compact('jobdesks'));
     }

     // Menampilkan jobdesk yang sudah "selesai" milik pengguna yang sedang login
     public function indexpenggunaselesai(Request $request)
     {
         $query = Jobdesk::whereHas('detailJobdesk', function ($q) {
             $q->where('user_id', Auth::id());
         })->where('status', 'selesai');
     
         // Filter nama pekerjaan
         if ($request->filled('nama_pekerjaan')) {
             $query->where('nama_pekerjaan', 'like', '%' . $request->nama_pekerjaan . '%');
         }
     
         // Filter berdasarkan format bulan-tahun
         if ($request->filled('tanggal_filter')) {
             $tanggal = explode('-', $request->tanggal_filter);
             if (count($tanggal) == 2) {
                 $query->whereYear('tenggat_waktu', $tanggal[0])
                       ->whereMonth('tenggat_waktu', $tanggal[1]);
             }
         }
     
         // Ambil semua kombinasi unik tahun-bulan dari tenggat_waktu
         $tanggalOptions = Jobdesk::selectRaw('DATE_FORMAT(tenggat_waktu, "%Y-%m") as tanggal')
             ->distinct()
             ->orderBy('tanggal', 'desc')
             ->pluck('tanggal');
     
         $jobdesks = $query->orderBy('tenggat_waktu', 'desc')->paginate(10);
     
         return view('jobdesk.indexpenggunaselesai', compact('jobdesks', 'tanggalOptions'));
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


//    untuk pengguna 
    public function editbukti($id)
{
    $jobdesk = Jobdesk::whereHas('detailJobdesk', function ($query) {
        $query->where('user_id', Auth::id());
    })->findOrFail($id);

    return view('jobdesk.editbukti', compact('jobdesk'));
}
public function updatebukti(Request $request, $id)
{
    $request->validate([
        'hasil' => 'required|string',
        'status' => 'required|in:ditugaskan,selesai',
    ]);

    $jobdesk = Jobdesk::whereHas('detailJobdesk', function ($query) {
        $query->where('user_id', Auth::id());
    })->findOrFail($id);

    $jobdesk->update([
        'hasil' => $request->hasil,
        'status' => $request->status,
        'waktu_selesai' => now(), // Set waktu selesai sekarang, sesuai permintaan
    ]);

    return redirect()->route('jobdesk.indexpenggunaselesai')->with('success', 'Data berhasil diperbarui!');
}



//ini unutk laporan teamleader
public function indexteamleader(Request $request)
{
    $loggedInUser = auth()->user();
    $teamIds = DetailTeam::where('user_id', $loggedInUser->id)->pluck('team_id');

    $jobdesks = Jobdesk::with('team')
        ->whereIn('team_id', $teamIds)
        ->when($request->search, fn($query) => $query->where('nama_pekerjaan', 'like', '%' . $request->search . '%'))
        ->when($request->team_id, fn($query) => $query->where('team_id', $request->team_id))
        ->when($request->status, fn($query) => $query->where('status', $request->status))
        ->when($request->bulan, function ($query) use ($request) {
            [$tahun, $bulan] = explode('-', $request->bulan); 
            return $query->whereMonth('tenggat_waktu', $bulan)->whereYear('tenggat_waktu', $tahun);
        })
        ->orderBy('tenggat_waktu', 'asc')
        ->paginate(2);

    $teams = Team::whereIn('id', $teamIds)->get();

    return view('jobdesk.indexteamleader', compact('jobdesks', 'teams'));
}


//ini untuk laporan pimpinan
public function indexpimpinan(Request $request)
{
    $query = Jobdesk::with('team');

    // Filter berdasarkan nama pekerjaan
    if ($request->filled('search')) {
        $query->where('nama_pekerjaan', 'like', '%' . $request->search . '%');
    }

    // Filter berdasarkan nama tim
    if ($request->filled('team_id')) {
        $query->where('team_id', $request->team_id);
    }

    // Filter berdasarkan status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $jobdesks = $query->paginate(2);
    $teams = Team::all(); // Ambil semua tim untuk dropdown filter

    return view('jobdesk.indexpimpinan', compact('jobdesks', 'teams'));
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

    $loggedInUser = auth()->user();

    // Lakukan proses update jobdesk di sini (sesuai kebutuhan)

    // Redirect berdasarkan role
    if ($loggedInUser->role === 'teamleader') {
        return redirect()->route('jobdesk.indexteamleader')
            ->with('success', 'Data berhasil diperbarui.');
    } else if ($loggedInUser->role === 'pimpinan') {
        return redirect()->route('jobdesk.indexpimpinan')
            ->with('success', 'Data berhasil diperbarui.');
    }
}




public function destroy($id)
{
    $jobdesk = Jobdesk::findOrFail($id);
    $jobdesk->delete();

    if (auth()->user()->role === 'pimpinan') {
        return redirect()->route('jobdesk.indexpimpinan')->with('success', 'Jobdesk berhasil dihapus.');
    } else {
        return redirect()->route('jobdesk.indexteamleader')->with('success', 'Jobdesk berhasil dihapus.');
    }
    
}

public function editkelolajob($id)
{
    $jobdesk = Jobdesk::with('users')->findOrFail($id);
    
    if ($jobdesk->team->nama_team == 'Individu') {
        // Jika timnya "Individu", ambil semua user kecuali yang memiliki role "Pimpinan"
        $teamUsers = User::where('role', '!=', 'Pimpinan')
                         ->where('status', 'aktif')
                         ->get();
    } else {
        // Jika bukan "Individu", ambil user berdasarkan team_id, kecuali role "Pimpinan"
        $teamUsers = DetailTeam::where('team_id', $jobdesk->team_id)
            ->with(['user' => function ($query) {
                $query->where('role', '!=', 'Pimpinan')
                      ->where('status', 'aktif');
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
        return back()->withErrors(['Pengguna sudah ada di dalam jobdesk.']);

    }

    DetailJobdesk::create([
        'jobdesk_id' => $jobdesk_id,
        'user_id' => $request->user_id
    ]);

    return back()->with('success', 'Pengguna berhasil ditambahkan.');
}


}
