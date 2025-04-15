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

        <div class="card card-primary  mt-2" >
                <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
                    <h3 class="card-title"><i class="fas fa-edit mr-1"></i>Edit Jobdesk</h3>
                </div>
                <div class="card-body">       
    <form action="{{ route('jobdesk.updatepimpinan', $jobdesk->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-users mr-1" style="color: #31beb4;"></i>Nama Tim</label>
            <input type="text" class="form-control" value="{{ $jobdesk->team->nama_team }}" disabled>
        </div>

        <div class="mb-3">
            <label for="nama_pekerjaan" class="form-label"><i class="fas fa-clipboard-list mr-1" style="color: #31beb4;"></i>Nama Pekerjaan</label>
            <input type="text" name="nama_pekerjaan" class="form-control" value="{{ $jobdesk->nama_pekerjaan }}">
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label"><i class="fas fa-comment-dot mr-1" style="color: #31beb4;"></i>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $jobdesk->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tenggat_waktu" class="form-label"><i class="fas fa-calendar-alt mr-1" style="color: #31beb4;"></i>Tenggat Waktu</label>
            <input type="date" name="tenggat_waktu" class="form-control" value="{{ $jobdesk->tenggat_waktu }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label"><i class="fas fa-hourglass-half mr-1" style="color: #31beb4;"></i>Status</label>
            <select name="status" class="form-control">
                <option value="ditugaskan" {{ $jobdesk->status == 'ditugaskan' ? 'selected' : '' }}>Ditugaskan</option>
                <option value="selesai" {{ $jobdesk->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="
    @if(auth()->user()->role == 'pimpinan')
        {{ route('jobdesk.indexpimpinan') }}
    @elseif(auth()->user()->role == 'teamleader')
        {{ route('jobdesk.indexteamleader') }}
    @endif
" class="btn btn-secondary">Kembali</a>


    </form>
</div>
</div>
<div class="card card-primary mt-2">
    <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
        <h3 class="card-title"><i class="fas fa-user mr-1"></i>Pengguna dalam Jobdesk ini</h3>
    </div>
    <div class="card-body">
        <ul class="list-group">
            @forelse($jobdesk->users as $user)
            <li class=" d-flex align-items-center rounded mb-2">
                    <div style="color: #31beb4; margin-right: 8px;">
                        <i class="fas fa-user"></i>
                    </div>
                    {{ $user->name }}
                </li>
            @empty
                <li class="list-group-item text-muted">Belum ada pengguna yang ditugaskan.</li>
            @endforelse
        </ul>

        <!-- Tombol tidak memanjang, diberikan class 'd-inline-block' -->
        <a href="{{ route('jobdesk.editkelolajob', $jobdesk->id) }}" class="btn btn-primary mt-3 d-inline-block">
            Kelola Pengguna
        </a>
    </div>
</div>

@endsection
