@extends('v_admin_master.layout.app')

@section('content')

@foreach($slot as $slot)
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">{{ $slot->warehouse_name }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('admin-master/show-warehouse') }}">Master Gudang</a></li>
          <li class="breadcrumb-item">
            <a href="{{ url('admin-master/detail-warehouse/'. $slot->id_warehouse) }}">{{ $slot->warehouse_name }}</a>
          </li>
          <li class="breadcrumb-item">{{ $slot->id_slot }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-tabs">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
          <li class="pt-2 px-3"><h3 class="card-title">{{ $slot->id_slot }}</h3></li>
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-entry-tab" data-toggle="pill" href="#custom-tabs-entry" role="tab" aria-controls="custom-tabs-entry" aria-selected="true">Barang Masuk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-exit-tab" data-toggle="pill" href="#custom-tabs-exit" role="tab" aria-controls="custom-tabs-exit" aria-selected="false">Barang Keluar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-item-tab" data-toggle="pill" href="#custom-tabs-item" role="tab" aria-controls="custom-tabs-item" aria-selected="false">Daftar Barang</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-two-tabContent">
          <div class="tab-pane fade show active" id="custom-tabs-entry" role="tabpanel" aria-labelledby="custom-tabs-entry-tab">
            <table id="table1" class="table m-0">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Item</th>
                  <th>Status</th>
                  <th>Popularity</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="badge badge-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="custom-tabs-exit" role="tabpanel" aria-labelledby="custom-tabs-exit-tab">
           Barang Keluar
          </div>
          <div class="tab-pane fade" id="custom-tabs-item" role="tabpanel" aria-labelledby="custom-tabs-item-tab">
           Barang
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endforeach

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
