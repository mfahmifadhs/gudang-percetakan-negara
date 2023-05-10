<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dist/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<style>
    @media print {
        .pagebreak {
            page-break-after: always;
        }

        .table-data {
            border: 1px solid;
            font-size: 20px;
        }

        .table-data th,
        .table-data td {
            border: 1px solid;
        }

        .table-data thead th,
        .table-data thead td {
            border: 1px solid;
        }
    }

    .divTable {
        border-top: 1px solid;
        border-left: 1px solid;
        border-right: 1px solid;
        font-size: 21px;
    }

    .divThead {
        border-bottom: 1px solid;
        font-weight: bold;
    }

    .divTbody {
        border-bottom: 1px solid;
        text-transform: capitalize;
    }

    .divTheadtd {
        border-right: 1px solid;
    }

    .divTbodytd {
        border-right: 1px solid;
        padding: 10px;
    }
</style>

<body style="font-family: Arial;">
    <section class="content m-5">
        <div class="form-group row">
            @if ($position == 'middle')
                <div class="col-md-6" style="margin-top: 51.2%;"></div>
                <div class="col-md-6" style="margin-top: 51.2%;"></div>
            @endif
            @if ($position == 'bottom')
                <div class="col-md-6" style="margin-top: 51.2%;"></div>
                <div class="col-md-6" style="margin-top: 51.2%;"></div>
                <div class="col-md-6" style="margin-top: 51.2%;"></div>
                <div class="col-md-6" style="margin-top: 51.2%;"></div>
            @endif
            @for ($i = 0; $i < $qty; $i++)
            <div class="col-md-6 p-4 mt-5">
                <div class="card border border-dark">
                    <div class="card-header">
                        <div class="form-group row text-center">
                            <div class="col-md-2">
                                <img src="{{ asset('dist/img/logo-kemenkes-icon.png') }}" width="100">

                            </div>
                            <div class="col-md-8" >
                                <h2 class="pt-1" style="font-weight: 1000;">Gudang Percetakan Negara</h2>
                                <h5 style="font-weight: 1000;">Jl. Percetakan Negara II No.23, RW.7, Johar Baru, Kec. Johar Baru, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10440</h5>
                            </div>
                            <div class="col-md-2">
                                <img src="{{ asset('dist/img/logo-germas.png') }}" width="100">
                            </div>
                        </div>
                    </div>
                    <div class="card-body border border-dark">
                        <div class="text-center">
                            <p>
                            {{ QrCode::size(500)->generate('https://gudangpn.kemkes.go.id/detail/barang/'.Crypt::encrypt($item->id_detail)) }}
                            </p>
                            <h3 style="font-family: roboto;font-weight: 1000;" class="text-middle">
                                {{ $item->nama_barang.' '.$item->pengajuan->unitkerja->nama_unit_kerja }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            @if (($i+1) % 6 == 0)
                <p class="pagebreak"></p>
            @endif
            @endfor
        </div>
    </section>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
