@extends('masterlayout')

@section('content')
<div class="container mt-5">
    <h1>Daftar Anggota Tim</h1>

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
 <a href="{{ route('anggotateam.create') }}" class="btn btn-primary mb-3">Tambah Anggota Tim</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Team</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $detail)
            <tr>
                <td>{{ $detail->id }}</td>
                <td>{{ $detail->user->name }}</td>
                <td>{{ $detail->team->nama_team }}</td>
                <td>
                    <a href="{{ route('anggotateam.edit', $detail->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('anggotateam.destroy', $detail->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
