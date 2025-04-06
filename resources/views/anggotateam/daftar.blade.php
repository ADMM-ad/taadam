@extends('masterlayout')

@section('content')
<div class="container mt-3">
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
<!-- Form Search -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Team {{ $team->nama_team }}</h3>
                </div>

                <div class="card-body table-responsive p-0">
  
                <table class="table table-hover table-bordered text-nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($team->detailTeams as $detail)
            <tr>
            <td>{{ $loop->iteration }}</td>
                <td>{{ $detail->user->name }}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('anggotateam.destroy', $detail->id) }}')">Keluarkan</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
</div>
    <a href="{{ route('anggotateam.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin mengeluarkan anggota ini dari team?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Keluarkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(action) {
        var form = document.getElementById('deleteForm');
        form.action = action; // Mengatur action form untuk penghapusan data
        $('#confirmDeleteModal').modal('show'); // Menampilkan modal konfirmasi
    }
</script>
@endsection
