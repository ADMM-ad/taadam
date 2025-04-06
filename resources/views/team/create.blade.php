@extends('masterlayout')

@section('content')
<div class="container mt-3">
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
                    <h3 class="card-title">Tambah Team Baru</h3>
                </div>
                <div class="card-body">
    <form action="{{ route('team.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_team">Nama Team</label>
            <input type="text" class="form-control" id="nama_team" name="nama_team" placeholder="Masukan Nama Team Baru"required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('team.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
</div>
</div>
@endsection
