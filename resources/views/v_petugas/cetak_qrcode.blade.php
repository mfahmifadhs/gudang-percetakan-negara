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
                <div class="col-12">
                    <table border="1" style="width: 100%;padding:20px;">
                        <tr>
                            <td><center><img src="{{ asset('dist/img/logo-kemenkes-icon.png') }}" width="250"></center></td>
                            <td><center><label style="font-size: 100px;text-transform:capitalize;">{{ $item->in_item_name.' Merk '.$item->in_item_merk }}</label></center></td>
                        </tr>
                        <tr>
                            <td><center><label style="font-size: 70px;text-transform:capitalize;">{{ $item->id_slot.' / '.$item->warehouse_name }}</label></center></td>
                            <td rowspan="3" style="padding: 12px;text-align:center">
                                {!! QrCode::size(600)->generate('https://www.inventory-testing.com/'.$item->id_item_incoming) !!}
                            </td>
                        </tr>
                        <tr>
                            <td><center><label style="font-size: 70px;text-transform:capitalize;">{{ $item->workunit_name }}</label></center></td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
