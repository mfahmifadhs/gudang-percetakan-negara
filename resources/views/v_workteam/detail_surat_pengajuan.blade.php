@extends('v_main.layout.app')

@section('content')

<div class="container-xxl py-5">
    <div class="container" style="margin-top: 100px;">
        <form action="{{ url('tim-kerja/surat/pengajuan-diterima/'. $appletter->id_app_letter) }}">
            @csrf
            <div class="row">
                <div class="col-md-3 form-group">
                    <div class="row">
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
                                <select name="appletter_status" class="form-control bg-white">
                                    <option value="proses">Proses</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <h6>Keterangan :</h6>
                            <p class="mt-2">
                                <textarea name="appletter_description" class="form-control" rows="5"></textarea>
                            </p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Validasi pengajuan selesai ?')">SUBMIT</button>
                        </div>
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
                                            <?php $no = 1; ?>
                                        <tbody>
                                            @foreach($item as $dataItem)
                                            <td class="pt-3">
                                                <input type="hidden" name="id_appletter_detail[]" value="{{ $dataItem->id_appletter_detail }}">
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
                                                    <option value="diterima">Diterima</option>
                                                    <option value="ditolak">Ditolak</option>
                                                </select>
                                            </td>
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
