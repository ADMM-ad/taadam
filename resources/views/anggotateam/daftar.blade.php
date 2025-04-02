@extends('masterlayout')

@section('content')
<div class="container mt-5">
    <h1>Daftar Anggota Tim: {{ $team->nama_team }}</h1>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Anggota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($team->detailTeams as $detail)
            <tr>
                <td>{{ $detail->id }}</td>
                <td>{{ $detail->user->name }}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('anggotateam.destroy', $detail->id) }}')">Hapus</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('anggotateam.index') }}" class="btn btn-secondary">Kembali</a>
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
                Apakah Anda yakin ingin menghapus anggota ini?
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
        form.action = action; // Mengatur action form untuk penghapusan data
        $('#confirmDeleteModal').modal('show'); // Menampilkan modal konfirmasi
    }
</script>
@endsection
