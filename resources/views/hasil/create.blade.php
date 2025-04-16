@extends('masterlayout')

@section('content')
<div class="container mt-3">
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-check-circle mr-2"></i>  <!-- Ikon untuk sukses -->
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>  <!-- Ikon untuk error -->
        <ul class="mb-0">
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
                    <h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i>Tambah Data Hasil</h3>
                </div>
                <div class="card-body">
    <form action="{{ route('hasil.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="team_id"><i class="fas fa-users mr-1" style="color: #31beb4;"></i>Nama Team</label>
            <select class="form-control" name="team_id" required>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->nama_team }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="bulan"><i class="fas fa-calendar mr-1" style="color: #31beb4;"></i>Bulan (YYYY-MM)</label>
            <input type="month" class="form-control" name="bulan" required>
        </div>
        <div class="form-group">
            <label for="views"><i class="fas fa-eye mr-1" style="color: #31beb4;"></i>Views</label>
            <input type="text" class="form-control" name="views" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ auth()->user()->role == 'pimpinan' ? route('hasil.index') : route('hasil.teamleader') }}" class="btn btn-secondary mt-3">
    Kembali
</a>
    </form>
    </div>
    </div>
    </div>
</div>
@endsection
