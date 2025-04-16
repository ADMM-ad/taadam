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
    Halaman ini digunakan untuk mengelola pengguna berdasarkan jabatan atau role teamleader. Anda dapat mengaktifkan atau menonaktifkan akun mereka sesuai kebutuhan dan dapat menurunkan jabatan atau role. Harap berhati-hati saat menghapus akun, karena tindakan ini akan menghapus seluruh data pengguna, termasuk data absensi dan jobdesk yang terkait.
    </div>
</div>
<div class="row">
    <!-- Filter Search -->
    <div class="col-md-6 mb-2">
        <form method="GET" action="{{ route('users.indexteamleader') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Silahkan cari nama teamleader." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" style="background-color: #26948E; border-color: #26948E;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Filter Status -->
    <div class="col-md-6 mb-2">
        <form method="GET" action="{{ route('users.indexteamleader') }}">
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidakaktif" {{ request('status') == 'tidakaktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </form>
    </div>
</div>


    <!-- Card Daftar Teamleader -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-tie mr-1" style="color: #31beb4;"></i>Daftar Teamleader</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>No HP</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->no_hp }}</td>
                                    <td>
                                        <span class="badge {{ $user->status == 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td>
                                    @if($user->status == 'aktif')
                                            <button type="button" class="btn btn-warning btn-sm" onclick="confirmStatusChange('{{ route('users.changeStatustl', $user->id) }}')">
                                                Deactivate
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-success btn-sm" onclick="confirmStatusChange('{{ route('users.changeStatustl', $user->id) }}')">
                                                Activate
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('users.destroytl', $user->id) }}')">
                                            Hapus
                                        </button>
                                        <button 
    type="button" 
    class="btn btn-primary btn-sm" 
    onclick="confirmDemote(this)" 
    data-url="{{ route('users.demote', $user->id) }}">
    Demote
</button>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3">
        {{ $users->appends(['search' => request('search'), 'status' => request('status')])->links('pagination::bootstrap-4') }}
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
                Apakah Anda yakin ingin menghapus teamleader ini?
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

<!-- Modal Konfirmasi Perubahan Status -->
<div class="modal fade" id="confirmStatusChangeModal" tabindex="-1" aria-labelledby="confirmStatusChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmStatusChangeModalLabel">Konfirmasi Perubahan Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin mengubah status teamleader ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <form id="statusChangeForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary">Ya, Ubah Status</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Konfirmasi Demote -->
<div class="modal fade" id="demoteModal" tabindex="-1" role="dialog" aria-labelledby="demoteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="demoteForm" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="demoteModalLabel">Konfirmasi Penurunan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menurunkan user ini menjadi <strong>Karyawan</strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-primary">Ya, Turunkan</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
    function confirmDelete(action) {
        var form = document.getElementById('deleteForm');
        form.action = action;
        $('#confirmDeleteModal').modal('show');
    }

    function confirmStatusChange(action) {
        var form = document.getElementById('statusChangeForm');
        form.action = action;
        $('#confirmStatusChangeModal').modal('show');
    }
    function confirmDemote(button) {
        const form = document.getElementById('demoteForm');
        form.action = button.getAttribute('data-url');
        $('#demoteModal').modal('show');
    }
</script>

@endsection
