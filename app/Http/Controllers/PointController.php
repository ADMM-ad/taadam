<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Absensi;
use App\Models\DetailJobdesk;
use App\Models\JobdeskHasil;
use App\Models\PointKPI;
use Illuminate\Support\Facades\Auth;
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

    // Menghitung jumlah jobdesk selesai oleh user dengan filter tenggat_waktu yang sesuai dengan bulan dan tahun
    $jobdeskSelesai = DetailJobdesk::where('user_id', $userId)
                ->whereHas('jobdesk', function ($query) use ($bulan) {
                    $query->where('status', 'selesai')
                          ->whereRaw("DATE_FORMAT(tenggat_waktu, '%Y-%m') = ?", [$bulan]); // Filter berdasarkan tenggat_waktu
                })
                ->count();

    // Mendapatkan semua team_id dari user yang dipilih
    $teamIds = \DB::table('detail_team')
                ->where('user_id', $userId)
                ->pluck('team_id'); 

    $views = JobdeskHasil::whereIn('team_id', $teamIds)
                ->whereRaw("DATE_FORMAT(bulan, '%Y-%m') = ?", [$bulan])
                ->sum('views');
    

    return response()->json([
        'absensi' => $absensi,
        'jobdesk_selesai' => $jobdeskSelesai,
        'views' => $views
    ]);
}

 
public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'bulan' => 'required|date_format:Y-m',
        'point_absensi' => 'required|numeric',
        'point_jobdesk' => 'required|numeric',
        'point_hasil' => 'required|numeric',
        'point_attitude' => 'required|numeric',
        'point_rata_rata' => 'required|numeric',
    ]);
    $bulanFormatted = $request->bulan . '-01';

    // Cek apakah sudah ada data dengan user_id dan bulan yang sama
    $existingRecord = PointKPI::where('user_id', $request->user_id)
        ->where('bulan', $bulanFormatted)
        ->first();

    if ($existingRecord) {
        return redirect()->back()->with('error', 'Data untuk bulan ini sudah ada.');
    }

    PointKPI::create([
        'user_id' => $request->user_id,
        'bulan' => $bulanFormatted,
        'point_absensi' => $request->point_absensi,
        'point_jobdesk' => $request->point_jobdesk,
        'point_hasil' => $request->point_hasil,
        'point_attitude' => $request->point_attitude,
        'point_rata_rata' => $request->point_rata_rata,
    ]);

    return redirect()->back()->with('success', 'Point KPI berhasil disimpan!');
}



//pengguna ngecek
public function indexPengguna()
{
    $user_id = Auth::id();
    $points = PointKpi::where('user_id', $user_id)->get();

    return view('point.indexpengguna', compact('points'));
}

//pimpinan ngecek
public function indexPimpinan()
{
    $points = PointKpi::with('user')->get(); // Ambil data beserta user

    return view('point.indexpimpinan', compact('points'));
}

}
