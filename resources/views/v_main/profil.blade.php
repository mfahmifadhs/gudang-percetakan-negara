@extends('v_main.layout.app')

@section('content')

<div class="container-xxl py-3">
    <div class="container" style="margin-top: 150px;">
        <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">Profil</div>
    </div>
</div>


<section class="container-xxl">
    <div class="container">
        <div class="row">
            <div class="col-md-12 form-group">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p class="fw-light" style="margin: auto;">{{ $message }}</p>
                </div>
                @endif
                @if ($message = Session::get('failed'))
                <div class="alert alert-danger">
                    <p class="fw-light" style="margin: auto;">{{ $message }}</p>
                </div>
                @endif
            </div>
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="form-group row">
                            <div class="col-sm-2 text-center">
                                <i class="fas fa-user-circle fa-5x bg-pri"></i>
                            </div>
                            <div class="col-sm-10 mt-3 text-capitalize">
                                <span class="font-weight-bold">{{ $profile->full_name }}</span> <br>
                                <span class="font-weight-bold">{{ ucfirst(strtolower($profile->workunit_name))  }}</span>
                            </div>
                        </div>
                    </div>
                    <form action="{{ url('main/profil/update/'. Auth::user()->id) }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <label class="mb-2">Nama Pegawai</label>
                            <div class="card-tools">
                                <input type="text" class="form-control" name="full_name" value="{{ ucfirst(strtolower($profile->full_name)) }}">
                            </div>

                            <label class="mb-2 mt-3">Unit Kerja</label>
                            <div class="card-tools">
                                <input type="hidden" class="form-control" name="workunit_id" value="{{ $profile->workunit_id }}" readonly>
                                <input type="text" class="form-control" value="{{ ucfirst(strtolower($profile->workunit_name)) }}" readonly>
                            </div>

                            <label class="mb-2 mt-3">Username</label>
                            <div class="card-tools">
                                <input type="hidden" class="form-control" name="username_old" value="{{ $profile->nip }}">
                                <input type="text" class="form-control" name="nip" placeholder="{{ $profile->nip }}">
                            </div>

                            <label class="mb-2 mt-3">Password</label>
                            <div class="card-tools">
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name="password" id="password" value="{{ $profile->password_text }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <a type="button" onclick="lihatPassword()"><span class="fas fa-eye"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header">
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Simpan Perubahan ?')">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
<!-- Lihat Password -->
<script type="text/javascript">
    function lihatPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
@endsection

@endsection
