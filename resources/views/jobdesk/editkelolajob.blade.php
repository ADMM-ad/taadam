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

    <div class="card card-primary mt-2">
        <div class="card-header" style="background-color: #31beb4; border-color: #31beb4;">
            <h3 class="card-title"><i class="fas fa-user mr-1"></i>Kelola Jobdesk</h3>
        </div>
        <div class="card-body">
            <div class="row"> 
                <!-- Kolom kiri: Daftar pengguna yang sudah ditambahkan -->
                <div class="col-md-6 col-12 mb-3">
                    <h5>Pengguna yang Terlibat</h5>
                    <div id="user-list">
                    @foreach($jobdesk->users ?? collect([]) as $user)
                            <div class="d-flex align-items-center justify-content-between  rounded mb-2">
                                <span>
                                    <i class="fas fa-user" style="color: #31beb4; margin-right: 8px;"></i> 
                                    {{ $user->name }}
                                </span>
                                <form action="{{ route('jobdesk.removeUser', ['jobdesk_id' => $jobdesk->id, 'user_id' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kolom kanan: Form tambah pengguna -->
                <div class="col-md-6 col-12">
                    
                        <h5 class="mb-3">Tambah Pengguna</h5>
                        <form action="{{ route('jobdesk.addUser', $jobdesk->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                
                                <select name="user_id" id="userSelect" class="form-control mb-3">
                                    @foreach($teamUsers as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">
                                 Tambah
                            </button>
                        </form>
                    </div>
                </div>
            
        </div>
    </div>

    <a href="{{ route('jobdesk.editpimpinan', $jobdesk->id) }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
