@extends('v_workunit.layout.app')

@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><small>Surat Permohonan Pengajuan</small></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('unit-kerja/dashboard') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Buat Surat Permohonan Pengajuan</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <div class="content">
    <div class="container">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">Buat Surat Permohonan Pengajuan</h3>
        </div>
        <!-- /.card-header -->
        <form action="{{ url('unit-kerja/surat/pengajuan/permohonan') }}" method="POST">
          @csrf
          <div class="card-body">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tujuan Pengajuan</label>
              <div class="col-sm-10">
                <select class="form-control" name="purpose">
                  <option value="penyimpanan">Penyimpanan Barang</option>
                  <option value="pengambilan">Pengambilan Barang</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">&nbsp;</label>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">
                  Submit
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



    
@endsection