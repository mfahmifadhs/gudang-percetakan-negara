@extends('Layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">Gudang Percetakan Negara</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.show') }}">Daftar User</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container">
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
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Tambah User</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('user.post') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Role*</label>
                        <div class="col-md-5">
                            <select class="form-control" id="role" name="role_id" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach ($role as $row)
                                <option value="{{ $row->id_role }}">
                                    {{ $row->nama_role }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Pegawai*</label>
                        <div class="col-md-10">
                            <select class="form-control" id="pegawai" name="pegawai_id" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach ($employee as $row)
                                <option value="{{ $row->id_pegawai }}">
                                    {{ $row->nip.' - '.$row->nama_pegawai.' - '.$row->workunit->nama_unit_kerja }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Password*</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                                <div class="input-group-append">
                                    <span class="input-group-text border-secondary">
                                        <i class="fa fa-eye-slash" id="eye-icon-pass"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Konfirmasi Password*</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control" id="conf-password" name="conf_password" placeholder="Konfirmasi Password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text border-secondary">
                                        <i class="fa fa-eye-slash" id="eye-icon-conf"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Status Pegawai*</label>
                        <div class="col-md-5">
                            <select class="form-control" name="status_id" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Tambah Baru ?')">
                        <i class="fas fa-paper-plane fa-1x"></i> <b>Submit</b>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#pegawai").select2()
        $("#role").select2()
    })

    $(document).ready(function() {
        $("#eye-icon-pass").click(function() {
            var password = $("#password");
            var icon = $("#eye-icon");
            if (password.attr("type") == "password") {
                password.attr("type", "text");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                password.attr("type", "password");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });

        $("#eye-icon-conf").click(function() {
            var password = $("#conf-password");
            var icon = $("#eye-icon");
            if (password.attr("type") == "password") {
                password.attr("type", "text");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                password.attr("type", "password");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });

        $("form").submit(function() {
            var password = $("#password").val();
            var conf_password = $("#conf-password").val();
            if (password != conf_password) {
                alert("Konfirmasi password tidak sama!");
                return false;
            }
            return true;
        });
    });
</script>
@endsection

@endsection
