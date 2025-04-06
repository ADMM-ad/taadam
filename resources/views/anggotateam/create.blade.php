@extends('masterlayout')

@section('content')
<div class="container mt-2">

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



        <div class="card card-primary  mt-2" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title">Tambah Anggota Team</h3>
                </div>
                <div class="card-body">
    <form action="{{ route('anggotateam.store') }}" method="POST">
        @csrf
        <div class="form-group">
    <label for="user_id">User</label>
    <select name="user_id" id="user_id" class="form-control">
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
        @endforeach
    </select>
</div>

        <div class="form-group">
            <label for="team_id">Team</label>
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
