@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
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
        <a href="{{ url('petugas/pengiriman-barang') }}" class="btn btn-primary btn-lg form-control"
        style="height: 15vh;padding: 3vh;">
          <img src="https://cdn-icons-png.flaticon.com/512/1524/1524539.png" height="50%">
          <p class="font-weight-bold mt-2">PENGIRIMAN BARANG</p>
        </a>
      </div>
      <div class="col-md-3 form-group">
        <a href="{{ url('petugas/pengeluaran-barang') }}" class="btn btn-primary btn-lg form-control"
        style="height: 15vh;padding: 3vh;">
          <img src="https://cdn-icons-png.flaticon.com/512/1524/1524539.png" height="50%">
          <p class="font-weight-bold mt-2">PENGELUARAN BARANG</p>
        </a>
      </div>
      <div class="col-md-3 form-group">
        <a href="#" class="btn btn-primary btn-lg form-control" style="height: 15vh;padding: 3vh;">
          <img src="https://cdn-icons-png.flaticon.com/512/1524/1524539.png" height="50%">
          <p class="font-weight-bold mt-2">BUAT SURAT PERINTAH</p>
        </a>
      </div>
      <div class="col-md-3 form-group">
        <a href="#" class="btn btn-primary btn-lg form-control" style="height: 15vh;padding: 3vh;">
          <img src="https://cdn-icons-png.flaticon.com/512/1524/1524539.png" height="50%">
          <p class="font-weight-bold mt-2">BUAT SURAT PERINTAH</p>
        </a>
      </div>
      <div class="col-md-3 form-group">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h4 class="font-weight-bold card-title">PENGIRIMAN</h4>
              </div>
              <div class="card-body">
                <div class="row">
                @foreach($delivery as $delivery)
                  <div class="col-md-12">
                    <span style="font-size: 12px;">{{ \Carbon\Carbon::parse($delivery->order_dt)->isoFormat('DD MMMM Y') }}</span><br>
                    <span style="font-size: 13px;" class="float-left"><label>{{ $delivery->workunit_name }}</label></span>
                    <span class="float-right"><h6>{{ $delivery->workunit_id }}</h6></span>
                    <hr class="mt-4">
                  </div>
                @endforeach
                  <div class="col-md-12">
                    <p class="mb-0" style="font-size: 14px;">
                      <a href="{{ url('petugas/daftar-aktivitas/pengiriman') }}" class="fw-bold text-primary">
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
                    <span class="float-right"><h6>{{ $pickup->workunit_id }}</h6></span>
                  </div>
                @endforeach
                  <div class="col-md-12">
                    <p class="mb-0" style="font-size: 14px;">
                      <a href="{{ url('petugas/daftar-aktivitas/pengeluaran') }}" class="fw-bold text-primary">
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
                      <th>No. Surat</th>
                      <th>Pengirim</th>
                      <th>Petugas</th>
                      <th>Tanggal Pengiriman</th>
                      <th>Total Barang</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <?php $no = 1;?>
                  <tbody>
                    @foreach($warrent as $warrent)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td class="text-uppercase">{{ $warrent->warr_num }}</td>
                      <td class="text-capitalize">{{ $warrent->workunit_name }}</td>
                      <td>{{ $warrent->warr_name }}</td>
                      <td>{{ \Carbon\Carbon::parse($warrent->warr_dt)->isoFormat('DD MMMM Y') }}</td>
                      <td>{{ $warrent->warr_total_item }} barang</td>
                      <td class="text-center">
                        <a type="button" class="btn btn-primary" data-toggle="dropdown">
                          <i class="fas fa-bars"></i>
                        </a>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ url('petugas/surat-perintah/penapisan/'. $warrent->id_warrent) }}">
                            <i class="fas fa-people-carry"></i> Proses
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
<!-- /.content -->

@section('js')
  <script>
    $(function () {
      $("#table-1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "paging": false, "info": false, "ordering":false
      });
    });
  </script>
@endsection

@endsection
