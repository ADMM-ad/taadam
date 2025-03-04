@extends('masterlayout')

@section('content')
<div class="container mt-5">
    <h1>Daftar Jobdesk Hasil</h1>

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

    <!-- Form Filter -->
    <form method="GET" action="{{ route('hasil.index') }}" class="mb-3">
        <div class="row">
            <!-- Filter Tahun -->
            <div class="col-md-4">
                <label for="tahun">Filter Tahun:</label>
                <select name="tahun" class="form-control">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunOptions as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Nama Team -->
            <div class="col-md-4">
                <label for="nama_team">Filter Nama Team:</label>
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
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('hasil.index') }}" class="btn btn-secondary ml-2">Reset</a>
            </div>
        </div>
    </form>

    <a href="{{ route('hasil.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

    <table class="table table-bordered">
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
                <td>{{ $data->bulan }}</td>
                <td>{{ $data->views }}</td>
                <td>
                    <a href="{{ route('hasil.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('hasil.destroy', $data->id) }}')">Hapus</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
