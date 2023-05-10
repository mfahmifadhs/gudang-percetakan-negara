<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Barang</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('dist_admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
</head>

<body>

    <!-- Content Header -->
    <section class="content-header">
        <div class="container">
            <div class="row text-capitalize">
                <div class="col-sm-6">
                    <h4>Informasi Barang</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Informasi Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Content Header -->

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 form-group">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>
                    @elseif ($message = Session::get('failed'))
                    <div class="alert alert-danger">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>
                    @endif
                </div>
                <div class="col-md-12 form-group text-capitalize">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-4">Tanggal Masuk</label>
                                <div class="col-8">:
                                    {{ \Carbon\carbon::parse($item->order_dt)->isoFormat('DD MMMM Y') }} /
                                    Pukul {{ \Carbon\carbon::parse($item->order_tm)->isoFormat('HH:mm') }}
                                </div>
                                <label class="col-4">Unit Kerja</label>
                                <div class="col-8">: {{ $item->workunit_name }}</div>
                                <label class="col-4">Nama Barang</label>
                                <div class="col-8">: {{ $item->item_name }}</div>
                                <label class="col-4">Deskripsi</label>
                                <div class="col-8">: {{ $item->item_merktype }}</div>
                                <label class="col-4">Keterangan</label>
                                <div class="col-8">: {{ $item->item_description }}</div>
                                <label class="col-4">Jumlah</label>
                                <div class="col-8">: {{ $item->item_qty.' '.$item->item_unit }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

</body>

</html>
