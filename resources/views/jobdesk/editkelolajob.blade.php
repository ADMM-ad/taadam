@extends('masterlayout')

@section('content')
<div class="container">
    <h2>Kelola Pengguna dalam Jobdesk</h2>

    <div class="mb-3">
        <label class="form-label">Pengguna</label>
        <div id="user-list">
            @foreach($jobdesk->users ?? collect([]) as $user)
                <div class="d-flex align-items-center mb-2">
                    <span class="me-3">{{ $user->name }}</span>
                    <form action="{{ route('jobdesk.removeUser', ['jobdesk_id' => $jobdesk->id, 'user_id' => $user->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah</button>
    </div>

    <a href="{{ route('jobdesk.editpimpinan', $jobdesk->id) }}" class="btn btn-secondary">Kembali ke Edit Jobdesk</a>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('jobdesk.addUser', $jobdesk->id) }}" method="POST">
                        @csrf
                        <label for="user_id">Pilih Pengguna:</label>
                        <select name="user_id" class="form-control">
                            @foreach($teamUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success mt-2">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
