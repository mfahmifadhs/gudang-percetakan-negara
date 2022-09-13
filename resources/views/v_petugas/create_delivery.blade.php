@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Penyimpanan Barang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('unit-kerja/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pengiriman Barang</li>
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
                <form action="{{ url('petugas/barang/proses-simpan/'. $order->id_order) }}" method="POST">
                    @csrf
                    <div class="card card-outline card-body">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Batas Waktu Penyimpanan</label>
                                    <div class="form-group">
                                        <input type="date" name="deadline" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Jumlah Barang</label>
                                    <div class="form-group">
                                        <input type="number" id="total_item" minlength="1" value="{{ $order->order_total_item }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <div class="col-md-4"><a class="btn btn-primary " id="btn-total">PILIH</a></div>
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
                                        <th>Pilih Barang</th>
                                        <th>Jumlah</th>
                                        <th>Pilih Gudang</th>
                                        <th>Pilih Pallet</th>
                                    </tr>
                                </thead>
                                <?php $no = 1; ?>
                                <tbody id="input-item-entry">
                                    @foreach($item as $i => $dataItem)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="warrent_id[]" value="{{ $dataItem->warrent_id }}">
                                            <input type="hidden" name="idData[]" value="{{ 'DATA_'.\Carbon\Carbon::now()->format('dmy').rand(100,999) }}">
                                            {{ $no++ }}
                                        </td>
                                        <td>
                                            <select name="item_id[]" class="form-control item" data-idtarget={{$i}}>
                                                <option value="">-- Pilih Barang --</option>
                                                @foreach($item as $entryItem)
                                                <option value="{{ $entryItem->id_warr_entry }}">{{ $entryItem->warr_item_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><span id="item_qty{{$i}}"><input type="text" class="form-control"></span></td>
                                        <td>
                                            <select class="form-control warehouse" data-idtarget="{{$i}}">
                                                <option value="">-- Pilih Gudang --</option>
                                                @foreach($warehouse as $dataWarehouse)
                                                <option value="{{ $dataWarehouse->id_warehouse }}">{{ $dataWarehouse->warehouse_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="slot_id[]" id="slot_id{{$i}}" class="form-control">
                                                <option value="">-- Pilih Pallet --</option>
                                            </select>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                            <button type="submit" class="btn btn-primary mt-2" onclick="return confirm('Apakah penempatan barang sudah benar ?')">Submit</button>
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

    $(function() {
        let j = 1
        let id = "{{ $order->warrent_id }}"
        let sumItem = "{{ $order->order_total_item }}"
        // More Item
        $('#btn-total').click(function() {
            $(".input-item-entry").empty();
            let no = sumItem
            let i
            let totalItem = ($('#total_item').val()) - sumItem
            for (i = 1; i <= totalItem; i++) {
                ++j
                ++no
                $("#input-item-entry").append(
                    `<tr>
                        <td>` + no++ + `</td>
                            <td>
                                <select name="item_id[]" class="form-control item" data-idtarget=` + j + `>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($item as $entryItem)
                                    <option value="{{ $entryItem->id_warr_entry }}">{{ $entryItem->warr_item_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><span id="item_qty[]` + j + `"><input type="text" class="form-control"></span></td>
                            <td>
                                <select class="form-control warehouse" data-idtarget="` + j + `">
                                    <option value="">-- Pilih Gudang --</option>
                                    @foreach($warehouse as $dataWarehouse)
                                    <option value="{{ $dataWarehouse->id_warehouse }}">{{ $dataWarehouse->warehouse_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="slot_id[]" id="slot_id` + j + `" class="form-control">
                                    <option value="">-- Pilih Pallet --</option>
                                </select>
                            </td>
                        </tr>`
                )
            }
        })
        // Detail Item
        $(document).on('change', '.item', function() {
            let itemId = $(this).val();
            let target = $(this).data('idtarget');
            if (itemId) {
                $.ajax({
                    type: "GET",
                    url: "/petugas/get-item/penyimpanan?itemId=" + itemId,
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            $("#item_qty" + target).empty();
                            $("#item" + target).select2();
                            $("#item" + target).append('<option value="">-- Pilih Barang --</option>');
                            $.each(res, function(index, row) {
                                $("#item_qty" + target).append(
                                    '<input type="number" name="item_qty[]" class="form-control" value="' + row.warr_item_qty + '" maxLength="' + row.warr_item_qty + '">'
                                )
                                $("#item" + target).append(
                                    '<option value="' + row.id_warr_entry + '">' + row.warr_item_name + '</option>'
                                )
                            });
                        } else {
                            $("#item" + target).empty();
                        }
                    }
                })
            }
        })
        // Detail Warehouse
        $(document).on('change', '.warehouse', function() {
            let warehouseId = $(this).val();
            let target = $(this).data('idtarget');
            if (warehouseId) {
                $.ajax({
                    type: "GET",
                    url: "/petugas/get-warehouse/penyimpanan?warehouseId=" + warehouseId,
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            $("#slot_id" + target).empty()
                            $("#slot_id" + target).select2()
                            $("#slot_id" + target).append('<option value="">-- Pilih Pallet --</option>')
                            $.each(res, function(index, row) {
                                console.log(res)
                                $("#slot_id" + target).append(
                                    '<option value="' + row.id_slot + '">' + row.id_slot + '</option>'
                                )
                            })
                        } else {
                            $("#slot_id" + target).empty();
                        }
                    }
                })
            }
        })

    })
</script>
@endsection


@endsection
