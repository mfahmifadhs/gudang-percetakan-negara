@extends('v_workunit.layout.app')

@section('content')

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Gudang Kementerian <br>Kesehatan Republik Indonesia</h1>
    <p class="lead">Kompleks Pergudangan dan Perkantoran Jl. Percetakan II No.23, Jakarta Pusat</p>
  </div>
</div>

<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h3 class="mb-4"><small>Pengajuan Penyimpanan / Pengambilan Barang</small></h3>
      </div>
      <div class="col-lg-3 form-group">
        <a href="{{ url('unit-kerja/surat/pengajuan/permohonan') }}">
          <div class="card card-primary card-outline text-center" style="height: 100%;">
            <div class="card-body">
              <p class="card-text mt-3">
                <img src="https://cdn-icons-png.flaticon.com/512/887/887997.png" height="70">
              </p>
            </div>
            <div class="card-footer">
              <h5 class="lead text-uppercase font-weight-bold" style="font-size: 16px;">
                Pengajuan Permohonan
              </h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 form-group">
        <a href="{{ url('unit-kerja/menu-surat-perintah') }}">
          <div class="card card-primary card-outline text-center" style="height: 100%;">
            <div class="card-body">
              <p class="card-text mt-3">
                <img src="https://cdn-icons-png.flaticon.com/512/950/950295.png" height="70">
              </p>
            </div>
            <div class="card-footer">
              <h5 class="lead text-uppercase font-weight-bold" style="font-size: 16px;">
                Surat Perintah
              </h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 form-group">
        <a href="{{ url('unit-kerja/menu-surat-perintah') }}">
          <div class="card card-primary card-outline text-center" style="height: 100%;">
            <div class="card-body">
              <p class="card-text mt-3">
                <img src="https://cdn-icons-png.flaticon.com/512/609/609361.png" height="70">
              </p>
            </div>
            <div class="card-footer">
              <h5 class="lead text-uppercase font-weight-bold" style="font-size: 16px;">
                Pengiriman/Pengambilan
              </h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 form-group">
        <a href="{{ url('unit-kerja/menu-surat-perintah') }}">
          <div class="card card-primary card-outline text-center" style="height: 100%;">
            <div class="card-body">
              <p class="card-text mt-3">
                <img src="https://cdn-icons-png.flaticon.com/512/3601/3601157.png" height="70">
              </p>
            </div>
            <div class="card-footer">
              <h5 class="lead text-uppercase font-weight-bold" style="font-size: 16px;">
                Berita Acara Serah Terima
              </h5>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

@endsection