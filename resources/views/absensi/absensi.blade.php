@extends('masterlayout')

@section('content')
    <div class="container mt-4 mb-5 px-2">
        <h1>Absensi</h1>

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

        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" class="form-control" id="latitude" disabled>
        </div>

        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" class="form-control" id="longitude" disabled>
        </div>

        <div class="d-flex gap-3">
            <form action="{{ route('absensi.datang') }}" method="POST" id="datang-form">
                @csrf
                <input type="hidden" id="latitude-datang" name="latitude">
                <input type="hidden" id="longitude-datang" name="longitude">
                <button type="submit" class="btn btn-primary">Absensi Datang</button>
            </form>

            <form action="{{ route('absensi.pulang') }}" method="POST" id="pulang-form">
                @csrf
                <input type="hidden" id="latitude-pulang" name="latitude">
                <input type="hidden" id="longitude-pulang" name="longitude">
                <button type="submit" class="btn btn-danger">Absensi Pulang</button>
            </form>
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
