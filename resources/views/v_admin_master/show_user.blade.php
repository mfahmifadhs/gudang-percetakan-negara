@extends('v_admin_master.layout.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Master Pengguna</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Master Pengguna</li>
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
            <h3 class="card-title font-weight-bold mt-2">Daftar Pengguna</h3>
            <div class="card-tools">
              <a href="{{ url('admin-master/pengguna/tambah/baru') }}" class="btn btn-primary">
                <i class="fas fa-plus-square"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <table id="table-user" class="table table-bordered table-responsive">
              <thead>
                <tr>
                  <th style="width: 1%;">No</th>
                  <th style="width: 19%;">Unit Kerja</th>
                  <th>Nama</th>
                  <th style="width: 20%;">NIP</th>
                  <th style="width: 10%;">Password</th>
                  <th style="width: 10%;" class="text-center">Role</th>
                  <th style="width: 10%;" class="text-center">Status</th>
                  <th style="width: 1%;"></th>
                </tr>
              </thead>
              <?php $no = 1; ?>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $user->workunit_name }}</td>
                  <td>{{ $user->full_name }}</td>
                  <td>{{ $user->nip }}</td>
                  <td>{{ $user->password_text }}</td>
                  <td class="text-center">
                    <a class="btn btn-primary btn-xs disabled" > {{ $user->role_name }} </a>
                  </td>
                  <td class="text-center">
                    @if($user->status = 1)
                      <a class="btn btn-success btn-xs disabled"> {{ $user->status_name }} </a>
                    @else
                      <a class="btn btn-danger btn-xs disabled"> {{ $user->status_name }} </a>
                    @endif
                  </td>
                  <td class="text-center">
                    <a type="button" class="btn btn-primary" data-toggle="dropdown">
                      <i class="fas fa-bars"></i>
                    </a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ url('admin-master/pengguna/detail/'. $user->id) }}">
                        Detail
                      </a>
                      <a class="dropdown-item" href="{{ url('admin-master/pengguna/hapus/'. $user->id) }}"
                      onclick="return confirm('Hapus data pengguna ?')">
                        Hapus
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
</section>

@section('js')
<script>
  $(function () {
    $("#table-user").DataTable({
      "responsive": true, "lengthChange": true  , "autoWidth": false ,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#table-workunit_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection

@endsection
