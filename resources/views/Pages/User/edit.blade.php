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
                <h3 class="card-title">Edit User</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Role*</label>
                        <div class="col-md-5">
                            <select class="form-control" id="role" name="role_id" required>
                                <option value="{{ $user->role_id }}">{{ $user->role->nama_role }}</option>
                                @foreach ($role->where('id_role', '!=', $user->role_id) as $row)
                                <option value="{{ $row->id_role }}">
                                    {{ $row->nama_role }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Pegawai*</label>
                        <div class="col-md-5">
                            <select class="form-control" id="pegawai" name="pegawai_id" required>
                                <option value="{{ $user->pegawai_id }}">
                                    {{ $user->pegawai->nip.' - '.$user->pegawai->nama_pegawai.' - '.$user->pegawai->workunit->nama_unit_kerja }}
                                </option>
                                @foreach ($employee->where('id_pegawai', '!=', $user->pegawai_id) as $row)
                                <option value="{{ $row->id_pegawai }}">
                                    {{ $row->nip.' - '.$row->nama_pegawai.' - '.$row->workunit->nama_unit_kerja }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Password</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" value="{{ $user->password_text }}">
                                <div class="input-group-append">
                                    <span class="input-group-text border-secondary">
                                        <i class="fa fa-eye-slash" id="eye-icon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Status User*</label>
                        <div class="col-md-5">
                            <select class="form-control" name="status_id" required>
                                @if ($user->status_id == 1)
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                                @else
                                <option value="0">Tidak Aktif</option>
                                <option value="1">Aktif</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Ubah Informasi User?')">
                        <i class="fas fa-save fa-1x"></i> <b>Simpan</b>
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
        $("#eye-icon").click(function() {
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
    });
</script>
@endsection

@endsection
