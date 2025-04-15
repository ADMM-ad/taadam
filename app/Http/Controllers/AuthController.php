<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'username' => 'required|string', // Ganti email menjadi username
            'password' => 'required|string',
        ]);
    
        // Kredensial login
        $credentials = [
            'username' => $request->username, // Ganti email menjadi username
            'password' => $request->password,
        ];
    
        $remember = $request->has('remember');

        // Cek kredensial dan autentikasi pengguna
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
    
            if ($user->status == 'tidakaktif') {
                return redirect()->route('profil.edit')->with('message', 'Silahkan mengubah Username dan Password untuk mengaktifkan akun');
            }
    
            // Redirect berdasarkan role
            if ($user->role == 'pimpinan') {
                return redirect()->route('dashboardpimpinan');
            } elseif ($user->role == 'teamleader') {
                return redirect()->route('dashboardteamleader');
            } elseif ($user->role == 'karyawan') {
                return redirect()->route('dashboardkaryawan');
            }
        }
    
        // Jika gagal login
        return redirect()->back()->withErrors(['username' => 'Username atau password salah']); // Ganti email menjadi username
    }
    
    public function register(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'name' => 'nullable|string|max:50', // Name opsional
            'username' => 'required|string|max:50|unique:users', // Ganti email menjadi username
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:karyawan,teamleader,pimpinan',
        ], [
            'name.max' => 'Nama tidak boleh lebih dari 50 karakter.',
            
            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.max' => 'Username tidak boleh lebih dari 50 karakter.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
            
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal harus terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            
            'role.required' => 'Peran pengguna wajib dipilih.',
            'role.in' => 'Peran pengguna harus salah satu dari: karyawan, teamleader, atau pimpinan.',
        ]);
    
        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username, // Ganti email menjadi username
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'tidakaktif',
        ]);
    
        return redirect()->route('register')->with('success', 'Akun berhasil ditambahkan.');
    }
    
    public function logout(Request $request)
    {
        Auth::logout(); // Logout pengguna saat ini

        $request->session()->invalidate(); // Hapus sesi pengguna

        $request->session()->regenerateToken(); // Regenerasi token sesi

        return redirect('/login'); // Redirect ke halaman login
    }

    public function checkUsername(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if ($user) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    // Simpan password baru
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $reset = \DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->first();
    
        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['token' => 'Token tidak valid atau sudah kadaluarsa.']);
        }
    
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
    
        // Hapus token reset
        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();
    
        return redirect()->route('login')->with('success', 'Password berhasil diubah!');
    }
    


    public function sendVerificationLink(Request $request)
{
    $request->validate([
        'username' => 'required',
        'email' => 'required|email',
    ]);

    $user = User::where('username', $request->username)
                ->where('email', $request->email)
                ->first();

                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Username atau email tidak ditemukan!'
                    ]);
                }

    // Generate token dan simpan
    $token = Str::random(64);
    \DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $user->email],
        ['token' => Hash::make($token), 'created_at' => now()]
    );

    // Kirim email
    $link = route('forgot.reset', ['token' => $token, 'email' => $user->email]);
    Mail::html("
    <p>Yth. {$user->name},</p>
    <p>Kami menerima permintaan untuk mereset kata sandi akun Anda.</p>
    <p>Silakan klik tombol di bawah ini untuk melanjutkan proses pengaturan ulang kata sandi:</p>
    <p>
        <a href=\"$link\" style=\"
            display: inline-block;
            padding: 10px 20px;
            background-color: #1D4ED8;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        \">
            Reset Kata Sandi
        </a>
    </p>
    <p>Jika tombol di atas tidak berfungsi, Anda dapat mengklik atau menyalin dan menempelkan tautan berikut ke browser Anda:</p>
    <p>$link</p>
     <p>Jika Anda tidak merasa melakukan permintaan reset kata sandi ini, silakan abaikan email ini. Tidak ada tindakan lebih lanjut yang diperlukan.</p>
    <br>
    <p>Hormat kami,<br>Tim Ourweb</p>
", function ($message) use ($user) {
    $message->to($user->email)->subject('Permintaan Reset Kata Sandi');
});


return response()->json([
    'success' => true,
    'message' => 'Link verifikasi telah dikirim ke email Anda.'
]);
}

public function showResetForm(Request $request, $token)
{
    return view('auth.resetpassword', ['token' => $token, 'email' => $request->email]);
}


}
