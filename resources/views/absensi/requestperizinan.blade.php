@extends('masterlayout')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Permintaan Perizinan</h2>
    
    <div class="row">
        @foreach($perizinan as $izin)
        <div class="col-md-4 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">{{ $izin->user->name }}</h5>
                    <p class="card-text">
                        <strong>Tanggal:</strong> {{ $izin->tanggal }}<br>
                        <strong>Keterangan:</strong> {{ ucfirst($izin->kehadiran) }}
                    </p>
                    <div class="d-flex justify-content-between">
                        <form action="{{ route('perizinan.update', ['id' => $izin->id, 'status' => 'disetujui']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Terima</button>
                        </form>
                        <form action="{{ route('perizinan.update', ['id' => $izin->id, 'status' => 'ditolak']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
