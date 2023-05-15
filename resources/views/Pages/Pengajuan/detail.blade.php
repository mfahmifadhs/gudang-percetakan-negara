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
                        {{ $data->unitkerja->nama_unit_kerja }}
                    </div>
                    <label class="col-md-2">Surat Pengajuan</label>
                    <div class="col-md-10">:
                        @if (!$data->surat_pengajuan)
                        Tidak ada file yang di upload
                        @else
                        <a href="{{ url('/surat/preview/'. $data->surat_pengajuan) }}">
                            Lihat Surat
                        </a>
                        @endif
                    </div>
                    <label class="col-md-2">Surat Perintah</label>
                    <div class="col-md-10">:
                        @if (!$data->surat_perintah)
                        Tidak ada file yang di upload
                        @else
                        <a href="{{ url('/surat/preview/'. $data->surat_perintah) }}">
                            Lihat Surat
                        </a>
                        @endif
                    </div>
                    @if ($data->keterangan_ketidaksesuaian)
                    <label class="col-md-2">Hasil Penapisan</label>
                    <div class="col-md-10">:
                        {{ $data->keterangan_ketidaksesuaian }}
                    </div>
                    @endif


                    @if ($data->status_proses_id == 4)
                        <label class="col-md-2">Berita Acara</label>
                        <div class="col-md-10">:
                            <a href="{{ route('bast.show', $data->id_pengajuan) }}" target="_blank">Lihat Surat</a>
                        </div>
                        @if ($data->jenis_pengajuan == 'masuk')
                        <label class="col-md-2">Batas Waktu</label>
                        <div class="col-md-10">:
                            {{ \Carbon\carbon::parse($data->batas_waktu)->isoFormat('DD MMMM Y') }}
                        </div>
                        @endif
                        <label class="col-md-2">Batas Waktu</label>
                        <div class="col-md-10">:
                            <a type="button" data-toggle="modal" data-target="#printBarcode" class="btn btn-warning btn-sm">
                                <i class="fas fa-qrcode"></i> Cetak QRCode
                            </a>
                        </div>
                    @endif
                </div>
                <div class="form-group row">
                    <label class="col-md-12">
                        Informasi Barang
                    </label>
                    <div class="col-md-12">
                        @if ($data->jenis_pengajuan == 'masuk')
                        <table id="table-preview-101" class="table table-bordered" style="font-size: 15px;">
                            <thead class="text-center">
                                <tr>
                                    <th class="p-4">No</td>
                                    <th class="p-4">Nama Barang</td>
                                    <th class="p-4">Merek/Tipe</td>
                                    <th class="p-4">Kondisi</td>
                                    @if ($catatan != 'NUP')
                                        <th class="p-3">{{ $catatan }}</td>
                                    @else
                                        <th class="p-4">{{ $catatan }}</td>
                                    @endif
                                    <th class="p-3">Jumlah <br> Permintaan</td>
                                    <th class="p-3">Jumlah <br> Diterima</td>
                                    <th class="p-4">Satuan</td>
                                    <th class="p-4">Keterangan</td>
                                    <th class="p-3">Lokasi <br> Penyimpanan</th>
                                </tr>
                            </thead>
                            @php $no = 1; @endphp
                            <tbody>
                                @foreach ($data->penyimpanan as $row)
                                <tr>
                                    <td class="text-center">
                                        {{ $no++ }}
                                    </td>
                                    <td>{{ $row->nama_barang }}</td>
                                    <td>{{ $row->deskripsi }}</td>
                                    <td class="text-center">
                                        {{ $row->kondisi_barang }}
                                    </td>
                                    <td class="text-center">
                                        {{ $row->catatan }}
                                    </td>
                                    <td class="text-center">
                                        {{ (int) $row->jumlah_pengajuan }}
                                    </td>
                                    <td class="text-center">
                                        {{ (int) $row->jumlah_diterima }}
                                    </td>
                                    <td class="text-center">
                                        {{ $row->satuan }}
                                    </td>
                                    <td class="text-center">
                                        {{ $row->keterangan }}
                                    </td>
                                    <td class="text-center">
                                        <a type="button" href="{{ route('item.detail', $row->id_detail) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pallet"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <table id="table-preview-102" class="table table-bordered" style="font-size: 15px;">
                            <thead class="text-center">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Barang</th>
                                    <th>Deskripsi</th>
                                    <th>NUP/Masa Kadaluarsa</th>
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
                                    <td>{{ $row->detailPenyimpanan->barang->deskripsi }}</td>
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
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('submission.show') }}" class="btn btn-default">
                    <i class="fas fa-arrow-circle-left fa-1x"></i> <b>Kembali</b>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="printBarcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('submission.barcode', $data->id_pengajuan) }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Posisi</label>
                        <select name="position" class="form-control">
                            <option value="">Atas</option>
                            <option value="middle">Tengah</option>
                            <option value="bottom">Bawah</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($data->penyimpanan as $i => $row)
<div class="modal fade" id="placement-{{ $row->id_detail }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModal">Lokasi Penyimpanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" name="status" value="false">
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-2">Nama Barang</div>:
                    <div class="col-md-9">{{ $row->nama_barang }}</div>
                    <div class="col-md-2">Catatan</div>:
                    <div class="col-md-9">{{ $row->catatan }}</div>
                    <div class="col-md-2">Deskripsi</div>:
                    <div class="col-md-9">{{ $row->deskripsi }}</div>
                    <div class="col-md-2">Jumlah</div>:
                    <div class="col-md-9">{{ $row->jumlah_diterima.' '.$row->satuan }}</div>
                </div>
                @if ($row->slot->count() != 0)
                <div class="form-group row">
                    <div class="col-md-12">Lokasi Penyimpanan</div>
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped text-center" style="font-size: 15px;">
                            <thead>
                                <th>No</th>
                                <th>Nama Gudang</th>
                                <th>Kode Palet</th>
                                <th>Total Barang Masuk</th>
                                <th>Total Barang Keluar</th>
                            </thead>
                            <tbody>
                                @foreach ($row->slot as $no => $subRow)
                                <tr>
                                    <td>{{ $no +1 }}</td>
                                    <td>{{ $subRow->nama_gedung }}</td>
                                    <td>{{ $subRow->kode_palet }}</td>
                                    <td>{{ (int) $subRow->total_masuk.' '.$row->satuan }}</td>
                                    <td>{{ (int) $subRow->total_keluar.' '.$row->satuan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                <div>

                </div>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</a>
            </div>
        </div>
    </div>
</div>
@endforeach

@section('js')
<script>
    $("#table-preview-101").DataTable({
        'paging': false,
        'info': false,
        'searching': false,
        'sort': false,
        'columnDefs': [
            {'width': '0%', 'targets': 0},
            {'width': '15%', 'targets': 1},
            {'width': '15%', 'targets': 2},
            {'width': '10%', 'targets': 3},
            {'width': '10%', 'targets': 4},
            {'width': '5%', 'targets': 5},
            {'width': '5%', 'targets': 6},
        ]
    });

    $(function() {
        $("#workunit").select2()
        $("#employee").select2()
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


    function displaySelectedFileCount(input) {
        var selectedFileCount = input.files.length;
        var selectedFileCountElement = document.getElementById('selected-file-count');
        selectedFileCountElement.textContent = selectedFileCount + ' (file dipilih)';
    }
</script>
@endsection

@endsection
