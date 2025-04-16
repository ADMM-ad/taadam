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
                {{ $error }}
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
    <div class="card card-warning collapsed-card mt-2">
    <div class="card-header" style="background-color: #31beb4;">
    <h3 class="card-title">
    <i class="bi bi-megaphone-fill"></i>
    Instructions
</h3>
        <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
    </div>
    <div class="card-body" style="background-color: #ffffff;">
    Halaman ini digunakan untuk mengelola daftar anggota team. Anda dapat melihat serta menambahkan anggota ke dalam team yang Anda pilih.
    </div>
</div>

    <!-- Form Search -->
    <div class="row mb-3">
        <div class="col-md-12 mb-1">
            <form method="GET" action="{{ route('anggotateam.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Silahkan mencari nama team." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" style="background-color: #26948E; border-color: #26948E;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


     <!-- Tabel Daftar Tim -->
    
            <a href="{{ route('anggotateam.create') }}" class="btn btn-success mb-3">Tambah Anggota</a>
     
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-sitemap mr-1" style="color: #31beb4;"></i>Daftar Team</h3>
                </div>

                <div class="card-body table-responsive p-0">
  
                <table class="table table-hover table-bordered text-nowrap">
            <thead>
                <tr>
                    <th>Nama Tim</th>
                    <th>Jumlah Anggota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $team)
                    <tr>
                        <td>{{ $team->nama_team }}</td>
                        <td>{{ $team->detailTeams->count() }}</td>
                        <td>
                            <a href="{{ route('anggotateam.daftar', $team->id) }}" class="btn btn-info btn-sm">Lihat Anggota</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="d-flex justify-content-end mt-3">
        {{ $teams->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
