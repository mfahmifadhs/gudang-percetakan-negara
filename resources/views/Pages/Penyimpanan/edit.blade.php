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
                    <li class="breadcrumb-item"><a href="{{ route('storage.show') }}">Daftar Penyimpanan</a></li>
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
                <h3 class="card-title">Edit Penyimpanan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('storage.update', $storage->id_penyimpanan) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Gedung*</label>
                        <div class="col-md-4">
                            <select class="form-control" name="gedung_id" required>
                                <option value="{{ $storage->gedung_id }}">
                                    {{ $storage->gedung->nama_gedung }}
                                </option>
                                @foreach ($gedung->where('status_id', 1)->where('id_gedung','!=',$storage->gedung_id) as $row)
                                <option value="{{ $row->id_gedung }}">
                                    {{ $row->nama_gedung }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Model Penyimpanan*</label>
                        <div class="col-md-4">
                            <select class="form-control" name="model_id" required>
                                <option value="{{ $storage->model_id }}">
                                    {{ $storage->model->nama_model }}
                                </option>
                                @foreach ($model->where('id_model','!=',$storage->model_id) as $row)
                                <option value="{{ $row->id_model }}">
                                    {{ $row->nama_model }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kode Palet*</label>
                        <div class="col-md-4">
                            <input type="varchar" class="form-control" name="kode_palet" value="{{ $storage->kode_palet }}" placeholder="Kode Palet" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Keterangan</label>
                        <div class="col-md-10">
                            <textarea type="text" class="form-control" name="keterangan" placeholder="Keterangan">{{ $storage->keterangan }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kapasitas*</label>
                        <div class="col-md-10">
                            <select class="form-control" name="status_kapasitas_id" required>
                                <option value="{{ $storage->status_kapasitas_id }}">
                                    {{ $storage->kapasitas->nama_kapasitas }}
                                </option>
                                @foreach ($kapasitas->where('id_kapasitas','!=',$storage->status_kapasitas_id) as $row)
                                <option value="{{ $row->id_kapasitas }}">
                                    {{ $row->nama_kapasitas }}
                                </option>
                                @endforeach
                            </select>
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
