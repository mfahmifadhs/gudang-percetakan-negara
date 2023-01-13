@extends('v_main.layout.app')

@section('content')

<div class="container-xxl py-5">
    <div class="container" style="margin-top: 100px;">
        <div class="row g-5">
            <div class="col-lg-12">
                <div class="h-100">
                    <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
                    <h1 class="display-6 mb-4 text-capitalize">surat pengajuan {{ $id }}</h1>
                    <div class="col-md-12 mb-4">
                        <div class="causes-item d-flex flex-column bg-light border-top border-5 border-primary rounded-top overflow-hidden h-100" style="color: black;">
                            <form action="{{ url('unit-kerja/surat/tambah-pengajuan/'. $id ) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 p-4 form-group">
                                        <label class="mb-2 text-capitalize">
                                            <b> upload surat permohonan pengajuan {{ $id }} </b><br>
                                            <small>
                                                surat permohonan pengajuan dibuat pada aplikasi <a href="https://srikandi.arsip.go.id/" target="_blank">SRIKANDI</a>.</small>
                                        </label>
                                        <div class="mt-2">
                                            <input type="file" class="form-control bg-white" name="upload_spm" accept="application/pdf" placeholder="Upload Barang">
                                            <label class="col-form-label text-muted"><small>Upload File (Format .pdf)</small></label>
                                        </div>
                                    </div>
                                    @if($id == 'penyimpanan')
                                    <input type="hidden" name="purpose" value="penyimpanan">
                                    <input type="hidden" name="id_appletter" value="spm_{{ random_int(100000, 999999) }}">
                                    <div class="col-md-12 p-4 form-group">
                                        <span style="float:left;margin: 3vh 0vh 4vh 0vh;">
                                            <b>Data Barang </b> <br> <small>Pastikan Seluruh Informasi Barang Terisi</small>
                                        </span>
                                        <!-- <span style="float:right;margin: 0vh 3vh 4vh 0vh;">
                                            <span style="font-size: 13px;">
                                                <i class="fas fa-file-upload"></i> Upload File <span style="font-size: 10px;"> (<a href="" download>Download </a> Format) </span>
                                            </span>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <input type="file" class="form-control" name="file_barang" style="font-size: 12px;">
                                                    <span style="font-size: 10px;">Upload file sesuai format dan format file (.xls)</span>
                                                </div>
                                            </div>
                                        </span> -->
                                        <table class="table table-responsive" style="color: black;">
                                            <thead>
                                                <tr style="font-size: 13px;">
                                                    <th class="text-center" style="width: 1%;">No</th>
                                                    <th style="width: 18%;">Jenis Barang</th>
                                                    <th style="width: 15%;">Nama Barang</th>
                                                    <th style="width: 15%;">Merk/Tipe</th>
                                                    <th style="width: 8%;">Jumlah</th>
                                                    <th style="width: 10%;">Satuan</th>
                                                    <th style="width: 18%;">Keterangan</th>
                                                    <th style="width: 10%;">Kondisi</th>
                                                    <th style="width: 5%;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <?php $no = 1; ?>
                                            <tbody id="section-input">
                                                <tr>
                                                    <td class="text-center pt-3" style="font-size: 13px;">{{ $no++ }}</td>
                                                    <td>
                                                        <select class="form-control bg-white" name="item_category_id[]" style="font-size: 13px;">
                                                            <option value="">-- Pilih Kategori Barang --</option>
                                                            @foreach($item_ctg as $dataItemCtg)
                                                            <option value="{{ $dataItemCtg->item_category_name }}">{{ $dataItemCtg->item_category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input class="form-control" name="appletter_item_name[]" style="font-size: 13px;" placeholder="Contoh: Mini Trampoline"></td>
                                                    <td><input class="form-control" name="appletter_item_merktype[]" style="font-size: 13px;" placeholder="Contoh: Kidilos"></td>
                                                    <td><input type="number" class="form-control" name="appletter_item_qty[]" minlength="1" style="font-size: 13px;" value="1"></td>
                                                    <td><input type="text" class="form-control text-uppercase" name="appletter_item_unit[]" style="font-size: 13px;"></td>
                                                    <td><input class="form-control" name="appletter_item_description[]" rows="3" style="font-size: 13px;" placeholder="Contoh: 1 box isi 5 pcs"></td>
                                                    <td>
                                                        <select class="form-control bg-white" name="item_condition_id[]" style="font-size: 13px;">
                                                            @foreach($item_condition as $dataItemCondition)
                                                            <option value="{{ $dataItemCondition->item_condition_name }}">{{ $dataItemCondition->item_condition_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <a id="add-row-penyimpanan" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-plus-square"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <input type="hidden" name="purpose" value="pengeluaran">
                                    <input type="hidden" name="id_appletter" value="spk_{{ random_int(100000, 999999) }}">
                                    <div class="col-md-12 p-4 form-group">
                                        <span style="float:left;margin-top:8px;">
                                            <b>Data Barang </b> <br> <small>Pastikan Seluruh Informasi Barang Terisi</small>
                                        </span>
                                        <span style="float:right;">
                                            <small>Jumlah Barang</small>
                                            <div class="form-group row">
                                                <div class="col-md-8"><input type="number" id="total_item" name="total_item" value="1" class="form-control"></div>
                                                <div class="col-md-4"><a class="btn btn-primary " id="btn-total">PILIH</a></div>
                                            </div>
                                        </span>
                                        <table class="table table-responsive" style="color: black;margin-top:15vh;">
                                            <thead>
                                                <tr style="font-size: 13px;">
                                                    <th class="text-center">No</th>
                                                    <th style="width: 22%;">Jenis Bsarang</th>
                                                    <th style="width: 20%;">Nama Barang</th>
                                                    <th>Lok. Penyimpanan</th>
                                                    <th style="width: 10%;">Jumlah (Stok)</th>
                                                    <th style="width: 10%;">Jumlah (Diambil)</th>
                                                    <th style="width: 10%;">Satuan</th>
                                                    <th style="width: 5%;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <?php $no = 1; ?>
                                            <tbody id="section-input">
                                                <tr>
                                                    <td class="text-center pt-3" style="font-size: 13px;">{{ $no++ }}</td>
                                                    <td>
                                                        <select name="id_item_category[]" class="form-control bg-white kategori" data-idtarget="1" style="font-size: 13px;" required>
                                                            <option value="">-- Pilih Jenis Barang --</option>
                                                            @foreach($item_ctg as $dataCategory)
                                                            <option value="{{ $dataCategory->id_item_category }}">{{ $dataCategory->item_category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="font-size: 13px;">
                                                        <select name="id_item_code[]" class="form-control bg-white detailItem" id="item1" data-idtarget="1" style="font-size: 13px;" required>
                                                            <option value="">-- Pilih Barang --</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="id_order_data[]" class="form-control bg-white detailWarehouse" id="data1" data-idtarget="1" style="font-size: 13px;" required>
                                                            <option value="">-- Pilih Lokasi Penyimpanan --</option>
                                                        </select>
                                                    </td>
                                                    <td><span id="item_qty1"><input type="text" class="form-control" style="font-size: 13px;" readonly></span></td>
                                                    <td><span id="item_pick1"><input type="text" class="form-control" style="font-size: 13px;" readonly></span></td>
                                                    <td><span id="item_unit1"><input type="text" class="form-control" style="font-size: 13px;" readonly></span></td>
                                                    <td>
                                                        <a id="add-row-pengeluaran" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-plus-square"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                    <div class="col-md-12 p-4">
                                        <button type="submit" class="btn btn-primary py-2 px-3 me-3" onclick="return confirm('Apakah data sudah benar ?');">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- About End -->

@section('js')
<script>
    $(function() {
        let j = 1
        let no = 1
        let id = "{{ $id }}"
        let slotData = []

        // More Item
        $('#add-row-penyimpanan').click(function() {
            ++j
            ++no
            $("#section-input").append(
                `<tr class="row-penyimpanan">
                    <td class="text-center pt-3" style="font-size: 13px;">` + no + `</td>
                    <td>
                        <select class="form-control bg-white" name="item_category_id[]" style="font-size: 13px;">
                            <option value="">-- Pilih Kategori Barang --</option>
                            @foreach($item_ctg as $dataItemCtg)
                            <option value="{{ $dataItemCtg->item_category_name }}">{{ $dataItemCtg->item_category_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input class="form-control" name="appletter_item_name[]" style="font-size: 13px;" placeholder="Contoh: Mini Trampoline"></td>
                    <td><input class="form-control" name="appletter_item_merktype[]" style="font-size: 13px;" placeholder="Contoh: Kidilos"></td>
                    <td><input type="number" class="form-control" name="appletter_item_qty[]" minlength="1" style="font-size: 13px;" value="1"></td>
                    <td><input type="text" class="form-control text-uppercase" name="appletter_item_unit[]" style="font-size: 13px;"></td>
                    <td><input class="form-control" name="appletter_item_description[]" rows="3" style="font-size: 13px;" placeholder="Contoh: 1 box isi 5 pcs"></td>
                    <td>
                        <select class="form-control bg-white" name="item_condition_id[]" style="font-size: 13px;">
                            @foreach($item_condition as $dataItemCondition)
                            <option value="{{ $dataItemCondition->item_condition_name }}">{{ $dataItemCondition->item_condition_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <a id="remove-row-penyimpanan" class="btn btn-danger btn-sm">
                            <i class="fas fa-minus-square"></i>
                        </a>
                    </td>
                    </tr>`
            )

            $(document).on('click', '#remove-row-penyimpanan', function() {
                $(this).parents('.row-penyimpanan').remove();
            });
        })

        $('#add-row-pengeluaran').click(function() {
            ++j
            ++no
            $("#section-input").append(
                `<tr class="row-pengeluaran">
                    <td class="text-center pt-3" style="font-size: 13px;">{{ $no++ }}</td>
                    <td>
                        <select name="id_item_category[]" class="form-control bg-white kategori" data-idtarget="` + j + `" style="font-size: 13px;" required>
                            <option value="">-- Pilih Jenis Barang --</option>
                            @foreach($item_ctg as $dataCategory)
                            <option value="{{ $dataCategory->id_item_category }}">{{ $dataCategory->item_category_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td style="font-size: 13px;">
                        <select name="id_item_code[]" class="form-control bg-white detailItem" id="item` + j + `" data-idtarget="` + j + `" style="font-size: 13px;" required>
                            <option value="">-- Pilih Barang --</option>
                        </select>
                    </td>
                    <td>
                        <select name="id_order_data[]" class="form-control bg-white detailWarehouse " id="data` + j + `" data-idtarget="` + j + `" style="font-size: 13px;" required>
                            <option value="">-- Pilih Lokasi Penyimpanan --</option>
                        </select>
                    </td>
                    <td><span id="item_qty` + j + `"><input type="text" class="form-control" style="font-size: 13px;" readonly></span></td>
                    <td><span id="item_pick` + j + `"><input type="text" class="form-control" style="font-size: 13px;" readonly></span></td>
                    <td><span id="item_unit` + j + `"><input type="text" class="form-control" style="font-size: 13px;" readonly></span></td>
                    <td>
                        <a id="remove-row-pengeluaran" class="btn btn-danger btn-sm">
                            <i class="fas fa-minus-square"></i>
                        </a>
                    </td>
                </tr>`
            )

            $(document).on('click', '#remove-row-pengeluaran', function() {
                $(this).parents('.row-pengeluaran').remove();
            })

        })
        // More Item
        $('#btn-total').click(function() {
            if (id == 'penyimpanan') {
                $(".input-item-entry").empty();
                let no = 2
                let i
                let totalItem = ($('#total_item').val()) - 1
                for (i = 1; i <= totalItem; i++) {
                    ++j
                    $("#input-item-entry").append(
                        `<tr class="input-item-entry">
                            <td class="text-center">` + no++ + `</td>
                            <td>
                                <select class="form-control bg-white" name="item_category_id[]">
                                    <option value="">-- Pilih Kategori Barang --</option>
                                    @foreach($item_ctg as $dataItemCtg)
                                    <option value="{{ $dataItemCtg->id_item_category }}">{{ $dataItemCtg->item_category_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><textarea class="form-control" name="appletter_item_name[]" rows="3"></textarea></td>
                            <td><textarea class="form-control" name="appletter_item_type[]" rows="3"></textarea></td>
                            <td><input type="number" class="form-control" name="appletter_item_qty[]" minlength="1"></td>
                            <td><input type="text" class="form-control" name="appletter_item_unit[]"></td>
                            <td>
                                <select class="form-control bg-white" name="item_condition_id[]">
                                    @foreach($item_condition as $dataItemCondition)
                                    <option value="{{ $dataItemCondition->id_item_condition }}">{{ $dataItemCondition->item_condition_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>`
                    )
                }
            } else if (id == 'pengeluaran') {
                $(".input-item-exit").empty();
                let no = 2
                let i
                let totalItem = ($('#total_item').val()) - 1
                for (i = 1; i <= totalItem; i++) {
                    ++j
                    $("#input-item-exit").append(
                        `<tr class="input-item-exit">
                                <td>
                                    ` + no++ + `
                                </td>
                                <td>
                                    <select name="id_item_category[]" class="form-control bg-white kategori" data-idtarget="` + j + `">
                                        <option value="">-- Pilih Jenis Barang --</option>
                                        @foreach($item_ctg as $dataCategory)
                                        <option value="{{ $dataCategory->id_item_category }}">{{ $dataCategory->item_category_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="id_item_code[]" class="form-control bg-white detailItem" id="item` + j + `" data-idtarget="` + j + `" >
                                        <option value="">-- Pilih Barang --</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="id_order_data[]" class="form-control bg-white detailWarehouse" id="data` + j + `" data-idtarget="` + j + `">
                                        <option value="">-- Pilih Lokasi Penyimpanan --</option>
                                    </select>
                                </td>
                                <td><span id="item_qty` + j + `"><input type="text" class="form-control" readonly></span></td>
                                <td><span id="item_pick` + j + `"><input type="text" class="form-control" readonly></span></td>
                            </tr>`
                    )
                }
            }
        })

        $(document).on('change', '.kategori', function() {
            let itemCategoryId = $(this).val()
            let target = $(this).data('idtarget')
            if (itemCategoryId) {
                $.ajax({
                    type: "GET",
                    url: "/unit-kerja/get-item/daftar?kategori=" + itemCategoryId,
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            $("#item" + target).empty();
                            // $("#item" + target).select2();
                            $("#item" + target).append('<option value="">-- Pilih Barang --</option>');
                            $.each(res, function(index, row) {
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

        // Menyimpan data slot id dalam Array
        $(document).on('change', '.detailItem', function() {
            slotData = $('.detailWarehouse').map(function() {
                return this.value
            }).get()
        })

        // Menampilkan detail informasi barang
        $(document).on('change', '.detailItem', function() {
            let idItem = $(this).val()
            let target = $(this).data('idtarget')
            if (idItem) {
                $.ajax({
                    type: "GET",
                    url: "/unit-kerja/get-item/penyimpanan?idItem=" + idItem,
                    data: {
                        "data": slotData
                    },
                    dataType: 'JSON',
                    success: function(res) {
                        $("#data" + target).empty();
                        $("#data" + target).append('<option value="">-- Pilih Penyimpanan --</option>');
                        $.each(res, function(index, row) {
                            $("#data" + target).append(
                                '<option value="' + row.slot_id + '">' + row.slot_id + '</option>'
                            );
                        })
                    }
                })
            }
        })

        $(document).on('change', '.detailWarehouse', function() {
            let idWarehouse = $(this).val()
            let target = $(this).data('idtarget')
            let itemId = $('#item' + target).val()
            if (idWarehouse) {
                $.ajax({
                    type: "GET",
                    url: "/unit-kerja/get-item/stok?idWarehouse=" + idWarehouse,
                    data: {
                        "idItem": itemId
                    },
                    dataType: 'JSON',
                    success: function(res) {
                        $("#item_qty" + target).empty()
                        $("#item_pick" + target).empty()
                        $("#item_unit" + target).empty()
                        $.each(res, function(index, row) {
                            $("#item_qty" + target).append(
                                '<input type="number" class="form-control" style="font-size: 13px;" value="' + row.total_item + '" readonly>'
                            )
                            $("#item_pick" + target).append(
                                '<input type="number" name="item_pick[]" class="form-control" style="font-size: 13px;" minLength="1" max="' + row.total_item + '" >'
                            )
                            $("#item_unit" + target).append(
                                '<input type="text" name="item_unit[]" class="form-control" style="font-size: 13px;" value="' + row.item_unit + '" readonly>'
                            )
                        })
                    }
                })
            }
        })
    });
</script>
@endsection

@endsection
