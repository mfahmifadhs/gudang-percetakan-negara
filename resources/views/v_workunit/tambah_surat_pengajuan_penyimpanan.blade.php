@extends('v_main.layout.app')

@section('content')

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container" style="margin-top: 100px;">
        <div class="row g-5">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
                <div class="h-100">
                    <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
                    <h1 class="display-6 mb-4">Surat Pengajuan Penyimpanan</h1>
                    <form action="{{ url('unit-kerja/surat/tambah-pengajuan/penyimpanan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="purpose" value="penyimpanan">
                        <input type="hidden" name="id_appletter" value="spm_{{ random_int(100000, 999999) }}">
                        <div class="col-md-12 mb-4" data-wow-delay="0.3s">
                            <div class="causes-item d-flex flex-column bg-light border-top border-5 border-primary rounded-top overflow-hidden h-100" style="color: black;">
                                <form action="{{ url('unit-kerja/surat/tambah-pengajuan/penyimpanan') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 p-4 form-group">
                                            <label class="mb-2">
                                                <b>UPLOAD SURAT PENGAJUAN PENYIMPANAN YANG TELAH DIBUAT PADA APLIKASI <a href="https://srikandi.arsip.go.id/" target="_blank">SRIKANDI</a>.</b>
                                            </label>
                                            <div class="form-floating mt-2">
                                                <input type="file" class="form-control" name="upload_spm" accept="application/pdf" placeholder="Upload Barang" required>
                                                <label for="name">Upload File (Format .pdf)</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 p-4 form-group">
                                            <span style="float:left;margin-top:5px;">
                                                <b>DATA BARANG YANG AKAN DISIMPAN </b> <br> <small>Pastikan Seluruh Informasi Barang Terisi</small>
                                            </span>
                                            <span style="float:right;">
                                                <small>Jumlah Barang</small>
                                                <div class="form-group row">
                                                    <div class="col-md-8"><input type="text" id="total_item" name="total_item" value="1 " class="form-control"></div>
                                                    <div class="col-md-4"><a class="btn btn-primary " id="btn-total">PILIH</a></div>
                                                </div>
                                            </span>
                                        </div>
                                        <div class="col-md-12 p-4">`
                                            <table class="table table-responsive" style="color: black;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th style="width: 22%;">Jenis Barang</th>
                                                        <th style="width: 20%;">Nama Barang</th>
                                                        <th style="width: 20%;">Merk/Tipe</th>
                                                        <th style="width: 10%;">Jumlah</th>
                                                        <th style="width: 10%;">Satuan</th>
                                                        <th>Kondisi</th>
                                                    </tr>
                                                </thead>
                                                <?php $no = 1; ?>
                                                <tbody id="input-item">
                                                    <tr>
                                                        <td class="text-center">
                                                            <input type="hidden" name="id_appletter_detail[]" value="spm_item_{{ random_int(10000, 99999) }}">
                                                            {{ $no++ }}
                                                        </td>
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
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-12 p-4">
                                            <button type="submit" class="btn btn-primary py-2 px-3 me-3" onclick="return confirm('Apakah data sudah benar ?');">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </form>
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
        // More Item
        $('#btn-total').click(function() {
            $(".input-item").empty();
            let no = 2;
            let i;
            let totalItem = ($('#total_item').val()) - 1;
            console.log(totalItem);
            for (i = 1; i <= totalItem; i++) {
                $("#input-item").append(
                    `<tr class='input-item'>
                        <td class="text-center">
                            <input type="hidden" name="id_appletter_detail[]" value="spm_item_{{ random_int(10000, 99999) }}">
                            ` + no++ + `
                        </td>
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
        });

        // Summernote
        $('#summernote').summernote({
            placeholder: 'Maksud atau tujuan',
            height: 140,
            toolbar: [
                ['style', ['bold', 'italic']],
                ['para', ['ul', 'ol']],
            ]
        });
    });
</script>
@endsection

@endsection
