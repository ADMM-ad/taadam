<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Karyawan</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
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
    background-color: white;
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
    background-color: #fb8149 !important;
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
  @media (max-width: 820px) and (min-height: 1180px) {
  .navbar {
    height: 60px; /* Tentukan tinggi navbar yang sesuai */
    display: flex;
    align-items: center; /* Menjaga elemen tetap sejajar secara vertikal */
    justify-content: space-between; /* Mengatur jarak antar elemen secara horizontal */
    padding: 0 1rem;
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
<nav class="navbar navbar-expand-lg navbar-dark bg-white">
    <a class="navbar-brand" href="#">
      <img src="{{ asset('gambar/logo.png') }}" alt="Logo">
    </a>
    <li class="nav-item d-flex align-items-center">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown d-flex align-items-center">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;">
          <img src="{{ asset('gambar/admin.png') }}" alt="User Photo" class="rounded-circle">
          {{ auth()->user()->name ?? 'User' }}
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
  </nav>

  <div class="wrapper">
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="/dashboardkaryawan" class="nav-link">
                <i class="fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-users"></i>
                <p>Data Pengguna</p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-clipboard-check"></i>
                <p>
                  Perizinan
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-file-signature"></i>
                    <p>Permintaan Perizinan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-file-alt"></i>
                    <p>Status Perizinan</p>
                  </a>
                </li>
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
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-calendar-day"></i>
                    <p>Absensi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-calendar-alt"></i>
                    <p>Riwayat Absensi</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-tasks"></i>
                <p>
                  Jobdesk
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-tasks"></i>
                    <p>Jobdesk</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-star"></i>
                <p>Point KPI</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      @yield('content')
    </div>
  </div>

  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
