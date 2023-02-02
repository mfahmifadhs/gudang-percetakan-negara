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
            <div class="col-md-12 form-group col-12">
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
            <div class="col-md-12 form-group col-12">
                <div class="row">
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
                                <table id="table-1" class="table table-bordered table-striped" style="font-size: 15px;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Tanggal</th>
                                            <th>Unit Kerja</th>
                                            <th>Penanggung Jawab</th>
                                            <th class="text-center">Tujuan</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($warrent as $dataWarrent)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($dataWarrent->warr_date)->isoFormat('DD MMM Y') }}</td>
                                            <td class="text-capitalize">{{ $dataWarrent->workunit_name }}</td>
                                            <td class="text-capitalize">
                                                <h6>{{ $dataWarrent->warr_emp_name.'/'.$dataWarrent->warr_emp_position }}</h6>
                                                @if ($dataWarrent->warr_file)
                                                <span>Surat Perintah : </span>
                                                <a href="{{ asset('data_file/surat_perintah/'. $dataWarrent->warr_file) }}" download="">
                                                    {{ $dataWarrent->warr_file }}
                                                </a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($dataWarrent->warr_purpose == 'penyimpanan')
                                                <span class="badge badge-success py-2">Penyimpanan</span>
                                                @else
                                                <span class="badge badge-danger py-2">Pengeluaran</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $dataWarrent->warr_total_item }} barang</td>
                                            <td class="text-center">
                                                @if($dataWarrent->warr_status == 'proses')
                                                <span class="badge badge-warning badge-pill py-2">Menunggu Proses <br> Penapisan</span>
                                                @elseif($dataWarrent->warr_status == 'proses barang' || $dataWarrent->warr_status == 'konfirmasi')
                                                <span class="badge badge-warning badge-pill py-2">Barang Sudah <br> Dapat Diproses</span>
                                                @else
                                                <span class="badge badge-success badge-pill py-2">Selesai</span>
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
                                                    @elseif($dataWarrent->warr_status == 'proses barang' || $dataWarrent->warr_status == 'konfirmasi')
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
            "lengthChange": true,
            "autoWidth": true,
            "paging": true,
            "info": true,
            "ordering": true,
            "columnDefs": [{
                    "width": "5%",
                    "targets": 0
                },
                {
                    "width": "10%",
                    "targets": 1
                },
                {
                    "width": "20%",
                    "targets": 3
                },
                {
                    "width": "10%",
                    "targets": 4
                },
                {
                    "width": "10%",
                    "targets": 5
                },
                {
                    "width": "5%",
                    "targets": 6
                },
                {
                    "width": "0%",
                    "targets": 7
                },
            ]
        });
    });
</script>
@endsection

@endsection
