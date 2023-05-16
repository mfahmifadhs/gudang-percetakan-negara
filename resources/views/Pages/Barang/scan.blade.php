<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $item->id_detail }}</title>

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

<body style="font-family: Arial;margin-bottom: 20vh;" class="mt-2">
    <div class="wrapper">
        <section class="content">
            <div class="container">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p style="color:white;margin: auto;">{{ $message }}</p>
                </div>
                @endif
                @if ($message = Session::get('failed'))
                <div class="alert alert-danger">
                    <p style="color:white;margin: auto;">{{ $message }}</p>
                </div>
                @endif
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <div class="row text-center">
                            <div class="col-2">
                                <img src="{{ asset('dist/img/logo-kemenkes-icon.png') }}" width="50">
                            </div>
                            <div class="col-8">
                                <h6 class="mt-2">
                                    Gudang Percetakan Negara <br>
                                    <small style="font-size: 9px;">
                                        Jl. H.R. Rasuna Said Blok X.5 Kav. 4-9, Jakarta 12950
                                        Telepon : (021) 5201590
                                    </small>
                                </h6>
                            </div>
                            <div class="col-2">
                                <img src="{{ asset('dist/img/logo-germas.png') }}" width="50">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group row small">

                                    <div class="col-12 form-group">
                                        <label> Unit Kerja </label>
                                        <p>{{ $item->pengajuan->unitkerja->nama_unit_kerja }}</p>
                                    </div>

                                    <div class="col-6 form-group">
                                        <label> Tanggal Masuk </label>
                                        <p>{{ \Carbon\carbon::parse($item->tanggal_pengajuan)->isoFormat('DD MMMM Y') }}</p>
                                    </div>

                                    <div class="col-6 form-group">
                                        <label> Jumlah </label>
                                        <p>{{ (int) $item->jumlah_diterima.' '.$item->satuan }}</p>
                                    </div>

                                    <div class="col-6 form-group">
                                        <label> Nama Barang </label>
                                        <p>{{ $item->nama_barang }}</p>
                                    </div>

                                    <div class="col-6 form-group">
                                        <label> Merek/Tipe </label>
                                        <p>{{ $item->deskripsi }}</p>
                                    </div>

                                    <div class="col-6 form-group">
                                        <label> Tahun Perolehan </label>
                                        <p>{{ $item->tahun_perolehan }}</p>
                                    </div>

                                    <div class="col-6 form-group">
                                        <label>{{ $item->jenis_barang_id == 441 ? 'NUP' : 'Masa Kadaluarsa' }} </label>
                                        <p>{{ $item->catatan }}</p>
                                    </div>

                                    <div class="col-12 form-group">
                                        <label>{{ $item->jenis_barang == 441 ? 'Proses Penghapusan' : 'Rencana Distribusi' }} </label>
                                        <p>{{ $item->keterangan }}</p>
                                    </div>

                                    <div class="col-12 form-group">
                                        <label>Lokasi Penyimpanan</label>
                                        <hr class="m-0 mb-2">
                                        @foreach($item->slot as $i => $row)
                                        <div class="row">
                                            <div class="col-2 text-center mt-4">
                                                {{ $i+1 }}
                                            </div>
                                            <div class="col-10">
                                                <div class="form-group row">
                                                    <div class="col-5">Gedung</div>:
                                                    <div class="col-6">{{ $row->nama_gedung }}</div>
                                                    <div class="col-5">Kode Palet</div>:
                                                    <div class="col-6">{{ $row->kode_palet }}</div>

                                                    <div class="col-5">Jumlah Masuk</div>:
                                                    <div class="col-6">{{ (int) $row->total_masuk.' '.$item->satuan }}</div>
                                                    <div class="col-5">Jumlah Keluar</div>:
                                                    <div class="col-6">{{ (int) $row->total_keluar.' '.$item->satuan }}</div>
                                                    <div class="col-5">Sisa Stok</div>:
                                                    <div class="col-6">{{ (int) $row->total_masuk - $row->total_keluar.' '.$item->satuan }}</div>
                                                    <div class="col-5">Riwayat</div>:
                                                    <div class="col-6">
                                                        <a type="button" class="text-primary" data-toggle="modal" data-target="#exampleModal">
                                                            Lihat Riwayat
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <hr class="m-0 mb-2">
                                            </div>
                                        </div>
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title" id="exampleModalLabel">Riwayat Barang</h6>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-2">No</div>
                                                            <div class="col-4">Tanggal</div>
                                                            <div class="col-3">Kategori</div>
                                                            <div class="col-3">Jumlah</div>
                                                        </div>
                                                        <hr class="mb-2 mt-2">
                                                        @foreach ($row->history as $i => $subRow)
                                                        <div class="row">
                                                            <div class="col-2">{{ $i + 1 }}</div>
                                                            <div class="col-4">
                                                                {{ \Carbon\carbon::parse($subRow->created_at)->isoFormat('DD/MM/Y') }}
                                                            </div>
                                                            <div class="col-3">
                                                                {{ $subRow->kategori == 'masuk' ? 'Penyimpanan' : 'Pengambilan' }}
                                                            </div>
                                                            <div class="col-3">
                                                                {{ $subRow->jumlah.' '.$item->satuan }}
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>


<!-- jQuery -->
<script src="{{ asset('dist/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</html>
