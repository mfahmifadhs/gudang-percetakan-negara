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
                    <li class="breadcrumb-item"><a href="{{ route('warehouse.show') }}">Daftar Gedung</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container-fluid">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    {{ $gedung->nama_gedung }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-sm-2">
                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#storage" role="tab" aria-controls="vert-tabs-home" aria-selected="true">
                                Penyimpanan
                            </a>
                            <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#layout" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">
                                Layout Gedung
                            </a>
                            <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#gallery" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">
                                Galeri
                            </a>
                        </div>
                    </div>
                    <div class="col-7 col-sm-10">
                        <div class="tab-content" id="vert-tabs-tabContent">
                            <div class="tab-pane text-left fade active show" id="storage" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                <h4>Penyimpanan {{ $gedung->nama_gedung }}</h4>
                                <div class="card">
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
                                                @foreach($gedung->penyimpanan as $row)
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
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="layout" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                                <h4>Layout gedung</h4>
                                Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                            </div>
                            <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                                <h4>Galeri</h4>
                                Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                            </div>
                        </div>
                    </div>
                </div>
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
                "width": "15%",
                "targets": 1
            }, {
                "width": "0%",
                "targets": 6
            }]
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')
    })
</script>
@endsection

@endsection
