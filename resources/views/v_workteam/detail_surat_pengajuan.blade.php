@extends('v_main.layout.app')

@section('content')

<div class="container-xxl py-5">
    <div class="container" style="margin-top: 100px;">
        <form action="{{ url('tim-kerja/surat/validasi-surat-pengajuan/'. $appletter->id_app_letter) }}">
            <input type="hidden" name="ctg" value="{{ $appletter->appletter_purpose }}">
            @csrf
            <div class="row">
                <div class="col-md-3 form-group">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <h6>Tujuan Pengajuan : </h6>
                            <p class="mt-2 text-capitalize">
                                {{ $appletter->appletter_purpose }} barang
                            </p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <h6>Tanggal Pengajuan : </h6>
                            <p class="mt-2">
                                {{ \Carbon\Carbon::parse($appletter->appletter_date)->isoFormat('HH:mm / DD MMMM Y') }}
                            </p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <h6>Unit Kerja : </h6>
                            <p class="mt-2">
                                {{ $appletter->workunit_name }}
                            </p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <h6>Surat Permohonan Pengajuan :</h6>
                            <p class="mt-2">
                                <a href="{{ asset('data_file/surat_permohonan/'. $appletter->appletter_file) }}" target="_blank">{{ $appletter->appletter_file }}</a>
                            </p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <h6>Status Pengajuan :</h6>
                            <p class="mt-2">
                                <select name="appletter_status" class="form-control bg-white">
                                    @if($appletter->appletter_status == 'diterima')
                                    <option value="diterima">Diterima</option>
                                    @elseif($appletter->appletter_status == 'ditolak')
                                    <option value="diterima">Diterima</option>
                                    @else
                                    <option value="proses">Proses</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                    @endif
                                </select>
                            </p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <h6>Keterangan :</h6>
                            <p class="mt-2">
                                @if($appletter->appletter_note == null)
                                <textarea name="appletter_note" class="form-control" rows="5"></textarea>
                                @else
                                <textarea name="appletter_note" class="form-control" rows="5" readonly>{{ $appletter->appletter_note }}</textarea>
                                @endif
                            </p>
                        </div>
                        @if($appletter->appletter_status == 'proses')
                        <div class="col-md-12 mb-2">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Validasi pengajuan selesai ?')">SUBMIT</button>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-9 form-group">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <a href="{{ url('tim-kerja/dashboard') }}" class=""><i class="fas fa-arrow-alt-circle-left"></i> KEMBALI</a>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title pt-2">Daftar Barang</h6>
                                </div>
                                <div class="card-body">
                                    @if($appletter->appletter_purpose == 'penyimpanan')
                                    <table id="table-1" class="table" style="color: black;">
                                        <thead>
                                            <tr>
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
                                            @foreach($item as $dataItem)
                                            <tr>
                                                <td class="pt-3">
                                                    <input type="hidden" name="appletter_id[]" value="{{ $dataItem->id_appletter_entry }}">
                                                    {{ $no++ }}
                                                </td>
                                                <td class="pt-3">{{ $dataItem->item_category_name }}</td>
                                                <td class="pt-3">{{ $dataItem->appletter_item_name }}</td>
                                                <td class="pt-3">{{ $dataItem->appletter_item_description }}</td>
                                                <td class="pt-3">{{ $dataItem->appletter_item_qty }}</td>
                                                <td class="pt-3">{{ $dataItem->appletter_item_unit }}</td>
                                                <td class="pt-3">{{ $dataItem->item_condition_name }}</td>
                                                <td>
                                                    <select class="form-control bg-white" name="appletter_item_status[]">
                                                        @if($dataItem->appletter_item_status == '')
                                                        <option value="terima">Diterima</option>
                                                        <option value="tolak">Ditolak</option>
                                                        @elseif($dataItem->appletter_item_status == 'terima')
                                                        <option value="terima">Diterima</option>
                                                        @endif
                                                        <option value="tolak">Ditolak</option>
                                                    </select>
                                                </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                        </thead>
                                    </table>
                                    @else
                                    <table id="table-1" class="table" style="color: black;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Merk/Tipe</th>
                                                <th>Jumlah Diambil</th>
                                                <th>Satuan</th>
                                                <th>Kondisi</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <?php $no = 1; ?>
                                        <tbody>
                                            @foreach($item as $dataItem)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $dataItem->item_category_name }}</td>
                                                <td>{{ $dataItem->in_item_name }}</td>
                                                <td>{{ $dataItem->in_item_description }}</td>
                                                <td>{{ $dataItem->item_pick }}</td>
                                                <td>{{ $dataItem->in_item_unit }}</td>
                                                <td>{{ $dataItem->item_condition_name }}</td>
                                                <td>
                                                    <select class="form-control bg-white" name="appletter_item_status[]">
                                                        @if($dataItem->appletter_item_status == '')
                                                        <option value="terima">Diterima</option>
                                                        <option value="tolak">Ditolak</option>
                                                        @elseif($dataItem->appletter_item_status == 'terima')
                                                        <option value="terima">Diterima</option>
                                                        @endif
                                                        <option value="tolak">Ditolak</option>
                                                    </select>
                                                </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
