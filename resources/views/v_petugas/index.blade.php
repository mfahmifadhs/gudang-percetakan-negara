@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Selamat Datang, <b>{{ Auth::user()->full_name }}</b></h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h4 class="font-weight-bold card-title">PENGIRIMAN</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($delivery as $dataDelivery)
                                    <div class="col-md-12">
                                        <span style="font-size: 12px;">{{ \Carbon\Carbon::parse($dataDelivery->order_dt)->isoFormat('DD MMMM Y') }}</span><br>
                                        <span style="font-size: 13px;" class="float-left"><label>{{ $dataDelivery->workunit_name }}</label></span>
                                        <span class="float-right">
                                            <h6>{{ $dataDelivery->order_total_item }}</h6>
                                        </span>
                                        <hr class="mt-4">
                                    </div>
                                    @endforeach
                                    <div class="col-md-12">
                                        <p class="mb-0" style="font-size: 14px;">
                                            <a href="{{ url('petugas/aktivitas/daftar/pengiriman') }}" class="fw-bold text-primary">
                                                <i class="fas fa-arrow-circle-right"></i> Lihat semua pengiriman
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h4 class="font-weight-bold card-title">PENGELUARAN</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($pickup as $pickup)
                                    <div class="col-md-12">
                                        <span style="font-size: 12px;">{{ \Carbon\Carbon::parse($pickup->order_dt)->isoFormat('DD MMMM Y') }}</span><br>
                                        <span style="font-size: 13px;" class="float-left"><label>{{ $pickup->workunit_name }}</label></span>
                                        <span class="float-right">
                                            <h6>{{ $pickup->workunit_id }}</h6>
                                        </span>
                                    </div>
                                    @endforeach
                                    <div class="col-md-12">
                                        <p class="mb-0" style="font-size: 14px;">
                                            <a href="{{ url('petugas/aktivitas/daftar/pengeluaran') }}" class="fw-bold text-primary">
                                                <i class="fas fa-arrow-circle-right"></i> Lihat semua pengeluaran
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 form-group">
                <div class="row">
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
                    <div class="col-md-12 form-group">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h4 class="font-weight-bold card-title mt-2">SURAT PERINTAH</h4>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-default" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="table-1" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tujuan</th>
                                            <th>Surat Perintah</th>
                                            <th>Pengirim</th>
                                            <th>Petugas</th>
                                            <th>Tanggal</th>
                                            <th>Total Barang</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($warrent as $dataWarrent)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                @if($dataWarrent->warr_purpose == 'penyimpanan')
                                                <span class="badge badge-success py-2">Penyimpanan</span>
                                                @else
                                                <span class="badge badge-danger py-2">Pengeluaran</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ asset('data_file/surat_perintah/'. $dataWarrent->warr_file) }}" download="">
                                                    {{ $dataWarrent->warr_file }}
                                                </a>
                                            </td>
                                            <td class="text-capitalize">{{ $dataWarrent->workunit_name }}</td>
                                            <td>{{ $dataWarrent->warr_emp_name.'/'.$dataWarrent->warr_emp_position }}</td>
                                            <td>{{ \Carbon\Carbon::parse($dataWarrent->warr_date)->isoFormat('DD/MM/YY') }}</td>
                                            <td>{{ $dataWarrent->warr_total_item }} barang</td>
                                            <td>
                                                @if($dataWarrent->warr_status == 'proses')
                                                <span class="badge badge-warning py-2">Menunggu Proses <br> Penapisan</span>
                                                @elseif($dataWarrent->warr_status == 'proses barang')
                                                <span class="badge badge-warning py-2">Proses <br> Barang</span>
                                                @elseif($dataWarrent->warr_status == 'konfirmasi')
                                                <span class="badge badge-warning py-2">Menunggu Konfirmasi <br> Unit Kerja</span>
                                                @else
                                                <span class="badge badge-success py-2">Selesai</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a type="button" class="btn btn-primary" data-toggle="dropdown">
                                                    <i class="fas fa-bars"></i>
                                                </a>
                                                <div class="dropdown-menu">

                                                    @if($dataWarrent->warr_status == 'proses')
                                                    <a class="dropdown-item" href="{{ url('petugas/surat-perintah/penapisan/'. $dataWarrent->id_warrent) }}">
                                                        <i class="fas fa-people-carry"></i> Proses
                                                    </a>
                                                    @elseif($dataWarrent->warr_status == 'proses barang')
                                                        @if($dataWarrent->warr_purpose == 'penyimpanan')
                                                        <a class="dropdown-item" href="{{ url('petugas/barang/penyimpanan/'. $dataWarrent->id_warrent) }}">
                                                            <i class="fas fa-people-carry"></i> Simpan Barang
                                                        </a>
                                                        @else
                                                        <a class="dropdown-item" href="{{ url('petugas/barang/pengeluaran/'. $dataWarrent->id_warrent) }}">
                                                            <i class="fas fa-people-carry"></i> Ambil Barang
                                                        </a>
                                                        @endif
                                                    @elseif($dataWarrent->warr_status == 'selesai')
                                                    @endif
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
<!-- /.content -->

@section('js')
<script>
    $(function() {
        $("#table-1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": false,
            "info": false,
            "ordering": false
        });
    });
</script>
@endsection

@endsection
