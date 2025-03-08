@extends('masterlayout')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Daftar Tim</h1>

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

    <div class="row">
        <!-- Kotak untuk Tambah Anggota -->
        <div class="col-md-4">
            <a href="{{ route('anggotateam.create') }}" class="text-decoration-none">
                <div class="card text-center p-4 border-dashed" style="border: 2px dashed #007bff;">
                    <h4 class="text-primary">+ Tambah Anggota</h4>
                </div>
            </a>
        </div>

        <!-- Looping untuk daftar tim -->
        @foreach($teams as $team)
        <div class="col-md-4">
            <a href="{{ route('anggotateam.daftar', $team->id) }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5 class="text-dark">{{ $team->nama_team }}</h5>
                    <p class="text-muted">Jumlah Anggota: {{ $team->detailTeams->count() }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
