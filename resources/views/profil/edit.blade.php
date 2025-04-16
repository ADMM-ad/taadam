@extends('masterlayout')

@section('content')
<div class="container mt-3">
<div class="card card-warning collapsed-card mt-2">
    <div class="card-header" style="background-color: #31beb4;">
    <h3 class="card-title">
    <i class="bi bi-megaphone-fill"></i>
    Instructions
</h3>
        <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
    </div>
    <div class="card-body" style="background-color: #ffffff;">
Halaman ini digunakan untuk mengedit akun Anda,
Pastikan data yang Anda masukkan benar dan sesuai.<br><br>
Ketentuan pengisian:<br>
- Nama tidak boleh melebihi 50 karakter<br>
- Username harus unik (tidak boleh sama dengan pengguna lain) dan maksimal 50 karakter<br>
- Nomor HP tidak boleh melebihi 15 karakter<br>
- Alamat email pemulihan digunakan untuk membantu pemulihan akun apabila Anda lupa kata sandi di kemudian hari, sehingga pastikan email anda aktif.<br>
- Password minimal terdiri dari 8 karakter
    </div>
</div>


    <div class="card card-primary card-outline mt-3 mb-3 ms-3 me-3 p-3" style="border-color: #31beb4;">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit" style="color: #31beb4;"></i>
                Edit Profil
            </h3>
        </div>
        <div class="card-body">
            @if(session('message'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('profil.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label"><i class="fas fa-user mr-1" style="color: #31beb4;"></i>Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label"><i class="fas fa-user-tag mr-1" style="color: #31beb4;"></i>Username</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label"><i class="fas fa-phone-alt mr-1" style="color: #31beb4;"></i>No HP</label>
                    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $user->no_hp) }}">
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fas fa-envelope mr-1" style="color: #31beb4;"></i>Email Pemulihan</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><i class="fas fa-lock mr-1" style="color: #31beb4;"></i>Password Baru (Opsional)</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label"><i class="bi bi-shield-lock-fill mr-1" style="color: #31beb4;"></i>Konfirmasi Password Baru (Opsional)</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div> <!-- Tutup card-body -->

            <div class="card-footer" style="background-color: #ffffff">
                <button type="submit" class="btn btn-success">
                    Simpan
                </button>
                <a href="{{ route('profil.index') }}" class="btn btn-secondary">
                     Kembali
                </a>
            </div>
            </form>
        </div>
    
</div>
@endsection
