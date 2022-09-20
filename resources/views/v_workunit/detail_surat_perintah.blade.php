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
                                    <table id="table-1" class="table table-bordered">
                                        <thead class="text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Jumlah <br>(pengajuan)</th>
                                                <th>Jumlah <br>(diterima)</th>
                                                <th>Status</th>
                                                <th>Konfirmasi</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <?php $no = 1; ?>
                                        <tbody>
                                            @foreach($item as $itemEntry)
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="id_screening[]" value="{{ $itemEntry->id_item_screening }}">
                                                    {{ $no++ }}
                                                </td>
                                                <td>{{ $itemEntry->warr_item_name.' '.$itemEntry->warr_item_description }}</td>
                                                <td class="text-center">{{ $itemEntry->warr_item_qty.' '.$itemEntry->warr_item_unit }}</td>
                                                <td class="text-center">{{ $itemEntry->item_received.' '.$itemEntry->warr_item_unit }}</td>
                                                <td class="text-center">
                                                    @if($itemEntry->status_screening == 'sesuai')
                                                    <b>sesuai</b>
                                                    @else
                                                    <b>tidak sesuai</b> <br>
                                                    <small>({{ $itemEntry->screening_notes }})</small>
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
                                    @else
                                    <table id="table-1" class="table table-bordered">
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
                                <table id="table-1" class="table table-bordered">
                                    <thead class="text-center">
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
                                        @foreach($item as $itemEntry)
                                        <tr>
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
                                <table id="table-1" class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Merk/Tipe</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Kondisi</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody>
                                        @foreach($item as $itemExit)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $itemExit->item_category_name }}</td>
                                            <td>{{ $itemExit->item_name }}</td>
                                            <td>{{ $itemExit->item_description }}</td>
                                            <td>{{ $itemExit->warr_item_pick }}</td>
                                            <td>{{ $itemExit->item_unit }}</td>
                                            <td>{{ $itemExit->item_condition_name }}</td>
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
