<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ourweb</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('template/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('template/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- Summernote -->
  <link rel="stylesheet" href="{{ asset('template/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- Kelender-->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

</head>

<style>
    body {
    background-color: #f4f6f9;
}
  .navbar {
    padding: 0.25rem 1rem;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 56px;
    z-index: 1040;
    background-color: #26948E !important;
  }


  .navbar-brand img {
    height: 80px;
    width: auto;
    display: block;
  }

  .navbar .nav-item img {
    height: 40px;
    width: 40px;
    border-radius: 50%;
    margin-right: 10px;
  }

  .navbar .nav-item p {
    margin: 0;
    color: black;
  }

  .navbar .nav-link {
    color: black;
  }

  .navbar .nav-link:hover,
  .navbar .nav-link.active {
    color: #007bff;
  }

  .navbar .dropdown-menu {
    background-color: white;
    z-index: 1050;
    position: absolute;
    left: 0;
    right: 0;
  }

  .navbar .dropdown-toggle::after {
    margin-left: 0.5rem;
  }

  .main-sidebar {
    background-color: #30BEB5 !important;
    margin-top: 56px;
  }

  .main-sidebar .nav-link i {
    color: white !important;
  }

  .main-sidebar .nav-link p {
    color: white;
  }

  .main-sidebar .nav-link.active,
  .main-sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
  }

  .content-wrapper {
    margin-left: 250px;
    padding-top: 56px;
  }
/* Mengubah warna background pagination */
.pagination {
    background-color: #26948E;  /* Ganti dengan warna yang diinginkan */
    border-radius: 0.25rem;  /* Optional: Memberikan border radius pada pagination */
}

/* Mengubah warna link pagination */
.pagination .page-link {
    color: white;  /* Warna teks saat tidak aktif */
    background-color: #26948E;  /* Warna background link */
    border: 1px solid #26948E;  /* Warna border link */
}

/* Mengubah warna saat hover pada link */
.pagination .page-link:hover {
    background-color: #1d7f74;  /* Warna hover saat link ditekan */
    color: white;  /* Warna teks saat hover */
}

/* Mengubah warna aktif pagination */
.pagination .active .page-link {
    background-color: #1d7f74;  /* Warna latar belakang saat aktif */
    color: white;  /* Warna teks saat aktif */
    border-color: #1d7f74;  /* Warna border saat aktif */
}

/* Mengubah warna untuk tombol disabled */
.pagination .disabled .page-link {
    background-color: #e0e0e0;  /* Warna latar belakang saat disabled */
    color: #b0b0b0;  /* Warna teks saat disabled */
    border-color: #e0e0e0;  /* Warna border saat disabled */
}


  @media (max-width: 820px) and (min-height: 1180px) {
  .navbar {
    height: 60px; /* Tentukan tinggi navbar yang sesuai */
    display: flex;
    align-items: center; /* Menjaga elemen tetap sejajar secara vertikal */
    justify-content: space-between; /* Mengatur jarak antar elemen secara horizontal */
    padding: 0 1rem;
  }

  .navbar-collapse {
    background-color: #26948E; /* Warna latar belakang dropdown */
    position: absolute;
    top: 56px; /* Sesuaikan dengan tinggi navbar */
    left: 0;
    width: 100%;
    z-index: 1030;
    padding: 10px 0;
}
  .navbar-brand {
    display: flex;
    align-items: center; /* Agar logo dan teks sejajar secara vertikal */
  }

  .navbar-brand img {
    height: 50px; /* Sesuaikan ukuran logo */
    width: auto;
  }

  .navbar .nav-item {
    display: flex;
    align-items: center; /* Menjaga elemen di dalam nav-item tetap sejajar secara vertikal */
  }

  .navbar .nav-item img {
    height: 40px; /* Sesuaikan ukuran gambar profil */
    width: 40px;
    margin-right: 10px;
  }

  .navbar .nav-item p {
    line-height: normal; /* Menjaga teks sejajar secara vertikal */
    margin: 0;
  }

  .navbar .nav-link {
    display: flex;
    align-items: center; /* Menjaga teks link tetap sejajar secara vertikal */
    color: black;
  }

  .navbar .dropdown-menu {
    position: absolute;
    right: 0;
    left: auto;
    width: 100%; /* Dropdown memenuhi lebar layar */
  }

  .navbar .nav-item.dropdown .nav-link {
    display: flex;
    justify-content: center; /* Konten dropdown tetap di tengah */
    align-items: center;
  }
}

  @media (max-width: 768px) {
  .navbar {
    padding: 0rem 0.25rem;
    height: 60px;
    position: fixed;
  }

  .navbar-collapse {
    background-color: #26948E; /* Warna latar belakang dropdown */
    position: absolute;
    top: 56px; /* Sesuaikan dengan tinggi navbar */
    left: 0;
    width: 100%;
    z-index: 1030;
    padding: 10px 0;
}
  .navbar-brand img {
    height: 60px;
  }

  .navbar .nav-item img {
    height: 30px;
    width: 30px;
  }

  .navbar .nav-item p {
    line-height: 60px; /* Menyesuaikan posisi teks vertikal */
    margin: 0;
  }

  .navbar .nav-link {
    margin-right: 15px;
  }

  .content-wrapper {
    margin-left: 0;
  }

  .main-sidebar {
    margin-top: 60px;
  }

  .navbar .dropdown-menu {
    position: absolute;
    right: 0;
    left: auto;
    width: 100%;
  }
  
  .navbar .nav-item.dropdown .nav-link {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
  }
}

@media (max-width: 576px) {
  .navbar {
    padding: 0rem 0.25rem;
    height: 60px;
    position: fixed;
  }

  .navbar-collapse {
    background-color: #26948E; /* Warna latar belakang dropdown */
    position: absolute;
    top: 56px; /* Sesuaikan dengan tinggi navbar */
    left: 0;
    width: 100%;
    z-index: 1030;
    padding: 10px 0;
}
  .navbar-brand img {
    height: 50px;
  }

  .navbar .nav-item img {
    height: 30px;
    width: 30px;
  }

  .navbar .nav-item p {
    line-height: 50px; /* Menyesuaikan posisi teks vertikal */
    margin: 0;
  }

  .navbar .nav-link {
    margin-right: 15px;
  }

  

  .navbar .dropdown-menu {
    position: absolute;
    right: 0;
    left: auto;
    width: 100%;
  }
  
  .navbar .nav-item.dropdown .nav-link {
    display: flex;
    justify-content: center;
    width: 100%;
    align-items: center;
  }
}

</style>

<body class="hold-transition sidebar-mini layout-fixed">
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="{{ asset('gambar/logo.png') }}" alt="Logo" height="40">
        </a>

        <!-- Tombol Toggle untuk HP -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto align-items-center">
                <!-- Tombol Menu -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>

                <!-- User Profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('gambar/admin.png') }}" alt="User Photo" class="rounded-circle" width="30">
                        <span class="d-none d-lg-inline text-nowrap ml-2">{{ auth()->user()->name ?? 'User' }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt" style="color: #FB8149;"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>


  <div class="wrapper">
  

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @if(auth()->user()->role == 'pimpinan')
            <li class="nav-item">
              <a href="/dashboardpimpinan" class="nav-link">
                <i class="fas fa-tachometer-alt"></i>
                <p>Dashboard Pimpinan</p>
              </a>
            </li>
            @endif

            @if(auth()->user()->role == 'teamleader')
            <li class="nav-item">
              <a href="/dashboardteamleader" class="nav-link">
                <i class="fas fa-tachometer-alt"></i>
                <p>Dashboard Teamleader</p>
              </a>
            </li>
            @endif

            @if(auth()->user()->role == 'karyawan')
            <li class="nav-item">
              <a href="/dashboardkaryawan" class="nav-link">
                <i class="fas fa-tachometer-alt"></i>
                <p>Dashboard Karyawan</p>
              </a>
            </li>
            @endif

            <li class="nav-item">
              <a href="/profil" class="nav-link">
                <i class="fas fa-user"></i>
                <p>Profil</p>
              </a>
            </li>
            
            @if(auth()->user()->role == 'pimpinan')
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-user"></i>
                <p>
                  User
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/userteamleader" class="nav-link">
                    <i class="fas fa-user-tie"></i>
                    <p>Team Leader</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/userkaryawan" class="nav-link">
                    <i class="fas fa-user-friends"></i>
                    <p>Karyawan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/register" class="nav-link">
                    <i class="fas fa-user-tie"></i>
                    <p>Tambah User</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-users"></i>
                <p>
                  Team
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/team" class="nav-link">
                    <i class="fas fa-folder"></i>
                    <p>Data Team</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/anggotateam" class="nav-link">
                    <i class="fas fa-user-check"></i>
                    <p>Anggota Team</p>
                  </a>
                </li>
              </ul>
            </li>
            @endif

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-clipboard-check"></i>
                <p>
                  Perizinanan
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if(auth()->user()->role == 'teamleader' || auth()->user()->role == 'karyawan')
                <li class="nav-item">
                  <a href="/absensi/perizinan?tanggal={{ date('Y-m-d') }}" class="nav-link">
                    <i class="fas fa-file-signature"></i>
                    <p>Permintaan Perizinan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/statusperizinan" class="nav-link">
                    <i class="fas fa-info-circle"></i>
                    <p>Status Perizinan</p>
                  </a>
                </li>
                @endif
                @if(auth()->user()->role == 'pimpinan')
                <li class="nav-item">
                  <a href="/request-perizinan" class="nav-link">
                    <i class="fas fa-file-alt"></i>
                    <p>Laporan Permintaan Perizinan</p>
                  </a>
                </li>
                @endif
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-calendar-check"></i>
                <p>
                  Absensi
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if(auth()->user()->role == 'teamleader' || auth()->user()->role == 'karyawan')
                <li class="nav-item">
                  <a href="/absensi" class="nav-link">
                    <i class="fas fa-calendar-day"></i>
                    <p>Absensi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/absensipengguna" class="nav-link">
                    <i class="fas fa-history"></i>
                    <p>Riwayat Absensi</p>
                  </a>
                </li>
                @endif
                @if(auth()->user()->role == 'teamleader')
                <li class="nav-item">
                  <a href="/absensiteam" class="nav-link">
                    <i class="fas fa-users"></i>
                    <p>Absensi Team</p>
                  </a>
                </li>
                @endif
                @if(auth()->user()->role == 'pimpinan')
                <li class="nav-item">
                  <a href="/absensipimpinan" class="nav-link">
                    <i class="fas fa-file-alt"></i>
                    <p>Laporan Absensi</p>
                  </a>
                </li>
                @endif
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-tasks"></i>
                <p>
                  Jobdesk
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if(auth()->user()->role == 'teamleader' || auth()->user()->role == 'karyawan')
                <li class="nav-item">
                  <a href="/jobdesk/pengguna" class="nav-link">
                    <i class="fas fa-tasks"></i>
                    <span class="badge badge-info right">{{ $countDitugaskan }}</span>
                    <p>Ditugaskan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/jobdesk/pengguna/selesai" class="nav-link">
                    <i class="fas fa-check"></i>
                    <p>Selesai</p>
                  </a>
                </li>
                @endif
                @if(auth()->user()->role == 'teamleader')
                <li class="nav-item">
                  <a href="/jobdesk/team" class="nav-link">
                    <i class="fas fa-users"></i>
                    <p>Jobdesk Team</p>
                  </a>
                </li>
                @endif
                @if(auth()->user()->role == 'pimpinan')
                <li class="nav-item">
                  <a href="/jobdesk/create" class="nav-link">
                    <i class="fas fa-file-alt"></i>
                    <p>Tambah Jobdesk Team</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/jobdesk/createindividu" class="nav-link">
                    <i class="fas fa-file-alt"></i>
                    <p>Tambah Jobdesk Individu</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/jobdesk/pimpinan" class="nav-link">
                    <i class="fas fa-users"></i>
                    <p>Laporan Jobdesk</p>
                  </a>
                </li>
                @endif
              </ul>
            </li>
            
            @if(auth()->user()->role == 'pimpinan' || auth()->user()->role == 'teamleader')
            <li class="nav-item">
              <a href="/hasil" class="nav-link">
                <i class="fas fa-chart-line"></i>
                <p>Hasil</p>
              </a>
            </li>
            @endif

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-star"></i>
                <p>
                  Point KPI
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if(auth()->user()->role == 'teamleader' || auth()->user()->role == 'karyawan')
                <li class="nav-item">
                  <a href="/cekpoint" class="nav-link">
                    <i class="fas fa-search"></i>
                    <p>Cek Point</p>
                  </a>
                </li>
                @endif
                @if(auth()->user()->role == 'teamleader')
                <li class="nav-item">
                  <a href="/pointteam" class="nav-link">
                    <i class="fas fa-calculator"></i>
                    <p>Hitung Point</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/laporanpointteam" class="nav-link">
                    <i class="fas fa-file-invoice"></i>
                    <p>Laporan Point</p>
                  </a>
                </li>
                @endif
                @if(auth()->user()->role == 'pimpinan')
                <li class="nav-item">
                  <a href="/point" class="nav-link">
                    <i class="fas fa-calculator"></i>
                    <p>Hitung Point</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/laporanpoint" class="nav-link">
                    <i class="fas fa-file-invoice"></i>
                    <p>Laporan Point</p>
                  </a>
                </li>
                @endif
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
  </div>

    <div class="content-wrapper">
      @yield('content')
    </div>
  </div>

  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>



  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  
 
  
  @yield('scripts')
</body>

</html>
