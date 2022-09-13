@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>DAFTAR BARANG MASUK</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('petugas/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('petugas/aktivitas/daftar/pengiriman') }}">Daftar Pengiriman</a></li>
                    <li class="breadcrumb-item active">Daftar Barang Masuk</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 form-group">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <a href="#" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> <b>Cari Barang</b>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 form-group">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <div class="card-tools">
                                    <button type="button" class="btn btn-default" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="table1" class="table table-responsive table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No</th>
                                            <th style="width: 30%;">Unit Kerja</th>
                                            <th style="width: 40%;">Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th style="width: 30%;;">Lokasi Penyimpanan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody class="text-capitalize text-center">
                                        @foreach($items as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->workunit_name }}</td>
                                            <td>{{ $item->in_item_name }}</td>
                                            <td>
                                                @if($item->order_category == 'Pengiriman')
                                                {{ $item->in_item_qty }}
                                                @endif
                                            </td>
                                            <td>{{ $item->in_item_unit }}</td>
                                            <td>{{ $item->id_slot.' / '.$item->warehouse_name}}</td>
                                            <td class="text-center">
                                                <a type="button" class="btn btn-primary" data-toggle="dropdown">
                                                    <i class="fas fa-bars"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a href="{{ url('petugas/cetak-qrcode/'. $item->id_item_incoming) }}" target="_blank">CETAK PDF</a>
                                                    <a class="dropdown-item btn" type="button" data-toggle="modal" data-target="#qr-code{{ $item->id_item_incoming }}">
                                                        <i class="fas fa-qrcode"></i> Cetak QR Code
                                                    </a>
                                                    <a class="dropdown-item" href="{{ url('admin-master/pengguna/hapus/'. $item->id_item_incoming) }}" onclick="return confirm('Hapus data pengguna ?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- MODAL QR CODE -->
                                        <div class="modal fade" id="qr-code{{ $item->id_item_incoming }}" tabindex="-1" role="dialog" aria-labelledby="qr-code" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-capitalize">Qr Code - {{ $item->in_item_name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="card-body text-center text-capitalize">
                                                        <p>
                                                            {!! QrCode::size(300)->generate('https://www.inventory-testing.com/'.$item->id_item_incoming) !!}
                                                        </p>
                                                        <p>{{ $item->in_item_name.' Merk '.$item->in_item_merk }}</p>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <p class="mt-4 mb-4">
                                                            <a href="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(250)->style('round')->generate('https://www.inventory-testing.com/'.$item->id_item_incoming)) }}" class="btn btn-primary" download="{{ $item->id_item_incoming }} ">
                                                                Download
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#table1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true
        });
    });
</script>
@endsection

@endsection
