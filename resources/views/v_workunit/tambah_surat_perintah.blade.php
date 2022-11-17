@extends('v_main.layout.app')

@section('content')

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container" style="margin-top: 100px;">
        <div class="row g-5">
            <div class="col-lg-12">
                <div class="h-100">
                    <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
                    <h1 class="display-6 mb-4 text-capitalize">surat perintah {{ $aksi }}</h1>
                    <div class="col-md-12 mb-4">
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
                    <div class="col-md-12 mb-4">
                        <div class="causes-item d-flex flex-column bg-light border-top border-5 border-primary rounded-top overflow-hidden h-100" style="color: black;">
                            <form action="{{ url('unit-kerja/surat-perintah/proses/'. $aksi) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_warrent" value="warr_{{ \Carbon\Carbon::now()->isoFormat('MMDDYY').rand(100,999) }}">
                                <input type="hidden" name="appletter_id" value="{{ $appletter->id_app_letter }}">
                                <div class="row">
                                    <div class="col-md-12 p-4 text-capitalize">
                                        <label class="mb-2">
                                            <b> informasi penyimpanan/pengeluaran barang </b><br>
                                            <small>seluruh informasi penyimpanan/pengeluaran barang, wajib diisi</small>
                                        </label>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <small> Tanggal Penyimpanan/Pengeluaran</small>
                                                    <input type="date" class="form-control" name="warr_dt" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <small> Nama Pengirim/Pengambil Barang</small>
                                                    <input type="text" class="form-control" name="warr_emp_name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <small> Jabatan Pengirim/Pengambil Barang</small>
                                                    <input type="text" class="form-control" name="warr_emp_position" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 p-4 text-capitalize">
                                        <label class="mb-2">
                                            <b> upload surat perintah {{ $aksi }} </b><br>
                                            <small>
                                                surat perintah dibuat pada aplikasi <a href="https://srikandi.arsip.go.id/" target="_blank">SRIKANDI</a>.</small>
                                        </label>
                                        <div class="form-floating mt-2">
                                            <input type="file" class="form-control" name="upload_warr" accept="application/pdf" placeholder="Upload Barang">
                                            <label for="name">Upload File (Format .pdf)</label>
                                        </div>
                                    </div>
                                    @if($aksi == 'penyimpanan')
                                    <div class="col-md-12 p-4 text-capitalize">
                                        <p>
                                            <b>data barang yang akan disimpan</b> <br> <small>pastikan seluruh informasi barang terisi</small>
                                        </p>
                                        <table class="table table-responsive" style="color: black;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th style="width: 22%;">Jenis Barang</th>
                                                    <th style="width: 20%;">Nama Barang</th>
                                                    <th style="width: 20%;">Keterangan</th>
                                                    <th style="width: 10%;">Jumlah</th>
                                                    <th style="width: 10%;">Satuan</th>
                                                    <th>Kondisi</th>
                                                </tr>
                                            </thead>
                                            <?php $no = 1; ?>
                                            <tbody id="input-item">
                                                @foreach($item as $dataItem)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="id_warr_entry[]" value="warr_entry_{{ \Carbon\Carbon::now()->isoFormat('MMDDYY').rand(100,999) }}">
                                                        <input type="hidden" name="total_item" value="{{ count($item) }}">
                                                        {{ $no++ }}
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="item_category_id[]" value="{{ $dataItem->id_item_category }}">
                                                        {{ $dataItem->item_category_name }}
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="item_name[]" value="{{ $dataItem->item_name }}">
                                                        {{ $dataItem->item_name }}
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="item_description[]" value="{{ $dataItem->item_description }}">
                                                        {{ $dataItem->item_description }}
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="item_qty[]" value="{{ $dataItem->item_qty }}">
                                                        {{ $dataItem->item_qty }}
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="item_unit[]" value="{{ $dataItem->item_unit }}">
                                                        {{ $dataItem->item_unit }}
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="item_condition_id[]" value="{{ $dataItem->id_item_condition }}">
                                                        {{ $dataItem->item_condition_name }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="col-md-12 p-4 text-capitalize">
                                        <p>
                                            <b>data barang yang akan dikeluarkan</b> <br> <small>pastikan seluruh informasi barang terisi</small>
                                        </p>
                                        <table class="table table-responsive" style="color: black;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th style="width: 22%;">Jenis Barang</th>
                                                    <th style="width: 20%;">Nama Barang</th>
                                                    <th style="width: 20%;">Merk/Tipe</th>
                                                    <th style="width: 10%;">Jumlah</th>
                                                    <th style="width: 10%;">Penyimpanan</th>
                                                    <th>Kondisi</th>
                                                </tr>
                                            </thead>
                                            <?php $no = 1; ?>
                                            <tbody id="input-item">
                                                @foreach($item as $dataItem)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="id_warr_exit[]" value="warr_exit_{{ \Carbon\Carbon::now()->isoFormat('MMDDYY').rand(100,999) }}">
                                                        <input type="hidden" name="total_item" value="{{ count($item) }}">
                                                        <input type="hidden" name="item_id[]" value="{{ $dataItem->item_id }}">
                                                        <input type="hidden" name="item_pick[]" value="{{ $dataItem->item_pick }}">
                                                        <input type="hidden" name="slot_id[]" value="{{ $dataItem->slot_id }}">
                                                        {{ $no++ }}
                                                    </td>
                                                    <td>{{ $dataItem->item_category_name }}</td>
                                                    <td>{{ $dataItem->item_name }}</td>
                                                    <td>{{ $dataItem->item_description }}</td>
                                                    <td>{{ $dataItem->item_qty.' '.$dataItem->item_unit }}</td>
                                                    <td>{{ $dataItem->slot_id }}</td>
                                                    <td>{{ $dataItem->item_condition_name }}</td>
                                                </tr>
                                                @endforeach
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

@endsection
