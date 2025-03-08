@extends('masterlayout')

@section('content')
<div class="container">
    <h1 class="mb-4">Profil Saya</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Informasi Profil</h5>
            <hr>
            <div class="mb-3">
                <strong>Nama:</strong>
                <p>{{ $user->name }}</p>
            </div>
            <div class="mb-3">
                <strong>Email:</strong>
                <p>{{ $user->email }}</p>
            </div>
            <div class="mb-3">
                <strong>No HP:</strong>
                <p>{{ $user->no_hp ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>Role:</strong>
                <p>{{ ucfirst($user->role) }}</p>
            </div>
            <div class="mb-3">
                <strong>Tim yang diikuti:</strong>
                <ul>
                    @forelse($teams as $team)
                        <li>{{ $team->nama_team }}</li>
                    @empty
                        <li>-</li>
                    @endforelse
                </ul>
            </div>
            <a href="{{ route('profil.edit') }}" class="btn btn-primary">Edit Profil</a>
        </div>
    </div>
</div>
@endsection
