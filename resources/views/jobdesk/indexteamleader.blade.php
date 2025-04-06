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
<!-- Form Search dan Filter -->
<!-- Form Search dan Filter -->
<div class="row mb-3">
    <div class="col-md-12">
        <form method="GET" action="{{ route('jobdesk.indexteamleader') }}">
            <div class="input-group mb-2">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama Pekerjaan..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" style="background-color: #26948E; border-color: #26948E;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mt-2">
                    <select name="team_id" class="form-control">
                        <option value="">Semua Team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->nama_team }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mt-2">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="ditugaskan" {{ request('status') == 'ditugaskan' ? 'selected' : '' }}>Ditugaskan</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-md-4 mt-2">
                    <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
                </div>

                
            </div>
            <div class="row mt-2">
<div class="col-md-12">
<a href="{{ route('jobdesk.createteamleader') }}" class="btn btn-success mr-2 ">Tambah</a>
                    <button type="submit" class="btn btn-primary mr-2 ">Filter</button>
                    <a href="{{ route('jobdesk.indexteamleader') }}" class="btn btn-secondary">Reset</a>
                    </div>
                    </div>
        </form>
    </div>
</div>


        <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Jobdesk Team</h3>
                </div>

                <div class="card-body table-responsive p-0">
  
                <table class="table table-hover table-bordered text-nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Team</th>
                <th>Nama Pekerjaan</th>
                <th>Tenggat Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobdesks as $index => $jobdesk)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $jobdesk->team ? $jobdesk->team->nama_team : 'Individu' }}</td>
                    <td>{{ $jobdesk->nama_pekerjaan }}</td>
                    <td>{{ $jobdesk->tenggat_waktu }}</td>
                    <td>
                        <span class="badge {{ $jobdesk->status == 'ditugaskan' ? 'badge-danger' : 'badge-success' }}">
                            {{ ucfirst($jobdesk->status) }}
                        </span>
                    </td>
                    <td>
    <a href="{{ route('jobdesk.detailpimpinan', $jobdesk->id) }}" class="btn btn-info btn-sm">Detail</a>
    <a href="{{ route('jobdesk.editpimpinan', $jobdesk->id) }}" class="btn btn-warning btn-sm">Edit</a>
    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('jobdesk.delete', $jobdesk->id) }}')">Delete</button>
</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
    {{ $jobdesks->withQueryString()->links('pagination::bootstrap-4') }}
                    </div>
    </div>
    </div>
    </div>
    </div>
</div>
<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pekerjaan ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(action) {
        var form = document.getElementById('deleteForm');
        form.action = action;
        $('#confirmDeleteModal').modal('show');
    }
</script>

@endsection
