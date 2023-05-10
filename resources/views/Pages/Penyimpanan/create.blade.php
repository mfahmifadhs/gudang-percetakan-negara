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
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Tambah Penyimpanan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('storage.post') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Gedung*</label>
                        <div class="col-md-4">
                            <select class="form-control" name="gedung_id" required>
                                <option value="">-- Pilih Gedung --</option>
                                @foreach ($gedung->where('status_id', 1) as $row)
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
                                <option value="">-- Pilih Model Penyimpanan --</option>
                                @foreach ($model as $row)
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
                            <input type="varchar" class="form-control" name="kode_palet" placeholder="Kode Palet" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Keterangan</label>
                        <div class="col-md-10">
                            <textarea type="text" class="form-control" name="keterangan" placeholder="Keterangan"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kapasitas*</label>
                        <div class="col-md-10">
                            <select class="form-control" name="status_kapasitas_id" required>
                                <option value="">-- Pilih Status Kapasitas --</option>
                                @foreach ($kapasitas as $row)
                                <option value="{{ $row->id_kapasitas }}">
                                    {{ $row->nama_kapasitas }}
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

@endsection
