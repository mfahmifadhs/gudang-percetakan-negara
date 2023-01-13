@extends('v_main.layout.app')

@section('content')

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
        <div class="row g-5">
            <div class="col-lg-12">
                <div class="h-100">
                    <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
                    <h1 class="display-6 mb-4">Daftar Barang</h1>
                    <div class="row">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <table id="table-1" class="table table-border text-capitalize" style="color: black;">
                                    <thead>
                                        <tr style="font-size: 14px;">
                                            <th style="width: 1%;">No</th>
                                            <th style="width: 19%;">Nama Barang</th>
                                            <th style="width: 15%;">Merk/Type</th>
                                            <th style="width: 5%;">NUP</th>
                                            <th style="width: 30%;">Keterangan</th>
                                            <th style="width: 10%;">Jumlah</th>
                                            <th style="width: 10%;">Expired</th>
                                            <th style="width: 10%;">Tanggal Masuk</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($item as $dataItem)
                                        <tr style="font-size: 13px;">
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td>
                                                {{ $dataItem->item_name }} <br>
                                                Kondisi : {{ $dataItem->item_condition_name }}
                                            </td>
                                            <td class="pt-3">
                                                @if ($dataItem->item_merktype == null)
                                                -
                                                @else
                                                {{ $dataItem->item_merktype }}
                                                @endif
                                            </td>
                                            <td class="pt-3">
                                                @if ($dataItem->item_nup == null)
                                                -
                                                @else
                                                {{ $dataItem->item_nup }}
                                                @endif
                                            </td>
                                            <td class="pt-3">{{ $dataItem->item_description }}</td>
                                            <td class="pt-3">{{ $dataItem->item_qty.' '.$dataItem->item_unit }}</td>
                                            <td class="pt-3">
                                                @if ($dataItem->item_exp == null)
                                                -
                                                @else
                                                {{ \Carbon\carbon::parse($dataItem->item_exp)->isoFormat('DD MMM Y') }}
                                                @endif
                                            </td>
                                            <td class="pt-3">
                                                {{ \Carbon\carbon::parse($dataItem->order_dt)->isoFormat('DD MMM Y') }}
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown">
                                                        <i class="fas fa-bars"></i>
                                                    </a>
                                                    <div class="dropdown-menu m-0">
                                                        <a class="dropdown-item" href="{{ url('unit-kerja/menu-barang/detail/'. $dataItem->id_item) }}">
                                                            <i class="fas fa-info-circle"></i> Detail
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    $(function() {
        $("#table-1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel", "pdf", "print"]
        }).buttons().container().appendTo('#table-1_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection

@endsection
