@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Penapisan Barang</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('Petugas/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Penapisan Barang</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- Content Header -->

@foreach($warrent as $warrent)
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 form-group">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p style="color:white;margin: auto;">{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('failed'))
            <div class="alert alert-danger">
                 <p style="color:white;margin: auto;">{{ $message }}</p>
            </div>
        @endif
      </div>
      <div class="col-md-12 form-group">
        <form action="{{ url('petugas/tambah-barang') }}" method="POST">
          @csrf
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title font-weight-bold mt-2">Informasi Pengirim </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-default" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <label>Kode Penyimpanan : </label>
                  <div class="input-group mb-3">
                    <input type="text" name="id_order" class="form-control" value="PBM-{{ \Carbon\Carbon::now()->isoFormat('DMYYhhmmss') }}" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Petugas Gudang : </label>
                  <div class="input-group mb-3">
                    <select class="form-control" name="adminuser_id" readonly>
                      <option value="{{ Auth::id(); }}">{{ Auth::user()->full_name }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Unit Kerja : </label>
                  <div class="input-group mb-3">
                    <select id="select2-workunit" name="id_workunit" class="form-control select2-workunit" required>
                      <option value="">-- Pilih Unit Kerja --</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Unit Utama :  </label>
                  <div class="input-group mb-3">
                    <select class="form-control" id="mainunit" name="mainunit_id" readonly>
                      <option value="">-- Unit Utama --</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Pengirim : </label>
                  <div class="input-group mb-3">
                    <input type="text" name="order_emp_name" class="form-control text-capitalize"
                    placeholder="Nama Petugas Yang Membawa Barang">
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Jabatan : </label>
                  <div class="input-group mb-3">
                    <input type="text" name="order_emp_position" class="form-control text-capitalize"
                    placeholder="Jabatan Petugas Yang Membawa Barang">
                  </div>
                </div>
                <div class="col-md-12">
                  <label>Nomor Kendaraan : </label>
                  <div class="input-group mb-3">
                    <input type="text" name="order_license_vehicle" class="form-control text-uppercase"
                    placeholder="Plat Nomor Kendaraan" onkeypress="return event.charCode != 32">
                  </div>
                </div>
                <div class="col-md-12">
                  <label>Data Barang: </label>
                  <div class="input-group mb-3">
                  <table class="table table-bordered table-responsive">
                    <thead>
                      <tr>
                        <th style="width: 1%;">No</th>
                        <th style="width: 20%;">Kategori Barang</th>
                        <th style="width: 10%;">Kode Barang</th>
                        <th style="width: 9%;">NUP</th>
                        <th style="width: 20%;">Nama Barang</th>
                        <th style="width: 20%;">Merk/Type Barang</th>
                        <th style="width: 20%;">Jumlah</th>
                      </tr>
                    </thead>
                    <?php $no = 1;?>
                    <tbody>
                      @foreach($warrent->entryitem as $item)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->warr_item_category }}</td>
                        <td>{{ $item->warr_item_code }}</td>
                        <td>{{ $item->warr_item_nup }}</td>
                        <td>{{ $item->warr_item_name }}</td>
                        <td>{{ $item->warr_item_type }}</td>
                        <td>{{ $item->warr_item_qty.' '.$item->warr_item_unit }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title font-weight-bold mt-2">Informasi Barang </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-default" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">

              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endforeach



@endsection
