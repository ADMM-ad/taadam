@extends('masterlayout')

@section('content')
<div class="container mt-3">
<div class="card card-primary  mt-2" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i>Tambah Team Baru</h3>
                </div>
                <div class="card-body">
    <form action="{{ route('team.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_team"><i class="fas fa-users mr-1" style="color: #31beb4;"></i>Nama Team</label>
            <input type="text" class="form-control @error('nama_team') is-invalid @enderror"
    id="nama_team" name="nama_team"
    placeholder="Masukan nama team baru." required
    value="{{ old('nama_team') }}">
    @error('nama_team')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
        </div>
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('team.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
</div>
</div>
@endsection
