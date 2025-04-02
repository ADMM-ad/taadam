@extends('masterlayout')

@section('title', 'Edit Absensi')

@section('content')
    <h2>Edit Absensi</h2>
    @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    <form action="{{ route('absensi.update') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="form-group">
            <label>Nama Karyawan:</label>
            <input type="text" class="form-control" value="{{ $user->name }}" disabled>
        </div>

        <div class="form-group">
            <label>Tanggal:</label>
            <input type="text" class="form-control" value="{{ $tanggal }}" disabled>
        </div>

        <div class="form-group">
            <label>Kehadiran:</label>
            <select name="kehadiran" class="form-control" required>
                <option value="hadir" {{ isset($absensi) && $absensi->kehadiran == 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="sakit" {{ isset($absensi) && $absensi->kehadiran == 'sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="izin" {{ isset($absensi) && $absensi->kehadiran == 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="datang" {{ isset($absensi) && $absensi->kehadiran == 'datang' ? 'selected' : '' }}>Datang</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
