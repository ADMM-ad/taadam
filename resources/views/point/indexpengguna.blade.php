@extends('masterlayout')

@section('content')
<div class="container mt-3">
<div class="card card-warning collapsed-card mt-2">
    <div class="card-header" style="background-color: #31beb4;">
    <h3 class="card-title">
    <i class="bi bi-megaphone-fill"></i>
    Instructions
</h3>
        <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
    </div>
    <div class="card-body" style="background-color: #ffffff;">
    Halaman ini digunakan untuk menampilkan point Key Performance Indicator (KPI) Anda yang telah dihitung berdasarkan bobot dari empat aspek penilaian bulanan, yaitu kehadiran, penyelesaian jobdesk, hasil kerja atau jumlah views, dan sikap atau attitude, sehingga memberikan gambaran menyeluruh terhadap kinerja Anda.
    </div>
</div>    
<div class="row">
    <form method="GET" action="{{ route('point.indexpengguna') }}" class="d-flex">
        <div class="col-md-10 col-10 ">
            <select name="tahun" id="tahun" class="form-control">
                <option value="">Tampilkan Semua Tahun</option>
                @foreach($availableYears as $year)
                    <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 col-4   align-items-end">
            <button class="btn btn-primary w-100" type="submit">Filter</button>
        </div>
    </form>
</div>







    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-star mr-1" style="color: #31beb4;"></i>Laporan Point Kinerja Saya</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered text-nowrap">
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

                    <div class="d-flex justify-content-end mt-3">
                        {{ $points->withQueryString()->links('pagination::bootstrap-4') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
