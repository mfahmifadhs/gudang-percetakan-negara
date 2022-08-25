@extends('v_main.layout.app')

@section('content')

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
      <div class="row g-5">
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
          <div class="position-relative overflow-hidden h-100" style="min-height: 400px;">
            <img class="position-absolute w-100 h-100 pt-5 pe-5" src="img/about-1.jpg" alt="" style="object-fit: cover;">
            <img class="position-absolute top-0 end-0 bg-white ps-2 pb-2" src="img/about-2.jpg" alt="" style="width: 200px; height: 200px;">
          </div>
        </div>
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
          <div class="h-100">
            <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
            <h1 class="display-6 mb-5">Gudang Percetakan Negara Kemenkes RI</h1>
            <div class="bg-light border-bottom border-5 border-primary rounded p-4 mb-4">
              <p class="text-dark mb-2">
                Gudang Percetakan Negara Kemenkes RI merupakan Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
            </div>
            <a class="btn btn-primary py-2 px-3 me-3" href="{{ url('unit-kerja/surat/pengajuan/penyimpanan') }}">
              <i class="fas fa-boxes"></i> Simpan Barang
            </a>
            <a class="btn btn-primary py-2 px-3 me-3" href="{{ url('unit-kerja/surat/pengajuan/pengeluaran') }}">
              <i class="fas fa-people-carry"></i> Ambil Barang
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

@endsection
