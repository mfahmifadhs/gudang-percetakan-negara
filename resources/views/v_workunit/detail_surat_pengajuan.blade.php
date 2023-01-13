@extends('v_main.layout.app')

@section('content')

<div class="container-xxl py-5">
    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="form-group row">
                    <div class="col-md-12 mb-4">
                        <a href="{{ url('unit-kerja/surat/daftar-surat-pengajuan/semua') }}" class=""><i class="fas fa-arrow-alt-circle-left"></i> KEMBALI</a>
                    </div>
                </div>
                <div class="form-group row text-capitalize">
                    <label class="col-md-2"><b>Tujuan</b></label>
                    <span class="col-md-10">: {{ $appletter->appletter_purpose }} barang</span>
                    <label class="col-md-2 mt-2"><b>Tanggal</b></label>
                    <span class="col-md-10 mt-2">: Pukul {{ \Carbon\Carbon::parse($appletter->appletter_date)->isoFormat('HH:mm / DD MMMM Y') }}</span>
                    <label class="col-md-2 mt-2"><b>Status Pengajuan</b></label>
                    <span class="col-md-10 mt-2">:
                        @if($appletter->appletter_status == 'proses')
                        <a class="btn btn-outline-primary p-1 disabled" style="font-size: 12px;">
                            Diproses
                        </a>
                        @elseif($appletter->appletter_status == 'ditolak')
                        <a class="btn btn-outline-danger p-1 disabled" style="font-size: 12px;">
                            Pengajuan Ditolak
                        </a>
                        @else
                        <a class="btn btn-outline-success p-1 disabled" style="font-size: 12px;">
                            Pengajuan Diterima
                        </a>
                        @endif
                    </span>
                    <form action="{{ url('unit-kerja/surat/tambah-pengajuan/update-surat' ) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="col-md-2 mt-2"><b>Surat Pengajuan</b></label>
                        <span class="col-md-10 mt-2">:
                            @if ($appletter->appletter_file != null)
                            <a href="{{ asset('data_file/surat_permohonan/'. $appletter->appletter_file) }}" target="_blank">{{ $appletter->appletter_file }}</a>
                            @else
                            <input type="hidden" name="id_appletter" value="{{ $appletter->id_app_letter }}">
                            <input type="file" class="bg-white" name="upload_spm" accept="application/pdf" style="font-size: 12px;" required> <br>
                            @endif
                        </span>
                        <label class="col-md-2 mt-2"><b>&nbsp;</b></label>
                        <span class="col-md-10 mt-2">&nbsp;
                            @if ($appletter->appletter_file == null)
                            <button type="submit" class="btn btn-primary btn-sm mt-3" style="font-size: 12px;" onclick="return confirm('Upload Surat Pengajuan ?')">
                                <i class="fas fa-upload"></i> Upload <span style="font-size: 9px;">Format file (.PDF)</span>
                            </button>
                            @endif
                        </span>
                    </form>
                    <span class="col-md-12 mt-2">
                        @if($appletter->appletter_status == 'diterima' && $appletter->appletter_process == 'false')
                        <a href="{{ url('unit-kerja/surat-perintah/'.$appletter->appletter_purpose.'/'. $appletter->id_app_letter) }}" class="btn btn-warning btn-sm mt-2" style="font-size: 12px;">
                            <i class="fas fa-plus-circle"></i> Buat Surat Perintah
                        </a>
                        @endif
                    </span>
                    <div class="col-md-12 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <h6 class="card-title pt-2 col-md-6 text-uppercase">
                                        daftar {{ $appletter->appletter_purpose }} barang
                                    </h6>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($appletter->appletter_purpose == 'penyimpanan')
                                <table id="table-1" class="table" style="color: black;">
                                    <thead>
                                        <tr style="font-size: 13px;">
                                            <th class="text-center" style="width: 1%;">No</th>
                                            <th style="width: 20%;">Nama Barang</th>
                                            <th style="width: 10%;">NUP</th>
                                            <th style="width: 10%;">Jumlah</th>
                                            <th style="width: 20%;">Keterangan</th>
                                            <th style="width: 10%;">Expired (Kadaluarsa)</th>
                                            <th style="width: 10%;">Status Pengajuan</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody class="small text-capitalize">
                                        @foreach($item as $dataItem)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                {{ $dataItem->item_category_name }} <br>
                                                {{ $dataItem->appletter_item_name }}
                                            </td>
                                            <td class="pt-3">
                                                @if ($dataItem->appletter_item_nup == null)
                                                -
                                                @else
                                                {{ $dataItem->appletter_item_nup }}
                                                @endif
                                            </td>
                                            <td class="pt-3">
                                                {{ $dataItem->appletter_item_qty.' '.$dataItem->appletter_item_unit }}
                                            </td>
                                            <td>
                                                @if ($dataItem->appletter_item_description != null)
                                                {{ $dataItem->appletter_item_description }} <br>
                                                Kondisi {{ $dataItem->item_condition_name }}
                                                @else
                                                <div style="padding-top: 1.2vh;">
                                                    Kondisi {{ $dataItem->item_condition_name }}
                                                </div>
                                                @endif
                                            </td>
                                            <td class="pt-3">
                                                @if ($dataItem->appletter_item_exp == null)
                                                -
                                                @else
                                                {{ \Carbon\carbon::parse($dataItem->appletter_item_exp)->isoFormat('DD MMM Y') }}
                                                @endif
                                            </td>
                                            <td class="pt-3">
                                                @if ($dataItem->appletter_item_status == null)
                                                proses
                                                @else
                                                {{ $dataItem->appletter_item_status }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <table id="table-1" class="table" style="color: black;">
                                    <thead>
                                        <tr style="font-size: 13px;">
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Keterangan</th>
                                            <th>Volume</th>
                                            <th>Jumlah</th>
                                            <th>Stok</th>
                                            <th>Penyimpanan</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody class="small text-capitalize">
                                        @foreach($item as $dataItem)
                                        <tr>
                                            <td class="text-center pt-3">{{ $no++ }}</td>
                                            <td>
                                                {{ $dataItem->item_category_name }} <br>
                                                {{ $dataItem->item_name }}
                                            </td>
                                            <td class="pt-3">{{ $dataItem->item_description }}</td>
                                            <td class="pt-3">{{ $dataItem->item_qty.' '.$dataItem->item_unit }}</td>
                                            <td class="pt-3">{{ $dataItem->item_pick.' '.$dataItem->item_unit }}</td>
                                            <td class="pt-3">{{ $dataItem->item_qty - $dataItem->item_pick.' '.$dataItem->item_unit }}</td>
                                            <td class="pt-3">{{ $dataItem->warehouse_name.' / '.$dataItem->slot_id }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
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
            "info": false,
            "sort": false,
            "paging": false,
            "searching": false
        });
    });
</script>
@endsection

@endsection
