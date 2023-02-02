@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Penyimpanan Barang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('petugas/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Penyimpanan Barang</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<!-- Main content -->
<section class="content">
    <div class="container">
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
                    <div class="card card-outline">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">
                                Proses Penyimpanan Barang
                            </h3>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Batas Waktu Penyimpanan</label>
                                    <div class="form-group">
                                        <input type="date" name="deadline" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <table id="table-1" class="table table-bordered" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pilih Barang</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Pilih Gudang</th>
                                        <th>Pilih Pallet</th>
                                        <th>Kapasitas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <?php $no = 1; ?>
                                <tbody id="section-input">
                                    <tr>
                                        <td class="text-center pt-3">
                                            <input type="hidden" name="warrent_id" value="{{ $order->warrent_id }}">
                                            <input type="hidden" name="idData[]" value="{{ 'DATA'.\Carbon\Carbon::now()->format('dmy').rand(100,999) }}">
                                            {{ $no++ }}
                                        </td>
                                        <td>
                                            <select name="item_id[]" class="form-control form-control-sm item" data-idtarget=0 style="font-size: 14px;">
                                                <option value="">-- Pilih Barang --</option>
                                                @foreach($item as $entryItem)
                                                <option value="{{ $entryItem->id_item }}">{{ $entryItem->item_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <span id="item_qty0">
                                                <input type="number" class="form-control form-control-sm" placeholder="satuan" readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span id="item_unit0">
                                                <input type="text" class="form-control form-control-sm" placeholder="jumlah" readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm warehouse" data-idtarget=0>
                                                <option value="">-- Pilih Gudang --</option>
                                                @foreach($warehouse as $dataWarehouse)
                                                <option value="{{ $dataWarehouse->id_warehouse }}">{{ $dataWarehouse->warehouse_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="slot_id[]" id="slot_id0" class="form-control form-control-sm">
                                                <option value="">-- Pilih Pallet --</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="slot_status[]" class="form-control form-control-sm">
                                                <option value="tersedia">Tersedia</option>
                                                <option value="kosong">Kosong</option>
                                                <option value="penuh">Penuh</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <a id="add-row" class="btn btn-dark btn-sm text-uppercase font-weight-bold">
                                                <i class="fas fa-plus-circle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah penempatan barang sudah benar ?')">Submit</button>
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
        let sumItem = "{{ $order->order_total_item }}"
        let i = 0
        let no = 1
        let id = "{{ $order->warrent_id }}"

        $("#table-1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": false,
            "info": false,
            "ordering": false,
            "searching": false,
            "columnDefs": [{
                "width": "0%",
                "targets": 0
            }, {
                "width": "20%",
                "targets": 1
            }, {
                "width": "10%",
                "targets": 2
            }, {
                "width": "10%",
                "targets": 3
            }, {
                "width": "0%",
                "targets": 7
            }, ]
        })
        // More Item
        $('#add-row').click(function() {
            ++i
            ++no
            $("#section-input").append(
                `<tr class="row-penyimpanan">
                    <td class="text-center pt-3">
                        <input type="hidden" name="idData[` + i + `]" value="{{ 'DATA'.\Carbon\Carbon::now()->format('dmy').rand(100,999) }}` + no + `">
                        ` + no + `
                    </td>
                    <td>
                        <select name="item_id[]" class="form-control form-control-sm item" data-idtarget=` + i + `>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($item as $entryItem)
                            <option value="{{ $entryItem->id_item }}">{{ $entryItem->item_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <span id="item_qty` + i + `">
                            <input type="text" class="form-control form-control-sm">
                        </span>
                    </td>
                    <td>
                        <span id="item_unit` + i + `">
                            <input type="text" class="form-control form-control-sm" readonly>
                        </span>
                    </td>
                    <td>
                        <select class="form-control form-control-sm warehouse" data-idtarget="` + i + `">
                            <option value="">-- Pilih Gudang --</option>
                            @foreach($warehouse as $dataWarehouse)
                            <option value="{{ $dataWarehouse->id_warehouse }}">{{ $dataWarehouse->warehouse_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="slot_id[]" id="slot_id` + i + `" class="form-control form-control-sm">
                            <option value="">-- Pilih Pallet --</option>
                        </select>
                    </td>
                    <td>
                        <select name="slot_status[]" class="form-control form-control-sm">
                            <option value="tersedia">tersedia</option>
                            <option value="kosong">kosong</option>
                            <option value="penuh">penuh</option>
                        </select>
                    </td>
                    <td>
                        <a id="remove-row" class="btn btn-dark btn-sm text-uppercase font-weight-bold">
                            <i class="fas fa-minus-circle"></i>
                        </a>
                    </td>
                </tr>`
            )

            $(document).on('click', '#remove-row', function() {
                $(this).parents('.row-penyimpanan').remove();
            })
        })

        // Detail Item
        $(document).on('change', '.item', function() {
            let itemId = $(this).val()
            let target = $(this).data('idtarget')
            let proses = `{{ $proses }}`
            let itemQty = $('#qty' + (target - 1)).val()
            let qty
            if (itemId) {
                $.ajax({
                    type: "GET",
                    url: "/petugas/get-item/penyimpanan?itemId=" + itemId,
                    data: {
                        "proses": proses
                    },
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            $("#item_qty" + target).empty();
                            $("#item_unit" + target).empty();
                            // $("#item" + target).select2();
                            $("#item" + target).append('<option value="">-- Pilih Barang --</option>');
                            $.each(res, function(index, row) {
                                target > 0 ? qty = row.item_qty - itemQty : qty = row.item_qty
                                $("#item_qty" + target).append(
                                    '<input type="number" name="item_qty[]" id="qty' + i + '" class="form-control form-control-sm" value="' + row.item_qty + '" maxLength="' + row.item_qty + '">'
                                )
                                $("#item_unit" + target).append(
                                    '<input type="text" name="item_unit[]" class="form-control form-control-sm" value="' + row.item_unit + '" readonly>'
                                )
                                $("#item" + target).append(
                                    '<option value="' + row.id_item + '">' + row.item_name + '</option>'
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
                            // $("#slot_id" + target).select2()
                            $("#slot_id" + target).append('<option value="">-- Pilih Pallet --</option>')
                            $.each(res, function(index, row) {
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
