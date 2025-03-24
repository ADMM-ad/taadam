@extends('masterlayout')

@section('content')
<div class="container mt-5">

    <h1>Data KPI Saya</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Absensi</th>
                <th>Jobdesk</th>
                <th>Hasil</th>
                <th>Attitude</th>
                <th>Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @foreach($points as $point)
            <tr>
                <td>{{ \Carbon\Carbon::parse($point->bulan)->format('F Y') }}</td>
                <td>{{ $point->point_absensi }} / 6.25</td>
                <td>{{ $point->point_jobdesk }} / 9</td>
                <td>{{ $point->point_hasil }} / 6.25</td>
                <td>{{ $point->point_attitude }} / 4</td>
                <td>{{ $point->point_rata_rata }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
