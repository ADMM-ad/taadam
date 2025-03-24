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

    <h1>Status Absensi Saya</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kehadiran</th>
                <th>Pesan</th>
                <th>Bukti</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $item)
            <tr>
                <td>{{ $item->tanggal }}</td> {{-- Tanggal format default --}}
                <td>{{ $item->kehadiran }}</td>
                <td>{{ $item->pesan }}</td>
                <td>
                    @if($item->bukti)
                    <a href="{{ asset('files/' . basename($item->bukti)) }}" target="_blank">Lihat</a>
                    @else
                        Tidak ada bukti
                    @endif
                </td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
