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
    Halaman ini digunakan untuk mengatur jaringan mana saja yang bisa melakukan absensi, Anda bisa menambahkan jaringannya dengan rentang IP pada jaringan Anda.
    </div>
</div>
<a href="{{ route('jaringan.create') }}" class="btn btn-success mb-2">Tambah Jaringan</a>
<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-network-wired  mr-1" style="color: #31beb4"></i>Jaringan Absensi</h3>
                </div>

                <div class="card-body table-responsive p-0">
  
                <table class="table table-hover table-bordered text-nowrap">
        <thead>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jaringan</th>
                    <th>IP Start</th>
                    <th>IP End</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jaringan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_jaringan }}</td>
                        <td>{{ $item->allowedRangeStart }}</td>
                        <td>{{ $item->allowedRangeEnd }}</td>
                        <td>
                            <a href="{{ route('jaringan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('jaringan.destroy', $item->id) }}')">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus jaringan ini?
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

<!-- Script untuk Modal -->
<script>
    function confirmDelete(action) {
        const form = document.getElementById('deleteForm');
        form.action = action;
        $('#confirmDeleteModal').modal('show');
    }
</script>

@endsection
