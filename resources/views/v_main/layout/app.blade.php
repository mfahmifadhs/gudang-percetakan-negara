<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Gudang Percetakan Negara</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('dist-main/img/logo-kemenkes-icon.png') }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Saira:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('dist-main/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist-main/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('dist-main/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('dist-main/css/style.css') }}" rel="stylesheet">

    <!-- summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('dist/plugins/select2/css/select2.min.css') }}">
    @yield('css')
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>Jl. Percetakan Negara II No.23.</small>
                <small class="ms-4"><i class="fa fa-envelope me-2"></i>roum@kemenkes.go.id</small>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            @if(Auth::user() != null && Auth::user()->role_id == 2)
            <a href="{{ url('tim-kerja/dashboard') }}" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="fw-bold text-primary m-0">Gudang <span class="text-white">PN</span></h1>
            </a>
            @else
            <a href="{{ url('/') }}" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="fw-bold text-primary m-0">Gudang <span class="text-white">PN</span></h1>
            </a>
            @endif
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    @if(Auth::user() != null && Auth::user()->role_id == 2)
                    <a href="{{ url('tim-kerja/dashboard') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Beranda</a>
                    @else
                    <a href="{{ url('/') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Beranda</a>
                    @endif
                    <a href="{{ url('main/gudang/daftar') }}" class="nav-item nav-link {{ Request::is('main/gudang/daftar') ? 'active' : '' }}">Gudang</a>
                    <a href="{{ url('main/prosedur') }}" class="nav-item nav-link {{ Request::is('main/prosedur') ? 'active' : '' }}">Prosedur</a>
                    @if(Auth::user() != null && Auth::user()->role_id == 3)
                        <a href="{{ url('unit-kerja/surat/pengajuan/penyimpanan') }}" class="nav-item nav-link">Penyimpanan</a>
                        <a href="{{ url('unit-kerja/surat/pengajuan/pengeluaran') }}" class="nav-item nav-link">Pengeluaran</a>

                        <a href="{{ url('unit-kerja/menu-barang/daftar/seluruh-barang') }}" class="nav-item nav-link">Daftar Barang</a>
                    @elseif(Auth::user() != null && Auth::user()->role_id == 2)
                        <a href="{{ url('tim-kerja/barang/daftar/seluruh-barang') }}" class="nav-item nav-link">Daftar Barang</a>
                    @endif
                </div>
                @if(Auth::user() == null)
                <a class="nav-item nav-link btn btn-outline-primary py-2 px-3" href="{{ route('login') }}">
                    Masuk
                </a>
                @else
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle btn btn-outline-primary py-2 px-3 text-capitalize" data-bs-toggle="dropdown">
                        {{ Auth::user()->full_name }}
                    </a>
                    <div class="dropdown-menu m-0">
                        <a href="{{ url('main/profil/ubah/'. Auth::user()->id) }}" class="dropdown-item">Profil</a>
                        @if(Auth::user()->role_id == 3)
                        <a href="{{ url('unit-kerja/surat/daftar-surat-pengajuan/semua') }}" class="dropdown-item">Surat Pengajuan</a>
                        <a href="{{ url('unit-kerja/surat-perintah/daftar/semua') }}" class="dropdown-item">Surat Perintah</a>
                        @endif
                        <a href="{{ route('signout') }}" class="dropdown-item">Keluar</a>
                    </div>
                </div>
                @endif
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    <div class="container-fluid p-0 mb-5">
        @yield('content')
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-9 col-md-6">
                    <h1 class="fw-bold text-primary mb-4">Gudang<span class="text-white">PN</span></h1>
                    <p>Gudang Percetakan Negara Kementerian Kesehatan Republik Indonesia</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Address</h5>
                    <p><i class="fa fa-map-marker-alt me-3"></i>Jl. Percetakan Negara II No.23</p>
                    <p><i class="fa fa-envelope me-3"></i>gudang_pn@kemkes.go.id</p>
                </div>
            </div>
        </div>
        <div class="container-fluid copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a href="#">Gudang PN</a>, Biro Umum Kemenkes RI.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Versi <a href="#">1.0</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('dist-main/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('dist-main/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('dist-main/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('dist-main/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('dist-main/lib/parallax/parallax.min.js') }}"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('dist-main/js/main.js') }}"></script>
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
    <script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>>
    <!-- Select2 -->
    <script src="{{ asset('dist/plugins/select2/js/select2.full.min.js') }}"></script>
    @yield('js')

</body>

</html>
