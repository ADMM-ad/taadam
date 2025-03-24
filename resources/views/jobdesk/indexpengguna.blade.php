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
    <h2>Daftar Jobdesk Anda</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pekerjaan</th>
                <th>Deskripsi</th>
                <th>Tenggat Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobdesks as $jobdesk)
                <tr>
                    <td>{{ $jobdesk->nama_pekerjaan }}</td>
                    <td>{{ $jobdesk->deskripsi }}</td>
                    <td>{{ $jobdesk->tenggat_waktu }}</td>
                    <td>{{ ucfirst($jobdesk->status) }}</td>
                    <td>
                        @if($jobdesk->status == 'ditugaskan')
                            <a href="{{ route('jobdesk.editpengguna', $jobdesk->id) }}" class="btn btn-primary">Edit</a>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
