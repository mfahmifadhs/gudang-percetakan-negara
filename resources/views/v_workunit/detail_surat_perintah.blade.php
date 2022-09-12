@extends('v_main.layout.app')

@section('content')

<div class="container-xxl py-5">
    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <div class="col-md-3 form-group">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <h6 class="text-capitalize">tanggal {{ $warrent->warr_purpose }} : </h6>
                        <p class="mt-2">
                            {{ \Carbon\Carbon::parse($warrent->warr_date)->isoFormat('DD MMMM Y') }}
                        </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <h6 class="text-capitalize">surat perintah {{ $warrent->warr_purpose }} :</h6>
                        <p class="mt-2">
                            <a href="{{ asset('data_file/surat_permohonan/'. $warrent->warr_file) }}" target="_blank">{{ $warrent->warr_file }}</a>
                        </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <h6 class="text-capitalize">status {{ $warrent->warr_purpose }} :</h6>
                        <p class="mt-2">
                            @if($warrent->warr_status == 'proses')
                            <a class="btn btn-outline-primary py-2 px-3 disabled">
                                Diproses
                            </a>
                            @elseif($warrent->warr_status == 'konfirmasi')
                            <a class="btn btn-outline-danger py-2 px-3 disabled">
                                Menunggu Konfirmasi
                            </a>
                            @else
                            <a class="btn btn-outline-success py-2 px-3 disabled">
                                Selesai
                            </a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-9 form-group">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <a href="{{ url('unit-kerja/surat/daftar-surat-pengajuan/semua') }}" class=""><i class="fas fa-arrow-alt-circle-left"></i> KEMBALI</a>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title pt-2 text-capitalize">konfirmasi {{ $warrent->warr_purpose }} barang</h6>
                            </div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title pt-2">Daftar Barang</h6>
                            </div>
                            <div class="card-body">
                                <table id="table-1" class="table table-responsive" style="color: black;">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%;">No</th>
                                            <th style="width: 20%;">Jenis Barang</th>
                                            <th style="width: 20%;">Kode Barang</th>
                                            <th style="width: 10%;">NUP</th>
                                            <th style="width: 15%;">Barang</th>
                                            <th style="width: 15%;">Merk/Tipe</th>
                                            <th style="width: 10%;">Jumlah</th>
                                            <th style="width: 10%;">Kondisi</th>
                                            <th style="width: 10%;">Status</th>
                                            <th style="width: 20%;">Catatan</th>
                                        </tr>
                                        <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($item as $dataItem)
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $dataItem->item_category_name }}</td>
                                        <td>{{ $dataItem->warr_item_code }}</td>
                                        <td>{{ $dataItem->warr_item_nup }}</td>
                                        <td>{{ $dataItem->warr_item_name }}</td>
                                        <td>{{ $dataItem->warr_item_description }}</td>
                                        <td>{{ $dataItem->warr_item_qty.' '.$dataItem->warr_item_unit }}</td>
                                        <td>{{ $dataItem->item_condition_name }}</td>
                                        <td>{{ $dataItem->warr_item_status }}</td>
                                        <td>{{ $dataItem->warr_item_note }}</td>
                                        @endforeach
                                    </tbody>
                                    </thead>
                                </table>
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
    $(function () {
      $("#table-1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "info": false, "sort":false, "paging":false, "searching":false
      });
    });
  </script>
@endsection

@endsection
