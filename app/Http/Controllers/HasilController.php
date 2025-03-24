<?php

namespace App\Http\Controllers;
use App\Models\JobdeskHasil;
use App\Models\Team;
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

        $jobdeskHasils = $query->orderBy('bulan', 'asc')->get();

        return view('hasil.index', compact('jobdeskHasils', 'tahunOptions', 'teamOptions'));
    }

    public function create()
    {
        $teams = Team::all();
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

        if ($existingData) {
            return redirect()->back()->withErrors(['error' => 'Data sudah ada yang mengisi'])->withInput();
        }

        // Simpan data
        JobdeskHasil::create([
            'team_id' => $request->team_id,
            'bulan' => date('Y-m-01', strtotime($request->bulan)), // Simpan sebagai format tanggal
            'views' => $request->views,
        ]);

        return redirect()->route('hasil.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(JobdeskHasil $jobdeskHasil)
    {
        $teams = Team::all();
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

        return redirect()->route('hasil.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(JobdeskHasil $jobdeskHasil)
    {
        $jobdeskHasil->delete();
        return redirect()->route('hasil.index')->with('success', 'Data berhasil dihapus.');
    }
}
