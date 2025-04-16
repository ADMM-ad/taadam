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
    Halaman ini digunakan untuk mengelola dan memantau seluruh jobdesk yang telah dibuat, baik individu maupun team.
Anda dapat melihat status pekerjaan, tenggat waktu, serta hasil jobdesk jika tersedia atau berupa link
dan gunakan tombol detail untuk melihat informasi lengkap, termasuk deskripsi pekerjaan dan pengguna yang terlibat dalam jobdesk tersebut.
    </div>
</div>


<!-- Form Search dan Filter -->
<div class="row mb-3">
    <div class="col-md-12">
        <form method="GET" action="{{ route('jobdesk.indexpimpinan') }}">
            <div class="input-group mb-2">
                <input type="text" name="search" class="form-control" placeholder="Silahkan mencari pekerjaan." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" style="background-color: #26948E; border-color: #26948E;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            
            <div class="row">
                <!-- Filter Team -->
                <div class="col-md-6 mt-2 ">
                    <select name="team_id" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->nama_team }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Filter Status -->
                <div class="col-md-6 mt-2 ">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="ditugaskan" {{ request('status') == 'ditugaskan' ? 'selected' : '' }}>Ditugaskan</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>


        <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-alt mr-1" style="color: #31beb4;"></i>Laporan Jobdesk</h3>
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
                    @if(Str::startsWith($jobdesk->hasil, ['http://', 'https://']))
        <a href="{{ $jobdesk->hasil }}" target="_blank" class="btn btn-sm btn-success">Lihat</a>
    @else
        {{ $jobdesk->hasil }}
    @endif
    <a href="{{ route('jobdesk.detailpimpinan', $jobdesk->id) }}" class="btn btn-info btn-sm">Detail</a>
    <a href="{{ route('jobdesk.editpimpinan', $jobdesk->id) }}" class="btn btn-warning btn-sm">Edit</a>
    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('jobdesk.delete', $jobdesk->id) }}')">Hapus</button>
</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    
    </div>
    </div>
    </div>
    </div>
    <div class="d-flex justify-content-end mt-3">
    {{ $jobdesks->appends(request()->query())->links('pagination::bootstrap-4') }} <!-- Ini untuk menampilkan navigasi paginasi -->
                    </div>
</div>
<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
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
