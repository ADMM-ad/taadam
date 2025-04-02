@extends('masterlayout')

@section('content')
<div class="container">
    <h2>Edit Jobdesk</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jobdesk.updatepimpinan', $jobdesk->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Tim</label>
            <input type="text" class="form-control" value="{{ $jobdesk->team->nama_team }}" disabled>
        </div>

        <div class="mb-3">
            <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
            <input type="text" name="nama_pekerjaan" class="form-control" value="{{ $jobdesk->nama_pekerjaan }}">
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $jobdesk->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tenggat_waktu" class="form-label">Tenggat Waktu</label>
            <input type="date" name="tenggat_waktu" class="form-control" value="{{ $jobdesk->tenggat_waktu }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="ditugaskan" {{ $jobdesk->status == 'ditugaskan' ? 'selected' : '' }}>Ditugaskan</option>
                <option value="selesai" {{ $jobdesk->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="javascript:history.back()" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Kembali
</a>

    </form>
    <div class="mt-4">
        <h5>Pengguna dalam Jobdesk Ini:</h5>
        <ul class="list-group">
            @forelse($jobdesk->users as $user)
                <li class="list-group-item">{{ $user->name }}</li>
            @empty
                <li class="list-group-item text-muted">Belum ada pengguna yang ditugaskan.</li>
            @endforelse
        </ul>
    </div>
    <a href="{{ route('jobdesk.editkelolajob', $jobdesk->id) }}" class="btn btn-secondary mt-3">Kelola Pengguna</a>
</div>
@endsection
