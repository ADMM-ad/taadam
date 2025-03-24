<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\User;

class AbsensiController extends Controller
{
    public function datang(Request $request)
    {
        $currentDate = Carbon::now()->toDateString();
        $currentTime = Carbon::now();
        $startTime = Carbon::createFromTime(7, 50); // 07:50
        $endTime = Carbon::createFromTime(8, 15); // 08:15
        $lateStart = Carbon::createFromTime(8, 16); // 08:16
        $lateEnd = Carbon::createFromTime(14, 50); // 14:50
    
        // Lokasi target
        $targetLatitude = -7.8267259;
        $targetLongitude = 112.0245211;
        $radius = 20; // Dalam meter
    
        // Lokasi pengguna
        $userLatitude = $request->input('latitude');
        $userLongitude = $request->input('longitude');
    
        if (!$userLatitude || !$userLongitude) {
            return redirect()->back()->withErrors(['error' => 'Koordinat lokasi tidak ditemukan. Pastikan GPS aktif.']);
        }
    
        $distance = $this->calculateDistance($targetLatitude, $targetLongitude, $userLatitude, $userLongitude);
        if ($distance > $radius) {
            return redirect()->back()->withErrors(['error' => 'Anda harus berada di lokasi absen untuk melakukan absensi.']);
        }
    
        // Cek jika absensi sudah ada
        $existingAbsensi = Absensi::where('user_id', Auth::id())->where('tanggal', $currentDate)->first();
        if ($existingAbsensi) {
            return redirect()->back()->withErrors(['error' => 'Anda sudah melakukan absensi datang hari ini.']);
        }
    
        // Tentukan keterangan dan status berdasarkan waktu
        $lateness = null;
        if ($currentTime->between($startTime, $endTime)) {
            $kehadiran = 'datang';
            $status = 'disetujui';
        } elseif ($currentTime->between($lateStart, $lateEnd)) {
            $lateness = $currentTime->diff($endTime)->format('%H:%I:%S');
            $kehadiran = 'datang';
            $status = 'disetujui';
        } else {
            return redirect()->back()->withErrors(['error' => 'Waktu absensi datang tidak valid.']);
        }
    
        // Simpan data absensi
        Absensi::create([
            'user_id' => Auth::id(),
            'tanggal' => $currentDate,
            'waktu_datang' => $currentTime->toTimeString(),
            'waktu_terlambat' => $lateness,
            'kehadiran' => $kehadiran,
            'status' => $status,
        ]);
    
        return redirect()->back()->with('success', 'Berhasil melakukan absensi datang.');
    }
    
    public function pulang(Request $request)
    {
        $currentDate = Carbon::now()->toDateString();
        $currentTime = Carbon::now();
        $lateStart = Carbon::createFromTime(14, 51); // 14:51
        $lateEnd = Carbon::createFromTime(16, 30); // 16:30
    
        // Lokasi target
        $targetLatitude = -7.8267259;
        $targetLongitude = 112.0245211;
        $radius = 20; // Dalam meter
    
        // Lokasi pengguna
        $userLatitude = $request->input('latitude');
        $userLongitude = $request->input('longitude');
    
        if (!$userLatitude || !$userLongitude) {
            return redirect()->back()->withErrors(['error' => 'Koordinat lokasi tidak ditemukan. Pastikan GPS aktif.']);
        }
    
        $distance = $this->calculateDistance($targetLatitude, $targetLongitude, $userLatitude, $userLongitude);
        if ($distance > $radius) {
            return redirect()->back()->withErrors(['error' => 'Anda harus berada di lokasi absen untuk melakukan absensi.']);
        }
    
        $absensi = Absensi::where('user_id', Auth::id())->where('tanggal', $currentDate)->first();
        if (!$absensi) {
            return redirect()->back()->withErrors(['error' => 'Anda belum melakukan absensi datang.']);
        }
    
        if ($currentTime->between($lateStart, $lateEnd)) {
            $absensi->update([
                'waktu_pulang' => $currentTime->toTimeString(),
                'kehadiran' => 'hadir',
            ]);
    
            return redirect()->back()->with('success', 'Berhasil melakukan absensi pulang.');
        }
    
        return redirect()->back()->withErrors(['error' => 'Waktu absensi pulang tidak valid.']);
    }
    
    // Fungsi untuk menghitung jarak menggunakan formula Haversine
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos($lat1) * cos($lat2) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function storePerizinan(Request $request)
    {
        $validatedData = $request->validate([
            'kehadiran' => 'required|in:sakit,izin,datang,hadir',
            'bukti' => 'file|mimes:pdf,jpg,png|max:5120',
        ], [
            'kehadiran.required' => 'Keterangan wajib dipilih.',
            'bukti.mimes' => 'File bukti harus berupa PDF, JPG, atau PNG.',
            'bukti.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $userId = Auth::id();
        $tanggal = $request->tanggal;
    
        // Jika memilih "Lupa Absen Pulang"
    if ($request->kehadiran === 'hadir') {
        // Cek apakah ada absensi dengan keterangan "datang" pada tanggal tersebut
        $absensiDatang = Absensi::where('user_id', $userId)
                                ->where('tanggal', $tanggal)
                                ->where('kehadiran', 'datang')
                                ->where('status', 'disetujui')
                                ->first();

        if ($absensiDatang) {
            // Jika ada, ubah menjadi "hadir"
            $absensiDatang->kehadiran = 'hadir';
            $absensiDatang->status = 'diproses';
            $absensiDatang->pesan = $request->pesan; // Simpan pesan jika ada
            $absensiDatang->save();

            return redirect()->back()->with('success', 'Perizinan berhasil diajukan');
        } else {
            // Jika tidak ada, kembalikan pesan error
            return redirect()->back()->with('error', 'Anda belum absen datang.');
        }
    }


        // Cek apakah data absensi sudah ada untuk tanggal tersebut
        $absensi = Absensi::where('user_id', $userId)->where('tanggal', $tanggal)->first();
    
        if ($absensi) {
            // Jika sudah ada, update data perizinan
            $absensi->kehadiran = $request->kehadiran;
            $absensi->status = 'diproses'; // Reset status ke "diproses"
        } else {
            // Jika belum ada, buat entri baru
            $absensi = new Absensi();
            $absensi->user_id = $userId;
            $absensi->tanggal = $tanggal;
            $absensi->kehadiran = $request->kehadiran;
            $absensi->pesan = $request->pesan; // Simpan pesan jika ada
            $absensi->status = 'diproses';
        }

        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'files';
            $file->move($filePath, $fileName);
            $absensi->bukti = $filePath . '/' . $fileName; // Simpan path file
        }

        $absensi->save();

        return redirect()->back()->with('success', 'Perizinan berhasil diajukan.');
    }

    public function showPerizinanForm(Request $request)
    {
        $tanggal = $request->query('tanggal', now()->toDateString()); // Default ke hari ini jika tidak ada parameter
        return view('absensi.perizinan', compact('tanggal'));
    }

    public function indexrequest()
    {
        $perizinan = Absensi::where('status', 'diproses')->with('user')->get();
        return view('absensi.requestperizinan', compact('perizinan'));
    }

// Mengupdate status perizinan (Terima atau Tolak)
    public function updateStatus($id, $status)
{
    $izin = Absensi::findOrFail($id);
    $izin->status = $status;
    $izin->save();

    return redirect()->back()->with('success', "Permohonan perizinan telah $status.");
}


public function statusPengguna()
{
    $user_id = Auth::id();
    $absensi = Absensi::where('user_id', $user_id)
                        ->where('status', '!=', 'disetujui')
                        ->get();

    return view('absensi.statuspengguna', compact('absensi'));
}





    public function index()
    {
        return view('absensi.indexpengguna');
    }

    public function getAbsensi()
    {
        $userId = Auth::id();
        $absensi = Absensi::where('user_id', $userId)->get();
    
        $events = [];
        $tanggalAbsensi = $absensi->pluck('tanggal')->toArray();
    
        // Cari tanggal pertama kali user absen
        $firstDate = !empty($tanggalAbsensi) ? min($tanggalAbsensi) : null;
        $today = now()->toDateString();
    
        // Loop data absensi
        foreach ($absensi as $item) {
            if ($item->status == 'disetujui') {
                $color = match ($item->kehadiran) {
                    'hadir' => 'green',
                    'sakit' => 'yellow',
                    'izin'  => 'orange',
                    'datang' => 'blue',
                    default => 'white', // Warna default jika tidak sesuai dengan yang ditentukan
                };
                
                        
                $events[] = [
                    'title' => ucfirst($item->kehadiran),
                    'start' => $item->tanggal,
                    'color' => $color
                ];
            } elseif ($item->status == 'diproses') {
                $events[] = [
                    'title' => 'Sedang menunggu persetujuan',
                    'start' => $item->tanggal,
                    'color' => 'gray'
                ];
            } elseif ($item->status == 'ditolak') {
                $events[] = [
                    'title' => 'Perizinan tidak disetujui',
                    'start' => $item->tanggal,
                    'color' => 'red'
                ];
            }
        }
    
        // Tambahkan event "Tidak Absen" untuk hari tanpa data
        if ($firstDate) {
            $dateRange = collect();
            for ($date = strtotime($firstDate); $date <= strtotime($today); $date += 86400) {
                $formattedDate = date('Y-m-d', $date);
                if (!in_array($formattedDate, $tanggalAbsensi)) {
                    $events[] = [
                        'title' => 'Tidak Absen',
                        'start' => $formattedDate,
                        'color' => 'black'
                    ];
                }
            }
        }
    
        return response()->json($events);
    }
    



    public function indexPimpinan()
{
    // Ambil semua user dengan role karyawan dan teamleader
    $users = User::whereIn('role', ['karyawan', 'teamleader'])->get();
    return view('absensi.indexpimpinan', compact('users'));
}

    public function getAbsensiPimpinan(Request $request)
{
    $userId = $request->input('user_id'); // Ambil user_id dari request
    
    // Jika tidak ada user_id yang dipilih, kembalikan data kosong
    if (!$userId) {
        return response()->json([]);
    }

    $absensi = Absensi::where('user_id', $userId)->get();

    $events = [];
    $tanggalAbsensi = $absensi->pluck('tanggal')->toArray();

    $firstDate = !empty($tanggalAbsensi) ? min($tanggalAbsensi) : null;
    $today = now()->toDateString();

    foreach ($absensi as $item) {
        if ($item->status == 'disetujui') {
            $color = match ($item->kehadiran) {
                'hadir' => 'green',
                'sakit' => 'yellow',
                'izin'  => 'orange',
                'datang' => 'blue',
                default => 'white',
            };

            $events[] = [
                'title' => ucfirst($item->kehadiran),
                'start' => $item->tanggal,
                'color' => $color
            ];
        } elseif ($item->status == 'diproses') {
            $events[] = [
                'title' => 'Sedang menunggu persetujuan',
                'start' => $item->tanggal,
                'color' => 'gray'
            ];
        } elseif ($item->status == 'ditolak') {
            $events[] = [
                'title' => 'Perizinan tidak disetujui',
                'start' => $item->tanggal,
                'color' => 'red'
            ];
        }
    }

    if ($firstDate) {
        $dateRange = collect();
        for ($date = strtotime($firstDate); $date <= strtotime($today); $date += 86400) {
            $formattedDate = date('Y-m-d', $date);
            if (!in_array($formattedDate, $tanggalAbsensi)) {
                $events[] = [
                    'title' => 'Tidak Absen',
                    'start' => $formattedDate,
                    'color' => 'black'
                ];
            }
        }
    }

    return response()->json($events);
}



public function edit(Request $request)
{
    $userId = $request->query('user_id');
    $tanggal = $request->query('tanggal');

    // Cek apakah data absensi sudah ada
    $absensi = Absensi::where('user_id', $userId)->where('tanggal', $tanggal)->first();

    // Ambil user untuk ditampilkan di form
    $user = User::find($userId);

    return view('absensi.edit', compact('absensi', 'user', 'tanggal'));
}

public function update(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'tanggal' => 'required|date',
        'kehadiran' => 'required|in:hadir,sakit,izin,datang',
    ]);

    $userId = $request->input('user_id');
    $tanggal = $request->input('tanggal');
    $kehadiran = $request->input('kehadiran');

    // Cek apakah data absensi sudah ada
    $absensi = Absensi::where('user_id', $userId)->where('tanggal', $tanggal)->first();

    if ($absensi) {
        // Jika sudah ada, update data
        $absensi->update([
            'kehadiran' => $kehadiran,
            'status' => 'disetujui',
        ]);
    } else {
        // Jika belum ada, buat baru
        Absensi::create([
            'user_id' => $userId,
            'tanggal' => $tanggal,
            'kehadiran' => $kehadiran,
            'status' => 'disetujui', // Default status
        ]);
    }

    return redirect()->route('absensi.indexpimpinan', ['selected_user' => $request->user_id])
    ->with('success', 'Data absensi berhasil diperbarui.');


}


}

