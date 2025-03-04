@extends('masterlayout')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Daftar User (Tanpa Pimpinan)</h2>
    <div class="row">
        @foreach($users as $user)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <a href="{{ route('point.create', ['user_id' => $user->id]) }}" class="btn btn-primary">
                            Point
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
