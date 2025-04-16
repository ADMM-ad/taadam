<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />


</head>

<style>
    body {
    background-color: #f4f6f9;
}
.custom-navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    padding: 0 1rem;
    background-color: #249c8e !important;
    z-index: 1040;
    display: flex;
    align-items: center;
}

/* Logo */
.custom-navbar .navbar-brand img {
    height: 50px;
    width: auto;
}

/* User Photo */
.custom-navbar .user-photo {
    height: 40px;
    width: 40px;
    border-radius: 50%;
}

/* Nav link styles */
.custom-navbar .nav-link {
    color: black;
    display: flex;
    align-items: center;
}

.custom-navbar .nav-link:hover {
    color: #007bff;
}

/* Dropdown Menu */
.custom-navbar .dropdown-menu {
    background-color: white;
}
  .main-sidebar {
    background-color: #31BEB4 !important;
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

/* kalender */

.fc-header-toolbar {
    display: flex;
    
    
    gap: 10px; /* Jarak antara tombol Today dan prev/next */
}

.fc .fc-button {
    background-color: #31beb4;
    border: none;
    color: white;
    font-weight: bold;
}
.fc .fc-today-button {
    background-color: #31beb4 !important;
    
}

/* Hover tombol "Today" */
.fc .fc-today-button:hover {
    background-color: #279c93 !important;
}
/* Hover button */
.fc .fc-button:hover {
    background-color: #279c93;
    color: #fff;
}


    /* Ubah warna nama hari seperti Sun, Mon, dst */
    .fc .fc-col-header-cell-cushion {
        color: #31beb4; /* biru */
        font-weight: bold;
    }

    /* Ubah warna angka tanggal di kalender */
    .fc .fc-daygrid-day-number {
        color: #31beb4; /* hijau */
        
    }
/* Warna header hari Minggu */
.fc .fc-col-header-cell.fc-day-sun .fc-col-header-cell-cushion {
        color: #ff0000 !important;
        font-weight: bold;
    }
/* Menyamakan tinggi dan font input Select2 dengan input form lain */

.choices__inner {
    min-height: 38px; /* default-nya sekitar 44px, kamu bisa ubah ke 30-35px */
    padding: 4px 8px;
   
  }

  .choices__list--single {
    padding: 0; /* mengurangi tinggi */
  }

  .choices__input {
    
    padding: 4px 6px;
  }

/* Sembunyikan nama user di tampilan kecil (<820px) */
@media (max-width: 819px) {
  .user-name {
    display: none !important;
  }
}

/* Tampilkan nama user di tampilan besar (>=820px) */
@media (min-width: 820px) {
  .user-name {
    display: inline-block !important;
  }
  .dropdown-menu {
    position: absolute !important; /* Pastikan dropdown tetap di posisinya */
    right: 0 !important; /* Letakkan ke kanan */
    left: auto !important; /* Hindari bug tampilan */
    top: 100% !important; /* Agar dropdown muncul di bawah icon */
    width: max-content; /* Sesuaikan lebar */
  }
}

  @media (max-width: 768px) {
    .custom-navbar .nav-link span {
        display: none !important;
    }

    .custom-navbar .navbar-brand img {
        height: 40px;
    }

    .custom-navbar .user-photo {
        height: 35px;
        width: 35px;
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


</style>

<body class="hold-transition sidebar-mini layout-fixed">
<nav class="navbar navbar-light bg-white custom-navbar">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Kiri: Logo -->
        <a class="navbar-brand mb-0" href="#">
            <img src="{{ asset('gambar/logo.png') }}" alt="Logo">
        </a>

        <!-- Kanan: Pushmenu, Profil -->
        <ul class="navbar-nav flex-row align-items-center">
            <!-- Pushmenu Icon -->
            <li class="nav-item mr-3">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>

            <!-- Profil Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ asset('gambar/admin.png') }}" alt="User Photo" class="user-photo">
                    <span class="user-name ml-2">{{ auth()->user()->name ?? 'User' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt" style="color: #31beb4 ;"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
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
                <i class="fas fa-user-circle"></i>
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
                    <i class="fas fa-user-plus"></i>
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
                    <p>Daftar Team</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/anggotateam" class="nav-link">
                    <i class="fas fa-sitemap"></i>
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
                    <p>Ajukan Perizinan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/statusperizinan" class="nav-link">
                    <i class="fas fa-info-circle"></i>
                    <p>Status Perizinan</p>
                  </a>
                </li>
                @endif
                @if(auth()->user()->role == 'teamleader')
                <li class="nav-item">
                  <a href="/request-team-leader" class="nav-link">
                    <i class="fas fa-file-alt"></i>
                    <p>Permintaan Perizinan</p>
                  </a>
                </li>
                @endif
                @if(auth()->user()->role == 'pimpinan')
                <li class="nav-item">
                  <a href="/request-perizinan" class="nav-link">
                    <i class="fas fa-file-alt"></i>
                    <p>Permintaan Perizinan</p>
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
                @if(auth()->user()->role == 'pimpinan' || auth()->user()->role == 'teamleader')
                <li class="nav-item">
                  <a href="/laporan-keterlambatan" class="nav-link">
                    <i class="fas fa-clock"></i>
                    <p>Laporan Terlambat</p>
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
                    <i class="fas fa fa-clipboard-list"></i>
                    <p>Jobdesk Team</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/jobdesk/createindividu" class="nav-link">
                    <i class="fas fa fa-briefcase"></i>
                    <p>Jobdesk Individu</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/jobdesk/pimpinan" class="nav-link">
                    <i class="fas fa-file-alt"></i>
                    <p>Laporan Jobdesk</p>
                  </a>
                </li>
                @endif
              </ul>
            </li>
            
            @if(auth()->user()->role == 'pimpinan')
            <li class="nav-item">
              <a href="/hasil" class="nav-link">
                <i class="fas fa-chart-line"></i>
                <p>Hasil</p>
              </a>
            </li>
            @endif


            @if(auth()->user()->role == 'teamleader')
                <li class="nav-item">
                  <a href="/hasil-teamleader" class="nav-link">
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


  
<!-- Scripts -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('template/plugins/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('template/plugins/jquery-knob/jquery.knob.min.js') }}"></script>


  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('select');
    selects.forEach(select => {
      new Choices(select, {
        searchEnabled: true,  // Menonaktifkan fitur pencarian
        itemSelectText: '',    // Menghilangkan teks "select"
      });
    });
  });
</script>

 
  @stack('scriptsdua')

  @yield('scripts')
</body>

</html>
