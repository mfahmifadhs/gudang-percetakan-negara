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
            <div class="card-body">
                <table id="table-show" class="table table-bordered table-striped" style="font-size: 15px;">
                    <thead class="text-center">
                        <tr>
                            <th rowspan="2" class="pb-5">No</th>
                            <th rowspan="2" class="pb-5">Unit Kerja</th>
                            <th rowspan="2" class="pb-5">Nama Barang</th>
                            <th rowspan="2" class="pb-5">Merek/Tipe</th>
                            <th rowspan="2" class="pb-5">NUP / Masa <br> Kadaluarsa</th>
                            <th rowspan="2" class="pb-5">Total <br> Barang</th>
                            <th colspan="5">Lokasi <br> Penyimpanan</th>
                        </tr>
                        <tr>
                            <th>Nama Gedung</th>
                            <th>Kode Palet</th>
                            <th>Jumlah Masuk</th>
                            <th>Jumlah Keluar</th>
                            <th>Sisa Stok</th>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody class="text-capitalize">
                        @foreach($item as $row)
                        <tr>
                            <td class="text-center">
                                <a href="{{ route('item.detail', ['ctg' => 'masuk', 'id' => $row->id_detail]) }}">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                {{ $no++ }}
                            </td>
                            <td class="">{{ $row->pengajuan->unitkerja->nama_unit_kerja }}</td>
                            <td class="">{{ $row->nama_barang }}</td>
                            <td class="">{{ $row->deskripsi }}</td>
                            <td class="text-center">{{ $row->catatan }}</td>
                            <td class="text-center">{{ (int) $row->jumlah_diterima.' '.$row->satuan }}</td>
                            <td class="text-center">
                                @foreach ($row->slot as $subRow)
                                    {{ $subRow->nama_gedung }}
                                    @if ($row->slot->count() > 1) <hr class="m-1"> @endif
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach ($row->slot as $subRow)
                                    {{ $subRow->kode_palet }}
                                    @if ($row->slot->count() > 1) <hr class="m-1"> @endif
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach ($row->slot as $subRow)
                                    {{ (int) $subRow->total_masuk.' '.$row->satuan }}
                                    @if ($row->slot->count() > 1) <hr class="m-1"> @endif
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach ($row->slot as $subRow)
                                    {{ (int) $subRow->total_keluar.' '.$row->satuan }}
                                    @if ($row->slot->count() > 1) <hr class="m-1"> @endif
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach ($row->slot as $subRow)
                                    {{ (int) $subRow->total_masuk - $subRow->total_keluar.' '.$row->satuan }}
                                    @if ($row->slot->count() > 1) <hr class="m-1"> @endif
                                @endforeach
                            </td>
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
</script>
@endsection

@endsection
