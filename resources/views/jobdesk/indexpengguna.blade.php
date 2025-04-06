@extends('masterlayout')

@section('content')
<div class="container mt-2">
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
    <div class="card card-warning collapsed-card mt-2">
    <div class="card-header">
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
    <div class="card-body">
        The body of the card
    </div>
</div>
<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Jobdesk Anda</h3>
                </div>

                <div class="card-body table-responsive p-0">
  
                <table class="table table-hover table-bordered text-nowrap">
        <thead>
            <tr>
                <th>Nama Pekerjaan</th>
                <th>Deskripsi</th>
                <th>Tenggat Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobdesks as $jobdesk)
                <tr>
                    <td>{{ $jobdesk->nama_pekerjaan }}</td>
                    <td>{{ $jobdesk->deskripsi }}</td>
                    <td>{{ $jobdesk->tenggat_waktu }}</td>
                    <td><span class="badge badge-danger">Ditugaskan</span></td>
                    <td>
                        @if($jobdesk->status == 'ditugaskan')
                            <a href="{{ route('jobdesk.editpengguna', $jobdesk->id) }}" class="btn btn-warning">Selesaikan</a>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
    {{ $jobdesks->links('pagination::bootstrap-4') }} 
                    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</div>
@endsection
