<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Absensi;
use App\Models\DetailJobdesk;
use App\Models\JobdeskHasil;
use App\Models\PointKPI;
use App\Models\DetailTeam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PointController extends Controller
{
     // Menampilkan daftar user selain pimpinan
     public function index()
     {
        $users = User::where('role', '!=', 'pimpinan')
        ->where('status', 'aktif') // Menampilkan hanya pengguna dengan status "aktif"
        ->get();
         return view('point.index', compact('users'));
     }


     public function indexteam()
     {
         // Ambil user yang sedang login
         $loggedInUser = auth()->user();
     
         // Ambil team_id yang dimiliki oleh user yang sedang login
         $teamIds = DetailTeam::where('user_id', $loggedInUser->id)->pluck('team_id');
     
         // Ambil user dengan role 'karyawan' yang memiliki team_id yang sama dengan user yang login
         $users = User::where('role', 'karyawan')
                        ->where('status', 'aktif')
                      ->whereIn('id', function ($query) use ($teamIds) {
                          $query->select('user_id')
                                ->from('detail_team')
                                ->whereIn('team_id', $teamIds);
                      })
                      ->get();
     
         return view('point.indexteam', compact('users'));
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
public function indexPengguna(Request $request)
{
    $user_id = Auth::id();

    // Ambil tahun dari request
    $tahun = $request->input('tahun');

    // Query awal
    $query = PointKpi::where('user_id', $user_id);

    // Filter jika tahun tersedia
    if ($tahun) {
        $query->whereYear('bulan', $tahun);
    }

    // Ambil data dengan paginasi
    $points = $query->orderBy('bulan', 'desc')->paginate(10);

    // Ambil semua tahun yang tersedia untuk dropdown filter
    $availableYears = PointKpi::where('user_id', $user_id)
        ->selectRaw('YEAR(bulan) as tahun')
        ->distinct()
        ->pluck('tahun');

    return view('point.indexpengguna', compact('points', 'tahun', 'availableYears'));
}


//pimpinan ngecek
public function indexPimpinan(Request $request)
{
    $query = PointKpi::with('user')->whereHas('user', function ($q) {
        $q->where('role', '!=', 'pimpinan')
          ->where('status', 'aktif');
    });

    if ($request->user_id) {
        $query->where('user_id', $request->user_id);
    }

    if ($request->date) {
        try {
            $date = Carbon::createFromFormat('Y-m', $request->date);
            $query->whereYear('bulan', $date->year)->whereMonth('bulan', $date->month);
        } catch (\Exception $e) {
            // Format tidak sesuai, bisa diabaikan atau diarahkan ke pesan error
        }
    }

    $points = $query->paginate(10); // Paginasi 10 data per halaman

    $users = User::where('role', '!=', 'pimpinan')
                 ->where('status', 'aktif')
                 ->get();

    return view('point.indexpimpinan', compact('points', 'users'));
}


public function indexteamleader(Request $request)
{
    // Ambil user yang sedang login
    $loggedInUser = auth()->user();

    // Ambil team_id yang dimiliki oleh user yang sedang login
    $teamIds = DetailTeam::where('user_id', $loggedInUser->id)->pluck('team_id');

    // Ambil user_id dari user yang memiliki role 'karyawan' dan berada di team yang sama
    $userIds = User::where('role', 'karyawan')
                   ->whereIn('id', function ($query) use ($teamIds) {
                       $query->select('user_id')
                             ->from('detail_team')
                             ->whereIn('team_id', $teamIds);
                   })
                   ->pluck('id');

    // Buat query awal
    $query = PointKpi::with('user')
                ->whereIn('user_id', $userIds);

    // Filter berdasarkan user_id
    if ($request->user_id) {
        $query->where('user_id', $request->user_id);
    }

    // Filter berdasarkan bulan dan tahun
    if ($request->date) {
        try {
            $date = \Carbon\Carbon::createFromFormat('Y-m', $request->date);
            $query->whereYear('bulan', $date->year)
                  ->whereMonth('bulan', $date->month);
        } catch (\Exception $e) {
            // invalid date
        }
    }

    // Paginasi
    $points = $query->paginate(10)->withQueryString();

    // Ambil user dari tim untuk opsi filter nama
    $users = User::whereIn('id', $userIds)->get();

    return view('point.indexteamleader', compact('points', 'users'));
}


public function destroy($id)
{
    $point = PointKpi::findOrFail($id);
    $point->delete();
    $user = auth()->user();

    if ($user->role === 'pimpinan') {
        return redirect()->route('point.indexpimpinan')->with('success', 'Data berhasil dihapus.');
    }

    if ($user->role === 'teamleader') {
        return redirect()->route('point.indexteamleader')->with('success', 'Data berhasil dihapus.');
    }
}

}
