@extends('masterlayout')

@section('content')
<div class="container mt-3">

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-triangle"></i>  <!-- Ikon untuk error -->
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
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
    <div class="card-body" style="background-color: #ffffff ;">
    Halaman ini digunakan untuk menambahkan jobdesk individu. Jobdesk individu adalah tugas atau pekerjaan yang tidak terkait dengan jobdesk dalam team.
    </div>
</div>


<div class="card card-primary  mt-2" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title"> <i class="fas fa fa-plus-circle mr-1"></i>Tambah Jobdesk Individu</h3>
                </div>
                <div class="card-body">
    <form action="{{ route('jobdesk.storeindividu') }}" method="POST">
        @csrf

 <!-- Pilih User -->
 <div class="mb-3">
            <label for="user_id" class="form-label"><i class="fas fa-user mr-1" style="color: #31beb4;"></i>Pilih Pengguna yang Mengerjakan</label>
            <select name="user_id" class="form-control" required>
                <option value="">Silahkan memilih pengguna.</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
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
            <input type="date" name="tenggat_waktu" class="form-control" value="YYYY-MM-DD" required >
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
</div>
</div>
@endsection
