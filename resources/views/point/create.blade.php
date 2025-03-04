@extends('masterlayout')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Tambah Point KPI untuk {{ $user->name }}</h2>

    <form action="{{ route('point.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div class="mb-3">
            <label for="bulan" class="form-label">Pilih Bulan</label>
            <input type="month" id="bulan" name="bulan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="absensi" class="form-label">Jumlah Absensi Hadir</label>
            <input type="number" id="absensi" name="absensi" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label for="jobdesk_selesai" class="form-label">Jumlah Jobdesk Selesai</label>
            <input type="number" id="jobdesk_selesai" name="jobdesk_selesai" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label for="views" class="form-label">Jumlah Views</label>
            <input type="number" id="views" name="views" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-success">Simpan Point</button>
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
            document.getElementById('jobdesk_selesai').value = data.jobdesk_selesai;
            document.getElementById('views').value = data.views;
        })
        .catch(error => console.error('Error:', error));
});
</script>
@endsection
