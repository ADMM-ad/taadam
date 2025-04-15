@extends('masterlayout')

@section('content')
<div class="container mt-2">
<div class="card card-primary" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title"><i class="fas fa-tasks mr-1"></i>Form Bukti Selesai</h3>
                </div>
                <div class="card-body">
    <form action="{{ route('jobdesk.updatepengguna', $jobdesk->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="hasil" class="form-label"><i class="fas fa-folder-open mr-1" style="color: #31beb4;"></i>Hasil Pekerjaan</label>
            <textarea class="form-control" id="hasil" name="hasil" rows="3" placeholder="Masukan bukti pekerjaan anda berupa link." required>{{ $jobdesk->hasil }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('jobdesk.indexpengguna') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
