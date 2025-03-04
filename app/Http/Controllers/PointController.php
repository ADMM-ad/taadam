<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Absensi;
use App\Models\DetailJobdesk;
use App\Models\JobdeskHasil;
use Illuminate\Http\Request;

class PointController extends Controller
{
     // Menampilkan daftar user selain pimpinan
     public function index()
     {
         $users = User::where('role', '!=', 'pimpinan')->get();
         return view('point.index', compact('users'));
     }
 
     // Menampilkan form create berdasarkan user_id
     public function create(Request $request)
     {
         $user = User::findOrFail($request->user_id);
         return view('point.create', compact('user'));
     }
 
// Mengambil data absensi, jobdesk, dan views berdasarkan user & bulan
public function getData(Request $request)
{
    $userId = $request->query('user_id');
    $bulan = $request->query('bulan');

    // Menghitung jumlah kehadiran user
    $absensi = Absensi::where('user_id', $userId)
                ->where('kehadiran', 'hadir')
                ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulan])
                ->count();

    // Menghitung jumlah jobdesk selesai oleh user
    $jobdeskSelesai = DetailJobdesk::where('user_id', $userId)
                ->whereHas('jobdesk', function ($query) {
                    $query->where('status', 'selesai');
                })->count();

    // Mendapatkan semua team_id dari user yang dipilih
    $teamIds = \DB::table('detail_team')
                ->where('user_id', $userId)
                ->pluck('team_id'); 

    $views = JobdeskHasil::whereIn('team_id', $teamIds)
                ->where('bulan', $bulan) // Sesuaikan langsung karena `bulan` adalah string
                ->sum('views');
    

    return response()->json([
        'absensi' => $absensi,
        'jobdesk_selesai' => $jobdeskSelesai,
        'views' => $views
    ]);
}

 
     // Menyimpan data point KPI
     public function store(Request $request)
     {
         PointKPI::create([
             'user_id' => $request->user_id,
             'bulan' => $request->bulan,
             'point_absensi' => $request->absensi,
             'point_jobdesk' => $request->jobdesk_selesai,
             'point_hasil' => $request->views,
             'point_attitude' => 0, // Bisa ditambahkan inputnya
             'point_keseluruhan' => 0, // Bisa ditambahkan perhitungan
         ]);
 
         return redirect()->route('point.index')->with('success', 'Data KPI berhasil disimpan.');
     }
}
