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
    <div class="card card-primary card-outline mt-3 mb-3 ms-3 me-3 p-3"  style="border-color: #31beb4;">
        <div class="card-header">
            <h4 class="card-title">
                <i class="fas fa-id-card" style="color: #31beb4"></i>
                Profil Anda
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Bagian Kanan: Informasi Profil -->
                <div class="col-md-6">
    <div class="mb-3">
        <i class="fas fa-user mr-1" style="color: #31beb4;"></i>
        <strong> Nama</strong>
        <p>{{ $user->name }}</p>
    </div>
    <div class="mb-3">
        <i class="fas fa-user-tag mr-1" style="color: #31beb4;"></i>
        <strong> Username</strong>
        <p>{{ $user->username }}</p>
    </div>
    <div class="mb-3">
        <i class="fas fa-envelope mr-1" style="color: #31beb4;"></i>
        <strong> Email Pemulihan</strong>
        <p>{{ $user->email ?? '-' }}</p>
    </div>
    <div class="mb-3">
        <i class="fas fa-phone-alt mr-1" style="color: #31beb4;"></i>
        <strong> Nomor HP</strong>
        <p>{{ $user->no_hp ?? '-' }}</p>
    </div>
    <div class="mb-3">
        <i class="fas fa-briefcase mr-1" style="color: #31beb4;"></i>
        <strong> Jabatan</strong>
        <p>{{ ucfirst($user->role) }}</p>
    </div>

                    <a href="{{ route('profil.edit') }}" class="btn btn-warning mb-2">
                        <i class="fas fa-user-edit " ></i> Edit Profil
                    </a>
                </div>

                <!-- Bagian Kiri: Tim yang diikuti -->
                <div class="col-md-6">
                    <p class="mb-3"> <i class="fas fa-users mr-1" style="color: #31beb4;"></i><strong>Team</strong></p>
                    @forelse($teams as $team)
                        <div class="card   mb-2">
                            <div class="card-body">
                                <p class="mb-0">{{ $team->nama_team }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0">-</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
