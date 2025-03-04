@extends('masterlayout')

@section('content')
<div class="container mt-5">
    <h1>Tambah Jobdesk Hasil</h1>
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
    <form action="{{ route('hasil.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="team_id">Nama Team</label>
            <select class="form-control" name="team_id" required>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->nama_team }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="bulan">Bulan (YYYY-MM)</label>
            <input type="month" class="form-control" name="bulan" required>
        </div>
        <div class="form-group">
            <label for="views">Views</label>
            <input type="text" class="form-control" name="views" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('hasil.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection
