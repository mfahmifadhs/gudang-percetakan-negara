<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Gudang Percetakan Negara</title>
  <link rel="icon" type="image/png" href="{{ asset('dist/img/logo-kemenkes-icon.png') }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('dist/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('dist/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('dist/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  @yield('css')
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Profil User -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user-circle"></i>
          <b>{{ Auth::user()->full_name }}</b>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{ Auth::user()->nip }}</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('signout') }}" class="dropdown-item dropdown-footer">
            <i class="fas fa-sign-out-alt"></i> Keluar
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('petugas/dashboard') }}" class="brand-link">
      <img src="{{ asset('dist/img/logo-kemenkes-icon.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">KEMENKES RI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->full_name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ url('petugas/dashboard') }}" class="nav-link
            {{ Request::is('petugas/dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('petugas/gudang/daftar/semua') }}" class="nav-link
            {{ Request::is('petugas/gudang/daftar/semua') ? 'active' : '' }}">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Gudang
              </p>
            </a>
          </li>
          <li class="nav-header font-weight-bold">Aktivitas</li>
          <li class="nav-item">
            <a href="{{ url('petugas/aktivitas/daftar/pengiriman') }}" class="nav-link
            {{ Request::is('petugas/pengiriman') ? 'active' : '' }}">
              <i class="nav-icon fas fa-dolly-flatbed"></i>
              <p>
                Pengiriman
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('petugas/aktivitas/daftar/pengeluaran') }}" class="nav-link
            {{ Request::is('petugas/pengeluarans') ? 'active' : '' }}">
              <i class="nav-icon fas fa-truck-loading"></i>
              <p>
                Pengeluaran
              </p>
            </a>
          </li>
          <li class="nav-header font-weight-bold">Barang</li>
          <li class="nav-item">
            <a href="{{ url('petugas/barang/daftar/masuk') }}" class="nav-link
            {{ Request::is('petugas/daftar-barang/masuk') ? 'active' : '' }}">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Barang Masuk
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('petugas/barang/daftar/keluar') }}" class="nav-link
            {{ Request::is('petugas/daftar-barang/keluar') ? 'active' : '' }}">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Barang Keluar
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Kementerian Kesehatan RI</b>
    </div>
    <strong>Biro Umum &copy; 2022 Sekretariat Jenderal.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('dist/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('dist/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('dist/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dist/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dist/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dist/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dist/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('dist/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('dist/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
@yield('js')
</body>
</html>
