<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AnggotateamController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\JobdeskController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\JaringanController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        
        if ($user->role == 'pimpinan') {
            return redirect()->route('dashboardpimpinan');
        } elseif ($user->role == 'teamleader') {
            return redirect()->route('dashboardteamleader');
        } elseif ($user->role == 'karyawan') {
            return redirect()->route('dashboardkaryawan');
        }
    }
    
    return redirect()->route('login');
});




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/lupa-password', function () {
    return view('auth.lupapasword');
})->name('forgot.password');

Route::post('/forgot-password/verify', [AuthController::class, 'sendVerificationLink'])->name('forgot.verify');
Route::get('/forgot-password/reset/{token}', [AuthController::class, 'showResetForm'])->name('forgot.reset');
Route::post('/forgot-password/update', [AuthController::class, 'updatePassword'])->name('update.password');


Route::post('/check-username', [AuthController::class, 'checkUsername'])->name('check.username');
Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update.password');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




















Route::middleware(['auth',RoleMiddleware::class . ':pimpinan',])->group(function () {

    //homepimpinan
    Route::get('/dashboardpimpinan', [DashboardController::class, 'pimpinan'])->name('dashboardpimpinan');
    //tambahakun
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])
        ->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    //kelola user
    Route::get('/userkaryawan', [UserController::class, 'indexKaryawan'])->name('users.indexkaryawan');
    Route::delete('/userkaryawan/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{id}/change-status', [UserController::class, 'changeStatus'])->name('users.changeStatus');
    Route::get('/userteamleader', [UserController::class, 'indexTeamleader'])->name('users.indexteamleader');
    Route::delete('/userteamleader/{id}', [UserController::class, 'destroytl'])->name('users.destroytl');
    Route::patch('teamleader/{id}/status', [UserController::class, 'changeStatustl'])->name('users.changeStatustl');
    Route::put('/users/{id}/promote', [UserController::class, 'promoteToTeamLeader'])->name('users.promote');
    Route::put('/users/{id}/demote', [UserController::class, 'demoteToKaryawan'])->name('users.demote');
    //kelola team
    Route::get('/team', [TeamController::class, 'index'])->name('team.index');
    Route::get('/team/create', [TeamController::class, 'create'])->name('team.create');
    Route::post('/team', [TeamController::class, 'store'])->name('team.store');
    Route::get('/team/{team}/edit', [TeamController::class, 'edit'])->name('team.edit');
    Route::put('/team/{team}', [TeamController::class, 'update'])->name('team.update');
    Route::delete('/team/{team}', [TeamController::class, 'destroy'])->name('team.destroy');
    //AnggotaTeam
    Route::get('/anggotateam', [AnggotateamController::class, 'index'])->name('anggotateam.index');
    Route::get('/anggotateam/create', [AnggotateamController::class, 'create'])->name('anggotateam.create');
    Route::post('/anggotateam', [AnggotateamController::class, 'store'])->name('anggotateam.store');
    Route::get('/anggotateam/{anggotateam}/edit', [AnggotateamController::class, 'edit'])->name('anggotateam.edit');
    Route::put('/anggotateam/{anggotateam}', [AnggotateamController::class, 'update'])->name('anggotateam.update');
    Route::delete('/anggotateam/{anggotateam}', [AnggotateamController::class, 'destroy'])->name('anggotateam.destroy');
    Route::get('/anggotateam/{team}/daftar', [AnggotateamController::class, 'daftar'])->name('anggotateam.daftar');
    //jobdesk
    Route::get('/jobdesk/create', [JobdeskController::class, 'create'])->name('jobdesk.create');
    //JobdeskIndividu
    Route::get('/jobdesk/createindividu', [JobdeskController::class, 'createindividu'])->name('jobdesk.createindividu');
    Route::post('/jobdesk/storeindividu', [JobdeskController::class, 'storeindividu'])->name('jobdesk.storeindividu');
    //laporan jobdesk
    Route::get('/jobdesk/pimpinan', [JobdeskController::class, 'indexpimpinan'])->name('jobdesk.indexpimpinan');
    //permintaan perizinan
    Route::get('/request-perizinan', [AbsensiController::class, 'indexrequest'])->name('absensi.indexrequest');
    //laporan absensi
    Route::get('/absensipimpinan', [AbsensiController::class, 'indexPimpinan'])->name('absensi.indexpimpinan');
    //hasilviews
    Route::get('/hasil', [HasilController::class, 'index'])->name('hasil.index');
    //point
    Route::get('/point', [PointController::class, 'index'])->name('point.index');
    Route::get('/laporanpoint', [PointController::class, 'indexPimpinan'])->name('point.indexpimpinan');    
//settingjaringan
Route::resource('jaringan', JaringanController::class);
});


Route::middleware(['auth',RoleMiddleware::class . ':teamleader',])->group(function () {

    //home teamleader
    Route::get('/dashboardteamleader', [DashboardController::class, 'teamleader'])->name('dashboardteamleader');

    //request perizinan team
    Route::get('/request-team-leader', [AbsensiController::class, 'indexrequestteamleader'])->name('absensi.requestteam');
    //laporan absensi team
    Route::get('/absensiteam', [AbsensiController::class, 'indexTeamleader'])->name('absensi.indexteamleader');
    //jobdesk yg dari teamleadaer
    Route::get('/jobdesk/createteam', [JobdeskController::class, 'createteamleader'])->name('jobdesk.createteamleader');
    Route::get('/jobdesk/team', [JobdeskController::class, 'indexteamleader'])->name('jobdesk.indexteamleader');
    //hasil views
    Route::get('/hasil-teamleader', [HasilController::class, 'indexteamleader'])->name('hasil.teamleader');
    //point
    Route::get('/pointteam', [PointController::class, 'indexteam'])->name('point.indexteam');
    Route::get('/laporanpointteam', [PointController::class, 'indexteamleader'])->name('point.indexteamleader');

});


Route::middleware(['auth',RoleMiddleware::class . ':karyawan',])->group(function () {

    
    Route::get('/dashboardkaryawan', [DashboardController::class, 'karyawan'])->name('dashboardkaryawan');

});


Route::middleware(['auth',RoleMiddleware::class . ':pimpinan,teamleader',])->group(function () {

// cek,acc,tolak perizinan
Route::get('/absensi/detailperizinan/{id}', [AbsensiController::class, 'detailPerizinan'])->name('absensi.detailperizinan');
Route::put('/perizinan/{id}/{status}', [AbsensiController::class, 'updateStatus'])->name('perizinan.update');
//data laporan absensi
Route::get('/absensi/datapimpinan', [AbsensiController::class, 'getAbsensiPimpinan']);
//edit absensi
Route::get('/absensi/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
Route::post('/absensi/update', [AbsensiController::class, 'update'])->name('absensi.update');
//terlambat
Route::get('/laporan-keterlambatan', [AbsensiController::class, 'menghitungterlambat'])->name('absensi.keterlambatan');
//jobdesk 
Route::post('/jobdesk/store', [JobdeskController::class, 'store'])->name('jobdesk.store');
Route::get('/jobdesk/users/{team_id}', [JobdeskController::class, 'getUsersByTeam']);
Route::get('/jobdesk/editpimpinan/{id}', [JobdeskController::class, 'editpimpinan'])->name('jobdesk.editpimpinan');

Route::put('/jobdesk/updatepimpinan/{id}', [JobdeskController::class, 'updatepimpinan'])->name('jobdesk.updatepimpinan');
Route::delete('/jobdesk/delete/{id}', [JobdeskController::class, 'destroy'])->name('jobdesk.delete');
Route::get('/jobdesk/editkelolajob/{id}', [JobdeskController::class, 'editkelolajob'])->name('jobdesk.editkelolajob');
Route::delete('/jobdesk/{jobdesk_id}/removeUser/{user_id}', [JobdeskController::class, 'removeUser'])->name('jobdesk.removeUser');
Route::post('/jobdesk/{jobdesk}/addUser', [JobdeskController::class, 'addUser'])->name('jobdesk.addUser');
//hasil
Route::get('/hasil/create', [HasilController::class, 'create'])->name('hasil.create');
Route::post('/hasil', [HasilController::class, 'store'])->name('hasil.store');
Route::get('/hasil/{jobdeskHasil}/edit', [HasilController::class, 'edit'])->name('hasil.edit');
Route::put('/hasil/{jobdeskHasil}', [HasilController::class, 'update'])->name('hasil.update');
Route::delete('/hasil/{jobdeskHasil}', [HasilController::class, 'destroy'])->name('hasil.destroy');
//point
Route::get('/point/create', [PointController::class, 'create'])->name('point.create');
Route::get('/point/get-data', [PointController::class, 'getData']);
Route::post('/point/store', [PointController::class, 'store'])->name('point.store');
Route::delete('/pimpinan/point/{id}', [PointController::class, 'destroy'])->name('point.destroy');
});


Route::middleware(['auth',RoleMiddleware::class . ':karyawan,teamleader',])->group(function () {
    
    Route::get('/absensi', [AbsensiController::class, 'absensiku'])->name('absensi.absensi');
    Route::post('/absensi/datang', [AbsensiController::class, 'datang'])->name('absensi.datang');
    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang'])->name('absensi.pulang');
    //perizinan
    Route::post('/absensi/perizinan', [AbsensiController::class, 'storePerizinan'])->name('absensi.perizinan');
    Route::get('/absensi/perizinan', [AbsensiController::class, 'showPerizinanForm'])->name('absensi.perizinan.form');
    //status perizinan
    Route::get('/statusperizinan', [AbsensiController::class, 'statusPengguna'])->name('absensi.statuspengguna');
    Route::delete('/hapusperizinan/{id}', [AbsensiController::class, 'destroyperizinan'])->name('absensi.destroyperizinan');
    //absensinya
    Route::get('/absensipengguna', [AbsensiController::class, 'index'])->name('absensi.indexpengguna');
    //jobdesk
    Route::get('/jobdesk/pengguna', [JobdeskController::class, 'indexpengguna'])->name('jobdesk.indexpengguna');
    Route::get('/jobdesk/pengguna/selesai', [JobdeskController::class, 'indexpenggunaselesai'])->name('jobdesk.indexpenggunaselesai');
    Route::get('/jobdesk/edit/{id}', [JobdeskController::class, 'editpengguna'])->name('jobdesk.editpengguna');
    Route::put('/jobdesk/update/{id}', [JobdeskController::class, 'updatepengguna'])->name('jobdesk.updatepengguna');
    Route::get('/jobdesk/{id}/editbukti', [JobdeskController::class, 'editbukti'])->name('jobdesk.editbukti');
    Route::put('/jobdesk/{id}/updatebukti', [JobdeskController::class, 'updatebukti'])->name('jobdesk.updatebukti');
    //cek point
    Route::get('/cekpoint', [PointController::class, 'indexPengguna'])->name('point.indexpengguna');
});






Route::middleware(['auth'])->group(function () {


//profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
//data absensi
Route::get('/absensi/data', [AbsensiController::class, 'getAbsensi']);
//job
Route::get('/jobdesk/detailpimpinan/{id}', [JobdeskController::class, 'detailpimpinan'])->name('jobdesk.detailpimpinan');

});





