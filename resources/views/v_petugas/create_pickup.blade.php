@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pengeluaran Barang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('petugas/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pengeluaran Barang</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 form-group">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p style="color:white;margin: auto;">{{ $message }}</p>
                </div>
                @elseif ($message = Session::get('failed'))
                <div class="alert alert-danger">
                    <p style="color:white;margin: auto;">{{ $message }}</p>
                </div>
                @endif
            </div>
            <div class="col-md-12 form-group">
                <form action="{{ url('petugas/barang/proses-ambil/'. $order->id_order) }}" method="POST">
                    @csrf
                    <input type="hidden" name="warrent_id" value="{{ $id }}">
                    <div class="card card-outline card-body">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Jumlah Barang</label>
                                    <div class="form-group">
                                        <input type="text" value="{{ $order->order_total_item.' barang' }}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @csrf
                        <div class="card-body">
                            <table id="table-1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Barang</th>
                                        <th>Penyimpanan</th>
                                        <th>Jumlah Pengeluaran</th>
                                        <th>Sisa Stok Barang</th>
                                    </tr>
                                </thead>
                                <?php $no = 1; ?>
                                <tbody id="input-item-entry">
                                    @foreach($item as $i => $dataItem)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="idData[{{$i}}]" value="{{ 'DATA_'.\Carbon\Carbon::now()->format('dmy').rand(100,999).$i }}">
                                            <input type="hidden" name="slot_id[]" value="{{ $dataItem->slot_id }}">
                                            <input type="hidden" name="item_id[]" value="{{ $dataItem->item_id }}">
                                            <input type="hidden" name="item_pick[]" value="{{ $dataItem->warr_item_pick }}">
                                            {{ $no++ }}
                                        </td>
                                        <td>{{ $dataItem->item_name }}</td>
                                        <td>{{ $dataItem->slot_id.' / '.$dataItem->warehouse_name }}</td>
                                        <td>{{ $dataItem->warr_item_pick.' '.$dataItem->item_unit }}</td>
                                        <td>
                                            <input type="hidden" name="item_stock[]" value="{{ $dataItem->item_qty - $item->sum('warr_item_pick') }}">
                                            {{ $dataItem->item_qty - $item->sum('warr_item_pick').' '. $dataItem->item_unit }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                            <button type="submit" class="btn btn-primary mt-2" onclick="return confirm('Apakah pengeluaran barang sudah benar ?')">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#table-1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": false,
            "info": false,
            "ordering": false,
            "searching": false
        })
    })
</script>
@endsection

@endsection
