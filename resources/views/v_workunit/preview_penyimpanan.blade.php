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
                            <form action="{{ url('unit-kerja/surat/tambah-pengajuan/proses-simpan' ) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_appletter" value="{{ $letter[0]['id_appletter'] }}">
                                <input type="hidden" name="purpose" value="{{ $letter[0]['purpose'] }}">
                                <div class="form-group row p-3" style="font-size: 14px;">
                                    <label class="col-md-2">Tujuan</label>
                                    <label class="col-md-10 text-uppercase"> : {{ $letter[0]['purpose'] }} Barang</label>
                                    <label class="col-md-2 mt-2">Tanggal</label>
                                    <label class="col-md-10 mt-2"> : {{ \Carbon\carbon::now()->isoFormat('DD MMMM Y') }}</label>
                                    <label class="col-md-2 mt-2">Kode</label>
                                    <label class="col-md-10 mt-2"> : {{ $letter[0]['id_appletter'] }}</label>
                                    <label class="col-md-2 mt-2">Surat Permohonan</label>
                                    <label class="col-md-6 mt-2"> :
                                        @if ($letter[0]['appletter_file'] != null)
                                        <a href="{{ asset('data_file/surat_permohonan/'. $letter[0]['appletter_file']) }}" target="_blank">{{ $letter[0]['appletter_file'] }}</a>
                                        <input type="hidden" name="filename" value="{{ $letter[0]['appletter_file'] }}">
                                        @else
                                        <input type="file" class="bg-white" name="upload_spm" accept="application/pdf" style="font-size: 12px;"> <br>
                                        <span style="font-size: 10px;margin-left:1.2vh;">Format file (.PDF)</small></span>
                                        @endif
                                    </label>
                                    <div class="col-md-12 form-group">
                                        <span style="float:left;margin: 3vh 0vh 4vh 0vh;">
                                            <b>Konfirmasi Data Barang </b> <br> <small>Mohon untuk mengecek kembali dan melengkapi informasi barang yang akan disimpan</small>
                                        </span>
                                        <table class="table table-responsive" style="color: black;">
                                            <thead>
                                                <tr style="font-size: 13px;">
                                                    <th class="text-center" style="width: 10%;">No</th>
                                                    <th style="width: 20%;">Nama Barang</th>
                                                    <th style="width: 10%;">NUP</th>
                                                    <th style="width: 10%;">Jumlah</th>
                                                    <th style="width: 20%;">Keterangan</th>
                                                    <th style="width: 20%;">Expired (Kadaluarsa)</th>
                                                </tr>
                                            </thead>
                                            <?php $no = 1; ?>
                                            <tbody id="section-input">
                                                @foreach ($item as $dataItem)
                                                <tr>
                                                    <td class="text-center pt-3" style="font-size: 13px;">{{ $no++ }}</td>
                                                    <td class="text-capitalize">
                                                        <input type="hidden" class="form-control" name="id_item_code[]" value="{{ $dataItem['item_category'] }}">
                                                        <input type="hidden" class="form-control" name="appletter_item_name[]" value="{{ $dataItem['appletter_item_name'] }}">
                                                        <input type="hidden" class="form-control" name="appletter_item_merktype[]" value="{{ $dataItem['appletter_item_merktype'] }}">
                                                        <span style="font-size: 13px;">
                                                            {{ $dataItem['item_category'] }} <br>
                                                            {{ $dataItem['appletter_item_name'].' '.$dataItem['appletter_item_merktype'] }}
                                                        </span>
                                                    </td>
                                                    <td style="padding-top: 1.5vh;">
                                                        @if ($dataItem['item_category'] == 'Barang Milik Negara (BMN)')
                                                        <input type="number" class="form-control" name="appletter_item_nup[]" placeholder="NUP Barang" style="font-size: 12px;" required>
                                                        @else
                                                        <input type="text" class="form-control" name="appletter_item_nup[]" value="" placeholder="-" style="font-size: 12px;" readonly>
                                                        @endif
                                                    </td>
                                                    <td class="text-uppercase pt-3">
                                                        <input type="hidden" class="form-control" name="appletter_item_qty[]" value="{{ $dataItem['appletter_item_qty'] }}">
                                                        <input type="hidden" class="form-control" name="appletter_item_unit[]" value="{{ $dataItem['appletter_item_unit'] }}">
                                                        <span style="font-size: 13px;">
                                                            {{ $dataItem['appletter_item_qty'].' '.$dataItem['appletter_item_unit'] }}
                                                        </span>
                                                    </td>
                                                    <td class="text-capitalize">
                                                        <input type="hidden" class="form-control" name="appletter_item_description[]" value="{{ $dataItem['appletter_item_description'] }}">
                                                        <input type="hidden" class="form-control" name="item_condition_id[]" value="{{ $dataItem['item_condition'] }}">
                                                        <span style="font-size: 13px;">
                                                            @if ($dataItem['appletter_item_description'] != null)
                                                            {{ $dataItem['appletter_item_description'] }} <br>
                                                            Kondisi {{ $dataItem['item_condition'] }}
                                                            @else
                                                            <div style="padding-top: 1.2vh;">
                                                            Kondisi {{ $dataItem['item_condition'] }}
                                                            </div>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td style="padding-top:1.5vh;">
                                                        @if ($dataItem['item_category'] == 'Barang Persediaan')
                                                        <input type="date" class="form-control" name="appletter_item_exp[]" style="font-size: 12px;" min="{{ \Carbon\carbon::now()->isoFormat('YYYY-MM-D') }}" value="{{ \Carbon\carbon::now()->isoFormat('YYYY-MM-D') }}">
                                                        @else
                                                        <input type="text" class="form-control" name="appletter_item_exp[]" style="font-size: 12px;" value="" placeholder="-" readonly>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
