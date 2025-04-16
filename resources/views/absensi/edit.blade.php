@extends('masterlayout')

@section('title', 'Edit Absensi')

@section('content')
<div class="container mt-3">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-check-circle mr-2"></i>  <!-- Ikon untuk sukses -->
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>  <!-- Ikon untuk error -->
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="card card-primary  mt-2" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title"><i class="fas fa-edit mr-1"></i>Edit Data Absensi</h3>
                </div>
                <div class="card-body">
    <form action="{{ route('absensi.update') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="form-group">
            <label><i class="fas fa-user mr-1" style="color: #31beb4;"></i>Nama</label>
            <input type="text" class="form-control" value="{{ $user->name }}" disabled>
        </div>

        <div class="form-group">
            <label><i class="fas fa-calendar-alt mr-1" style="color: #31beb4;"></i>Tanggal</label>
            <input type="text" class="form-control" value="{{ $tanggal }}" disabled>
        </div>

        <div class="form-group">
            <label><i class="fas fa-calendar-check mr-1" style="color: #31beb4;"></i>Kehadiran</label>
            <select name="kehadiran" class="form-control" required>
                <option value="hadir" {{ isset($absensi) && $absensi->kehadiran == 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="sakit" {{ isset($absensi) && $absensi->kehadiran == 'sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="izin" {{ isset($absensi) && $absensi->kehadiran == 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="datang" {{ isset($absensi) && $absensi->kehadiran == 'datang' ? 'selected' : '' }}>Datang</option>
                <option value="tanpa_keterangan" {{ isset($absensi) && $absensi->kehadiran == 'tanpa_keterangan' ? 'selected' : '' }}>Tidak Absen</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ Auth::user()->role === 'pimpinan' ? route('absensi.indexpimpinan') : (Auth::user()->role === 'teamleader' ? route('absensi.indexteamleader') : '#') }}" class="btn btn-secondary">Kembali</a>
    </form>
    </div>
    </div>
    </div>
@endsection
