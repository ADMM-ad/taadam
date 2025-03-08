<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AnggotateamController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\JobdeskController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\PointController;
Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/absensi', function () {
        return view('absensi.absensi');
    })->name('absensi');
    Route::get('/permintaanperizinan', function () {
        return view('absensi.perizinan');
    })->name('permintaan.perizinan');

    Route::post('/absensi/datang', [AbsensiController::class, 'datang'])->name('absensi.datang');
    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang'])->name('absensi.pulang');
    Route::post('/absensi/perizinan', [AbsensiController::class, 'storePerizinan'])->name('absensi.perizinan');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');

});

Route::get('/dashboardpimpinan', function () {
    return view('pimpinan.dashboardpimpinan');
})->name('dashboardpimpinan');
Route::get('/dashboardteamleader', function () {
    return view('teamleader.dashboardteamleader');
})->name('dashboardteamleader');
Route::get('/dashboardkaryawan', function () {
    return view('karyawan.dashboardkaryawan');
})->name('dashboardkaryawan');


//User
Route::get('/userkaryawan', [UserController::class, 'indexKaryawan'])->name('users.indexkaryawan');
Route::delete('/userkaryawan/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/userteamleader', [UserController::class, 'indexTeamleader'])->name('users.indexteamleader');
Route::delete('/userteamleader/{id}', [UserController::class, 'destroytl'])->name('users.destroytl');

//Team
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



//Jobdesk
Route::get('/jobdesk/create', [JobdeskController::class, 'create'])->name('jobdesk.create');
Route::post('/jobdesk/store', [JobdeskController::class, 'store'])->name('jobdesk.store');
Route::get('/jobdesk/users/{team_id}', [JobdeskController::class, 'getUsersByTeam']);

// Hasil
Route::get('/hasil', [HasilController::class, 'index'])->name('hasil.index');
Route::get('/hasil/create', [HasilController::class, 'create'])->name('hasil.create');
Route::post('/hasil', [HasilController::class, 'store'])->name('hasil.store');
Route::get('/hasil/{jobdeskHasil}/edit', [HasilController::class, 'edit'])->name('hasil.edit');
Route::put('/hasil/{jobdeskHasil}', [HasilController::class, 'update'])->name('hasil.update');
Route::delete('/hasil/{jobdeskHasil}', [HasilController::class, 'destroy'])->name('hasil.destroy');

//Point
Route::get('/point', [PointController::class, 'index'])->name('point.index');
Route::get('/point/create', [PointController::class, 'create'])->name('point.create');
Route::get('/point/get-data', [PointController::class, 'getData']);
Route::post('/point/store', [PointController::class, 'store'])->name('point.store');