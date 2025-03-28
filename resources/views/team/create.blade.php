@extends('masterlayout')

@section('content')
<div class="container mt-5">
    <h1>Tambah Team Baru</h1>


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
    <form action="{{ route('team.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_team">Nama Team</label>
            <input type="text" class="form-control" id="nama_team" name="nama_team" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('team.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection
