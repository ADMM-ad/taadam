@extends('masterlayout')

@section('content')
<div class="container mt-2">
<div class="card card-primary card-outline mt-3 mb-3 ms-3 me-3 p-3"  style="border-color: #31beb4;">
        <div class="card-header">
            <h3 class="card-title">
                Detail Jobdesk
            </h3>
        </div>
        <div class="card-body">
        <div class="row mb-3">
                <div class="col-md-4 font-weight-bold ">Nama Team : </div>
                <div class="col-md-8">{{ $jobdesk->team ? $jobdesk->team->nama_team : 'Individu' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 font-weight-bold ">Nama Pekerjaan : </div>
                <div class="col-md-8">{{ $jobdesk->nama_pekerjaan }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 font-weight-bold ">Deskripsi : </div>
                <div class="col-md-8">{{ $jobdesk->deskripsi }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 font-weight-bold ">Tenggat Waktu : </div>
                <div class="col-md-8">{{ $jobdesk->tenggat_waktu }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 font-weight-bold ">Nama Pengguna yang Terlibat : </div>
                <div class="col-md-8">
                    <ul class="list-unstyled mb-0">
                        @foreach($users as $user)
                        <li >
    <i class="fas fa-user" style="color: #31beb4; margin-right: 8px;"></i> {{ $user->name }}
</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 font-weight-bold ">Status : </div>
                <div class="col-md-8">
                    <span class="badge {{ $jobdesk->status == 'ditugaskan' ? 'badge-danger' : 'badge-success' }}">
                        {{ ucfirst($jobdesk->status) }}
                    </span>
                </div>
            </div>
        </div>

</div>
<a href="{{ Auth::user()->role == 'pimpinan' ? route('jobdesk.indexpimpinan') : route('jobdesk.indexteamleader') }}" class="btn btn-secondary">
    Kembali
</a>

</div>

    
</div>
@endsection
