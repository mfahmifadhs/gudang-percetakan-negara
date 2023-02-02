@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">daftar {{ $id }} barang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item"><a href="{{ url('petugas/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">daftar {{ $id }} barang</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Barang Masuk</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="table-1" class="table table-bordered" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Jam / Tanggal</th>
                            <th>Unit Kerja</th>
                            <th>Pengirim / Jabatan</th>
                            <th class="text-center">Total Barang</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody class="text-capitalize">
                        @foreach($activity as $activity)
                        <tr>
                            <td class="text-center">{{ $no++ }} </td>
                            <td class="text-center">
                                {{ \Carbon\carbon::parse($activity->order_tm)->isoFormat('HH:mm') }} /
                                {{ \Carbon\carbon::parse($activity->order_dt)->isoFormat('DD MMM Y') }}
                            </td>
                            <td>{{ $activity->workunit_name }} </td>
                            <td>{{ $activity->order_emp_name.' / '.$activity->order_emp_position }} </td>
                            <td class="text-center">{{ $activity->order_total_item }} barang</td>
                            <td class="text-center">
                                <a type="button" class="btn btn-primary" data-toggle="dropdown">
                                    <i class="fas fa-bars"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item btn" rel="noopener" target="_blank" href="{{ url('petugas/buat-bast/'.$activity->id_order) }}">
                                        <i class="fas fa-file"></i> BAST
                                    </a>
                                    <a class="dropdown-item btn" href="{{ url('petugas/barang/cari/'. $activity->id_order) }}">
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
</section>

@section('js')
<script>
    $(function() {
        $("#table-1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true,
            "columnDefs": [{
                "width": "0%",
                "targets": 0,

            },{
                "width": "12%",
                "targets": 1
            },{
                "width": "0%",
                "targets": 5
            }]
        }).buttons().container().appendTo('#table-1_wrapper .col-md-6:eq(0)')
    })
</script>
@endsection

@endsection
