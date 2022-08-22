@extends('v_admin_master.layout.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Tambah Kategori Barang</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('admin-master/barang/daftar/semua/#tabs-incoming') }}">Kategori Barang</a></li>
          <li class="breadcrumb-item active">Tambah Ketegori Barang</li>
        </ol>
      </div>
    </div>
  </div>
</div>

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
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title font-weight-bold">Tambah Kategori Barang</h3>
            <div class="card-tools">
              <!-- action -->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ url('admin-master/barang/post-kategori/baru') }}" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Jenis / Kategori Barang</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="item_category_name" placeholder="Kategori Barang">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Keterangan</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="item_category_description" rows="10" placeholder="Keterangan"></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">&nbsp;</label>
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary font-weight-bold" onclick="return confirm('Tambah kategori baru ?')">SUBMIT</button>
                    <a href="{{ url('admin-master/barang/daftar/semua/#tabs-incoming') }}" class="btn btn-danger font-weight-bold">KEMBALI</a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



@endsection
