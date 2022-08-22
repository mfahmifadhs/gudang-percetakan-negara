@extends('v_workunit.layout.app')

@section('content')

<div class="content">
  <div class="container">
  	<div class="row">
      <div class="col-md-12 form-group">
        <ol class="breadcrumb text-center">
          <li class="breadcrumb-item"><a href="{{ url('unit-kerja/dashboard') }}">Beranda</a></li>
          <li class="breadcrumb-item">Daftar Gudang</li>
        </ol>
        <h5 class="lead text-uppercase font-weight-bold text-center mb-4">Daftar Gudang</h5>
        <hr>
      </div>
      <div class="col-md-12 form-group">
        <div class="row">
          @foreach($warehouse as $warehouse)
          <div class="col-md-6 form-group">
            <div class="card" style="height: 100%;font-size: 14px;">
              <div class="card-header">
                <h3 class="card-title mt-2 font-weight-bold">{{ $warehouse->warehouse_name }}</h3>
                <div class="card-tools">
                  <a href="{{ url('unit-kerja/detail-gudang/'.$warehouse->id_warehouse) }}" class="btn btn-default"
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
        </div>
      </div>
    </div>
  </div>
</div>


@endsection