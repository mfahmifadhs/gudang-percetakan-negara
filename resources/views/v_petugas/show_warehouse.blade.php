@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daftar Penyimpanan Barang</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('petugas/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Daftar Penyimpanan Barang</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- Content Header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
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
      </div>
      <div class="col-md-12">
        <div class="row">
          @foreach($warehouses as $warehouse)
          <div class="col-md-6 form-group">
            <div class="card" style="height: 100%;font-size: 14px;">
              <div class="card-header">
                <h3 class="card-title mt-2 font-weight-bold">{{ $warehouse->warehouse_name }}</h3>
                <div class="card-tools">
                  <a href="{{ url('petugas/gudang/detail/'.$warehouse->id_warehouse) }}" class="btn btn-default"
                  title="Cek Gudang">
                    <i class="fas fa-pallet"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 form-group text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/2271/2271068.png" style="height: 30vh;"
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
          {{ $warehouses->links("pagination::bootstrap-4") }}
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
