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
    <h2>Jobdesk yang Selesai</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pekerjaan</th>
                <th>Deskripsi</th>
                <th>Tenggat Waktu</th>
                <th>Waktu Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobdesks as $jobdesk)
                <tr>
                    <td>{{ $jobdesk->nama_pekerjaan }}</td>
                    <td>{{ $jobdesk->deskripsi }}</td>
                    <td>{{ $jobdesk->tenggat_waktu }}</td>
                    <td>{{ $jobdesk->waktu_selesai }}</td>
                    <td><span class="badge bg-success">Selesai</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
