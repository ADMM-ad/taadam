@extends('masterlayout')

@section('content')
<div class="container mt-3">


@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-triangle"></i>  <!-- Ikon untuk error -->
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif



        <div class="card card-primary  mt-2" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i>Tambah Anggota Team</h3>
                </div>
                <div class="card-body">
    <form action="{{ route('anggotateam.store') }}" method="POST">
        @csrf
        <div class="form-group">
    <label for="user_id"><i class="fas fa-user mr-1" style="color: #31beb4;"></i>Pilih User</label>
    <select name="user_id" id="user_id" class="form-control">
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
        @endforeach
    </select>
</div>

        <div class="form-group">
            <label for="team_id"><i class="fas fa-users mr-1" style="color: #31beb4;"></i>Pilih Team</label>
            <select name="team_id" id="team_id" class="form-control">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->nama_team }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('anggotateam.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
</div>
</div>
@endsection
