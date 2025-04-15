@extends('masterlayout')

@section('content')
    <div class="container mt-2">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-check-circle mr-2"></i>  <!-- Ikon untuk sukses -->
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i>  <!-- Ikon untuk error -->
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


        <div class="card card-primary  mt-2" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title"><i class="fas fa-calendar-day mr-1"></i>Formulir Absensi</h3>
                </div>
                <div class="card-body">
        <div >
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" class="form-control" id="latitude" disabled>
        </div>

        <div >
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" class="form-control" id="longitude" disabled>
        </div>

       
            <!-- Tombol disusun sejajar -->
            <div class="d-flex  mt-2">
            
                <form action="{{ route('absensi.datang') }}" method="POST" id="datang-form" style="margin-right: 10px; display: inline;" >
                    @csrf
                    <input type="hidden" id="latitude-datang" name="latitude">
                    <input type="hidden" id="longitude-datang" name="longitude">
                    <button type="submit" class="btn btn-primary ">Absensi Datang</button>
                </form>

                <form action="{{ route('absensi.pulang') }}" method="POST" id="pulang-form" style="margin-right: 10px;">
                    @csrf
                    <input type="hidden" id="latitude-pulang" name="latitude">
                    <input type="hidden" id="longitude-pulang" name="longitude">
                    <button type="submit" class="btn btn-danger ">Absensi Pulang</button>
                </form>
            </div>
            
        </div>
        </div>


        <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-check mr-1" style="color: #31beb4;"></i>Absensi Saya (7 Hari Terakhir)</h3>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered text-nowrap">
                    <thead class="bg-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Waktu Datang</th>
                            <th>Waktu Terlambat</th>
                            <th>Waktu Pulang</th>
                            <th>Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $item->waktu_datang ?? '-' }}</td>
                                <td>{{ $item->waktu_terlambat ?? '-' }}</td>
                                <td>{{ $item->waktu_pulang ?? '-' }}</td>
                                <td>{{ ucfirst($item->kehadiran) }}</td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;

                    document.getElementById('latitude-datang').value = position.coords.latitude;
                    document.getElementById('longitude-datang').value = position.coords.longitude;

                    document.getElementById('latitude-pulang').value = position.coords.latitude;
                    document.getElementById('longitude-pulang').value = position.coords.longitude;
                }, function (error) {
                    alert('Gagal mendapatkan lokasi. Pastikan GPS Anda aktif.');
                });
            } else {
                alert('Geolocation tidak didukung oleh browser Anda.');
            }
        });
    </script>
@endsection
