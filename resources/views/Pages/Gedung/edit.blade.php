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
                    <li class="breadcrumb-item"><a href="{{ route('warehouse.show') }}">Daftar Gedung</a></li>
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
                <h3 class="card-title">Edit Gedung</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('warehouse.update', $gedung->id_gedung) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kode Gedung</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="id_gedung" value="{{ $gedung->kode_gedung }}" placeholder="Kode Gedung" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Kategori</label>
                        <div class="col-md-4">
                            <select class="form-control" name="kategori_id" required>
                                <option value="{{ $gedung->kategori_id }}">
                                    {{ $gedung->kategori->nama_kategori }}
                                </option>
                                @foreach ($kategori->where('id_kategori', '!=', $gedung->kategori_id) as $row)
                                <option value="{{ $row->id_kategori }}">
                                    {{ $row->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nama Gedung</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="nama_gedung" value="{{ $gedung->nama_gedung }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Keterangan</label>
                        <div class="col-md-10">
                            <textarea type="text" class="form-control" name="keterangan" placeholder="Keterangan Gedung">{{ $gedung->keterangan }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Status Gedung</label>
                        <div class="col-md-10">
                            <select class="form-control" name="status_id" required>
                                <option value="{{ $gedung->status_id }}">
                                    {{ $gedung->status->status }}
                                </option>
                                @foreach ($status->where('id_status', '!=', $gedung->status_id) as $row)
                                <option value="{{ $row->id_status }}">
                                    {{ $row->status }}
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
