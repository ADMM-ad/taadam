@extends('masterlayout')

@section('content')
<style>
    

    /* Atur lebar tiap kolom */
    th:nth-child(2), td:nth-child(2) { /* Nilai */
        width: 150px;
        min-width: 150px;
    }

    th:nth-child(3), td:nth-child(3) { /* Bobot */
        width: 150px;
        min-width: 150px;
    }

    th:nth-child(4), td:nth-child(4) { /* Skor */
        width: 150px;
        min-width: 150px;
    }

    th:nth-child(5), td:nth-child(5) { /* Skor Akhir */
        width: 150px;
        min-width: 150px;
    }

    input.form-control {
        width: 100%;
        min-width: 100%;
    }

    select.form-control {
        width: 100%;
        min-width: 100%;
    }

    
</style>

<div class="container mt-2">
<div class="card card-warning collapsed-card mt-2">
    <div class="card-header">
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
    <div class="card-body">
        The body of the card
    </div>
</div>
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

        
        <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hitung Point KPI {{ $user->name }}</h3>
                </div>

                <div class="card-body table-responsive">
  
                <table class="table table-hover table-bordered text-nowrap">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <th >Nilai</th>
                    <th>Bobot</th>
                    <th>Skor</th>
                    <th>Skor Akhir</th> <!-- Kolom baru -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Absensi Kehadiran</td>
                    <td><input type="number" name="absensi" id="absensi" class="form-control" required readonly></td>
                    <td><input type="number" name="bobot_absensi" id="bobot_absensi" class="form-control" required></td>
                    <td><span id="skor_absensi">0</span></td>
                    <td><span id="skor_akhir_absensi">0</span></td>
                </tr>
                <tr>
                    <td>Jobdesk Selesai</td>
                    <td><input type="number" name="jobdesk" id="jobdesk" class="form-control" required readonly></td>
                    <td><input type="number" name="bobot_jobdesk" id="bobot_jobdesk" class="form-control" required></td>
                    <td><span id="skor_jobdesk">0</span></td>
                    <td><span id="skor_akhir_jobdesk">0</span></td>
                </tr>
                <tr>
                    <td>Views</td>
                    <td><input type="number" name="views" id="views" class="form-control" required readonly></td>
                    <td><input type="number" name="bobot_views" id="bobot_views" class="form-control" required></td>
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
</div>
</div>
</div>
</div>
        <button type="submit" class="btn btn-success">Simpan Point</button>
        <a href="{{ auth()->user()->role == 'pimpinan' ? route('point.index') : route('point.indexteam') }}" class="btn btn-secondary">
    Kembali
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
    let absensi = parseInt(document.getElementById('absensi').value) || 0;
    let bobotInput = document.getElementById('bobot_absensi');
    
    // Hanya hitung otomatis jika input masih kosong
    if (bobotInput.value === '') {
        let bobot = absensi < 15 ? 10 : absensi <= 17 ? 40 : absensi <= 21 ? 80 : 100;
        bobotInput.value = bobot;
        updateSkorAbsensi(bobot);
    } else {
        // Jika user sudah isi manual, ambil nilainya
        let bobotManual = parseInt(bobotInput.value) || 0;
        updateSkorAbsensi(bobotManual);
    }
}


function updateBobotJobdesk() {
    let jobdesk = parseInt(document.getElementById('jobdesk').value) || 0;
    let bobotInput = document.getElementById('bobot_jobdesk');

    if (bobotInput.value === '') {
        let bobot = jobdesk < 10 ? 10 : jobdesk <= 15 ? 40 : jobdesk <= 20 ? 80 : 100;
        bobotInput.value = bobot;
        updateSkorJobdesk(bobot);
    } else {
        let bobotManual = parseInt(bobotInput.value) || 0;
        updateSkorJobdesk(bobotManual);
    }
}

document.getElementById('bobot_jobdesk').addEventListener('input', function () {
    let bobotManual = parseInt(this.value) || 0;
    updateSkorJobdesk(bobotManual);
});


function updateBobotViews() {
    let views = parseInt(document.getElementById('views').value) || 0;
    let bobotInput = document.getElementById('bobot_views');

    if (bobotInput.value === '') {
        let bobot = views < 100 ? 10 : views <= 500 ? 40 : views <= 1000 ? 80 : 100;
        bobotInput.value = bobot;
        updateSkorViews(bobot);
    } else {
        let bobotManual = parseInt(bobotInput.value) || 0;
        updateSkorViews(bobotManual);
    }
}


document.getElementById('bobot_views').addEventListener('input', function () {
    let bobotManual = parseInt(this.value) || 0;
    updateSkorViews(bobotManual);
});

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
    let skor = (25 * bobot) / 100;
    document.getElementById('skor_jobdesk').innerText = skor.toLocaleString('id-ID', { minimumFractionDigits: 1 }) + '%';
    let skorAkhir = (skor * 25) / 100;
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
    let skor = (25 * bobot) / 100;
    document.getElementById('skor_attitude').innerText = skor.toLocaleString('id-ID', { minimumFractionDigits: 1 }) + '%';
    let skorAkhir = (skor * 25) / 100;
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


document.getElementById('bobot_absensi').addEventListener('input', function () {
    let bobotManual = parseInt(this.value) || 0;
    updateSkorAbsensi(bobotManual);
});
</script>
@endsection
