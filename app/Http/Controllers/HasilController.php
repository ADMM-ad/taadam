<?php

namespace App\Http\Controllers;
use App\Models\JobdeskHasil;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index(Request $request)
    {
        $query = JobdeskHasil::query();

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('bulan', $request->tahun);
        }

        // Filter Nama Team
        if ($request->filled('nama_team')) {
            $query->whereHas('team', function ($q) use ($request) {
                $q->where('nama_team', $request->nama_team);
            });
        }

        // Ambil daftar tahun unik dari kolom bulan
        $tahunOptions = JobdeskHasil::selectRaw('YEAR(bulan) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Ambil daftar nama tim
        $teamOptions = Team::select('nama_team')->distinct()->get();

        $jobdeskHasils = $query->orderBy('bulan', 'asc')->paginate(10);

        return view('hasil.index', compact('jobdeskHasils', 'tahunOptions', 'teamOptions'));
    }

    public function indexteamleader(Request $request)
    {
        $user = Auth::user();
    
        // Ambil ID tim yang terkait dengan user
        $teamIds = \DB::table('detail_team')
            ->where('user_id', $user->id)
            ->pluck('team_id');
    
        // Query awal: hanya data dari team yang dimiliki oleh user
        $query = JobdeskHasil::whereIn('team_id', $teamIds);
    
        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('bulan', $request->tahun);
        }
    
        // Tidak perlu filter nama_team, karena team sudah dibatasi sesuai user
    
        // Ambil daftar tahun unik dari kolom bulan (hanya dari team terkait)
        $tahunOptions = JobdeskHasil::whereIn('team_id', $teamIds)
            ->selectRaw('YEAR(bulan) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
    
        // Ambil nama team yang hanya dimiliki user
        $teamOptions = Team::whereIn('id', $teamIds)->select('nama_team')->get();
    
        // Ambil data jobdesk hasil
        $jobdeskHasils = $query->orderBy('bulan', 'asc')->paginate(2);
    
        return view('hasil.indexteamleader', compact('jobdeskHasils', 'tahunOptions', 'teamOptions'));
    }

    public function create()
{
    $user = Auth::user();

    if ($user->role === 'pimpinan') {
        $teams = Team::all();
    } else {
        // Ambil hanya team yang terkait dengan user login
        $teams = Team::whereHas('detailTeams', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
    }

    return view('hasil.create', compact('teams'));
}

    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required|exists:team,id',
            'bulan' => 'required|date_format:Y-m', // Pastikan format YYYY-MM
            'views' => 'required|string',
        ]);

        // Cek apakah sudah ada data dengan team_id dan bulan yang sama
        $existingData = JobdeskHasil::where('team_id', $request->team_id)
            ->whereYear('bulan', date('Y', strtotime($request->bulan)))
            ->whereMonth('bulan', date('m', strtotime($request->bulan)))
            ->exists();

            $userRole = Auth::user()->role;

            if ($existingData) {
                if ($userRole === 'pimpinan') {
                    return redirect()->route('hasil.index')
                        ->withErrors(['error' => 'Data sudah ada yang mengisi'])
                        ->withInput();
                } else {
                    return redirect()->route('hasil.teamleader')
                        ->withErrors(['error' => 'Data sudah ada yang mengisi'])
                        ->withInput();
                }
            }
            

        // Simpan data
        JobdeskHasil::create([
            'team_id' => $request->team_id,
            'bulan' => date('Y-m-01', strtotime($request->bulan)), // Simpan sebagai format tanggal
            'views' => $request->views,
        ]);

        // Redirect setelah berhasil
        if ($userRole === 'pimpinan') {
            return redirect()->route('hasil.index')->with('success', 'Data berhasil ditambahkan.');
        } else {
            return redirect()->route('hasil.teamleader')->with('success', 'Data berhasil ditambahkan.');
        }
        
    }

    public function edit(JobdeskHasil $jobdeskHasil)
{
    $user = Auth::user();

    if ($user->role === 'pimpinan') {
        $teams = Team::all();
    } else {
        // Ambil hanya team yang terkait dengan user login
        $teams = Team::whereHas('detailTeams', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
    }

    return view('hasil.edit', compact('jobdeskHasil', 'teams'));
}


    public function update(Request $request, JobdeskHasil $jobdeskHasil)
    {
        $request->validate([
            'team_id' => 'required|exists:team,id',
            'bulan' => 'required|date_format:Y-m',
            'views' => 'required|string',
        ]);

        // Cek apakah data sudah ada, kecuali data yang sedang diupdate
        $existingData = JobdeskHasil::where('team_id', $request->team_id)
            ->whereYear('bulan', date('Y', strtotime($request->bulan)))
            ->whereMonth('bulan', date('m', strtotime($request->bulan)))
            ->where('id', '!=', $jobdeskHasil->id)
            ->exists();

        if ($existingData) {
            return redirect()->back()->withErrors(['error' => 'Data sudah ada yang mengisi'])->withInput();
        }

        $jobdeskHasil->update([
            'team_id' => $request->team_id,
            'bulan' => date('Y-m-01', strtotime($request->bulan)), // Simpan dengan tanggal awal bulan
            'views' => $request->views,
        ]);

        $userRole = Auth::user()->role;

        if ($userRole === 'pimpinan') {
            return redirect()->route('hasil.index')->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect()->route('hasil.teamleader')->with('success', 'Data berhasil diperbarui.');
        }
        
    }

    public function destroy(JobdeskHasil $jobdeskHasil)
    {
        $jobdeskHasil->delete();
        $userRole = Auth::user()->role;

        if ($userRole === 'pimpinan') {
            return redirect()->route('hasil.index')->with('success', 'Data berhasil dihapus.');
        } else {
            return redirect()->route('hasil.teamleader')->with('success', 'Data berhasil dihapus.');
        }
    }
}
