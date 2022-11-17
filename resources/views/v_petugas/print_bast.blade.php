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
    <style type="text/css">
        @media print {
            footer {page-break-after: always;}
        }
    </style>
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
                <h2 class="page-header">
                    <h5 style="font-size: 30px;"><b>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</b></h5>
                    <h6 class="text-uppercase" style="font-size: 30px;"><b>{{ $bast->mainunit_name }}</b></h6>
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
        <div class="row text-capitalize" style="font-size: 22px;">
            <div class="col-md-12 form-group text-capitalize">
                <p class="m-0">Perihal : {{ $bast->order_category }} Barang</p>
            </div>
            <div class="col-md-12 mt-4">
                <div class="form-group row">
                    <div class="col-md-12 text-justify">
                        Pada hari ini, {{ \Carbon\Carbon::parse($bast->order_dt)->isoFormat('dddd') }}
                        Tanggal {{ \Carbon\Carbon::parse($bast->order_dt)->isoFormat('DD') }}
                        Bulan {{ \Carbon\Carbon::parse($bast->order_dt)->isoFormat('MMMM') }}
                        Tahun {{ \Carbon\Carbon::parse($bast->order_dt)->isoFormat('YYYY') }}
                        bertempat di Kompleks Perkantoran dan Pergudangan Kementerian Kesehatan RI
                        Jl. Percetakan Negara II No.23 Jakarta Pusat, kami yang bertanda tangan dibawah ini:
                    </div>
                </div>
                <div class="form-group row">
                    <span class="col-sm-2 ml-4">Nama</span>
                    <span class="col-sm-9">: Nurhuda</span>
                    <span class="col-sm-2 ml-4">Jabatan</span>
                    <span class="col-sm-9">: Pengelola Gudang</span>
                    <span class="col-sm-2 ml-4">Unit Kerja</span>
                    <span class="col-sm-9">: Biro Umum</span>
                    <div class="col-md-12 mt-3">
                        Dalam berita acara ini bertindak untuk dan atas nama Biro Umum Sekretariat Jenderal Pengelola Gudang
                        yang selanjutnya disebut <span class="font-weight-bold"> PIHAK PERTAMA </span>.
                    </div>
                    <span class="col-sm-2 ml-4 mt-2">Nama</span>
                    <span class="col-sm-9 mt-2">: {{ $bast->order_emp_name }}</span>
                    <span class="col-sm-2 ml-4">Jabatan</span>
                    <span class="col-sm-9">: {{ $bast->order_emp_position }}</span>
                    <span class="col-sm-2 ml-4">Unit Kerja</span>
                    <span class="col-sm-9">: {{ $bast->workunit_name }}</span>
                    <div class="col-md-12 mt-3">
                        Dalam berita acara ini bertindak untuk dan atas nama <span class="font-weight-bold">
                            {{ $bast->workunit_name.' '.$bast->mainunit_name }} </span> selaku pengirim barang yang selanjutnya disebut PIHAK
                        <span class="font-weight-bold"> KEDUA </span>.
                    </div>
                    <div class="col-md-12 mt-3">
                        Bahwa PIHAK PERTAMA telah menerima/menyerahkan barang dari/kepada PIHAK KEDUA dengan rincian sebagai berikut:
                    </div>
                </div>
            </div>
            <div class="col-12 table-responsive">
                <table class="table table-striped m-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Kondisi</th>
                        </tr>
                    </thead>
                    <?php $no = 1; ?>
                    <tbody>
                        @foreach($item as $i => $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->item_description }}</td>
                            <td>{{ $item->total_item }}</td>
                            <td>{{ $item->item_unit }}</td>
                            <td>{{ $item->item_condition_name }}</td>
                        </tr>
                        @if($i % 3 == 2 ) <p style="page-break-after: avoid;"></p> @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-12 form-group mb-4">
                <p class="text-justify mt-4">
                    Barang diterima/diserahkan sesuai dengan catatan kondisi yang tertera dalam surat perintah yang merupakan satu kesatuan dari berita acara ini. Demikian Berita Acara Serah Terima Barang ini dibuat sebagai bukti yang sah sebanyak 2 rangkap dan ditandatangani oleh <span class="font-weight-bold">PIHAK PERTAMA</span> dan <span class="font-weight-bold">PIHAK KEDUA</span>.
                </p>
            </div>
            <div class="col-md-12">
                <div class="page">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <h5 class="font-weight-bold text-center">PIHAK PERTAMA</h5>
                            <h5 class="text-underline" style="margin-top: 20%;">Nurhuda</h5>
                            <h5>Pengelola Gudang</h5>
                        </div>
                        <div class="col-md-6">
                            <h5 class="font-weight-bold text-center">PIHAK KEDUA</h5>
                            <h5 class="text-underline text-capitalize" style="margin-top: 20%;">{{ $bast->order_emp_name }}</h5>
                            <h5 class="text-capitalize">{{ $bast->order_emp_position }}</h5>
                        </div>
                    </div>
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
