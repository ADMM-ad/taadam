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
    Halaman ini digunakan untuk mengelola hasil yang didapatkan oleh team dan berupa views.
    </div>
</div>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('hasil.index') }}" class="mb-2">
        <div class="row">
            <!-- Filter Tahun -->
            <div class="col-md-5 mt-2">
               
                <select name="tahun" class="form-control">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunOptions as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Nama Team -->
            <div class="col-md-5 mt-2">
               
                <select name="nama_team" class="form-control">
                    <option value="">Semua Team</option>
                    @foreach($teamOptions as $team)
                        <option value="{{ $team->nama_team }}" {{ request('nama_team') == $team->nama_team ? 'selected' : '' }}>
                            {{ $team->nama_team }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Submit -->
            <div class="col-md-2 d-flex justify-content-end align-items-end mt-2 gap-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('hasil.index') }}" class="btn btn-secondary ml-2">Reset</a>
            </div>
        </div>
    </form>

    <a href="{{ route('hasil.create') }}" class="btn btn-success mb-2 ">Tambah Data</a>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line mr-1" style="color: #31beb4"></i>Daftar Hasil</h3>
                </div>

                <div class="card-body table-responsive p-0">
  
                <table class="table table-hover table-bordered text-nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Team</th>
                <th>Bulan</th>
                <th>Views</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobdeskHasils as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->team->nama_team }}</td>
                <td>{{ \Carbon\Carbon::parse($data->bulan)->translatedFormat('F Y') }}</td>
                <td>{{ $data->views }}</td>
                <td>
                    <a href="{{ route('hasil.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('hasil.destroy', $data->id) }}')">Hapus</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-3">
                        {{ $jobdeskHasils->withQueryString()->links('pagination::bootstrap-4') }}
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
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
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
        form.action = action; // Set action form untuk delete data yang sesuai
        $('#confirmDeleteModal').modal('show'); // Menampilkan modal konfirmasi
    }
</script>

@endsection
