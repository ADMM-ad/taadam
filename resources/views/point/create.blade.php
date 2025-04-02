@extends('masterlayout')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Tambah Point KPI untuk {{ $user->name }}</h2>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))  {{-- Tambahkan pengecekan session error --}}
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
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

    <form action="{{ route('point.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div class="mb-3">
            <label for="bulan" class="form-label">Pilih Bulan</label>
            <input type="month" id="bulan" name="bulan" class="form-control" required>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <th>Nilai</th>
                    <th>Bobot</th>
                    <th>Skor</th>
                    <th>Skor Akhir</th> <!-- Kolom baru -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Absensi Kehadiran</td>
                    <td><input type="number" name="absensi" id="absensi" class="form-control" required></td>
                    <td><span id="bobot_absensi">0</span></td>
                    <td><span id="skor_absensi">0</span></td>
                    <td><span id="skor_akhir_absensi">0</span></td>
                </tr>
                <tr>
                    <td>Jobdesk Selesai</td>
                    <td><input type="number" name="jobdesk" id="jobdesk" class="form-control" required></td>
                    <td><span id="bobot_jobdesk">0</span></td>
                    <td><span id="skor_jobdesk">0</span></td>
                    <td><span id="skor_akhir_jobdesk">0</span></td>
                </tr>
                <tr>
                    <td>Views</td>
                    <td><input type="number" name="views" id="views" class="form-control" required></td>
                    <td><span id="bobot_views">0</span></td>
                    <td><span id="skor_views">0</span></td>
                    <td><span id="skor_akhir_views">0</span></td>
                </tr>
                <tr>
                    <td>Attitude</td>
                    <td>
                        <select name="attitude" id="attitude" class="form-control" required>
                            <option value="kurang">Kurang</option>
                            <option value="lumayan">Lumayan</option>
                            <option value="baik">Baik</option>
                            <option value="sangat baik">Sangat Baik</option>
                        </select>
                    </td>
                    <td><span id="bobot_attitude">0</span></td>
                    <td><span id="skor_attitude">0</span></td>
                    <td><span id="skor_akhir_attitude">0</span></td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">Simpan Point</button>
        <a href="javascript:history.go(-2);" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Kembali 
</a>


        <input type="hidden" name="point_absensi" id="point_absensi">
<input type="hidden" name="point_jobdesk" id="point_jobdesk">
<input type="hidden" name="point_hasil" id="point_hasil">
<input type="hidden" name="point_attitude" id="point_attitude">
<input type="hidden" name="point_rata_rata" id="point_rata_rata">

    </form>
</div>

<script>
document.getElementById('bulan').addEventListener('change', function() {
    let bulan = this.value;
    let userId = "{{ $user->id }}";

    fetch(`/point/get-data?user_id=${userId}&bulan=${bulan}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('absensi').value = data.absensi;
            document.getElementById('jobdesk').value = data.jobdesk_selesai;
            document.getElementById('views').value = data.views;

            updateBobotAbsensi();
            updateBobotJobdesk();
            updateBobotViews();
            updateBobotAttitude();
        })
        .catch(error => console.error('Error:', error));
});

// Fungsi update bobot & skor
function updateBobotAbsensi() {
    let value = parseInt(document.getElementById('absensi').value) || 0;
    let bobot = value < 15 ? 10 : value <= 17 ? 40 : value <= 21 ? 80 : 100;
    document.getElementById('bobot_absensi').innerText = bobot;
    updateSkorAbsensi(bobot);
}

function updateBobotJobdesk() {
    let value = parseInt(document.getElementById('jobdesk').value) || 0;
    let bobot = value < 12 ? 10 : value <= 15 ? 40 : value <= 20 ? 80 : 100;
    document.getElementById('bobot_jobdesk').innerText = bobot;
    updateSkorJobdesk(bobot);
}

function updateBobotViews() {
    let value = parseInt(document.getElementById('views').value) || 0;
    let bobot = value < 100 ? 10 : value <= 500 ? 40 : value <= 1000 ? 80 : 100;
    document.getElementById('bobot_views').innerText = bobot;
    updateSkorViews(bobot);
}

function updateBobotAttitude() {
    let bobotMapping = {
        'kurang': 10,
        'lumayan': 40,
        'baik': 80,
        'sangat baik': 100
    };
    let attitude = document.getElementById('attitude').value;
    let bobot = bobotMapping[attitude] || 0;
    document.getElementById('bobot_attitude').innerText = bobot;
    updateSkorAttitude(bobot);
}

// Fungsi update Skor dan Skor Akhir dengan koma sebagai pemisah desimal
function updateSkorAbsensi(bobot) {
    let skor = (25 * bobot) / 100;
    document.getElementById('skor_absensi').innerText = skor.toLocaleString('id-ID', { minimumFractionDigits: 1 }) + '%';
    let skorAkhir = (skor * 25) / 100;
    document.getElementById('skor_akhir_absensi').innerText = skorAkhir.toLocaleString('id-ID', { minimumFractionDigits: 2 });
    document.getElementById('point_absensi').value = skorAkhir;
}

function updateSkorJobdesk(bobot) {
    let skor = (30 * bobot) / 100;
    document.getElementById('skor_jobdesk').innerText = skor.toLocaleString('id-ID', { minimumFractionDigits: 1 }) + '%';
    let skorAkhir = (skor * 30) / 100;
    document.getElementById('skor_akhir_jobdesk').innerText = skorAkhir.toLocaleString('id-ID', { minimumFractionDigits: 2 });
    document.getElementById('point_jobdesk').value = skorAkhir;
}

function updateSkorViews(bobot) {
    let skor = (25 * bobot) / 100;
    document.getElementById('skor_views').innerText = skor.toLocaleString('id-ID', { minimumFractionDigits: 1 }) + '%';
    let skorAkhir = (skor * 25) / 100;
    document.getElementById('skor_akhir_views').innerText = skorAkhir.toLocaleString('id-ID', { minimumFractionDigits: 2 });
    document.getElementById('point_hasil').value = skorAkhir;
}

function updateSkorAttitude(bobot) {
    let skor = (20 * bobot) / 100;
    document.getElementById('skor_attitude').innerText = skor.toLocaleString('id-ID', { minimumFractionDigits: 1 }) + '%';
    let skorAkhir = (skor * 20) / 100;
    document.getElementById('skor_akhir_attitude').innerText = skorAkhir.toLocaleString('id-ID', { minimumFractionDigits: 2 });
    document.getElementById('point_attitude').value = skorAkhir;
}
// Hitung rata-rata
function updateRataRata() {
    let absensi = parseFloat(document.getElementById('point_absensi').value) || 0;
    let jobdesk = parseFloat(document.getElementById('point_jobdesk').value) || 0;
    let hasil = parseFloat(document.getElementById('point_hasil').value) || 0;
    let attitude = parseFloat(document.getElementById('point_attitude').value) || 0;

    let rataRata = (absensi + jobdesk + hasil + attitude) / 4;
    document.getElementById('point_rata_rata').value = rataRata;
}
// Event Listener
document.getElementById('absensi').addEventListener('input', updateBobotAbsensi);
document.getElementById('jobdesk').addEventListener('input', updateBobotJobdesk);
document.getElementById('views').addEventListener('input', updateBobotViews);
document.getElementById('attitude').addEventListener('change', updateBobotAttitude);
document.querySelectorAll('input, select').forEach(element => {
    element.addEventListener('input', updateRataRata);
});
</script>
@endsection
