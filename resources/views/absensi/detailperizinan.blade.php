@extends('masterlayout')

@section('content')
<div class="container mt-3">
<div class="card card-primary card-outline mt-3 mb-3 ms-3 me-3 p-3"  style="border-color: #31beb4;">
        <div class="card-header">
            <h3 class="card-title">
                Detail Perizinan {{ $absensi->user->name }}
            </h3>
        </div>
        <div class="card-body">
            <p><strong>Nama :</strong> {{ $absensi->user->name }}</p>
            <p><strong>Tanggal Perizinan:</strong> {{ $absensi->tanggal }}</p>
            <p><strong>Alasan :</strong> 
    @if(in_array($absensi->kehadiran, ['datang', 'pulang']))
        Lupa Absen {{ ucfirst($absensi->kehadiran) }}
    @else
        {{ ucfirst($absensi->kehadiran) }}
    @endif
</p>

            <p><strong>Pesan :</strong> {{ $absensi->pesan ?? 'Tidak ada pesan' }}</p>
            
            @if($absensi->bukti)
                <p><strong>Bukti Perizinan:</strong></p>
                
                @if (in_array(pathinfo($absensi->bukti, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                    <!-- Jika bukti berupa gambar -->
                    <img src="{{ asset('/' . $absensi->bukti) }}" alt="Bukti Perizinan" class="img-fluid" style="max-width: 100%; height: auto;">
                @else
                    <!-- Jika bukti berupa file lain (misalnya PDF) -->
                    <a href="{{ asset('/' . $absensi->bukti) }}" target="_blank" class="btn btn-info btn-sm">
                        Lihat Bukti
                    </a>
                @endif
            @else
                <p><strong>Bukti Perizinan:</strong> Tidak ada bukti yang diunggah.</p>
            @endif
        </div>
        
       
    </div>
    
    <a href="{{ Auth::user()->role === 'pimpinan' ? route('absensi.indexrequest') : route('absensi.requestteam') }}" class="btn btn-secondary mb-3">Kembali</a>

</div>
@endsection
