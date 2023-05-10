@extends('Layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">Gudang Percetakan Negara</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Daftar Penyimpanan</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container-fluid">
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
                <h3 class="card-title">Daftar Penyimpanan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="table-show" class="table table-bordered table-striped" style="font-size: 15px;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Gedung</th>
                            <th>Model Penyimpanan</th>
                            <th>Kode Palet</th>
                            <th>Keterangan</th>
                            <th class="text-center">Kapasitas</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody class="text-capitalize">
                        @foreach($storage as $row)
                        <tr>
                            <td class="pt-3 text-center">{{ $no++ }} </td>
                            <td class="pt-3">{{ $row->gedung->nama_gedung }}</td>
                            <td class="pt-3">{{ $row->model->nama_model }} </td>
                            <td class="pt-3">{{ $row->kode_palet }} </td>
                            <td class="pt-3">{{ $row->keterangan }} </td>
                            <td class="pt-3 text-center">
                                @if ($row->status_kapasitas_id == 1)
                                <span class="badge-secondary p-2 rounded">Kosong</span>
                                @elseif ($row->status_kapasitas_id == 2)
                                <span class="badge-success p-2 rounded">Tersedia</span>
                                @else
                                <span class="badge-danger p-2 rounded">Penuh</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a type="button" class="btn btn-warning btn-sm" data-toggle="dropdown">
                                    <i class="fas fa-bars"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item btn" type="button" href="{{ route('storage.detail', $row->id_penyimpanan) }}">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    <a class="dropdown-item btn" type="button" href="{{ route('storage.edit', $row->id_penyimpanan) }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a class="dropdown-item btn" type="button" href="{{ route('storage.delete', $row->id_penyimpanan) }}" onclick="return confirm('Ingin Menghapus Data?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#table-show").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true,
            "columnDefs": [{
                "width": "5%",
                "targets": 0,

            }, {
                "width": "5%",
                "targets": 6
            }]
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')
    })
</script>
@endsection

@endsection
