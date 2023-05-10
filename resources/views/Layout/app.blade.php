<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gudang Percetakan Negara</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('dist-main/img/logo-kemenkes-icon.png') }}">

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

<body class="hold-transition sidebar-mini sidebar-fixed">

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
                        <b>
                            {{ in_array(Auth::user()->role_id, [1,2]) ?
                                Auth::user()->role->nama_role
                                :
                                Auth::user()->pegawai->nama_pegawai
                            }}
                        </b>
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
        <aside class="main-sidebar sidebar-dark-warning elevation-4">
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
                        <a href="#" class="d-block">
                            {{ in_array(Auth::user()->role_id, [1,2]) ?
                                Auth::user()->role->nama_role
                                :
                                Auth::user()->pegawai->nama_pegawai
                            }}
                        </a>
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
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>
                                    Barang
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('item.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Barang</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>
                                    Pengajuan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('submission.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Pengajuan</p>
                                    </a>
                                </li>
                                @if (Auth::user()->role_id == 4)
                                <li class="nav-item">
                                    <a type="button" class="nav-link" data-toggle="modal" data-target="#create-submission">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Pengajuan</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @if (Auth::user()->role_id != 4)
                        <li class="nav-header font-weight-bold">Gedung Pecetakan Negara</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>
                                    Penyimpanan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('storage.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Penyimpanan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('storage.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Penyimpanan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>
                                    Gedung PN
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('warehouse.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Gedung</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('warehouse.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Gedung</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th-large"></i>
                                <p>
                                    Kategori Gedung
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('warehouseCategory.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Kategori</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('warehouseCategory.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Kategori</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-memory"></i>
                                <p>
                                    Model Penyimpanan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('storageModel.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Model</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('storageModel.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Model</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Auth::user()->role_id == 1)
                        <li class="nav-header font-weight-bold">Pegawai Kemenkes</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Pengguna
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('user.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Pengguna</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Pengguna</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-address-card"></i>
                                <p>
                                    Pegawai
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('employee.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Pegawai</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('employee.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Pegawai</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-address-card"></i>
                                <p>
                                    Unit Kerja
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('workunit.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Unit Kerja</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('workunit.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Unit Kerja</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-address-card"></i>
                                <p>
                                    Unit Utama
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview ">
                                <li class="nav-item">
                                    <a href="{{ route('mainunit.show') }}" class="nav-link">
                                        <i class="nav-icon fas fa"></i>
                                        <p>Daftar Unit Utama</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('mainunit.create') }}" class="nav-link">
                                        <i class="nav-icon fas fa-hand-holding-usds"></i>
                                        <p>Tambah Unit Utama</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>


        <!-- Modal -->
        <div class="modal fade" id="create-submission" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row text-center">
                            <div class="col-md-6">
                                <a class="btn btn-default" href="{{ route('submission.create', 'penyimpanan') }}">
                                    Penyimpanan
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-default" href="{{ route('submission.create', 'pengambilan') }}">
                                    Pengambilan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
    <!-- Summernote -->
    <script src="{{ asset('dist/plugins/summernote/summernote-bs4.min.js') }}"></script>
    @yield('js')
    <script>
        $(function() {
            var url = window.location;
            // for single sidebar menu
            $('ul.nav-sidebar a').filter(function() {
                return this.href == url;
            }).addClass('active');

            // for sidebar menu and treeview
            $('ul.nav-treeview a').filter(function() {
                    return this.href == url;
                }).parentsUntil(".nav-sidebar > .nav-treeview")
                .css({
                    'display': 'block'
                })
                .addClass('menu-open').prev('a')
                .addClass('active');
        });
    </script>
</body>

</html>
