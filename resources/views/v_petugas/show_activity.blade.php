@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daftar Pengiriman Barang</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('Petugas/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Daftar Pengiriman Barang</li>
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
        <table id="table1" class="table table-responsive table-bordered">
          <thead class="text-center">
            <tr>
              <th style="width: 1%">No</th>
              <th style="width: 20%">Unit Kerja</th>
              <th style="width: 20%">Pengirim / Jabatan</th>
              <th style="width: 10%;">Jumlah</th>
              <th style="width: 20%">Jam / Tanggal</th>
              <th></th>
            </tr>
          </thead>
          <?php $no = 1;?>
          <tbody class="text-capitalize text-center">
            @foreach($activity as $activity)
              <tr>
                <td>{{ $no++ }} </td>
                <td>{{ $activity->workunit_name }} </td>
                <td>{{ $activity->order_emp_name.' / '.$activity->order_emp_position }} </td>
                <td>{{ $activity->totalitem }} Barang</td>
                <td>{{ $activity->order_tm .' / '.\Carbon\Carbon::parse($activity->order_dt)->isoFormat('DD MMMM Y') }}</td>
                <td>
                  <a class="btn btn-primary btn-sm" rel="noopener" target="_blank" href="{{ url('petugas/cetak-bast/'.$activity->id_order) }}">
                    <i class="fas fa-file"></i> <br> BAST
                  </a>
                  <a class="btn btn-primary btn-sm" href="{{ url('petugas/barang/cari/'. $activity->id_order) }}">
                    <i class="fas fa-box"></i> <br> Barang
                  </a>
                  <a class="btn btn-primary btn-sm" href="{{ url('petugas/barang/kelengkapan-barang/'. $activity->id_order) }}">
                    <i class="fas fa-edit"></i> <br> Kelengkapan
                  </a>
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
  $(function () {
    $("#table1").DataTable({
      "responsive": true, "lengthChange": true  , "autoWidth": true ,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $("#table2").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "searching":true, "paging": true, "info": true,
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      "buttons": ["print","pdf","excel"]
    }).buttons().container().appendTo('#table4_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection

@endsection
