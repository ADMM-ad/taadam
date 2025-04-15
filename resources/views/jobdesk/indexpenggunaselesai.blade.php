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

<div class="row">
<div class="col-md-12">
<form method="GET" action="{{ route('jobdesk.indexpenggunaselesai') }}">
<div class="input-group mb-2">
<input type="text" name="nama_pekerjaan" class="form-control" placeholder="Cari Nama Pekerjaan" value="{{ request('nama_pekerjaan') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" style="background-color: #26948E; border-color: #26948E;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
    <div class="row">
    <div class="col-md-10 mt-2">
    <input type="month" name="tanggal_filter" class="form-control" value="{{ request('tanggal_filter') }}">
</div>

    <div class="col-md-2 d-flex justify-content-end align-items-end mt-2 gap-2">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('jobdesk.indexpenggunaselesai') }}" class="btn btn-secondary ml-2">Reset</a>
    </div>
</div>
</form>
</div>
</div>


<div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tasks mr-1" style="color: #31beb4;"></i>Daftar Jobdesk yang Selesai</h3>
                </div>

                <div class="card-body table-responsive p-0">
  
                <table class="table table-hover table-bordered text-nowrap">
        <thead>
            <tr>
                <th>Nama Pekerjaan</th>
                <th>Deskripsi</th>
                <th>Tenggat Waktu</th>
                <th>Waktu Selesai</th>
                <th>Status</th>
                <th>Hasil</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobdesks as $jobdesk)
                <tr>
                    <td>{{ $jobdesk->nama_pekerjaan }}</td>
                    <td>{{ $jobdesk->deskripsi }}</td>
                    <td>{{ $jobdesk->tenggat_waktu }}</td>
                    <td>{{ $jobdesk->waktu_selesai }}</td>
                    <td><span class="badge bg-success">Selesai</span></td>
                    <td>
    @if(Str::startsWith($jobdesk->hasil, ['http://', 'https://']))
        <a href="{{ $jobdesk->hasil }}" target="_blank" class="btn btn-sm btn-success">Lihat</a>
    @else
        {{ $jobdesk->hasil }}
    @endif
</td>
<td>
                <a href="{{ route('jobdesk.editbukti', $jobdesk->id) }}" class="btn btn-sm btn-warning">
                    Edit
                </a>
                <a href="{{ route('jobdesk.detailpimpinan', $jobdesk->id) }}" class="btn btn-info btn-sm">Detail</a>
            </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-3">
    {{ $jobdesks->withQueryString()->links('pagination::bootstrap-4') }} <!-- Ini untuk menampilkan navigasi paginasi -->
                    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</div>
@endsection
