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
                    <li class="breadcrumb-item"><a href="{{ route('workunit.show') }}">Daftar Unit Kerja</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                <h3 class="card-title">Edit Unit Kerja</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('workunit.edit', $workunit->id_unit_kerja) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Unit Utama</label>
                        <div class="col-md-6">
                            <select class="form-control" name="unit_utama_id">
                                <option value="{{ $workunit->unit_utama_id }}">
                                    {{ $workunit->mainunit->kode_unit_utama.' - '.$workunit->mainunit->nama_unit_utama }}
                                </option>
                                @foreach ($mainunit as $row)
                                <option value="{{ $row->id_unit_utama }}">
                                    {{ $row->kode_unit_utama.' - '.$row->nama_unit_utama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kode Unit Kerja</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="kode_unit_kerja" value="{{ $workunit->kode_unit_kerja }}" placeholder="Kode Unit Utama" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Unit Kerja</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="nama_unit_kerja" value="{{ $workunit->nama_unit_kerja }}" placeholder="Nama Unit Utama" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Simpan Perubahan ?')">
                        <i class="fas fa-save fa-1x"></i> <b>Simpan</b>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
