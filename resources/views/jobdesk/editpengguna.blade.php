@extends('masterlayout')

@section('content')
<div class="container">
    <h2>Edit Hasil Pekerjaan</h2>
    <form action="{{ route('jobdesk.updatepengguna', $jobdesk->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="hasil" class="form-label">Hasil Pekerjaan</label>
            <textarea class="form-control" id="hasil" name="hasil" rows="3" required>{{ $jobdesk->hasil }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('jobdesk.indexpengguna') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
