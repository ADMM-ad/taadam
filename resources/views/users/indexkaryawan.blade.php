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
    Halaman ini digunakan untuk mengelola pengguna berdasarkan jabatan atau role karyawan. Anda dapat mengaktifkan atau menonaktifkan akun mereka sesuai kebutuhan dan dapat mempromosikan jabatan atau role. Harap berhati-hati saat menghapus akun, karena tindakan ini akan menghapus seluruh data pengguna, termasuk data absensi dan jobdesk yang terkait.
    </div>
</div>
<!-- Form Search & Filter -->
<div class="row ">
    <!-- Filter Search -->
    <div class="col-md-6 mb-2">
        <form method="GET" action="{{ route('users.indexkaryawan') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Silahkan cari nama karyawan." value="{{ request('search') }}">
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
        <form method="GET" action="{{ route('users.indexkaryawan') }}">
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidakaktif" {{ request('status') == 'tidakaktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </form>
    </div>
</div>


    <!-- Card Daftar Karyawan -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-friends mr-1" style="color: #31beb4;"></i>Daftar Karyawan</h3>
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
                                            <button type="button" class="btn btn-warning btn-sm" onclick="confirmStatusChange('{{ route('users.changeStatus', $user->id) }}')">
                                                Deactivate
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-success btn-sm" onclick="confirmStatusChange('{{ route('users.changeStatus', $user->id) }}')">
                                                Aktivate
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('users.destroy', $user->id) }}')">
                                            Hapus
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="confirmPromote({{ $user->id }})">
                                        Promote
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
                Apakah Anda yakin ingin menghapus karyawan ini?
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

<!-- Modal Konfirmasi Status -->
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
                Apakah Anda yakin ingin mengubah status karyawan ini?
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

<!-- Modal Konfirmasi Promosikan -->
<div class="modal fade" id="promoteModal" tabindex="-1" role="dialog" aria-labelledby="promoteModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <form id="promoteForm" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="promoteModalLabel">Konfirmasi Promosi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin mempromosikan user ini menjadi <strong>Team Leader</strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-primary">Ya, Promosikan</button>
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
    function confirmPromote(userId) {
        const form = document.getElementById('promoteForm');
        form.action = '/users/' + userId + '/promote'; // atau gunakan route jika ingin lebih fleksibel
        $('#promoteModal').modal('show');
    }
</script>

@endsection
