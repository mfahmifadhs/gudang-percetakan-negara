@extends('v_admin_master.layout.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Tambah Pengguna</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('admin-master/pengguna/daftar/semua') }}">Daftar Pengguna</a></li>
          <li class="breadcrumb-item active">Tambah Pengguna Baru Barang</li>
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
            <h3 class="card-title font-weight-bold">Tambah Pengguna</h3>
            <div class="card-tools">
              <!-- action -->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ url('admin-master/pengguna/proses-tambah/baru') }}" method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Role</label>
                  <div class="col-sm-10">
                    <select name="role_id" class="form-control">
                      @foreach($roles as $role)
                        <option value="{{ $role->id_role }}">{{ $role->role_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Unit Kerja</label>
                  <div class="col-sm-4">
                    <select id="select2-workunit" name="workunit_id" class="form-control select2-workunit">
                      <option value="">-- Pilih Unit Kerja --</option>
                    </select>
                  </div>
                  <label class="col-sm-1 col-form-label">Unit Utama</label>
                  <div class="col-sm-5">
                    <select id="mainunit" class="form-control" readonly>
                      <option value="">-- Unit Utama --</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nama Pengguna</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="full_name" placeholder="Nama pengguna">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NIP</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nip" placeholder="Nomor Induk Pegawai (NIP)">
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
                        <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter" min="8">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Status Pengguna</label>
                  <div class="col-sm-10">
                    <select name="status_id" class="form-control">
                      <option value="1">Aktif</option>
                      <option value="2">Tidak Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">&nbsp;</label>
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary font-weight-bold" onclick="return confirm('Apakah data sudah benar ?')">
                      SUBMIT
                    </button>
                    <a href="{{ url('admin-master/pengguna/daftar/semua') }}" class="btn btn-danger font-weight-bold">KEMBALI</a>
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
