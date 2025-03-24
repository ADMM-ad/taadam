@extends('masterlayout')

@section('content')
<div class="container">
    <h2>Buat Jobdesk Baru</h2>

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

    <form action="{{ route('jobdesk.storeindividu') }}" method="POST">
        @csrf

 <!-- Pilih User -->
 <div class="mb-3">
            <label for="user_id" class="form-label">Pilih User</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
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

        <button type="submit" class="btn btn-primary">Simpan Jobdesk</button>
    </form>
</div>

@endsection
