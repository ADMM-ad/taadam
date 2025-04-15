@extends('masterlayout')

@section('content')
<div class="container mt-3">
    

        <div class="card card-primary  mt-2" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title"><i class="fas fa-edit mr-1"></i>Edit Team</h3>
                </div>
                <div class="card-body">        
    <form action="{{ route('team.update', $team->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_team"><i class="fas fa-users mr-1" style="color: #31beb4;"></i>Nama Team</label>
            <input type="text"
       class="form-control @error('nama_team') is-invalid @enderror"
       id="nama_team"
       name="nama_team"
       value="{{ $team->nama_team }}"
       required>

            @error('nama_team')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
        </div>
        <button type="submit" class="btn btn-success mt-3">Perbarui</button>
        <a href="{{ route('team.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
    </div>
    </div>
</div>
@endsection
