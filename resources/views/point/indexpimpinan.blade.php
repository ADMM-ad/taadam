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
    <div class="card-header" style="background-color: #31beb4;" >
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
    Halaman ini digunakan untuk mengelola dan menampilkan point Key Performance Indicator (KPI) karyawan yang telah dihitung berdasarkan bobot dari empat aspek penilaian bulanan, yaitu kehadiran, penyelesaian jobdesk, hasil kerja atau jumlah views, dan sikap atau attitude.
    </div>
</div>
<!-- Form Filter -->
<form method="GET" action="{{ route('point.indexpimpinan') }}" class="mb-2">
    <div class="row">
        <!-- Filter Nama Pengguna -->
        <div class="col-md-5 mt-2">
            <select name="user_id" class="form-control">
                <option value="">Semua Pengguna</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filter Bulan -->
        <div class="col-md-5 mt-2">
        <label for="bulan" class="form-label d-md-none">Filter berdasarkan bulan.</label>
            <input type="month" name="date" class="form-control" value="{{ request('date') }}">
        </div>

        <!-- Tombol Submit dan Reset -->
        <div class="col-md-2 d-flex justify-content-end align-items-end mt-2  gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('point.indexpimpinan') }}" class="btn btn-secondary ml-2">Reset</a>
        </div>
    </div>
</form>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-star mr-1" style="color: #31beb4;"></i>Laporan Point Kinerja</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    
                   

                    <table class="table table-hover table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pengguna</th>
                                <th>Bulan</th>
                                <th>Absensi</th>
                                <th>Jobdesk</th>
                                <th>Hasil</th>
                                <th>Attitude</th>
                                <th>Rata-rata</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($points as $point)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $point->user->name ?? 'Tidak Diketahui' }}</td>
                                <td>{{ \Carbon\Carbon::parse($point->bulan)->format('F Y') }}</td>
                                <td>{{ $point->point_absensi }} / 6.25</td>
                                <td>{{ $point->point_jobdesk }} / 9</td>
                                <td>{{ $point->point_hasil }} / 6.25</td>
                                <td>{{ $point->point_attitude }} / 4</td>
                                <td>{{ $point->point_rata_rata }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('point.destroy', $point->id) }}')">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-3">
        {{ $points->links('pagination::bootstrap-4') }}
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
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

<!-- Script Modal -->
<script>
    function confirmDelete(action) {
        var form = document.getElementById('deleteForm');
        form.action = action;
        $('#confirmDeleteModal').modal('show');
    }
</script>

@endsection
