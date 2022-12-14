@extends('v_main.layout.app')

@section('content')

<div class="container-xxl py-5">
    <div class="container" style="margin-top: 100px;">
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
                        <h6>Surat Permohonan Pengajuan :</h6>
                        <p class="mt-2">
                            <a href="{{ asset('data_file/surat_permohonan/'. $appletter->appletter_file) }}" target="_blank">{{ $appletter->appletter_file }}</a>
                        </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <h6>Status Pengajuan :</h6>
                        <p class="mt-2">
                            @if($appletter->appletter_status == 'proses')
                            <a class="btn btn-outline-primary py-2 px-3 disabled">
                                Diproses
                            </a>
                            @elseif($appletter->appletter_status == 'ditolak')
                            <a class="btn btn-outline-danger py-2 px-3 disabled">
                                Pengajuan Ditolak
                            </a>
                            @else
                            <a class="btn btn-outline-success py-2 px-3 disabled">
                                Pengajuan Diterima
                            </a>
                            @endif
                        </p>
                    </div>
                    @if ($appletter->appletter_status != 'proses')
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
                    @endif
                    @if($appletter->appletter_status == 'diterima' && $appletter->appletter_process == 'false')
                    <div class="col-md-12 mb-2">
                        <a href="{{ url('unit-kerja/surat-perintah/penyimpanan/'. $appletter->id_app_letter) }}" class="btn btn-warning py-2 px-3">
                            Buat Surat Perintah
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-9 form-group">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <a href="{{ url('unit-kerja/surat/daftar-surat-pengajuan/semua') }}" class=""><i class="fas fa-arrow-alt-circle-left"></i> KEMBALI</a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <h6>Tujuan Pengajuan : </h6>
                        <p class="mt-2 text-capitalize">
                            {{ $appletter->appletter_purpose }} barang
                        </p>
                    </div>
                    <div class="col-md-3 mb-2">
                        <h6>Tanggal Pengajuan : </h6>
                        <p class="mt-2">
                            {{ \Carbon\Carbon::parse($appletter->appletter_date)->isoFormat('HH:mm / DD MMMM Y') }}
                        </p>
                    </div>
                    <div class="col-md-3 mb-2">
                        <h6>Surat Pengajuan :</h6>
                        <p class="mt-2">
                            <a href="{{ asset('data_file/surat_permohonan/'. $appletter->appletter_file) }}" target="_blank">{{ $appletter->appletter_file }}</a>
                        </p>
                    </div>
                    <div class="col-md-3 mb-2">
                        <h6>Status Pengajuan :</h6>
                        <p class="mt-2">
                            @if($appletter->appletter_status == 'proses')
                            <a class="btn btn-outline-primary disabled">
                                Diproses
                            </a>
                            @elseif($appletter->appletter_status == 'ditolak')
                            <a class="btn btn-outline-danger disabled">
                                Pengajuan Ditolak
                            </a>
                            @else
                            <a class="btn btn-outline-success disabled">
                                Pengajuan Diterima
                            </a>
                            @endif
                        </p>
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
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Keterangan</th>
                                            <th>Status Pengajuan</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody class="small">
                                        @foreach($item as $dataItem)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $dataItem->item_category_name }}</td>
                                            <td>{{ $dataItem->appletter_item_name }}</td>
                                            <td>{{ $dataItem->appletter_item_description }}</td>
                                            <td>{{ $dataItem->appletter_item_qty }}</td>
                                            <td>{{ $dataItem->appletter_item_unit }}</td>
                                            <td>{{ $dataItem->appletter_item_status }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <table id="table-1" class="table" style="color: black;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah Diambil</th>
                                            <th>Satuan</th>
                                            <th>Penyimpanan</th>
                                            <th>Status Pengajuan</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($item as $dataItem)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $dataItem->item_category_name }}</td>
                                            <td>{{ $dataItem->item_name }}</td>
                                            <td>{{ $dataItem->item_description }}</td>
                                            <td>{{ $dataItem->item_pick }}</td>
                                            <td>{{ $dataItem->item_unit }}</td>
                                            <td>{{ $dataItem->slot_id }}</td>
                                            <td>{{ $dataItem->appletter_item_status }}</td>
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
