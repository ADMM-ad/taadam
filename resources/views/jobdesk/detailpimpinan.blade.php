@extends('masterlayout')

@section('content')
<div class="container">
    <h2>Detail Jobdesk</h2>

    <table class="table table-bordered">
        <tr>
            <th>Nama Team</th>
            <td>{{ $jobdesk->team ? $jobdesk->team->nama_team : 'Individu' }}</td>
        </tr>
        <tr>
            <th>Nama Pekerjaan</th>
            <td>{{ $jobdesk->nama_pekerjaan }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>{{ $jobdesk->deskripsi }}</td>
        </tr>
        <tr>
            <th>Tenggat Waktu</th>
            <td>{{ $jobdesk->tenggat_waktu }}</td>
        </tr>
        <tr>
            <th>Nama Pengguna Yang terlibat</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
            </tr>
        @endforeach
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($jobdesk->status) }}</td>
        </tr>
    </table>

    <a href="{{ route('jobdesk.indexpimpinan') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
