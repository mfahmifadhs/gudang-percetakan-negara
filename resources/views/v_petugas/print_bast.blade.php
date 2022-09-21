<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Informasi Pergudangan Kementerian Kesehatan Republik Indonesia</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('dist/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body>
<div class="wrapper">
  <div class="row">
    <div class="col-md-2">
      <h2 class="page-header ml-4">
        <img src="{{ asset('dist/img/logo-kemenkes-icon.png') }}">
      </h2>
    </div>
    <div class="col-md-8 text-center">
      <h2 class="page-header" >
        <h5 style="font-size: 26px;"><b>BERITA ACARA SERAH TERIMA BARANG</b></h5>
        <h5 style="font-size: 26px;"><b>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</b></h5>
        <h6 class="text-uppercase" style="font-size: 26px;"><b>{{ $bast->mainunit_name }}</b></h6>
        <p style="font-size: 20px;"><i>Jl. H.R. Rasuna Said Blok X.5 Kav. 4-9, Blok A, 2nd Floor, Jakarta 12950<br>Telp.: (62-21) 5201587, 5201591 Fax. (62-21) 5201591</i></p>
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
  </div>
  <div class="row" style="font-size: 22px;">
    <div class="col-md-12 form-group">
      <p class="m-0">Nomor    : {{ $bast->id_order }}</p>
      <p class="m-0">Perihal : {{ $bast->order_category }} Barang</p>
    </div>
    <div class="col-md-12 form-group">
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
      <table class="table table-striped m-0">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>NUP</th>
            <th>Nama Barang</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Kondisi</th>
            <th>Tahun</th>
          </tr>
        </thead>
        <?php $no = 1;?>
        <tbody>
          @foreach($item as $i => $item)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $item->item_code }}</td>
            <td>{{ $item->item_nup }}</td>
            <td>{{ $item->item_name }}</td>
            <td>{{ $item->item_description }}</td>
            <td>{{ $item->total_item }}</td>
            <td>{{ $item->item_unit }}</td>
            <td>{{ $item->item_condition_name }}</td>
            <td>{{ $item->item_purchase }}</td>
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
    <div class="col-md-6 form-group mt-4">
      <div class="text-center">
        <h5 class="font-weight-bold text-center">PIHAK PERTAMA</h5>

        <p style="margin-top: 30%;">
          <h6 class="text-underline">Nurhuda</h6>
          <div style="border: 1px; width: 20%;"></div>
          <h6>Pengelola Gudang</h6>
        </p>
      </div>

    </div>
    <div class="col-md-6 form-group mt-4">
      <div class="text-center">
        <h5 class="font-weight-bold text-center">PIHAK KEDUA</h5>

        <p style="margin-top: 30%;">
          <h6 class="text-underline text-capitalize">{{ $bast->order_emp_name }}</h6>
          <div style="border: 1px; width: 20%;"></div>
          <h6 class="text-capitalize">{{ $bast->order_emp_position }}</h6>
        </p>
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
