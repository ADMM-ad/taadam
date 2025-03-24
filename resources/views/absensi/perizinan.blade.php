@extends('masterlayout')

@section('content')
        <div class="container">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
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

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Form Perizinan</h1>
                </div>
            </div>
   

    
            <form method="POST" action="{{ route('absensi.perizinan') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $tanggal }}" required readonly>
                </div>
                <div class="form-group">
                    <label for="kehadiran">Keterangan</label>
                    <select class="form-control" id="kehadiran" name="kehadiran" required>
                        <option value="">-- Pilih Keterangan --</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                        <option value="datang">Lupa Absen Datang</option>
                        <option value="hadir">Lupa Absen Pulang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bukti">Upload Bukti</label>
                    <input type="file" class="form-control-file" id="bukti" name="bukti" accept=".pdf,.jpg,.png" >
                </div>
                <div class="form-group">
                <label for="pesan">Pesan (Opsional)</label>
                <textarea class="form-control" id="pesan" name="pesan" rows="3" placeholder="Tambahkan pesan jika diperlukan..."></textarea>
            </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('absensi.indexpengguna') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>

            </form>
     
   
</div>
@endsection
