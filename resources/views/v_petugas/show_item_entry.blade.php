@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">
                    daftar barang masuk
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item"><a href="{{ url('petugas/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('petugas/aktivitas/daftar/pengiriman') }}">Daftar Penyimpanan</a></li>
                    <li class="breadcrumb-item active">daftar barang masuk</li>
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
                <div class="row">
                    <div class="col-md-12 form-group">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <table id="table1" class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Unit Kerja</thstyle=>
                                            <th>Nama Barang</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Kondisi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody class="text-capitalize text-center">
                                        @foreach($itemEntry as $dataItem)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $dataItem->workunit_name }}</td>
                                            <td>{{ $dataItem->item_name }}</td>
                                            <td>{{ $dataItem->item_description }}</td>
                                            <td>{{ $dataItem->item_qty }}</td>
                                            <td>{{ $dataItem->item_unit }}</td>
                                            <td>{{ $dataItem->item_condition_name }}</td>
                                            <td class="text-center">
                                                <a type="button" class="btn btn-primary" data-toggle="dropdown">
                                                    <i class="fas fa-bars"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item btn" href="{{ url('petugas/barang/detail/'. $dataItem->id_item) }}" >
                                                        <i class="fas fa-info-circle"></i> Detail
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#table1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true
        });
    });
</script>
@endsection

@endsection
