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
                    <li class="breadcrumb-item active">Daftar Gedung</li>
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
                <h3 class="card-title">Daftar Barang</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="table-show" class="table table-bordered table-striped text-center" style="font-size: 15px;">
                    <thead>
                        <tr>
                            <th rowspan="2" class="pb-5">No</th>
                            <th rowspan="2" class="pb-5">Nama Barang</th>
                            <th rowspan="2" class="pb-5">Total</th>
                            <th colspan="5" style="width: 50%;">Lokasi <br> Penyimpanan</th>
                            @if (Auth::user()->role_id != 4)
                            <th rowspan="2" class="pb-5">Unit Kerja</th>
                            @endif
                        </tr>
                        <tr>
                            <th>Nama <br> Gedung</th>
                            <th>Kode <br> Palet</th>
                            <th>Jumlah <br> Masuk</th>
                            <th>Jumlah <br> Keluar</th>
                            <th>Sisa <br> Stok</th>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody class="text-capitalize">
                        @foreach($item as $i => $row)
                        <tr>
                            <td style="width: 0%;">{{ $no++ }}</td>
                            <td style="width: 20%;" class="text-justify">
                                <a href="{{ route('item.detail', ['ctg' => 'masuk', 'id' => $row->id_detail]) }}">
                                    <h6 class="font-weight-bold">{{ $row->id_detail }} <br>  {{ $row->nama_barang }}</h6>
                                </a>
                            </td>
                            <td style="width: 10%;" class="pt-4">
                                {{ (int) $row->jumlah_diterima.' '.$row->satuan }}
                            </td>
                            <td>
                                {{ $row->slot->first()->nama_gedung }}
                                <div class="text-gdn-{{ $i }} hide" style="display: none;">
                                @foreach ($row->slot as $key => $subRow)
                                    @if ($key === 0)
                                        @continue
                                    @endif
                                    <hr class="m-1">
                                    {{ $subRow->nama_gedung }}
                                @endforeach
                                </div>

                                @if ($row->slot->count() > 1)
                                    <br> <a class="btn show-hide-gdn text-lowercase small text-primary" data-id="{{ $i }}">show ⬇️</a>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $row->slot->first()->kode_palet }}

                                <div class="text-slot-{{ $i }} hide" style="display: none;">
                                @foreach ($row->slot as $key => $subRow)
                                    @if ($key === 0)
                                        @continue
                                    @endif
                                    <hr class="m-1">
                                    {{ $subRow->kode_palet }}
                                @endforeach
                                </div>

                                @if ($row->slot->count() > 1)
                                    <br> <a class="btn show-hide-slot text-lowercase small text-primary" data-id="{{ $i }}">show ⬇️</a>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ (int) $row->slot->first()->total_masuk.' '.$row->satuan }}

                                <div class="text-in-{{ $i }} hide" style="display: none;">
                                @foreach ($row->slot as $key => $subRow)
                                    @if ($key === 0)
                                        @continue
                                    @endif
                                    <hr class="m-1">
                                    {{ (int) $subRow->total_masuk.' '.$row->satuan }}
                                @endforeach
                                </div>

                                @if ($row->slot->count() > 1)
                                    <br> <a class="btn show-hide-in text-lowercase small text-primary" data-id="{{ $i }}">show ⬇️</a>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ (int) $row->slot->first()->total_keluar.' '.$row->satuan }}

                                <div class="text-out-{{ $i }} hide" style="display: none;">
                                @foreach ($row->slot as $key => $subRow)
                                    @if ($key === 0)
                                        @continue
                                    @endif
                                    <hr class="m-1">
                                    {{ (int) $subRow->total_keluar.' '.$row->satuan }}
                                @endforeach
                                </div>

                                @if ($row->slot->count() > 1)
                                    <br> <a class="btn show-hide-out text-lowercase small text-primary" data-id="{{ $i }}">show ⬇️</a>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ (int) $row->slot->first()->total_masuk - $row->slot->first()->total_keluar.' '.$row->satuan }}

                                <div class="text-stok-{{ $i }} hide" style="display: none;">
                                @foreach ($row->slot as $key => $subRow)
                                    @if ($key === 0)
                                        @continue
                                    @endif
                                    <hr class="m-1">
                                    {{ (int) $subRow->total_masuk - $subRow->total_keluar.' '.$row->satuan }}
                                @endforeach
                                </div>

                                @if ($row->slot->count() > 1)
                                    <br> <a class="btn show-hide-stok text-lowercase small text-primary" data-id="{{ $i }}">show ⬇️</a>
                                @endif
                            </td>

                            @if (Auth::user()->role_id != 4)
                            <td style="width: 15%;" class="text-justify">
                                {{ $row->pengajuan->unitkerja->nama_unit_kerja }}
                            </td>
                            @endif
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
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true,
            'columnDefs': [{
                    'width': '0%',
                    'targets': 0
                },
                {
                    'width': '10%',
                    'targets': 1
                },
                {
                    'width': '15%',
                    'targets': 2
                },
                {
                    'width': '10%',
                    'targets': 4
                },
                {
                    'width': '10%',
                    'targets': 5
                },
            ]
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')
    })

    $(document).ready(function() {
        $(".show-hide-gdn").click(function() {
            var rowId = $(this).data('id');
            $(".text-gdn-" + rowId).slideToggle();
            console.log(rowId)
            $(this).text(function(i, text){
                return text === "show ⬇️" ? "hide ⬆️" : "show ⬇️";
            });
        });

        $(".show-hide-slot").click(function() {
            var rowId = $(this).data('id');
            $(".text-slot-" + rowId).slideToggle();
            console.log(rowId)
            $(this).text(function(i, text){
                return text === "show ⬇️" ? "hide ⬆️" : "show ⬇️";
            });
        });

        $(".show-hide-in").click(function() {
            var rowId = $(this).data('id');
            $(".text-in-" + rowId).slideToggle();
            console.log(rowId)
            $(this).text(function(i, text){
                return text === "show ⬇️" ? "hide ⬆️" : "show ⬇️";
            });
        });

        $(".show-hide-out").click(function() {
            var rowId = $(this).data('id');
            $(".text-out-" + rowId).slideToggle();
            console.log(rowId)
            $(this).text(function(i, text){
                return text === "show ⬇️" ? "hide ⬆️" : "show ⬇️";
            });
        });

        $(".show-hide-stok").click(function() {
            var rowId = $(this).data('id');
            $(".text-stok-" + rowId).slideToggle();
            console.log(rowId)
            $(this).text(function(i, text){
                return text === "show ⬇️" ? "hide ⬆️" : "show ⬇️";
            });
        });
    });
</script>
@endsection

@endsection
