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
        <form action="{{ route('submission.post', $category) }}" method="POST" enctype="multipart/form-data">
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
                            <input type="date" class="form-control" name="tanggal_pengajuan" value="{{ \Carbon\carbon::parse($data['tanggal_pengajuan'])->isoFormat('YYYY-MM-DD') }}" required>
                        </div>
                        <label class="col-md-2 col-form-label">Jenis Pengajuan*</label>
                        <div class="col-md-4">
                            <select class="form-control" name="jenis_pengajuan" required>
                                @if ($data['jenis_pengajuan'] == 'masuk')
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
                                    {{ $row->kode_unit_kerja.' - '.$row->nama_unit_kerja }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Keterangan*</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="keterangan" required>{{ $data['keterangan'] }}</textarea>
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
                            @if (!$resFile['surat_pengajuan'])
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
                                ✅ File sudah di upload
                                <input type="hidden" name="surat_pengajuan" value="{{ $resFile['surat_pengajuan'] }}">

                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Surat Perintah</label>
                        <div class="col-md-10">
                            @if (!$resFile['surat_perintah'])
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
                                ✅ File sudah di upload
                                <input type="hidden" name="surat_perintah" value="{{ storage_path('app/' . $resFile['surat_perintah']) }}">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h4 class="card-title">Informasi Barang</h4>
                </div>
                <div class="card-body">
                    @foreach ($resArr as $row)
                    @if ($row['data_barang'])
                    @if ($row['kode_form'] == 101)
                    <b>Barang Milik Negara (BMN)</b>
                    <table id="table-preview-101" class="table table-bordered">
                        <thead class="text-center medium">
                            <tr>
                                <th class="p-4">No</td>
                                <th class="p-4">Nama Barang</td>
                                <th class="p-4">Merek/Tipe</td>
                                <th class="p-4">NUP</td>
                                <th class="p-4">Kondisi</td>
                                <th class="p-3">Jumlah <br> Unit</td>
                                <th class="p-3">Tahun <br> Perolehan</td>
                                <th class="p-4">Keterangan</td>
                            </tr>
                        </thead>
                        @php $no = 1; @endphp
                        <tbody class="small">
                            @foreach($row['data_barang'] as $rowItem)
                            <tr>
                                <td class="text-center">
                                    {{ $no++ }}
                                </td>
                                <td>
                                    <input type="hidden" name="jenis_barang[]" value="441">
                                    <input type="text" name="nama_barang[]" class="form-control input-border-bottom" value="{{ $rowItem['nama_barang'] }}">
                                </td>
                                <td>
                                    <input type="text" name="deskripsi[]" class="form-control input-border-bottom" value="{{ $rowItem['deskripsi'] }}">
                                </td>
                                <td>
                                    <input type="text" name="catatan[]" class="form-control input-border-bottom text-center" value="{{ $rowItem['nup'] }}">
                                </td>
                                <td>
                                    <input type="text" name="kondisi[]" class="form-control input-border-bottom" value="{{ $rowItem['kondisi'] }}">
                                </td>
                                <td>
                                    <input type="text" name="jumlah[]" class="form-control input-border-bottom text-center" value="{{ $rowItem['jumlah'] }}">
                                    <input type="hidden" name="satuan[]" value="unit">
                                </td>
                                <td class="text-center">
                                    <input type="text" name="tahun_perolehan[]" class="form-control input-border-bottom text-center" value="{{ $rowItem['tahun'] }}">
                                </td>
                                <td>
                                    <input type="text" name="keterangan_barang[]" class="form-control input-border-bottom text-center" value="{{ $rowItem['keterangan'] }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <b>Barang Persediaan</b>
                    <table id="table-preview-102" class="table table-bordered">
                        <thead class="text-center medium">
                            <tr>
                                <th class="p-4">No</td>
                                <th class="p-4">Nama Barang</td>
                                <th class="p-4">Merek/Tipe</td>
                                <th class="p-4">Jumlah</td>
                                <th class="p-4">Satuan</td>
                                <th class="p-3">Tahun <br> Perolehan</td>
                                <th class="p-3">Masa <br> Kadaluarsa</td>
                                <th class="p-4">Keterangan</td>
                            </tr>
                        </thead>
                        @php $no = 1; @endphp
                        <tbody class="small">
                            @foreach($row['data_barang'] as $rowItem)
                            <tr>
                                <td class="text-center">
                                    {{ $no++ }}
				    <input type="hidden" name="cobain[]" value={{ count($row['data_barang']) }}>
                                </td>
                                <td>
                                    <input type="hidden" name="jenis_barang[]" value="442">
                                    <input type="text" name="nama_barang[]" class="form-control input-border-bottom" value="{{ $rowItem['nama_barang'] }}">
                                    <input type="hidden" name="kondisi[]" class="form-control input-border-bottom" value="Baik">
                                </td>
                                <td>
                                    <input type="text" name="deskripsi[]" class="form-control input-border-bottom" value="{{ $rowItem['deskripsi'] }}">
                                </td>
                                <td>
                                    <input type="text" name="jumlah[]" class="form-control input-border-bottom text-center" value="{{ $rowItem['jumlah'] }}">
                                </td>
                                <td class="text-center">
                                    <input type="text" name="satuan[]" class="form-control input-border-bottom text-center" value="{{ $rowItem['satuan'] }}">
                                </td>
                                <td>
                                    <input type="text" name="tahun_perolehan[]" class="form-control input-border-bottom text-center" value="{{ $rowItem['tahun'] }}">
                                </td>
                                <td>
                                    <input type="text" name="catatan[]" class="form-control input-border-bottom text-center" value="{{ $rowItem['expired'] }}">
                                </td>
                                <td>
                                    <input type="text" name="keterangan_barang[]" class="form-control input-border-bottom text-center" value="{{ $rowItem['keterangan'] }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ URL::previous() }}" class="btn btn-danger" onclick="return confirm('Batalkan Pengajuan?')">
                    <i class="fas fa-sync fa-1x"></i> <b>Batal</b>
                </a>
                <button type="submit" class="btn btn-secondary" onclick="return confirm('Buat Pengajuan?')">
                    <i class="fas fa-paper-plane fa-1x"></i> <b>Submit</b>
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
        'sorting': false,
        'columnDefs': [{
                'width': '0%',
                'targets': 0
            },
            {
                'width': '20%',
                'targets': 1
            },
            {
                'width': '20%',
                'targets': 2
            },
            {
                'width': '10%',
                'targets': 3
            },
            {
                'width': '15%',
                'targets': 4
            },
            {
                'width': '10%',
                'targets': 5
            },
            {
                'width': '15%',
                'targets': 6
            },
            {
                'width': '15%',
                'targets': 7
            },
        ]
    });
    $("#table-preview-102").DataTable({
        'paging': false,
        'info': false,
        'searching': false,
        'sorting': false,
        'columnDefs': [{
                'width': '0%',
                'targets': 0
            },
            {
                'width': '20%',
                'targets': 1
            },
            {
                'width': '25%',
                'targets': 2
            },
            {
                'width': '10%',
                'targets': 3
            },
            {
                'width': '10%',
                'targets': 4
            },
            {
                'width': '15%',
                'targets': 5
            },
        ]
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
