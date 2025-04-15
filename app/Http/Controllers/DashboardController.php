<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Jobdesk;
use App\Models\Team;
use App\Models\PointKpi;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function pimpinan(Request $request)
{
    $jumlahUserAktif = User::where('status', 'aktif')->count();
    $jumlahUser = User::count();
    $jumlahPimpinanAktif = User::where('status', 'aktif')->where('role', 'pimpinan')->count();
    $jumlahTeamleaderAktif = User::where('status', 'aktif')->where('role', 'teamleader')->count();
    $jumlahKaryawanAktif = User::where('status', 'aktif')->where('role', 'karyawan')->count();

    $absensiDisetujuiHariIni = Absensi::with('user')
        ->whereDate('tanggal', Carbon::today())
        ->where('status', 'disetujui')
        ->get();

    $absensiDiprosesHariIni = Absensi::with('user')
        ->whereDate('tanggal', Carbon::today())
        ->where('status', 'diproses')
        ->get();


        $tanggalFilter = $request->bulan ? Carbon::parse($request->bulan) : null;
        $teamIdFilter = $request->team_id;
    
        // Data Team untuk dropdown
        $semuaTeam = Team::all();
    
        // Filter data jobdesk berdasarkan bulan dan tim
        $jobdeskQuery = Jobdesk::query();
    
        if ($tanggalFilter) {
            $jobdeskQuery->whereMonth('tenggat_waktu', $tanggalFilter->month)
                         ->whereYear('tenggat_waktu', $tanggalFilter->year);
        }
    
        if ($teamIdFilter) {
            $jobdeskQuery->where('team_id', $teamIdFilter);
        }
    
        $jobdeskDitugaskan = (clone $jobdeskQuery)->where('status', 'ditugaskan')->count();
        $jobdeskSelesai = (clone $jobdeskQuery)->where('status', 'selesai')->count();



        $selectedUserId = $request->input('user_id');
        $selectedMonth = $request->input('bulan_kinerja');
    
        $users = User::whereIn('role', ['teamleader', 'karyawan'])
            ->where('status', 'aktif')
            ->get();
    
        $pointKpi = null;
    
        if ($selectedUserId && $selectedMonth) {
            $pointKpi = PointKpi::where('user_id', $selectedUserId)
                ->whereMonth('bulan', date('m', strtotime($selectedMonth)))
                ->whereYear('bulan', date('Y', strtotime($selectedMonth)))
                ->first();
        }



    return view('pimpinan.dashboardpimpinan', compact(
        'jumlahUserAktif',
        'jumlahUser',
        'jumlahPimpinanAktif',
        'jumlahTeamleaderAktif',
        'jumlahKaryawanAktif',
        'absensiDisetujuiHariIni',
        'absensiDiprosesHariIni',
        'jobdeskSelesai',
'jobdeskDitugaskan',
'semuaTeam',
'users', 
'pointKpi', 
'selectedUserId', 
'selectedMonth'
    ));
}



public function teamleader(Request $request)
{
    $user = auth()->user(); // Ambil user yang sedang login
    $teamId = \DB::table('detail_team')->where('user_id', $user->id)->value('team_id');


    $tanggalHariIni = Carbon::now()->toDateString();
    $absensiHariIni = Absensi::where('user_id', $user->id)
    ->where('tanggal', $tanggalHariIni)
    ->where('status', 'disetujui')
    ->first();


// Hitung total waktu_terlambat bulan ini
$now = Carbon::now();

$terlambatBulanIni = Absensi::where('user_id', $user->id)
    ->whereMonth('tanggal', $now->month)
    ->whereYear('tanggal', $now->year)
    ->whereNotNull('waktu_terlambat')
    ->pluck('waktu_terlambat');

$totalDetikTerlambat = 0;

foreach ($terlambatBulanIni as $time) {
    if ($time) {
        $carbonTime = Carbon::createFromFormat('H:i:s', $time);
        $detik = ($carbonTime->hour * 3600) + ($carbonTime->minute * 60) + $carbonTime->second;
        $totalDetikTerlambat += $detik;
    }
}

$jam = floor($totalDetikTerlambat / 3600);
$menit = floor(($totalDetikTerlambat % 3600) / 60);
$detik = $totalDetikTerlambat % 60;

$totalWaktuTerlambatBulanIni = sprintf('%02d:%02d:%02d', $jam, $menit,$detik);




    // 2. Jumlah Teamleader & Karyawan aktif dalam team yang sama
    $jumlahTeamleaderAktif = User::where('status', 'aktif')
        ->where('role', 'teamleader')
        ->whereIn('id', function($query) use ($teamId) {
            $query->select('user_id')
                  ->from('detail_team')
                  ->where('team_id', $teamId);
        })
        ->count();

    $jumlahKaryawanAktif = User::where('status', 'aktif')
        ->where('role', 'karyawan')
        ->whereIn('id', function($query) use ($teamId) {
            $query->select('user_id')
                  ->from('detail_team')
                  ->where('team_id', $teamId);
        })
        ->count();

    // 3. Absensi hari ini (status disetujui & diproses) hanya untuk role 'karyawan' di tim yang sama
    $absensiDisetujuiHariIni = Absensi::with('user')
        ->whereDate('tanggal', Carbon::today())
        ->where('status', 'disetujui')
        ->whereHas('user', function ($query) use ($teamId) {
            $query->where('role', 'karyawan')
                  ->whereIn('id', function($sub) use ($teamId) {
                      $sub->select('user_id')->from('detail_team')->where('team_id', $teamId);
                  });
        })
        ->get();

    $absensiDiprosesHariIni = Absensi::with('user')
        ->whereDate('tanggal', Carbon::today())
        ->where('status', 'diproses')
        ->whereHas('user', function ($query) use ($teamId) {
            $query->where('role', 'karyawan')
                  ->whereIn('id', function($sub) use ($teamId) {
                      $sub->select('user_id')->from('detail_team')->where('team_id', $teamId);
                  });
        })
        ->get();

        $tanggalFilter = $request->bulan ? Carbon::parse($request->bulan) : null;
        $teamIdFilter = $request->team_id ?? $teamId; // default ke team user login
        
        // Pastikan hanya bisa pilih tim sendiri
        $allowedTeams = Team::where('id', $teamId)->get(); // bisa jadi array atau collection
        
        $jobdeskQuery = Jobdesk::query()->where('team_id', $teamIdFilter);
        
        if ($tanggalFilter) {
            $jobdeskQuery->whereMonth('tenggat_waktu', $tanggalFilter->month)
                         ->whereYear('tenggat_waktu', $tanggalFilter->year);
        }
        
        $jobdeskDitugaskan = (clone $jobdeskQuery)->where('status', 'ditugaskan')->count();
        $jobdeskSelesai = (clone $jobdeskQuery)->where('status', 'selesai')->count();
        

    // 5. KPI: hanya user di team yang sama
    $selectedUserId = $request->input('user_id');
    $selectedMonth = $request->input('bulan_kinerja');

    $users = User::whereIn('role', ['teamleader', 'karyawan'])
        ->where('status', 'aktif')
        ->whereIn('id', function($query) use ($teamId) {
            $query->select('user_id')->from('detail_team')->where('team_id', $teamId);
        })
        ->get();

    $pointKpi = null;
    if ($selectedUserId && $selectedMonth) {
        $pointKpi = PointKpi::where('user_id', $selectedUserId)
            ->whereMonth('bulan', date('m', strtotime($selectedMonth)))
            ->whereYear('bulan', date('Y', strtotime($selectedMonth)))
            ->first();
    }

    return view('teamleader.dashboardteamleader', compact(
        'jumlahTeamleaderAktif',
        'jumlahKaryawanAktif',
        'absensiHariIni',
        'totalWaktuTerlambatBulanIni',
        'absensiDisetujuiHariIni',
        'absensiDiprosesHariIni',
        'jobdeskDitugaskan',
        'jobdeskSelesai',
        'allowedTeams',
        'users',
        'pointKpi',
        'selectedUserId',
        'selectedMonth'
    ));
}




public function karyawan(Request $request)
{
    $user = auth()->user();
    $tanggalHariIni = Carbon::now()->toDateString();
    $absensiHariIni = Absensi::where('user_id', $user->id)
    ->where('tanggal', $tanggalHariIni)
    ->where('status', 'disetujui')
    ->first();

//2
$now = Carbon::now();
// Hitung jumlah kehadiran bulan ini berdasarkan jenis kehadiran
$kehadiranBulanIni = Absensi::where('user_id', $user->id)
    ->whereMonth('tanggal', $now->month)
    ->whereYear('tanggal', $now->year)
    ->where('status', 'disetujui')
    ->selectRaw("
        SUM(CASE WHEN kehadiran = 'hadir'  THEN 1 ELSE 0 END) as total_hadir,
        SUM(CASE WHEN kehadiran = 'sakit' THEN 1 ELSE 0 END) as total_sakit,
        SUM(CASE WHEN kehadiran = 'izin' THEN 1 ELSE 0 END) as total_izin
    ")
    ->first();


// Hitung total waktu_terlambat bulan ini


$terlambatBulanIni = Absensi::where('user_id', $user->id)
    ->whereMonth('tanggal', $now->month)
    ->whereYear('tanggal', $now->year)
    ->whereNotNull('waktu_terlambat')
    ->pluck('waktu_terlambat');

$totalDetikTerlambat = 0;

foreach ($terlambatBulanIni as $time) {
    if ($time) {
        $carbonTime = Carbon::createFromFormat('H:i:s', $time);
        $detik = ($carbonTime->hour * 3600) + ($carbonTime->minute * 60) + $carbonTime->second;
        $totalDetikTerlambat += $detik;
    }
}

$jam = floor($totalDetikTerlambat / 3600);
$menit = floor(($totalDetikTerlambat % 3600) / 60);
$detik = $totalDetikTerlambat % 60;

$totalWaktuTerlambatBulanIni = sprintf('%02d:%02d:%02d', $jam, $menit,$detik);


//3 job me
// Ambil semua team yang user ikuti + team "Individu"
$allowedTeams = Team::whereIn('id', function ($query) use ($user) {
    $query->select('team_id')
          ->from('detail_team')
          ->where('user_id', $user->id);
})->orWhere('nama_team', 'Individu')->get();

// Ambil filter bulan dan team dari request
$tanggalFilter = $request->bulan ? Carbon::parse($request->bulan) : null;
$teamIdFilter = $request->team_id ?? ($allowedTeams->first()->id ?? null);

// Query jobdesk berdasarkan user login dan team_id
$jobdeskQuery = Jobdesk::query()
    ->whereHas('detailJobdesk', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })
    ->where('team_id', $teamIdFilter);

if ($tanggalFilter) {
    $jobdeskQuery->whereMonth('tenggat_waktu', $tanggalFilter->month)
                 ->whereYear('tenggat_waktu', $tanggalFilter->year);
}

// Hitung jobdesk ditugaskan dan selesai
$jobdeskDitugaskan = (clone $jobdeskQuery)->where('status', 'ditugaskan')->count();
$jobdeskSelesai = (clone $jobdeskQuery)->where('status', 'selesai')->count();


//point
$selectedUserId = auth()->user()->id; // langsung ambil dari user login
$selectedMonth = $request->input('bulan_kinerja');

$users = collect(); // kosongkan karena tidak akan ditampilkan

$pointKpi = null;
if ($selectedMonth) {
    $pointKpi = PointKpi::where('user_id', $selectedUserId)
        ->whereMonth('bulan', date('m', strtotime($selectedMonth)))
        ->whereYear('bulan', date('Y', strtotime($selectedMonth)))
        ->first();
}


return view('karyawan.dashboardkaryawan', compact(
   
    'absensiHariIni',
    'kehadiranBulanIni',
    'totalWaktuTerlambatBulanIni',
    'jobdeskDitugaskan',
        'jobdeskSelesai',
        'allowedTeams',
        'pointKpi',
));
}

}
