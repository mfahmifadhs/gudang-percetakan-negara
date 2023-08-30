@extends('Layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
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
    <div class="container-fluid">
        <form action="{{ route('submission.update', $submission->id_pengajuan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">Informasi Pengusul</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tanggal Pengajuan*</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="tanggal_pengajuan" value="{{ \Carbon\carbon::parse($submission->tanggal_pengajuan)->isoFormat('YYYY-MM-DD') }}" required>
                        </div>
                        <label class="col-md-2 col-form-label">Jenis Pengajuan*</label>
                        <div class="col-md-4">
                            <select class="form-control" name="jenis_pengajuan" required>
                                @if ($submission->jenis_pengajuan == 'masuk')
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
                            <textarea class="form-control" name="keterangan" required>{{ $submission->keterangan }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <small class="text-danger">
                                Untuk pengajuan permohonan darurat. Surat pengajuan dapat dilewati dan di upload nanti.
                            </small>
                        </div>
                        <label class="col-md-2 col-form-label">Surat Pengajuan</label>
                        <div class="col-md-10">
                            @if (!$submission->surat_pengajuan)
                            <div class="card-footer col-md-12 text-center border border-dark">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-upload"></i> Upload File
                                    <input type="file" class="form-control image" name="surat_pengajuan" accept=".pdf" onchange="displaySelectedFileCountSubmission(this)">
                                    <span id="selected-file-count-submission"></span>
                                </div><br>
                                <span class="help-block small">Mohon upload file sesuai format yang telah di download (.pdf)</span>
                            </div>
                            @else
                            <div class="mt-2">
                                <a href="{{ url('/surat/surat-pengajuan/preview/'. $submission->surat_pengajuan) }}" target="_blank">
                                    Lihat Surat
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label class="col-md-2 col-form-label">Surat Perintah</label>
                        <div class="col-md-10">
                            @if (!$submission->surat_perintah)
                            <div class="card-footer col-md-12 text-center border border-dark">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-upload"></i> Upload File
                                    <input type="file" class="form-control image" name="surat_perintah" accept=".pdf" onchange="displaySelectedFileCountWarrent(this)">
                                    <span id="selected-file-count-warrent"></span>
                                </div><br>
                                <span class="help-block" style="font-size: 12px;">Mohon upload file sesuai format yang telah di download (.pdf)</span>
                            </div>
                            @else
                            <div class="mt-2">
                                <a href="{{ url('/surat/surat-perintah/preview/'. $submission->surat_perintah) }}" target="_blank">
                                    Lihat Surat
                                </a>
                            </div>
                            @endif
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h4 class="card-title">Informasi Barang</h4>
                </div>
                @if ($submission->jenis_pengajuan == 'masuk')
                <table class="table table-bordered" style="font-size: 15px;">
                    <thead>
                        <tr>
                            <th class="text-center">No</td>
                            <th>Nama Barang</td>
                            <th>Catatan</td>
                            <th>Keterangan</td>
                            <th style="width: 10%;" class="text-center">Permintaan</td>
                            <th style="width: 10%;" class="text-center">Satuan</td>
                            <th style="width: 20%;">Rencana Penghapusan/Distribusi</td>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody>
                        @foreach ($submission->penyimpanan as $row)
                        <tr>
                            <td class="text-center pt-3">{{ $no++ }}</td>
                            <td>
                                <input type="hidden" name="id_barang[]" class="form-control input-border-bottom" value="{{ $row->id_detail }}">
                                <input type="text" name="nama_barang[]" class="form-control input-border-bottom" value="{{ $row->nama_barang.' '.$row->tahun }}">
                            </td>
                            <td>
                                <input type="text" name="catatan[]" class="form-control input-border-bottom" value="{{ $row->catatan }}">
                            </td>
                            <td>
                                <input type="text" name="deskripsi[]" class="form-control input-border-bottom" value="{{ $row->keterangan }}">
                            </td>
                            <td class="text-center">
                                <input type="number" name="jumlah[]" class="form-control input-border-bottom text-center" value="{{ $row->jumlah_pengajuan }}">
                            </td>
                            <td class="text-center">
                                <input type="text" name="satuan[]" class="form-control input-border-bottom text-center" value="{{ $row->satuan }}">
                            </td>
                            <td>
                                <input type="text" name="keterangan_barang[]" class="form-control input-border-bottom" value="{{ $row->keterangan }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else

                @endif
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-secondary" onclick="return confirm('Buat Pengajuan?')">
                    <i class="fas fa-save fa-1x"></i> <b>Simpan</b>
                </button>
            </div>
        </form>
    </div>
</section>

@section('js')
<script>
    $("#table-preview-101").DataTable({
        'paging': false,
        'info': false,
        'searching': false,
        'sorting': false
    });
    $("#table-preview-102").DataTable({
        'paging': false,
        'info': false,
        'searching': false,
        'sorting': false
    });

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


    function displaySelectedFileCount(input) {
        var selectedFileCount = input.files.length;
        var selectedFileCountElement = document.getElementById('selected-file-count');
        selectedFileCountElement.textContent = selectedFileCount + ' (file dipilih)';
    }
</script>
@endsection

@endsection
