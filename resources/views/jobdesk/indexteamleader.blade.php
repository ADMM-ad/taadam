@extends('masterlayout')

@section('content')
<div class="container">
    <h2>Daftar Jobdesk</h2>

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
        <a href="{{ route('jobdesk.createteamleader') }}" class="btn btn-primary mb-3">Tambah Data</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Team</th>
                <th>Nama Pekerjaan</th>
                <th>Tenggat Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobdesks as $index => $jobdesk)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $jobdesk->team ? $jobdesk->team->nama_team : 'Individu' }}</td>
                    <td>{{ $jobdesk->nama_pekerjaan }}</td>
                    <td>{{ $jobdesk->tenggat_waktu }}</td>
                    <td>
                        <span class="badge {{ $jobdesk->status == 'ditugaskan' ? 'badge-danger' : 'badge-success' }}">
                            {{ ucfirst($jobdesk->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('jobdesk.detailpimpinan', $jobdesk->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('jobdesk.editpimpinan', $jobdesk->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('jobdesk.delete', $jobdesk->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
