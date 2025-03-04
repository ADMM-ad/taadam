@extends('masterlayout')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
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

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Form Perizinan</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('absensi.perizinan') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="kehadiran">Keterangan</label>
                    <select class="form-control" id="kehadiran" name="kehadiran" required>
                        <option value="">-- Pilih Keterangan --</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bukti">Upload Bukti</label>
                    <input type="file" class="form-control-file" id="bukti" name="bukti" accept=".pdf,.jpg,.png" required>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </section>
</div>
@endsection
