@extends('masterlayout')

@section('content')
<div class="container mt-5">
    <h1>Edit Anggota Tim</h1>
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
    <form action="{{ route('anggotateam.update', $anggotateam->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
    <label for="user_id">User</label>
    <select name="user_id" id="user_id" class="form-control">
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ $user->id == $anggotateam->user_id ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->role }})
            </option>
        @endforeach
    </select>
</div>
        <div class="form-group">
            <label for="team_id">Team</label>
            <select name="team_id" id="team_id" class="form-control">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ $team->id == $anggotateam->team_id ? 'selected' : '' }}>
                        {{ $team->nama_team }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Perbarui</button>
    </form>
</div>
@endsection
