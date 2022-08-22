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
            <div class="callout callout-info">
              <h6 class="font-weight-bold">PENGIRIMAN</h6>
            </div>
          </div>
          <div class="col-md-12">
            <div class="callout callout-info">
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
          <div class="col-md-12">
            <div class="callout callout-info">
              <h6 class="font-weight-bold">PENGIRIMAN</h6>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card">
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
          <div class="col-md-12">
            <div class="callout callout-info">
              <h6 class="font-weight-bold">DAFTAR GUDANG</h6>
            </div>
          </div>
          @foreach($warehouses as $warehouse)
          <div class="col-md-6 form-group">
            <div class="card" style="height: 100%;font-size: 14px;">
              <div class="card-header">
                <h3 class="card-title mt-2 font-weight-bold">{{ $warehouse->warehouse_name }}</h3>
                <div class="card-tools">
                  <a href="{{ url('admin-master/detail-warehouse/'.$warehouse->id_warehouse) }}" class="btn btn-default"
                    title="Cek Gudang">
                    <i class="fas fa-pallet"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 form-group text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/2271/2271068.png" style="height: 25vh;margin-top: 15%;" 
                    class="img-thumbnail">
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Kode</label>
                        <p>{{ $warehouse->id_warehouse }}</p>
                      </div>
                      <div class="col-md-6">
                        <label>Model Penyimpanan</label>
                        <p>{{ $warehouse->warehouse_category }}</p>
                      </div>
                      <div class="col-md-6">
                        <label>Nama Gudang</label>
                        <p>{{ $warehouse->warehouse_name }}</p>
                      </div>
                      <div class="col-md-6">
                        <label>Status</label>
                        @if($warehouse->status_id == 1)
                        <p class="text-success font-weight-bold" readonly>Aktif</p>
                        @elseif($warehouse->status_id == 2)
                        <p class="text-danger font-weight-bold" readonly>Tidak Aktif</p>
                        @endif
                      </div>
                      <div class="col-md-12">
                        <label>Keterangan</label>
                        <p>{!! $warehouse->warehouse_description !!}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          <div class="col-md-6 form-group">
            <div class="col-md-12 form-group">
              {{ $warehouses->links("pagination::bootstrap-4") }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /.content -->

@endsection