@extends('v_admin_master.layout.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Master Unit Kerja</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Master Unit Kerja</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 float-right">
        <!-- <div class="float-right">
          <a type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-workunit">
            <i class="fas fa-plus-circle"></i> <br> Unit Kerja
          </a>
          <a type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-mainunit">
            <i class="fas fa-plus-circle"></i> <br> Unit Utama
          </a>
        </div> -->
      </div>
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
        <div class="card card-primary card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
              <li class="pt-2 px-3"><h3 class="card-title">MASTER UNIT KERJA</h3></li>
              <li class="nav-item">
                <a class="nav-link active" id="tabs-workunit-tab" data-toggle="pill" href="#tabs-workunit" role="tab"
              aria-controls="tabs-workunit" aria-selected="false">Unit Kerja</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tabs-mainunit-tab" data-toggle="pill" href="#tabs-mainunit" role="tab"
                aria-controls="tabs-mainunit" aria-selected="false">Unit Utama</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
              <div class="tab-pane fade show active" id="tabs-workunit" role="tabpanel" aria-labelledby="tabs-workunit-tab">
                <table id="table-workunit" class="table table-bordered table-responsive text-center">
                  <thead>
                    <tr>
                      <th style="width: 1%;">No</th>
                      <th style="width: 20%;">Unit Kerja</th>
                      <th style="width: 20%;">Unit Utama</th>
                      <!-- <th style="width: 1%;"></th> -->
                    </tr>
                  </thead>
                  <?php $no = 1;?>
                  <tbody>
                    @foreach($workunit as $workunit)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $workunit->workunit_name }}</td>
                      <td>{{ $workunit->mainunit_name }}</td>
                      <!-- <td>
                        <a type="button" class="btn btn-primary" data-toggle="dropdown">
                          <i class="fas fa-bars"></i>
                        </a>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" data-toggle="modal" data-target="#edit-workunit-{{ $workunit->id_workunit }}">
                            Ubah
                          </a>
                          <a class="dropdown-item" href="{{ url('admin-master/unit-kerja/hapus/'. $workunit->id_workunit) }}"
                          onclick="return confirm('Yakin ingin menghapus data unit kerja ini ?')">
                            Hapus
                          </a>
                        </div>
                      </td> -->
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade" id="tabs-mainunit" role="tabpanel" aria-labelledby="tabs-mainunit-tab">
                <table id="table-mainunit" class="table table-bordered table-responsive text-center">
                  <thead>
                    <tr>
                      <th style="width: 1%;">No</th>
                      <th style="width: 20%;">Unit Utama</th>
                      <!-- <th style="width: 1%;"></th> -->
                    </tr>
                  </thead>
                  <?php $no = 1;?>
                  <tbody>
                    @foreach($mainunit as $mainunit)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $mainunit->mainunit_name }}</td>
                      <!-- <td>
                        <a type="button" class="btn btn-primary" data-toggle="dropdown">
                          <i class="fas fa-bars"></i>
                        </a>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ url('admin-master/unit-kerja/ubah/'. $mainunit->id_mainunit) }}">
                            Ubah
                          </a>
                          <a class="dropdown-item" href="{{ url('admin-master/unit-kerja/hapus/'. $mainunit->id_mainunit) }}"
                          onclick="return confirm('Yakin ingin menghapus data unit kerja ini ?')">
                            Hapus
                          </a>
                        </div> -->
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

@section('js')
<script>
  $(function () {
    $("#table-workunit").DataTable({
      "responsive": true, "lengthChange": true  , "autoWidth": false ,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#table-workunit_wrapper .col-md-6:eq(0)');

    $("#table-mainunit").DataTable({
      "responsive": true, "lengthChange": true  , "autoWidth": false ,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#table-mainunit_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection

@endsection
