@extends('masterlayout')

@section('content')
<div class="container mt-3">
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>
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
                    <h3 class="card-title"><i class="fas fa-edit mr-1"></i>Form Edit Jaringan Absensi</h3>
                </div>
                <div class="card-body">
                <form action="{{ route('jaringan.update', $jaringan->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nama_jaringan"><i class="fas fa-network-wired mr-1" style="color: #31beb4;"></i>Nama Jaringan</label>
        <input type="text" class="form-control" name="nama_jaringan" value="{{ $jaringan->nama_jaringan }}" required>
    </div>

    <div class="form-group">
        <label for="allowedRangeStart"><i class="fas fa-play mr-1" style="color: #31beb4;"></i>IP Start</label>
        <input type="text" class="form-control" name="allowedRangeStart" value="{{ $jaringan->allowedRangeStart }}" required>
    </div>

    <div class="form-group">
        <label for="allowedRangeEnd"><i class="fas fa-stop mr-1" style="color: #31beb4;"></i>IP End</label>
        <input type="text" class="form-control" name="allowedRangeEnd" value="{{ $jaringan->allowedRangeEnd }}" required>
    </div>

    <button type="submit" class="btn btn-success mt-3">Simpan</button>
    <a href="{{ route('jaringan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</form>

</div>
</div>
</div>
@endsection
