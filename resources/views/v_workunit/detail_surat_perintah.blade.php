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
                    <span class="col-md-10">: {{ $warrent->warr_purpose }} barang</span>
                    <label class="col-md-2 mt-2"><b>Tanggal</b></label>
                    <span class="col-md-10 mt-2">: {{ \Carbon\Carbon::parse($warrent->warr_date)->isoFormat('DD MMMM Y') }}</span>
                    <label class="col-md-2 mt-2"><b>Status Pengajuan</b></label>
                    <span class="col-md-10 mt-2">:
                        @if($warrent->warr_status == 'proses')
                        <a class="btn btn-outline-primary p-1 disabled" style="font-size: 12px;">
                            Diproses
                        </a>
                        @elseif($warrent->warr_status == 'ditolak')
                        <a class="btn btn-outline-danger p-1 disabled" style="font-size: 12px;">
                            Pengajuan Ditolak
                        </a>
                        @else
                        <a class="btn btn-outline-success p-1 disabled" style="font-size: 12px;">
                            Pengajuan Diterima
                        </a>
                        @endif
                    </span>
                    <form action="{{ url('unit-kerja/surat/tambah-pengajuan/update-surat-perintah' ) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="col-md-2 mt-2"><b>Surat Pengajuan</b></label>
                        <span class="col-md-10 mt-2">:
                            @if ($warrent->warr_file != null)
                            <a href="{{ asset('data_file/surat_permohonan/'. $warrent->warr_file) }}" target="_blank">{{ $warrent->warr_file }}</a>
                            @else
                            <input type="hidden" name="id_warrent" value="{{ $warrent->id_warrent }}">
                            <input type="file" class="bg-white" name="upload_warr" accept="application/pdf" style="font-size: 12px;" required> <br>
                            @endif
                            <label class="col-md-2 mt-2"><b>&nbsp;</b></label>
                            <span class="col-md-10 mt-2">&nbsp;
                                @if ($warrent->warr_file == null)
                                <button type="submit" class="btn btn-primary btn-sm mt-3" style="font-size: 12px;" onclick="return confirm('Upload Surat Perintah ?')">
                                    <i class="fas fa-upload"></i> Upload <span style="font-size: 9px;">Format file (.PDF)</span>
                                </button>
                                @endif
                            </span>
                    </form>
                    <span class="col-md-12 mt-2">
                        @if($warrent->warr_status == 'diterima' && $warrent->warr_process == 'false')
                        <a href="{{ url('unit-kerja/surat-perintah/penyimpanan/'. $warrent->id_warrent) }}" class="btn btn-warning btn-sm mt-2" style="font-size: 12px;">
                            <i class="fas fa-plus-circle"></i> Buat Surat Perintah
                        </a>
                        @endif
                    </span>
                    <div class="col-md-12 mt-3">
                        @if($warrent->warr_status == 'konfirmasi')
                        <form action="{{ url('unit-kerja/surat-perintah/konfirmasi-penapisan/'. $warrent->id_warrent) }}">
                            @csrf
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title pt-2">Daftar Barang</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($warrent->warr_purpose == 'penyimpanan')
                                        <table id="table-1" class="table">
                                            <thead>
                                                <tr style="font-size: 14px;">
                                                    <th style="width: 1%;">No</th>
                                                    <th style="width: 24%;">Nama Barang</th>
                                                    <th style="width: 15%;">Jumlah (pengajuan)</th>
                                                    <th style="width: 15%;">Jumlah (diterima)</th>
                                                    <th style="width: 5%;">Status</th>
                                                    <th style="width: 10%;">Konfirmasi</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <?php $no = 1; ?>
                                            <tbody>
                                                @foreach($item as $itemEntry)
                                                <tr style="font-size: 14px;">
                                                    <td class="pt-3">
                                                        <input type="hidden" name="id_screening[]" value="{{ $itemEntry->id_item_screening }}">
                                                        {{ $no++ }}
                                                    </td>
                                                    <td class="pt-3">{{ $itemEntry->warr_item_name.' '.$itemEntry->warr_item_description }}</td>
                                                    <td class="pt-3">{{ $itemEntry->warr_item_qty.' '.$itemEntry->warr_item_unit }}</td>
                                                    <td class="pt-3">{{ $itemEntry->item_received.' '.$itemEntry->warr_item_unit }}</td>
                                                    <td class="pt-3 text-center">
                                                        @if($itemEntry->status_screening == 'sesuai')
                                                        <b>sesuai</b>
                                                        @else
                                                        <b>tidak sesuai</b> <br>
                                                        <small>({{ $itemEntry->screening_notes }})</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <select name="approve_workunit[]" class="form-control bg-white" style="font-size: 13px;">
                                                            <option value="1">setuju</option>
                                                            <option value="0">tidak setuju</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea name="screening_notes_workunit[]" rows="1" class="form-control" style="font-size: 13px;" placeholder="Jika tidak setuju, mohon isi keterangan"></textarea>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <table id="table-1" class="table">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Jumlah <br>(pengajuan)</th>
                                                    <th>Jumlah <br>(diambil)</th>
                                                    <th>Status</th>
                                                    <th>Konfirmasi</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <?php $no = 1; ?>
                                            <tbody>
                                                @foreach($item as $itemExit)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="id_screening[]" value="{{ $itemExit->id_item_screening }}">
                                                        {{ $no++ }}
                                                    </td>
                                                    <td>{{ $itemExit->item_name.' '.$itemExit->item_description }}</td>
                                                    <td class="text-center">{{ $itemExit->item_volume.' '.$itemExit->item_unit }}</td>
                                                    <td class="text-center">{{ $itemExit->item_received.' '.$itemExit->item_unit }}</td>
                                                    <td class="text-center">
                                                        @if($itemExit->status_screening == 'sesuai')
                                                        <b>sesuai</b>
                                                        @else
                                                        <b>tidak sesuai</b>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <select name="approve_workunit[]" class="form-control bg-white text-center">
                                                            <option value="1">setuju</option>
                                                            <option value="0">tidak setuju</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea name="screening_notes_workunit[]" rows="1" class="form-control" placeholder=""></textarea>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mt-2" onclick="return confirm('Apakah setuju dengan konfirmasi yang telah diberikan ?')">SUBMIT</button>
                            </div>
                        </form>
                        @else
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title pt-2">Daftar Barang</h6>
                                </div>
                                <div class="card-body">
                                    @if($warrent->warr_purpose == 'penyimpanan')
                                    <table id="table-1" class="table" style="color: black;">
                                        <thead>
                                            <tr style="font-size: 13px;">
                                                <th>No</th>
                                                <th>Jenis Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Merk/Tipe</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Kondisi</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <?php $no = 1; ?>
                                        <tbody>
                                            @foreach($item as $itemEntry)
                                            <tr style="font-size: 12px;">
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $itemEntry->item_category_name }}</td>
                                                <td>{{ $itemEntry->warr_item_name }}</td>
                                                <td>{{ $itemEntry->warr_item_description }}</td>
                                                <td>{{ $itemEntry->warr_item_qty }}</td>
                                                <td>{{ $itemEntry->warr_item_unit }}</td>
                                                <td>{{ $itemEntry->item_condition_name }}</td>
                                                <td>{{ $itemEntry->warr_item_status }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <table id="table-1" class="table">
                                        <thead>
                                            <tr style="font-size: 14px;">
                                                <th>No</th>
                                                <th>Jenis Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Keterangan</th>
                                                <th>Jumlah</th>
                                                <th>Kondisi</th>
                                                <th>Penyimpanan</th>
                                            </tr>
                                        </thead>
                                        <?php $no = 1; ?>
                                        <tbody class="small">
                                            @foreach($item as $itemExit)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $itemExit->item_category_name }}</td>
                                                <td>{{ $itemExit->item_name.' '.$itemExit->item_merktype }}</td>
                                                <td>{{ $itemExit->item_description }}</td>
                                                <td>{{ $itemExit->warr_item_pick.' '.$itemExit->item_unit }}</td>
                                                <td>{{ $itemExit->item_condition_name }}</td>
                                                <td>{{ $itemExit->slot_id }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
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
