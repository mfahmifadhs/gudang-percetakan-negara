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

@if ($category == 'penyimpanan')
<section class="content">
    <div class="container">
        <form action="{{ $category == 'penyimpanan' ? route('submission.preview', '*') : route('submission.post', 'pengambilan') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                    <!-- <div class="form-group row">
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
                    </div> -->

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
                                    <input type="file" class="form-control image" name="file_barang[]" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" onchange="displaySelectedFileCountItem(this)" required>
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

                            @if ($category == 441)
                            <h6>
                                Checklist (✔️) barang yang akan diambil, jika total lebih dari 1, masukkan jumlah pengambilan.
                            </h6>
                            <table class="table table-bordered text-center" style="font-size: 15px;">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2" style="width: 25%;">Nama Barang</th>
                                        <th rowspan="2">Deskripsi</th>
                                        <th rowspan="2">Kondisi</th>
                                        <th rowspan="2">Total</th>
                                        <th rowspan="2" style="width: 15%;">Jumlah Pengambilan</th>
                                        <th colspan="2">Lokasi Penyimpanan</th>
                                        <th rowspan="2">
                                            <input type="checkbox" id="selectAll" style="scale: 1.7;">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Gedung</th>
                                        <th>Kode Palet</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($item->where('status_proses_id', 4) as $i => $row)
                                    @foreach($row->slot as $subRow)
                                    <tr>
                                        <td class="pt-3">{{ $no++ }}</td>
                                        <td class="pt-3 text-left">{{ $subRow->barang->nama_barang }}</td>
                                        <td class="pt-3 text-left">{{ $subRow->barang->keterangan }}</td>
                                        <td class="pt-3">{{ $subRow->barang->kondisi_barang }}</td>
                                        <td class="pt-3">{{ $subRow->total_masuk - $subRow->penyimpanan->total_keluar }} {{ $row->satuan }}</td>
                                        <td>
                                            <input type="hidden" name="penyimpanan_detail_id[]" value="{{ $subRow->id_detail }}">
                                            <input type="number" class="form-control input-border-bottom text-center" name="jumlah[]" min="0" max="{{ $subRow->total_masuk - $subRow->penyimpanan->total_keluar }}" value="{{ $subRow->total_masuk - $subRow->penyimpanan->total_keluar }}">
                                        </td>
                                        <td class="pt-3">{{ $subRow->penyimpanan->gedung->nama_gedung }}</td>
                                        <td class="pt-3">{{ $subRow->penyimpanan->kode_palet }}</td>
                                        <td class="text-center p-3">
                                            <input type="hidden" value="" name="status_barang[{{$i}}]">
                                            <input type="checkbox" class="confirm-check" style="scale: 1.7;" name="status_barang[{{$i}}]" id="checkbox_id{{$i}}" value="true">
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            @endif

                            @if ($category == 442)
                            <h6>
                                Pilih <b>Ambil</b> barang - masukkan jumlah pengambilan - Tutup -> Submit
                            </h6>
                            <table class="table table-bordered text-center" style="font-size: 15px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Deskripsi</th>
                                        <th>Kondisi</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($item as $row)
                                    <tr>
                                        <td class="pt-3">{{ $no++ }}</td>
                                        <td class="pt-3 text-left">{{ $row->nama_barang }}</td>
                                        <td class="pt-3 text-left">{{ $row->keterangan }}</td>
                                        <td class="pt-3">{{ $row->kondisi_barang }}</td>
                                        <td class="pt-3">{{ $row->jumlah_diterima }} {{ $row->satuan }}</td>
                                        <td>
                                            <a type="button" data-toggle="modal" onclick="showModal('{{ $row->id_detail }}')" class="btn btn-warning btn-sm">
                                                <img src="https://img.icons8.com/?size=512&id=Ao3on8PYsYxx&format=png" class="mb-1" width="20">
                                                Ambil
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Informasi Sudah Benar?')">
                        <i class="fas fa-paper-plane fa-1x"></i> <b>Submit</b>
                    </button>
                </div>
            </div>

        </form>
    </div>
</section>
@else
<form action="{{ $category == 'penyimpanan' ? route('submission.preview', '*') : route('submission.post', 'pengambilan') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="content">
        <div class="container">

            <div class="text-center mt-5 mb-5">
                <a href="{{ route('submission.create', 441) }}" class="btn btn-default border-secondary
            {{ $category == 441 ? 'disabled' : '' }}">
                    <img src="https://img.icons8.com/?size=512&id=y2GWL3nrlTBH&format=png" width="100">
                    <h5 class="mt-2 font-weight-bold">Barang Milik Negara</h5>
                </a>
                <a href="{{ route('submission.create', 442) }}" class="btn btn-default border-secondary mr-3 ml-3
            {{ $category == 442 ? 'disabled' : '' }}">
                    <img src="https://img.icons8.com/?size=512&id=ZMPdx6W4ncKR&format=png" width="100">
                    <h5 class="mt-2 font-weight-bold">Barang Persediaan</h5>
                </a>
                <a href="{{ route('submission.create', 443) }}" class="btn btn-default border-secondary disabled">
                    <img src="https://img.icons8.com/?size=512&id=Yz_vvkGf41Jj&format=png" width="100">
                    <h5 class="mt-2 font-weight-bold">Barang Bongkaran</h5>
                </a>
            </div>

            @if ($item && $item->count() > 0)
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
                    <!-- <div class="form-group row">
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
                    </div> -->

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
                                    <input type="file" class="form-control image" name="file_barang[]" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" onchange="displaySelectedFileCountItem(this)" required>
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

                            @if ($category == 441)
                            <h6>
                                Checklist (✔️) barang yang akan diambil, jika total lebih dari 1, masukkan jumlah pengambilan.
                            </h6>
                            <table class="table table-bordered text-center" style="font-size: 15px;">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2" style="width: 25%;">Nama Barang</th>
                                        <th rowspan="2">Deskripsi</th>
                                        <th rowspan="2">Kondisi</th>
                                        <th rowspan="2">Total</th>
                                        <th rowspan="2" style="width: 15%;">Jumlah Pengambilan</th>
                                        <th colspan="2">Lokasi Penyimpanan</th>
                                        <th rowspan="2">
                                            <input type="checkbox" id="selectAll" style="scale: 1.7;">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Gedung</th>
                                        <th>Kode Palet</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($item->where('status_proses_id', 4) as $i => $row)
                                    @foreach($row->slot as $subRow)
                                    <tr>
                                        <td class="pt-3">{{ $no++ }}</td>
                                        <td class="pt-3 text-left">{{ $subRow->barang->nama_barang }}</td>
                                        <td class="pt-3 text-left">{{ $subRow->barang->keterangan }}</td>
                                        <td class="pt-3">{{ $subRow->barang->kondisi_barang }}</td>
                                        <td class="pt-3">{{ $subRow->total_masuk - $subRow->penyimpanan->total_keluar }} {{ $row->satuan }}</td>
                                        <td>
                                            <input type="hidden" name="penyimpanan_detail_id[]" value="{{ $subRow->id_detail }}">
                                            <input type="number" class="form-control input-border-bottom text-center" name="jumlah[]" min="0" max="{{ $subRow->total_masuk - $subRow->penyimpanan->total_keluar }}" value="{{ $subRow->total_masuk - $subRow->penyimpanan->total_keluar }}">
                                        </td>
                                        <td class="pt-3">{{ $subRow->penyimpanan->gedung->nama_gedung }}</td>
                                        <td class="pt-3">{{ $subRow->penyimpanan->kode_palet }}</td>
                                        <td class="text-center p-3">
                                            <input type="hidden" value="" name="status_barang[{{$i}}]">
                                            <input type="checkbox" class="confirm-check" style="scale: 1.7;" name="status_barang[{{$i}}]" id="checkbox_id{{$i}}" value="true">
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            @endif

                            @if ($category == 442)
                            <h6>
                                Pilih <b>Ambil</b> barang - masukkan jumlah pengambilan - Tutup -> Submit
                            </h6>
                            <table class="table table-bordered text-center" style="font-size: 15px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Deskripsi</th>
                                        <th>Kondisi</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($item as $row)
                                    <tr>
                                        <td class="pt-3">{{ $no++ }}</td>
                                        <td class="pt-3 text-left">{{ $row->nama_barang }}</td>
                                        <td class="pt-3 text-left">{{ $row->keterangan }}</td>
                                        <td class="pt-3">{{ $row->kondisi_barang }}</td>
                                        <td class="pt-3">{{ $row->jumlah_diterima }} {{ $row->satuan }}</td>
                                        <td>
                                            <a type="button" data-toggle="modal" onclick="showModal('{{ $row->id_detail }}')" class="btn btn-warning btn-sm">
                                                <img src="https://img.icons8.com/?size=512&id=Ao3on8PYsYxx&format=png" class="mb-1" width="20">
                                                Ambil
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Informasi Sudah Benar?')">
                        <i class="fas fa-paper-plane fa-1x"></i> <b>Submit</b>
                    </button>
                </div>
            </div>
            @elseif ($item && $item->count() == 0)
            <div class="alert alert-danger alert-dismissible">
                <h5 class="mt-2"><i class="icon fas fa-ban"></i> Tidak ada barang yang tersimpan di Gudang PN!</h5>
            </div>
            @endif
        </div>
    </section>

    @foreach ($item as $i => $row)
    <div class="modal fade" id="placement-{{ $row->id_detail }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModal">Penempatan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="status" value="false">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-2 col-4">Barang</div>:
                        <div class="col-md-9 col-7">{{ $row->nama_barang }}</div>
                        <div class="col-md-2 col-4">Catatan</div>:
                        <div class="col-md-9 col-7">{{ $row->catatan }}</div>
                        <div class="col-md-2 col-4">Deskripsi</div>:
                        <div class="col-md-9 col-7">{{ $row->deskripsi }}</div>
                        <div class="col-md-2 col-4">Jumlah</div>:
                        <div class="col-md-9 col-7">{{ $row->jumlah_diterima.' '.$row->satuan }}</div>
                    </div>
                    <div>
                        <label>Lokasi Penyimpanan</label>
                        <div class=" table-responsive">
                            <table class="table table-bordered text-center border-secondary">
                                <thead>
                                    <tr>
                                        <th style="width: 0%;" class="text-center">No</th>
                                        <th style="width: 25%;">Gedung</th>
                                        <th style="width: 25%;">Kode Palet</th>
                                        <th style="width: 10%;">Stok</th>
                                        <th style="width: 20%;">Jumlah Permintaan</th>
                                        <th style="width: 25%;">Satuan</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($row->slot as $subRow)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $subRow->penyimpanan->gedung->nama_gedung }}</td>
                                        <td>{{ $subRow->penyimpanan->kode_palet }}</td>
                                        <td>{{ $subRow->total_masuk - $subRow->penyimpanan->total_keluar }}</td>
                                        <td>
                                            <input type="hidden" name="penyimpanan_detail_id[]" value="{{ $subRow->id_detail }}">
                                            <input type="number" class="form-control input-border-bottom text-center" name="jumlah[]" max="{{ $subRow->total_masuk - $subRow->penyimpanan->total_keluar }}" min="0" value="0">
                                        </td>
                                        <td>{{ $row->satuan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-danger" data-dismiss="modal">Tutup</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</form>
@endif

@section('js')
<script>
    $(function() {
        $("#workunit").select2()
        $("#employee").select2()

        $('#selectAll').click(function() {
            if ($(this).prop('checked')) {
                $('.confirm-check').prop('checked', true);
            } else {
                $('.confirm-check').prop('checked', false);
            }
        })
    })

    function showModal(id_barang) {
        var modal_target = "#placement-" + id_barang;
        $(modal_target).modal('show');
    }

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
