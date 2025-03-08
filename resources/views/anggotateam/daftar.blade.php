@extends('masterlayout')

@section('content')
<div class="container mt-5">
    <h1>Daftar Anggota Tim: {{ $team->nama_team }}</h1>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Anggota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($team->detailTeams as $detail)
            <tr>
                <td>{{ $detail->id }}</td>
                <td>{{ $detail->user->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('anggotateam.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
