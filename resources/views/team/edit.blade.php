@extends('masterlayout')

@section('content')
<div class="container mt-3">
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
                    <h3 class="card-title">Edit Team</h3>
                </div>
                <div class="card-body">        
    <form action="{{ route('team.update', $team->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_team">Nama Team</label>
            <input type="text" class="form-control" id="nama_team" name="nama_team" value="{{ $team->nama_team }}" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Perbarui</button>
        <a href="{{ route('team.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
    </div>
    </div>
</div>
@endsection
