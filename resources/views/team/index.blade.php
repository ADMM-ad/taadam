@extends('masterlayout')

@section('content')
<div class="container mt-5">
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

    <h1>Daftar Team</h1>
    <a href="{{ route('team.create') }}" class="btn btn-primary mb-3">Tambah Team</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Team</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teams as $team)
            <tr>
                <td>{{ $team->id }}</td>
                <td>{{ $team->nama_team }}</td>
                <td>
                    <a href="{{ route('team.edit', $team->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('team.destroy', $team->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
