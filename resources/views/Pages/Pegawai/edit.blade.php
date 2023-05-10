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
                <h3 class="card-title">Edit Pegawai</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('employee.update', $employee->id_pegawai) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Unit Kerja*</label>
                        <div class="col-md-10">
                            <select class="form-control" id="unit-kerja" name="unit_kerja_id" required>
                                <option value="{{ $employee->unit_kerja_id }}">
                                    {{ $employee->workunit->kode_unit_kerja.' - '.$employee->workunit->nama_unit_kerja }}
                                </option>
                                @foreach ($workunit->where('id_unit_kerja', '!=', $employee->unit_kerja_id) as $row)
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
                            <input type="text" class="form-control" name="nip" value="{{ $employee->nip }}" placeholder="Nomor Induk Pegawai">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Pegawai*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="nama_pegawai" value="{{ $employee->nama_pegawai }}" placeholder="Nama Pegawai" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Jabatan Pegawai*</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="jabatan" value="{{ $employee->jabatan }}" placeholder="Jabatan Pegawai" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Status Pegawai*</label>
                        <div class="col-md-4">
                            <select class="form-control" name="status_id" required>
                                <option value="{{ $employee->status_id }}">
                                    {{ $employee->status->status }}
                                </option>
                                @foreach ($status->where('id_status', '!=', $employee->status_id) as $row)
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
        $("#unit-kerja").select2()
    })
</script>
@endsection

@endsection
