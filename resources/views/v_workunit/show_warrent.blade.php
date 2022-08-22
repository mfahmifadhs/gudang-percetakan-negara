@extends('v_workunit.layout.app')

@section('content')

<div class="content">
 <div class="row">
  <div class="col-md-12 form-group">
    <ol class="breadcrumb text-center">
      <li class="breadcrumb-item"><a href="{{ url('unit-kerja/dashboard') }}">Beranda</a></li>
      <li class="breadcrumb-item">Daftar Surat Perintah</li>
    </ol>
  </div>
  <div class="col-md-3 form-group">
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Followers</b> <a class="float-right">1,322</a>
          </li>
          <li class="list-group-item">
            <b>Following</b> <a class="float-right">543</a>
          </li>
          <li class="list-group-item">
            <b>Friends</b> <a class="float-right">13,287</a>
          </li>
        </ul>

        <a href="#" class="btn btn-primary"><b>Follow</b></a>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
  <div class="col-md-9 form-group">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Daftar Surat Perintah</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="table-1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Rendering engine</th>
              <th>Browser</th>
              <th>Platform(s)</th>
              <th>Engine version</th>
              <th>CSS grade</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Trident</td>
              <td>Internet
                Explorer 4.0
              </td>
              <td>Win 95+</td>
              <td> 4</td>
              <td>X</td>
            </tr>
            <tr>
              <td>Misc</td>
              <td>PSP browser</td>
              <td>PSP</td>
              <td>-</td>
              <td>C</td>
            </tr>
            <tr>
              <td>Other browsers</td>
              <td>All others</td>
              <td>-</td>
              <td>-</td>
              <td>U</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th>Rendering engine</th>
              <th>Browser</th>
              <th>Platform(s)</th>
              <th>Engine version</th>
              <th>CSS grade</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>
</div>

@section('js')
<script>
  $(function () {
    $("#table-1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table-1_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection

@endsection