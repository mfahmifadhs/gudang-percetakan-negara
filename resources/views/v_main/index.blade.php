@extends('v_main.layout.app')

@section('content')

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container" style="margin-top: 100px;">
      <div class="row g-5">
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
          <div class="position-relative overflow-hidden h-100" style="min-height: 400px;">
            <img class="position-absolute w-100 h-100 pt-5 pe-5" src="{{ asset('dist-main/img/gudang-pn.jpg') }}" alt="" style="object-fit: cover;">
            <img class="position-absolute top-0 end-0 bg-white ps-2 pb-2" src="{{ asset('dist-main/img/roadmap-gudang-pn.jpg') }}" alt="" style="width: 200px; height: 200px;">
          </div>
        </div>
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
          <div class="h-100">
            <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
            <h1 class="display-6 mb-5">Gudang Percetakan Negara Kemenkes RI</h1>
            <div class="bg-light border-bottom border-5 border-primary rounded p-4 mb-4">
              <p class="text-dark mb-2">
              Kompleks Pergudangan dan Perkantoran Kementerian Kesehatan yang terletak di Jl. Percetakan Negara No. 23 selesai dibangun pada tahun 1950
              dengan total luas 69.104 m2. <br> Kompleks ini terdiri dari 12 bangunan Gedung , antara lain: <br><br>
              1. Gedung Laboratorium Penelitian Penyakit Infeksi (Gd. Prof Dr. Sri Oemijati),<br>
              2. Gedung Perkantoran Biomedis,<br>
              3. Gedung Records Center Kemenkes RI (Gd. Soedjoto),<br>
              4. Gedung Perkantoran, dan<br>
              5. 8 Gudang Kementerian Kesehatan RI<br>

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
