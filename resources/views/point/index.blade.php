@extends('masterlayout')

@section('content')
<div class="container">
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
    <div class="row">
        @foreach($users as $user)
            <div class="col-md-4 mb-2">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center text-center">

                        <!-- BAGIAN KIRI: Icon user & nama (dalam kolom vertikal) -->
                        <div class="d-flex flex-column align-items-center w-50">
                            <i class="fas fa-user fa-4x mb-2" style="color: #31beb4;"></i>
                            <h5 class="card-title mb-0">{{ $user->name }}</h5>
                        </div>

                        <!-- BAGIAN KANAN: Icon Hitung besar & teks "Hitung" -->
                        <div class="d-flex flex-column align-items-center w-50">
                            <a href="{{ route('point.create', ['user_id' => $user->id]) }}" 
                               class="btn btn-success d-flex flex-column align-items-center py-3 px-4">
                                <i class="bi bi-calculator-fill" style="font-size: 2rem;"></i>
                                <span class="mt-1">Hitung</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
