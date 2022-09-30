<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gudang Percetakan Negara</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('dist/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('dist/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('dist/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('dist/plugins/select2/css/select2.min.css') }}">
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">

<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{ asset('dist/img/logo-kemenkes-brown.png') }}" alt="Sistem Informasi Pergudangan" height="200">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Notifications Dropdown Menu -->
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
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('dist/img/logo-kemenkes-icon.png') }}" alt="Sistem Informasi Pergudangan" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SIP KEMENKES</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
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
            <a href="{{ url('admin-master/dashboard') }}" class="nav-link
              {{ Request::is('admin-master/dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header font-weight-bold">Menu</li>
          <li class="nav-item">
            <a href="{{ url('admin-master/barang/daftar/semua') }}" class="nav-link
              {{ Request::is('admin-master/barang/daftar/semua') ? 'active' : '' }}">
              <i class="nav-icon fas fa-boxes"></i>
              <p>Master Barang</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin-master/gudang/daftar/semua') }}" class="nav-link
              {{ Request::is('admin-master/gudang/daftar/semua') ? 'active' : '' }}">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>Master Gudang</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin-master/pengguna/daftar/semua') }}" class="nav-link
              {{ Request::is('admin-master/pengguna/daftar/semua') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Master Pengguna</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin-master/unit-kerja/daftar/semua') }}" class="nav-link
              {{ Request::is('admin-master/unit-kerja/daftar/semua') ? 'active' : '' }}">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>Master Unit Kerja</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    @yield('content')
    <br>
  </div>


  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href="https://adminlte.io">Biro Umum</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('dist/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('dist/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>

<!-- PAGE PLUGINS -->
<script src="{{ asset('dist/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('dist/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('dist/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('dist/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('dist/plugins/chart.js/Chart.min.js') }}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('dist/plugins/summernote/summernote-bs4.min.js') }}"></script>
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
<!-- Select2 -->
<script src="{{ asset('dist/plugins/select2/js/select2.full.min.js') }}"></script>
@yield('js')
</body>
</html>
