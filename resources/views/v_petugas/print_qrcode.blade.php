<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CETAK QR CODE</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dist-admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist-admin/css/adminlte.css') }}">
    <style type="text/css">
        @media print {
            @page {
                size: 10cm 15cm;
                /* auto is the initial value */
                margin: 0;
                /* this affects the margin in the printer settings */
                border: 1px solid red;
                /* set a border for all printed pages */
            }
            footer {page-break-after: always;}
        }

        label #satu {
            font-size: 100px;
            text-transform: capitalize;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p class="fw-light" style="margin: auto;">{{ $message }}</p>
                    </div>
                    @endif
                    @if ($message = Session::get('failed'))
                    <div class="alert alert-danger">
                        <p class="fw-light" style="margin: auto;">{{ $message }}</p>
                    </div>
                    @endif
                </div>
                @foreach($item as $i => $dataItem)
                <div class="col-12" style="padding:2vh;">
                    <table border="1" style="width: 100%;">
                        <tr>
                            <td style="width: 60%;">
                                <center><label style="font-size: 70px;text-transform:capitalize;">{{ $dataItem->workunit_name }}</label></center>
                            </td>
                            <td style="width: 40%;">
                                <center><img src="{{ asset('dist/img/logo-kemenkes-icon.png') }}" width="250"></center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center><label style="font-size: 70px;text-transform:capitalize;">{{ $dataItem->in_item_name.' '.$dataItem->in_item_merk }}</label></center>
                            </td>
                            <td rowspan="5" style="padding: 12px;text-align:center;margin-top: 5vh;text-transform:capitalize;">
                                {!! QrCode::size(400)->generate("DETAIL INFORMASI BARANG : \n\n".
                                    "Asal Unit Kerja : \n".$dataItem->workunit_name. "\n\n".
                                    "Nama Barang : \n".$dataItem->in_item_name. "\n\n".
                                    "Keterangan : \n".$dataItem->in_item_merk. "\n\n".
                                    "Jumlah : \n".$dataItem->in_item_qty.' '.$dataItem->in_item_unit. "\n\n".
                                    "Tanggal Masuk : \n".\Carbon\Carbon::parse($dataItem->order_dt)->isoFormat('DD MMMM Y'). "\n\n".
                                    "Lokasi Penyimpanan : \n". $dataItem->id_slot." / ".$dataItem->warehouse_name

                                    ) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center><label style="font-size: 70px;text-transform:capitalize;">{{ $dataItem->id_slot.' / '.$dataItem->warehouse_name }}</label></center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center><label style="font-size: 70px;text-transform:capitalize;">Tanggal Masuk : {{ \Carbon\Carbon::parse($dataItem->order_dt)->isoFormat('DD MMMM Y') }}</label></center>
                            </td>
                        </tr>

                    </table>
                </div>
                @if($i % 3 == 2 ) <p style="page-break-before: always;"></p> @endif
                @endforeach
            </div>
        </section>
    </div>

    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
