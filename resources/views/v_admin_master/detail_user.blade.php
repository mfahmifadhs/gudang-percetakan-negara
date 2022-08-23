@extends('v_admin_master.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>{{ $users->full_name .' - '. $users->workunit_name }}</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('admin-master/pengguna/daftar/semua') }}">Daftar Pengguna</a></li>
          <li class="breadcrumb-item active">{{ $users->full_name }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" src="https://cdn-icons-png.flaticon.com/512/599/599305.png" alt="Profil">
            </div>
            <h3 class="profile-username text-center">{{ $users->full_name }}</h3>
            <p class="text-muted text-center">{{ $users->workunit_name }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#profil" data-toggle="tab">Profil</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="profil">
                <form class="form-horizontal" action="{{ url('admin-master/pengguna/ubah/'. $users->id) }}" method="POST">
                  @csrf
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Unit Kerja</label>
                    <div class="col-sm-4">
                      <select id="select2-workunit" name="workunit_id" class="form-control select2-workunit">
                        <option value="{{ $users->workunit_id }}">{{ $users->workunit_name }}</option>
                      </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Unit Utama</label>
                    <div class="col-sm-4">
                      <select id="mainunit" class="form-control" readonly>
                        <option value="">{{ $users->mainunit_name }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="full_name" value="{{ $users->full_name }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NIP</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="nip" value="{{ $users->nip }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <a type="button" onclick="viewPass()"><i class="fas fa-eye"></i></a>
                          </span>
                        </div>
                        <input type="password" id="password" name="password" class="form-control" value="{{ \Crypt::decryptString($users->password) }}">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="role_id">
                      @foreach($roles as $role)
                        <option value="{{ $role->id_role }}"
                          <?php if($users->role_id == $role->id_role) echo "selected"; ?>>
                          {{ $role->role_name }}
                        </option>
                      @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="status_id">
                      @foreach($status as $status)
                        <option value="{{ $status->id_status }}"
                          <?php if($users->status_id == $status->id_status) echo "selected"; ?>>
                          {{ $status->status_name }}
                        </option>
                      @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-primary" onclick="return confirm('Data sudah benar ?')">Ubah</button>
                    </div>
                  </div>
                </form>
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
  function viewPass() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
  $(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $( "#select2-workunit" ).select2({
      ajax: {
        url: "{{ url('admin-master/select2/workunit/daftar') }}",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            _token: CSRF_TOKEN,
            search: params.term // search term
          };
        },
        processResults: function (response) {
          return {
            results: response
          };
        },
        cache: true
      }
    });

    $('.select2-workunit').change(function(){
      var workunit = $(this).val();
      console.log(workunit);
      if(workunit){
          $.ajax({
              type:"GET",
              url:"/admin-master/json/mainunit/" + workunit,
              dataType: 'JSON',
              success:function(res){
              if(res){
                  $("#mainunit").empty();
                  $.each(res,function(mainunit_name,id_mainunit){
                      $("#mainunit").append(
                        '<option value="'+id_mainunit+'">'+mainunit_name+'</option>'
                      );
                  });
              }else{
                     $("#mainunit").empty();
              }
              }
          });
      }else{
              $("#mainunit").empty();
      }
    });
  });
</script>
@endsection

@endsection
