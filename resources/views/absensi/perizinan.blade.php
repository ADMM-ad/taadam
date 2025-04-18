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

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle mr-2"></i>  <!-- Ikon untuk error -->
        {{ session('error') }}
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
    <div class="card-body" style="background-color: #ffffff">
    Halaman ini digunakan untuk mengajukan permohonan perizinan. Pastikan Anda memilih alasan yang sesuai untuk pengajuan perizinan Anda. Pengisian alasan wajib dilakukan, sementara pengunggahan bukti yang dapat berupa file PDF, JPG, atau PNG dengan ukuran maksimal 1MB, serta pengisian pesan, bersifat opsional dan hanya sebagai pendukung pengajuan perizinan.
    </div>
</div>
 
            <div class="card card-primary  mt-2" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title"><i class="fas fa-file-signature mr-1"></i>Formulir Perizinan</h3>
                </div>
                <div class="card-body">
    
            <form method="POST" action="{{ route('absensi.perizinan') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="tanggal"><i class="fas fa-calendar-alt mr-1" style="color: #31beb4;"></i>Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $tanggal }}" required readonly>
                </div>
                <div class="form-group">
                    <label for="kehadiran"><i class="fas fa-question-circle mr-1" style="color: #31beb4;"></i>Alasan</label>
                    <select class="form-control" id="kehadiran" name="kehadiran" required>
                        <option value="">-- Pilih Alasan --</option>
                        <option value="sakit" {{ isset($absensi) && $absensi->kehadiran == 'sakit' ? 'selected' : '' }}>Sakit</option>
            <option value="izin" {{ isset($absensi) && $absensi->kehadiran == 'izin' ? 'selected' : '' }}>Izin</option>
            <option value="datang" {{ isset($absensi) && $absensi->kehadiran == 'datang' ? 'selected' : '' }}>Lupa Absen Datang</option>
            <option value="hadir" {{ isset($absensi) && $absensi->kehadiran == 'hadir' ? 'selected' : '' }}>Lupa Absen Pulang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bukti"><i class="fas fa-file-alt mr-1" style="color: #31beb4;"></i>Upload Bukti</label>
                    <input type="file" class="form-control-file" id="bukti" name="bukti" accept=".pdf,.jpg,.png" >
                    @if(isset($absensi) && $absensi->bukti)
        <div class="mt-2">
            <a href="{{ asset('/' . $absensi->bukti) }}" target="_blank" class="btn btn-primary btn-sm">
                Lihat Bukti
            </a>
        </div>
    @endif
                </div>
                <div class="form-group">
                <label for="pesan"><i class="fas fa-comment-dots mr-1" style="color: #31beb4;"></i>Pesan</label>
                <textarea class="form-control" id="pesan" name="pesan" rows="3" placeholder="Tambahkan pesan jika diperlukan...">{{ isset($absensi) ? $absensi->pesan : '' }}</textarea>
            </div>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-success mr-2">Kirim</button>
                    <a href="{{ route('absensi.indexpengguna') }}" class="btn btn-secondary">Cek Absensi</a>
                    
                </div>

            </form>
            </div>
            </div>
</div>
@endsection
