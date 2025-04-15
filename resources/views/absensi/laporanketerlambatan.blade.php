@extends('masterlayout')

@section('content')
<div class="container mt-3">
    <!-- Filter Form Outside the Card -->
    <div class="row mb-2">
        <div class="col-12">
            <form method="GET" action="{{ route('absensi.keterlambatan') }}" class="d-flex flex-wrap align-items-center">
                <!-- Filter Date -->
                <div class="form-group mb-2 me-4 mr-2" style="min-width: 200px;">
                    <input type="month" name="date" id="date" class="form-control" value="{{ $tahun . '-' . $bulan }}">
                </div>

                <!-- Filter Button -->
                <div class="form-group mb-2 me-4 mr-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>

                <!-- Reset Button -->
                <div class="form-group mb-2">
                    <a href="{{ route('absensi.keterlambatan') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Card for the Report -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-clock mr-1" style="color: #31beb4;"></i>
                Laporan Keterlambatan Bulan {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
                    
                   

                    <table class="table table-hover table-bordered text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Total Keterlambatan (Jam:Menit:Detik)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($result as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['total_keterlambatan'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data keterlambatan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
   
</div>
@endsection
