@extends('masterlayout')

@section('content')
<div class="container mt-3">
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
<div class="card card-warning collapsed-card mt-3">
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
    Halaman ini digunakan untuk menambahkan jobdesk ke dalam team Anda. Anda dapat menentukan jobdesk yang akan dikerjakan oleh anggota team, baik secara individu maupun kelompok.

Untuk memulai, pastikan Anda memilih team terlebih dahulu agar dapat menampilkan daftar anggota yang akan melaksanakan tugas tersebut. Jika anggota yang Anda inginkan tidak muncul dalam daftar, itu berarti pengguna tersebut belum tergabung dalam team yang dipilih.
    </div>
</div>
<div class="card card-primary  mt-2" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title"><i class="fas fa fa-plus-circle mr-1"></i>Tambah Jobdesk Team </h3>
                </div>
                <div class="card-body">
    <form action="{{ route('jobdesk.store') }}" method="POST">
        @csrf

        <!-- Pilih Team -->
        <div class="mb-3">
            <label for="team_id" class="form-label"><i class="fas fa-users mr-1" style="color: #31beb4;"></i>Pilih Team</label>
            <select name="team_id" id="team_id" class="form-control" required>
                <option value="">-- Pilih Team --</option>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->nama_team }}</option>
                @endforeach
            </select>
        </div>

        <!-- Pilih Nama Pekerjaan -->
        <div class="mb-3">
            <label for="nama_pekerjaan" class="form-label"><i class="fas fa-clipboard-list mr-1" style="color: #31beb4;"></i>Nama Pekerjaan</label>
            <input type="text" name="nama_pekerjaan" class="form-control" placeholder="Masukan nama perkerjaan." required>
        </div>

        <!-- Pilih Deskripsi -->
        <div class="mb-3">
            <label for="deskripsi" class="form-label"><i class="fas fa-comment-dots mr-1" style="color: #31beb4;"></i>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" placeholder="Masukan deskripsi atau penjelasan perkerjaan."></textarea>
        </div>

        <!-- Pilih Tenggat Waktu -->
        <div class="mb-3">
            <label for="tenggat_waktu" class="form-label"><i class="fas fa-calendar-alt mr-1" style="color: #31beb4;"></i>Tenggat Waktu</label>
            <input type="date" name="tenggat_waktu" class="form-control">
        </div>

        <!-- Pilih User yang Mengerjakan -->
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-user mr-1" style="color: #31beb4;"></i>Pilih Pengguna yang Mengerjakan</label>
            <div id="user-checkboxes">
                <p class="text-muted">Pilih team terlebih dahulu.</p>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ Auth::user()->role == 'pimpinan' ? route('jobdesk.indexpimpinan') : route('jobdesk.indexteamleader') }}" class="btn btn-secondary">
    Kembali
</a>

    </form>
    </div>
    </div>
</div>

<!-- Script untuk AJAX -->
<script>
    document.getElementById('team_id').addEventListener('change', function() {
        let team_id = this.value;
        let userCheckboxes = document.getElementById('user-checkboxes');

        if (team_id) {
            fetch(`/jobdesk/users/${team_id}`)
                .then(response => response.json())
                .then(users => {
                    userCheckboxes.innerHTML = ""; // Hapus daftar lama

                    if (users.length > 0) {
                        users.forEach(user => {
                            let checkbox = `
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="user_ids[]" value="${user.id}" id="user_${user.id}">
                                    <label class="form-check-label" for="user_${user.id}">
                                        ${user.name}
                                    </label>
                                </div>
                            `;
                            userCheckboxes.innerHTML += checkbox;
                        });
                    } else {
                        userCheckboxes.innerHTML = "<p class='text-muted'>Tidak ada pengguna dalam tim ini.</p>";
                    }
                })
                .catch(error => console.error("Error:", error));
        } else {
            userCheckboxes.innerHTML = "<p class='text-muted'>Pilih team terlebih dahulu.</p>";
        }
    });
</script>
@endsection