@extends('Layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">Gudang Percetakan Negara</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('warehouse.show') }}">Daftar Gedung</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('warehouse.detail', $storage->gedung_id) }}">
                            {{ $storage->gedung->nama_gedung }}
                        </a></li>
                    <li class="breadcrumb-item active">{{ $storage->kode_palet }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    Detail Penyimpanan
                </h3>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-4">Nama Gedung </label>
                    <div class="col-md-10 col-8">: {{ $storage->gedung->nama_gedung }}</div>
                    <label class="col-md-2 col-4">Kode Palet </label>
                    <div class="col-md-10 col-8">: {{ $storage->kode_palet }}</div>
                    <label class="col-md-2 col-4">Keterangan </label>
                    <div class="col-md-10 col-8">: {{ $storage->keterangan }}</div>
                </div>
            </div>
            <div class="card-footer">
                <h4>Barang Masuk</h4>
            </div>
            <div class="card-body">
                <table id="table-item-in" class="table" style="font-size: medium;">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Tanggal</td>
                            <td>Deskripsi Barang</td>
                            <td>Volume</td>
                            <td>Satuan</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="card-footer">
                <h4>Barang Keluar</h4>
            </div>
            <div class="card-body">
                <table id="table-item-out" class="table" style="font-size: medium;">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Tanggal</td>
                            <td>Deskripsi Barang</td>
                            <td>Volume</td>
                            <td>Satuan</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#table-item-in").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true,
            "columnDefs": [{
                "width": "5%",
                "targets": 0,

            }, {
                "width": "15%",
                "targets": 1
            }, {
                "width": "0%",
                "targets": 6
            }]
        }).buttons().container().appendTo('#table-item-in_wrapper .col-md-6:eq(0)')
    })

    $(function() {
        $("#table-item-out").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true,
            "columnDefs": [{
                "width": "5%",
                "targets": 0,

            }, {
                "width": "15%",
                "targets": 1
            }, {
                "width": "0%",
                "targets": 6
            }]
        }).buttons().container().appendTo('#table-item-in_wrapper .col-md-6:eq(0)')
    })
</script>
@endsection

@endsection
