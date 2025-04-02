@extends('masterlayout')

@section('content')
<div class="container">
    <div class="card card-primary card-outline mt-3 mb-3 ms-3 me-3 p-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user"></i>
                Profil Anda
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Bagian Kanan: Informasi Profil -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>Nama Anda</strong>
                        <p>{{ $user->name }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Username</strong>
                        <p>{{ $user->username }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Nomor HP</strong>
                        <p>{{ $user->no_hp ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Jabatan</strong>
                        <p>{{ ucfirst($user->role) }}</p>
                    </div>
                    <a href="{{ route('profil.edit') }}" class="btn btn-primary mb-2">
                        <i class="fas fa-user-edit " ></i> Edit Profil
                    </a>
                </div>

                <!-- Bagian Kiri: Tim yang diikuti -->
                <div class="col-md-6">
                    <h5 class="mb-3"><strong>Team</strong></h5>
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
