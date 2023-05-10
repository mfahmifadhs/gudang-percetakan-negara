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
                    <li class="breadcrumb-item"><a href="{{ route('employee.show') }}">Daftar Pegawai</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Tambah Pegawai</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('employee.post') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Unit Kerja*</label>
                        <div class="col-md-10">
                            <select class="form-control" id="unit-kerja" name="unit_kerja_id" required>
                                <option value="">-- Pilih Unit Kerja --</option>
                                @foreach ($workunit as $row)
                                <option value="{{ $row->id_unit_kerja }}">
                                    {{ $row->kode_unit_kerja.' - '.$row->nama_unit_kerja }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nomor Induk Pegawai</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="nip" placeholder="Nomor Induk Pegawai">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Pegawai*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="nama_pegawai" placeholder="Nama Pegawai" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Jabatan Pegawai*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="jabatan" placeholder="Jabatan Pegawai" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Status Pegawai*</label>
                        <div class="col-md-4">
                            <select class="form-control" name="status_id" required>
                                @foreach ($status as $row)
                                <option value="{{ $row->id_status }}">
                                    {{ $row->status }}
                                </option>
                                @endforeach
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
        $("#unit-kerja").select2()
    })
</script>
@endsection

@endsection
