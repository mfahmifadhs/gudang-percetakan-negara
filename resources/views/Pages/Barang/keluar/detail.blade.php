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
                    <li class="breadcrumb-item"><a href="{{ route('item.show') }}">Daftar Barang</a></li>
                    <li class="breadcrumb-item active">Detail Barang</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p style="color:white;margin: auto;">{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('failed'))
        <div class="alert alert-danger">
            <p style="color:white;margin: auto;">{{ $message }}</p>
        </div>
        @endif
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Detail Barang</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label class="col-md-3">Tanggal</label>:
                            <div class="col-md-8">{{ \Carbon\carbon::parse($item->tanggal_pengajuan)->isoFormat('DD MMMM Y') }}</div>
                            <label class="col-md-3">Unit Kerja</label>:
                            <div class="col-md-8">{{ $item->pengajuan->unitkerja->nama_unit_kerja }}</div>
                            <label class="col-md-3">Nama Barang</label>:
                            <div class="col-md-8">{{ $item->detailPenyimpanan->barang->nama_barang }}</div>
                            <label class="col-md-3">Merek/Tipe</label>:
                            <div class="col-md-8">{{ $item->detailPenyimpanan->barang->deskripsi }}</div>
                            <label class="col-md-3">Tahun Perolehan</label>:
                            <div class="col-md-8">{{ $item->detailPenyimpanan->barang->tahun_perolehan }}</div>
                            <label class="col-md-3">{{ $item->detailPenyimpanan->barang->jenis_barang_id == 441 ? 'NUP' : 'Masa Kadaluarsa' }}</label>:
                            <div class="col-md-8">{{ $item->detailPenyimpanan->barang->catatan }}</div>
                            <label class="col-md-3">Keterangan</label>:
                            <div class="col-md-8">{{ $item->keterangan }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-md-4">Total Barang</label>:
                            <div class="col-md-7">{{ $item->detailPenyimpanan->barang->jumlah_diterima.' '.$item->detailPenyimpanan->barang->satuan }}</div>
                            <label class="col-md-4">Sisa Stok</label>:
                            <div class="col-md-7">{{ $stock.' '.$item->satuan }}</div>
                            @if (Auth::user()->role_id != 4)
                            <label class="col-md-4">QR Code</label>:
                            <label class="col-md-7">
                                <a type="button" data-toggle="modal" data-target="#printBarcode" class="btn btn-warning btn-sm">
                                    <i class="fas fa-qrcode"></i> Cetak QRCode
                                </a>
                            </label>
                            @endif
                        </div>
                    </div>
                </div>
                <table id="table-show" class="table table-bordered table-striped" style="font-size: 15px;">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Gedung</th>
                            <th>Kode Palet</th>
                            <th>Jumlah Masuk</th>
                            <th>Jumlah Keluar</th>
                            <th>Sisa Stok</th>
                            <th>Riwayat</th>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody class="text-center">
                        @foreach($item->detailPenyimpanan->barang->slot as $row)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="">{{ $row->nama_gedung }}</td>
                            <td class="">{{ $row->kode_palet }}</td>
                            <td class="">{{ (int) $row->total_masuk.' '.$item->satuan }}</td>
                            <td class="">{{ (int) $row->total_keluar.' '.$item->satuan }}</td>
                            <td class="">{{ (int) $row->total_masuk - $row->total_keluar.' '.$item->satuan }}</td>
                            <td class="text-center">
                                <a type="button" data-toggle="modal" onclick="showModal('{{ $row->id_detail }}')" class="btn btn-warning btn-sm">
                                    <i class="fas fa-history"></i>
                                </a>
                            </td>
                            @endforeach
                    </tbody>
                </table>
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
            <form action="{{ route('item.barcode', $item->id_detail) }}" method="POST" target="_blank">
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
                    <div class="form-group">
                        <label>Jumlah Cetakan</label>
                        <input type="number" class="form-control" name="qty" value="1">
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

@foreach ($item->detailPenyimpanan->barang->slot as $i => $row)
<div class="modal fade" id="item-{{ $row->id_detail }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModal">Riwayat Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" name="status" value="false">
            <div class="modal-body">
                <table id="table-history" class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($row->history as $i => $subRow)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ \Carbon\carbon::parse($subRow->created_at)->isoFormat('DD MMMM Y HH:mm:ss') }}</td>
                            <td>{{ $subRow->kategori }}</td>
                            <td class="text-center">{{ $subRow->jumlah.' '.$item->satuan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach

@section('js')
<script>
    $(function() {
        $("#table-show").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')

        $("#table-history").DataTable({
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')
    })

    function showModal(id_barang) {
        var modal_target = "#item-" + id_barang;
        $(modal_target).modal('show');
    }
</script>
@endsection

@endsection
