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
    <div class="card-header">
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
    <div class="card-body">
    Halaman ini digunakan untuk mengelola permintaan perizinan dari karyawan. Anda dapat meninjau setiap permintaan yang masuk, menerima permintaan dengan menekan tombol centang berwarna hijau, atau menolak permintaan dengan tombol silang berwarna merah. Untuk melihat detail permintaan perizinan, silakan klik tombol berwarna biru.
    </div>
</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clipboard-check mr-1" style="color: #31beb4;"></i>Permintaan Perizinan</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>Nama Pengguna</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perizinan as $izin)
                            <tr>
                                <td>{{ $izin->user->name }}</td>
                                <td>{{ $izin->tanggal }}</td>
                                <td>
    @if(in_array($izin->kehadiran, ['datang', 'pulang']))
        Lupa Absen {{ ucfirst($izin->kehadiran) }}
    @else
        {{ ucfirst($izin->kehadiran) }}
    @endif
</td>

                                <td>
                                    <div class="d-flex">
                                        <!-- Terima (centang icon) -->
                                        <form action="{{ route('perizinan.update', ['id' => $izin->id, 'status' => 'disetujui']) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm mx-1">
                                                <i class="fas fa-check"></i> <!-- Ikon centang -->
                                            </button>
                                        </form>

                                        <!-- Tolak (X icon) -->
                                        <form action="{{ route('perizinan.update', ['id' => $izin->id, 'status' => 'ditolak']) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm mx-1">
                                                <i class="fas fa-times"></i> <!-- Ikon X -->
                                            </button>
                                        </form>

                                        <!-- Detail (icon untuk detail) -->
                                        <a href="{{ route('absensi.detailperizinan', ['id' => $izin->id]) }}" class="btn btn-info btn-sm mx-1">
                                            <i class="fas fa-info-circle"></i> <!-- Ikon info untuk detail -->
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                   
                </div> <!-- Penutupan card-body -->
            </div> <!-- Penutupan card -->
        </div> <!-- Penutupan col-12 -->
    </div> <!-- Penutupan row -->
    <div class="d-flex justify-content-end mt-3">
                    {{ $perizinan->links('pagination::bootstrap-4') }} <!-- Ini untuk menampilkan navigasi paginasi -->
                    </div>
</div> <!-- Penutupan container -->
@endsection
