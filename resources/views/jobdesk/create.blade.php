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

        <div class="card card-primary  mt-2" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title">Tambah Jobdesk Team </h3>
                </div>
                <div class="card-body">
    <form action="{{ route('jobdesk.store') }}" method="POST">
        @csrf

        <!-- Pilih Team -->
        <div class="mb-3">
            <label for="team_id" class="form-label">Pilih Team</label>
            <select name="team_id" id="team_id" class="form-control" required>
                <option value="">-- Pilih Team --</option>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->nama_team }}</option>
                @endforeach
            </select>
        </div>

        <!-- Pilih Nama Pekerjaan -->
        <div class="mb-3">
            <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
            <input type="text" name="nama_pekerjaan" class="form-control" required>
        </div>

        <!-- Pilih Deskripsi -->
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
        </div>

        <!-- Pilih Tenggat Waktu -->
        <div class="mb-3">
            <label for="tenggat_waktu" class="form-label">Tenggat Waktu</label>
            <input type="date" name="tenggat_waktu" class="form-control" required>
        </div>

        <!-- Pilih User yang Mengerjakan -->
        <div class="mb-3">
            <label class="form-label">Pilih Pengguna yang Mengerjakan</label>
            <div id="user-checkboxes">
                <p class="text-muted">Pilih team terlebih dahulu.</p>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
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
