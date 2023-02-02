@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Penapisan Barang </h1>
                <h6>({{ \Carbon\Carbon::parse($warrent->warr_date)->isoFormat('DD MMMM Y') }})</h6>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('petugas/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Penapisan Barang</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container">
        <div class="col-md-12 form-group">
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
        <form action="{{ url('petugas/surat-perintah/proses-penapisan/'. $warrent->id_warrent) }}" method="POST">
            @csrf
            <input type="hidden" name="total_item" value="{{ $warrent->warr_total_item }}">
            <div class="row">
                <div class="col-md-12 form-group">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Informasi Barang</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="text-muted text-capitalize">informasi {{ $warrent->warr_purpose }} barang</label>
                                </div>
                                <div class="col-md-12">
                                    <label>Surat Perintah</label>
                                    <p>
                                        @if ($warrent->warr_file)
                                        <a href="{{ asset('data_file/surat_perintah/'. $warrent->warr_file) }}" download>{{ $warrent->warr_file }}</a>
                                        @else
                                        Belum ada surat perintah
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Unit Kerja</label>
                                    <input type="hidden" class="form-control" name="workunit_id" value="{{ $warrent->workunit_id }}">
                                    <input type="text" class="form-control" value="{{ $warrent->workunit_name }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Tujuan</label>
                                    <input type="text" class="form-control text-capitalize" name="category" value="{{ $warrent->warr_purpose }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Pengirim</label>
                                    <input type="text" class="form-control" name="emp_name" value="{{ $warrent->warr_emp_name }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control" name="emp_position" value="{{ $warrent->warr_emp_position }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>No. Mobil</label>
                                    <input type="text" class="form-control" name="license_vehicle" placeholder="Masukan Nomor Mobil Pengirim" required>
                                </div>
                            </div>

                            <label class="text-muted">Informasi Barang</label>
                            @if($warrent->warr_purpose == 'penyimpanan')
                            <table id="table-1" class="table table-bordered" style="font-size: 14px;">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Merk/Type</th;>
                                        <th>Jumlah <br>(pengajuan)</th>
                                        <th>Jumlah <br>(diterima)</th>
                                        <th>Satuan</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <?php $no = 1; ?>
                                <tbody>
                                    @foreach($item as $itemEntry)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="item_id[]" value="{{ $itemEntry->id_warr_entry }}">
                                            {{ $no++ }}
                                        </td>
                                        <td>{{ $itemEntry->warr_item_name }}</td>
                                        <td>{{ $itemEntry->warr_item_description }}</td>
                                        <td class="text-center">
                                            <input type="hidden" name="item_volume[]" value="{{ $itemEntry->warr_item_qty }}">
                                            {{ $itemEntry->warr_item_qty }}
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="form-control" name="item_received[]" placeholder="Jumlah diterima" required>
                                        </td>
                                        <td class="text-center">{{ $itemEntry->warr_item_unit }}</td>
                                        <td>
                                            <select name="status_screening[]" class="form-control">
                                                <option value="sesuai">sesuai</option>
                                                <option value="tidak sesuai">tidak sesuai</option>
                                            </select>
                                        </td>
                                        <td>
                                            <textarea name="screening_notes[]" class="form-control" cols="30" rows="2"></textarea>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <table id="table-1" class="table table-bordered" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama</th>
                                        <th>Merk/Type</th;>
                                        <th class="text-center">Jumlah (pengajuan)</th>
                                        <th class="text-center">Jumlah (diambil)</th>
                                        <th class="text-center">Satuan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Keterangan</th>
                                    </tr>
                                </thead>
                                <?php $no = 1; ?>
                                <tbody>
                                    @foreach($item as $itemExit)
                                    <tr>
                                        <td class="text-center pt-3">
                                            <input type="hidden" name="item_id[]" value="{{ $itemExit->item_id }}">
                                            {{ $no++ }}
                                        </td>
                                        <td class="pt-3">{{ $itemExit->item_name }}</td>
                                        <td class="pt-3">{{ $itemExit->item_description }}</td>
                                        <td class="text-center pt-3">
                                            <input type="hidden" name="item_volume[]" value="{{ $itemExit->warr_item_pick }}">
                                            {{ $itemExit->warr_item_pick }}
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm text-center" name="item_received[]" value="{{ $itemExit->warr_item_pick }}" required>
                                        </td>
                                        <td class="text-center pt-3">{{ $itemExit->item_unit }}</td>
                                        <td>
                                            <select name="status_screening[]" class="form-control form-control-sm text-center">
                                                <option value="sesuai">sesuai</option>
                                                <option value="tidak sesuai">tidak sesuai</option>
                                            </select>
                                        </td>
                                        <td>
                                            <textarea name="screening_item[]" class="form-control" cols="20" rows="1" style="font-size: 14px;"></textarea>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Data yang telah tersimpan, tidak dapat diubah. Proses penapisan selesai ?')">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#table-1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": false,
            "info": false,
            "ordering": false,
            "searching": false,
            "columnDefs": [{
                "width": "0%",
                "targets": 0
            }, {
                "width": "0%",
                "targets": 3
            }, {
                "width": "10%",
                "targets": 4
            }, ]
        });
    });
</script>
@endsection

@endsection
