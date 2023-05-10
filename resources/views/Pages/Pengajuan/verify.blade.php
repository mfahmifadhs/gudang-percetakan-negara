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
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container-fluid">
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
            <form action="{{ route('submission.check', $data->id_pengajuan) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2">Tanggal Pengajuan</label>
                        <div class="col-md-10">:
                            {{ \Carbon\carbon::parse($data->tanggal_pengajuan)->isoFormat('DD MMMM Y') }}
                        </div>
                        <label class="col-md-2">Jenis Pengajuan</label>
                        <div class="col-md-10">:
                            {{ $data->jenis_pengajuan == 'masuk' ? 'Penyimpanan' : 'Pengeluaran' }}
                        </div>
                        <label class="col-md-2">Unit Kerja</label>
                        <div class="col-md-10">:
                            {{ $data->pegawai->workunit->nama_unit_kerja }}
                        </div>
                        <label class="col-md-2">Surat Pengajuan</label>
                        <div class="col-md-10">:
                            @if (!$data->surat_pengajuan)
                            Tidak ada file yang di upload
                            @else
                            <a href="{{ url('/surat/preview/'. $data->surat_pengajuan) }}" target="_blank">Lihat Surat</a>
                            @endif
                        </div>
                        <label class="col-md-2">Surat Perintah</label>
                        <div class="col-md-10">:
                            @if (!$data->surat_perintah)
                            Tidak ada file yang di upload
                            @else
                            <a href="{{ url('/surat/preview/'. $data->surat_perintah) }}" target="_blank">Lihat Surat</a>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-12">
                            Informasi Barang <br>
                            <small class="text-danger"></small>
                        </label>
                        <div class="col-md-12">
                            @if ($data->jenis_pengajuan == 'masuk')
                            <input type="hidden" name="category" value="masuk">
                            <table id="table-verify" class="table table-bordered" style="font-size: 15px;">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</td>
                                        <th>Nama Barang</td>
                                        <th>Merek/Tipe</td>
                                        <th>{{ $catatan }}</td>
                                        <th>Permintaan</td>
                                        <th>Disetujui</td>
                                        <th>Satuan</td>
                                        <th>Keterangan</td>
                                        <th>
                                            <input type="checkbox" id="selectAll" style="scale: 1.7;" checked>
                                        </th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($data->penyimpanan as $i => $row)
                                    <tr>
                                        <td class="pt-3 text-center">
                                            {{ $no++ }}
                                            <input type="hidden" name="status" value="true">
                                            <input type="hidden" name="id_barang[]" value="{{ $row->id_detail }}">
                                        </td>
                                        <td class="pt-3">{{ $row->nama_barang }}</td>
                                        <td class="pt-3">{{ $row->deskripsi }}</td>
                                        <td class="pt-3 text-center">{{ $row->catatan }}</td>
                                        <td class="pt-3 text-center">
                                            {{ $row->jumlah_pengajuan }}
                                        </td>
                                        <td class="pt-3 text-center">
                                            <input type="number" name="jumlah[]" class="form-control input-border-bottom text-center" value="{{ $row->jumlah_pengajuan }}">
                                        </td>
                                        <td class="pt-3 text-center">
                                            {{ $row->satuan }}
                                        </td>
                                        <td class="pt-3 text-center">
                                            {{ $row->keterangan }}
                                        </td>
                                        <td class="text-center p-3">
                                            <input type="hidden" value="" name="status_barang[{{$i}}]">
                                            <input type="checkbox" class="confirm-check" style="scale: 1.7;" name="status_barang[{{$i}}]" id="checkbox_id{{$i}}" value="true" checked>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <input type="hidden" name="category" value="keluar">
                            <input type="hidden" name="status" value="true">
                            <table class="table table-bordered" style="font-size: 15px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Barang</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">Kondisi</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Satuan</th>
                                        <th class="text-center" colspan="2">Lokasi Penyimpanan</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($data->riwayat as $row)
                                    <tr>
                                        <td class="text-center">
                                            {{ $no++ }}
                                        </td>
                                        <td>{{ $row->detailPenyimpanan->barang->nama_barang }}</td>
                                        <td class="text-center">{{ $row->detailPenyimpanan->barang->catatan }}</td>
                                        <td class="text-center">{{ $row->detailPenyimpanan->barang->kondisi_barang }}</td>
                                        <td class="text-center">{{ $row->jumlah }}</td>
                                        <td class="text-center">{{ $row->detailPenyimpanan->barang->satuan }}</td>
                                        <td class="text-center">
                                            {{ $row->detailPenyimpanan->penyimpanan->gedung->nama_gedung }}
                                        </td>
                                        <td class="text-center">
                                            {{ $row->detailPenyimpanan->penyimpanan->kode_palet }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                        <label class="col-md-12">
                            Catatan
                        </label>
                        <div class="col-md-12">
                            <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('submission.show') }}" class="btn btn-default">
                            <i class="fas fa-arrow-circle-left fa-1x"></i> <b>Kembali</b>
                        </a>
                    </div>
                    <div class="float-right">
                        <a type="button" data-toggle="modal" data-target="#rejectModal" class="btn btn-danger">
                            <i class="fas fa-times-circle fa-1x"></i> <b>Tolak</b>
                        </a>
                        <button type="submit" class="btn btn-success" onclick="return confirm('Apakah pengajuan ini disetujui?')">
                            <i class="fas fa-check-circle fa-1x"></i> <b>Setuju</b>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModal">Persetujuan Pengajuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('submission.check', $data->id_pengajuan) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="false">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-12">Alasan Penolakan</label>
                        <div class="col-md-12">
                            <textarea name="keterangan" name="catatan" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        @foreach ($data->penyimpanan as $i => $row)
                        <input type="hidden" name="id_barang[]" value="{{ $row->id_detail }}">
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Pengajuan Ditolak?')">
                        <i class="fas fa-times-circle fa-1x"></i> <b>Tolak</b>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
<script>
    $("#table-verify").DataTable({
        'paging': false,
        'info': false,
        'searching': false,
        'sort': false,
        'columnDefs': [
            {'width': '0%', 'targets': 0},
            {'width': '10%', 'targets': 4},
            {'width': '10%', 'targets': 5},
            {'width': '10%', 'targets': 6},
            {'width': '5%', 'targets': 8},
        ]
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

    $(function() {
        $('#selectAll').click(function() {
            if ($(this).prop('checked')) {
                $('.confirm-check').prop('checked', true);
            } else {
                $('.confirm-check').prop('checked', false);
            }
        })
    })
</script>
@endsection

@endsection
