@extends('Layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">Gudang Percetakan Negara</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('submission.show') }}">Daftar Pengajuan</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Tambah Pengajuan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ $category == 'penyimpanan' ? route('submission.preview', '*') : route('submission.post', 'pengambilan') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tanggal Pengajuan*</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="tanggal_pengajuan">
                            </div>
                            <label class="col-md-2 col-form-label">Jenis Pengajuan*</label>
                            <div class="col-md-4">
                                <select class="form-control" name="jenis_pengajuan">
                                    @if ($category == 'penyimpanan')
                                    <option value="masuk">Penyimpanan</option>
                                    @else
                                    <option value="keluar">Pengambilan</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Unit Kerja*</label>
                            <div class="col-md-10">
                                <select class="form-control" id="workunit" name="unit_kerja_id">
                                    @foreach ($workunit as $row)
                                    <option value="{{ $row->id_unit_kerja }}">
                                        {{ $row->nama_unit_kerja }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Keterangan*</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="keterangan" placeholder="Rencana Distribusi / Proses Penghapusan"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2"></div>
                            <div class="col-md-10">
                                <small class="text-danger">
                                    *Pengajuan penyimpanan / pengambilan darurat, Surat Pengajuan dan Surat Perintah dapat dilengkapi nanti.
                                </small>
                            </div>
                            <label class="col-md-2 col-form-label">Surat Pengajuan</label>
                            <div class="col-md-10">
                                <div class="card-footer col-md-12 text-center border border-dark">
                                    <div class="btn btn-default btn-file">
                                        <i class="fas fa-upload"></i> Upload File
                                        <input type="file" class="form-control image" name="surat_pengajuan" accept=".pdf" onchange="displaySelectedFileCountSubmission(this)">
                                        <span id="selected-file-count-submission"></span>
                                    </div><br>
                                    <span class="help-block small">Mohon upload file sesuai format yang telah di download (.pdf)</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Surat Perintah</label>
                            <div class="col-md-10">
                                <div class="card-footer col-md-12 text-center border border-dark">
                                    <div class="btn btn-default btn-file">
                                        <i class="fas fa-upload"></i> Upload File
                                        <input type="file" class="form-control image" name="surat_perintah" accept=".pdf" onchange="displaySelectedFileCountWarrent(this)">
                                        <span id="selected-file-count-warrent"></span>
                                    </div><br>
                                    <span class="help-block" style="font-size: 12px;">Mohon upload file sesuai format yang telah di download (.pdf)</span>
                                </div>
                            </div>
                        </div>

                        @if ($category == 'penyimpanan')
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Data Barang</label>
                            <div class="col-md-10 mt-1">
                                <small>
                                    Mohon untuk melengkapi informasi barang yang akan disimpan,
                                    format file dapat diunduh
                                    <a href="{{ asset('format/format_penyimpanan.xlsx') }}" class="font-weight-bold" download>
                                        <u>Disini</u>
                                    </a>
                                </small>
                                <div class="card-footer col-md-12 text-center border border-dark">
                                    <div class="btn btn-default btn-file">
                                        <i class="fas fa-upload"></i> Upload File
                                        <input type="file" class="form-control image" name="file_barang[]" onchange="displaySelectedFileCountItem(this)" required>
                                        <span id="selected-file-count-item"></span>
                                    </div><br>
                                    <span class="help-block" style="font-size: 12px;">Mohon upload file sesuai format yang telah di download (.xlsx)</span>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Data Barang</label>
                            <div class="col-md-12 mt-1">
                                <small>
                                    Mohon untuk melengkapi informasi barang yang akan disimpan,
                                    format file dapat diunduh <a href="" class="font-weight-bold"><u>Disini</u></a>
                                </small>
                                <table class="table table-bordered" style="font-size: 15px;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama Barang</th>
                                            <th>Deskripsi</th>
                                            <th class="text-center">Kondisi</th>
                                            <th class="text-center" colspan="2">Lokasi Penyimpanan</th>
                                            <th class="text-center">Stok</th>
                                            <th class="text-center" style="width: 15%;">Pengambilan</th>
                                            <th class="text-center">Satuan</th>
                                        </tr>
                                    </thead>
                                    @php $no = 1; @endphp
                                    <tbody>
                                        @foreach ($item as $row)
                                        @if ($row->total_masuk != $row->total_keluar)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td>{{ $row->nama_barang }}</td>
                                            <td>{{ $row->deskripsi }}</td>
                                            <td class="text-center">{{ $row->kondisi_barang }}</td>
                                            <td class="text-center">{{ $row->penyimpanan->gedung->nama_gedung }}</td>
                                            <td class="text-center">{{ $row->penyimpanan->kode_palet }}</td>
                                            <td class="text-center">{{ (int) $row->total_masuk - $row->total_keluar }}</td>
                                            <td>
                                                <input type="hidden" name="penyimpanan_detail_id[]" value="{{ $row->stg_detail_id }}">
                                                <input type="hidden" name="pengajuan_detail_id[]" value="{{ $row->sub_detail_id }}">
                                                <input type="hidden" name="penyimpanan_id[]" value="{{ $row->penyimpanan_id }}">
                                                <input type="number" class="form-control input-border-bottom text-center" name="jumlah[]"
                                                max="{{ (int) $row->total_masuk - $row->total_keluar }}" value="0"
                                                oninput="this.value = Math.abs(this.value)" required>
                                            </td>
                                            <td class="text-center">{{ $row->satuan }}</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Informasi Sudah Benar?')">
                            <i class="fas fa-paper-plane fa-1x"></i> <b>Submit</b>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#workunit").select2()
        $("#employee").select2()
    })

    function displaySelectedFileCountSubmission(input) {
        var selectedFileCount = input.files.length;
        var selectedFileCountElement = document.getElementById('selected-file-count-submission');
        selectedFileCountElement.textContent = selectedFileCount + ' (file dipilih)';
    }

    function displaySelectedFileCountWarrent(input) {
        var selectedFileCount = input.files.length;
        var selectedFileCountElement = document.getElementById('selected-file-count-warrent');
        selectedFileCountElement.textContent = selectedFileCount + ' (file dipilih)';
    }

    function displaySelectedFileCountItem(input) {
        var selectedFileCount = input.files.length;
        var selectedFileCountElement = document.getElementById('selected-file-count-item');
        selectedFileCountElement.textContent = selectedFileCount + ' (file dipilih)';
    }
</script>
@endsection

@endsection
