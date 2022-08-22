@extends('v_petugas.layout.app')

@section('css')
<style type="text/css" media="print">
  @page 
  {
    size: auto;   /* auto is the initial value */
    margin: 0mm;  /* this affects the margin in the printer settings */
    margin-top: -22vh;
    margin-left: -1.8vh;
  }
  .header-confirm .header-text-confirm {
    padding-top: 8vh;
    line-height: 2vh;
  }
  .header-confirm img {
    margin-top: 3vh;
    height: 2vh;
    width: 2vh;
  }
  .print, .pdf, .logo-header, .nav-right {
    display: none;
  }
  nav, footer {
    display: none;
  }
</style>
@endsection

@section('content')

<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Berita Acara Serah Terima</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('unit-kerja/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Daftar Pengiriman Barang</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- Content Header -->

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 form-group">
        <a href="{{ url('petugas/dashboard') }}" class="btn btn-primary print mr-2">
          <i class="fas fa-home"></i>
        </a>
        <a href="{{ url('petugas/cetak-bast/'. $bast->id_order) }}" rel="noopener" target="_blank" class="btn btn-danger pdf">
          <i class="fas fa-print"></i>
        </a>
      </div>
      <div class="col-md-12 form-group ">
        <div style="background-color: white;margin-right: 15%;margin-left: 15%;padding:2%;">
          <div class="row">
            <div class="col-md-2">
              <h2 class="page-header">
                <img src="{{ asset('dist/img/logo-kemenkes-icon.png') }}">
              </h2>
            </div>
            <div class="col-md-8 text-center">
              <h2 class="page-header">
                <h5><b>BERITA ACARA SERAH TERIMA BARANG</b></h5>
                <h5><b>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</b></h5>
                <h6 class="text-uppercase"><b>{{ $bast->mainunit_name }}</b></h6>
                <p><i>Jl. H.R. Rasuna Said Blok X.5 Kav. 4-9, Blok A, 2nd Floor, Jakarta 12950<br>Telp.: (62-21) 5201587, 5201591 Fax. (62-21) 5201591</i></p>
              </h2>
            </div>
            <div class="col-md-2">
              <h2 class="page-header">
                <img src="{{ asset('dist/img/logo-germas.png') }}" style="width: 128px; height: 128px;">
              </h2>
            </div>
            <div class="col-md-12">
              <hr style="border-width: medium;border-color: black;">
            </div>
            <div class="col-md-12">
              <p class="m-0">Nomor    : {{ $bast->id_order }}</p>
              <p class="m-0">Perihal : {{ $bast->order_category }} Barang</p>
            </div>
            <div class="col-md-12 mt-4">
              <p class="text-justify">
                Pada hari ini, {{ \Carbon\Carbon::parse($bast->order_dt)->isoFormat('dddd') }} 
                Tanggal {{ \Carbon\Carbon::parse($bast->order_dt)->isoFormat('DD') }} 
                Bulan   {{ \Carbon\Carbon::parse($bast->order_dt)->isoFormat('MMMM') }} 
                Tahun   {{ \Carbon\Carbon::parse($bast->order_dt)->isoFormat('YYYY') }} 
                bertempat di Kompleks Perkantoran dan Pergudangan Kementerian Kesehatan RI 
                Jl. Percetakan Negara II No.23 Jakarta Pusat, kami yang bertanda tangan dibawah ini:
              </p>
              <p class="m-0 ml-4 text-capitalize">
                Nama    <span style="margin-left: 2vh;">  : Nurhuda </span></p> 
              <p class="text-capitalize ml-4">
                Jabatan <span style="margin-left: 1vh;">    : Pengelola Gudang</span></p>
              <p>
                Dalam berita acara ini bertindak untuk dan atas nama Biro Umum Sekretariat Jenderal Pengelola Gudang yang selanjutnya disebut <span class="font-weight-bold"> PIHAK PERTAMA </span>.
              </p>
              <p class="m-0 ml-4 text-capitalize">
                Nama    <span style="margin-left: 2vh;">  : {{ $bast->order_emp_name }} </span></p> 
              <p class="ml-4 text-capitalize">
                Jabatan <span style="margin-left: 1vh;">    : {{ $bast->order_emp_position }}</span></p>
              <p>
                Dalam berita acara ini bertindak untuk dan atas nama <span class="font-weight-bold"> {{ $bast->workunit_name.' '.$bast->mainunit_name }} </span> selaku pengirim barang yang selanjutnya disebut PIHAK <span class="font-weight-bold"> KEDUA </span>.
              </p>
              <p class="mt-4 m-0">
                Bahwa PIHAK PERTAMA telah menerima/menyerahkan barang dari/kepada PIHAK KEDUA dengan rincian sebagai berikut:
              </p>
            </div>
            <div class="col-12 table-responsive">
              <table class="table table-striped mt-4">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>NUP</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Kondisi</th>
                    <th>Tahun</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <?php $no = 1;?>
                <tbody>
                  @foreach($item as $item)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->in_item_code }}</td>
                    <td>{{ $item->in_item_nup }}</td>
                    <td>{{ $item->in_item_name }}</td>
                    <td>
                      @if($item->order_category == 'Pengiriman')
                        {{ $item->in_item_qty }}
                      @else
                        {{ $item->ex_item_qty }}
                      @endif
                    </td>
                    <td>{{ $item->in_item_unit }}</td>
                    <td>{{ $item->item_condition_name }}</td>
                    <td>{{ $item->in_item_purchase }}</td>
                    <td>{{ $item->in_item_description }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="col-md-12 form-group mb-4">
              <p class="text-justify mt-4">
                Barang diterima/diserahkan sesuai dengan catatan kondisi yang tertera dalam surat perintah yang merupakan satu kesatuan dari berita acara ini. Demikian Berita Acara Serah Terima Barang ini dibuat sebagai bukti yang sah sebanyak 2 rangkap dan ditandatangani oleh <span class="font-weight-bold">PIHAK PERTAMA</span> dan <span class="font-weight-bold">PIHAK KEDUA</span>. 
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


@endsection