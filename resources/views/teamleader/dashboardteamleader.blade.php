@extends('masterlayout')

@section('content')

<div class="container-fluid mt-2">
    <div class="row">
        <!-- User Aktif -->
        
        <!-- Teamleader Aktif -->
        <div class="col-12 col-md-3">
            <div class="info-box mb-2">
                <span class="info-box-icon bg-dark elevation-1"><i class="bi bi-person-gear"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Teamleader</span>
                    <span class="info-box-number">{{ $jumlahTeamleaderAktif }}</span>
                </div>
            </div>
        </div>

        <!-- Karyawan Aktif -->
        <div class="col-12 col-md-3">
            <div class="info-box mb-2">
                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Karyawan</span>
                    <span class="info-box-number">{{ $jumlahKaryawanAktif }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
    <div class="info-box">
        <span class="info-box-icon bg-info elevation-1">
            <i class="fas fa-user-check"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">Kehadiran Hari Ini</span>
            @if($absensiHariIni)
                <span class="info-box-number">
                    {{ ucfirst($absensiHariIni->kehadiran) }}
                </span>
            @else
                <span class="info-box-number">Belum Absen</span>
            @endif
        </div>
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="info-box">
        <span class="info-box-icon bg-warning elevation-1">
            <i class="fas fa-clock"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">Total Terlambat Bulan Ini</span>
            <span class="info-box-number">
                {{ $totalWaktuTerlambatBulanIni }} 
            </span>
        </div>
    </div>
</div>


    </div>


    <div class="row mt-2">
    <!-- Kotak 1: Absensi Hari Ini -->
    <div class="col-12 col-md-6">
    <div class="card card-primary card-outline"  style="border-color: #31beb4;">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-user-check" style="color: #31beb4;"></i>
                    Absensi Team Hari Ini
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm" style="background-color: #31beb4;" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-sm" style="background-color: #31beb4;" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-2">
    <div class="direct-chat-messages" style="height: 150px; overflow-y: auto;">
        @if ($absensiDisetujuiHariIni->isNotEmpty())
            <table class="table  table-bordered mb-0">
                <thead >
                    <tr>
                        <th>Nama</th>
                        <th>Kehadiran</th>
                        <th>Terlambat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absensiDisetujuiHariIni as $absen)
                        <tr>
                            <td>{{ $absen->user->name }}</td>
                            <td>{{ ucfirst($absen->kehadiran) }}</td>
                            <td>{{ ucfirst($absen->waktu_terlambat ?? '-') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada data absensi team hari ini.</p>
        @endif
    </div>
</div>

        </div>
    </div>

    <!-- Kotak 2: Perizinan Hari Ini -->
    <div class="col-12 col-md-6">
    <div class="card card-primary card-outline"  style="border-color: #31beb4;">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-user-clock" style="color: #31beb4;"></i>
                    Pengajuan Perizinan Team Hari Ini
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm" style="background-color: #31beb4;" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-sm" style="background-color: #31beb4;" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-2">
    <div class="direct-chat-messages" style="height: 150px; overflow-y: auto;">
        @if ($absensiDiprosesHariIni->isNotEmpty())
            <table class="table table-bordered mb-0">
                <thead >
                    <tr>
                        <th>Nama</th>
                        <th>Alasan</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absensiDiprosesHariIni as $absen)
                        <tr>
                            <td>{{ $absen->user->name }}</td>
                            <td>{{ $absen->kehadiran === 'datang' ? 'Lupa Absen' : ucfirst($absen->kehadiran ?? '') }}</td>
                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="mb-0">Tidak ada pengajuan perizinan team hari ini.</p>
        @endif
    </div>
</div>

        </div>
    </div>
</div> <!-- ROW ditutup di sini -->


<div class="row mt-2">
    <div class="col-12">
        <div class="card card-primary card-outline" style="border-color: #31beb4;">
            <div class="card-header border-0 d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="card-title mb-2 mb-md-0">
                    <i class="fas fa-chart-pie" style="color: #31beb4;"></i> Statistik Jobdesk Team
                </h3>
                <div class="card-tools ml-auto">
                    <button type="button" class="btn btn-sm" style="background-color: #31beb4;" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-sm" style="background-color: #31beb4;" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Filter Bulan & Tim -->
                <form method="GET" action="{{ route('dashboardteamleader') }}" class="row g-2 mb-4">
                    <div class="col-sm-5 mb-2">
                        <input type="month" name="bulan" id="filterBulan" class="form-control" value="{{ request('bulan') }}">
                    </div>
                    <div class="col-sm-5 mb-2">
                        <select name="team_id" id="filterTim" class="form-control">
                            @foreach($allowedTeams as $team)
                                <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>
                                    {{ $team->nama_team }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2 mb-2 d-flex align-items-end">
                        <button type="submit" class="btn w-100" style="background-color: #31beb4;">Tampilkan</button>
                    </div>
                </form>

                <!-- Grafik Pie - Hanya tampilkan jika ada request -->
                @if(request()->has('bulan') || request()->has('team_id'))
                <div class="flex-grow-1">
                    <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 100%; max-width: 100%;"></canvas>
                </div>
                @else
                <div class="text-center">
                    <p>Silahkan pilih bulan dan team terlebih dahulu.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="row mt-2">
    <div class="col-12">
    <div class="card card-primary card-outline" style="border-color: #31beb4;">
            <div class="card-header border-0 d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="card-title mb-2 mb-md-0">
                    <i class="fas fa-chart-pie" style="color: #31beb4;"></i> Persentase Kinerja Team
                </h3>
                <div class="card-tools ml-auto">
                    <button type="button" class="btn btn-sm" style="background-color: #31beb4;" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-sm" style="background-color: #31beb4;" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                {{-- Filter Form --}}
                <form method="GET" action="{{ route('dashboardteamleader') }}" class="row g-2 mb-4">
                    <div class="col-sm-5 mb-2">
                        <select name="user_id" class="form-control">
                            <option value="">Silahkan pilih nama karyawan.</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-5 mb-2">
                        <input type="month" name="bulan_kinerja" class="form-control" value="{{ request('bulan_kinerja') }}">
                    </div>
                    <div class="col-sm-2 mb-2">
                        <button type="submit" class="btn w-100" style="background-color: #31beb4;">Tampilkan</button>
                    </div>
                </form>

                {{-- KPI Knobs --}}
                @if($pointKpi)
                    <div class="row">
                        <div class="col-6 col-md-3 text-center">
                            <input type="text" class="knob" value="{{ ($pointKpi->point_absensi / 6.25) * 25 }}" data-width="90" data-height="90" data-fgColor="#000080" data-readonly="true">
                            <div class="knob-label">Absensi</div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <input type="text" class="knob" value="{{ ($pointKpi->point_jobdesk / 9) * 30 }}" data-width="90" data-height="90" data-fgColor="#00a65a" data-readonly="true">
                            <div class="knob-label">Jobdesk</div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <input type="text" class="knob" value="{{ ($pointKpi->point_hasil / 6.25) * 25 }}" data-width="90" data-height="90" data-fgColor="#B8860B" data-readonly="true">
                            <div class="knob-label">Hasil</div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <input type="text" class="knob" value="{{ ($pointKpi->point_attitude / 4) * 20 }}" data-width="90" data-height="90" data-fgColor="#00c0ef" data-readonly="true">
                            <div class="knob-label">Attitude</div>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <p>Silahkan pilih nama dan bulan terlebih dahulu.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>





</div>

@push('scriptsdua')
@if(request()->has('bulan') || request()->has('team_id'))
<script>
    const donutChart = document.getElementById('donutChart').getContext('2d');

    new Chart(donutChart, {
        type: 'doughnut',
        data: {
            labels: ['Dikerjakan', 'Selesai'],
            datasets: [{
                data: [{{ $jobdeskDitugaskan }}, {{ $jobdeskSelesai }}],
                backgroundColor: ['#f39c12', '#00a65a'],
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endif
<script>
    $(function () {
        $(".knob").knob();
    });
</script>
@endpush


@endsection
