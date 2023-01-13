@extends('v_main.layout.app')

@section('content')

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container" style="margin-top: 80px;">
        <div class="row g-5">
            <div class="col-lg-12">
                <div class="h-100">
                    <div class="row">
                        <div class="col-md-12 pt-3 pb-3">
                            <h3 class="text-capitalize">Selamat Datang, {{ Auth::user()->full_name }}</h3>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h2>{{ $items->where('item_category_id', 1)->count() }}</h2>
                                    <span>Barang Milik Negara (BMN)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h2>{{ $items->where('item_category_id', 2)->count() }}</h2>
                                    <span>Barang Persediaan</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h2>{{ $items->where('item_category_id', 3)->count() }}</h2>
                                    <span>Bongkaran</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h2>{{ $items->where('item_category_id', 4)->count() }}</h2>
                                    <span>Alat Angkutan Darat Bermotor</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <b>Tabel Usulan Penyimpanan / Pengeluaran Barang</b>
                                </div>
                                <div class="card-body">
                                    <table id="table1" class="table text-capitalize text-center" style="color: black;">
                                        <thead style="color: black;">
                                            <tr>
                                                <th>No</th>
                                                <th style="width: 20%;">Tanggal</th>
                                                <th>Unit Kerja</th>
                                                <th style="width: 20%;">Tujuan</th>
                                                <th style="width: 20%;">Status</th>
                                                <th style="width: 10%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <?php $no = 1; ?>
                                        <tbody class="small">
                                            @foreach($appletter as $dataAppletter)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ \Carbon\Carbon::parse($dataAppletter->appletter_date)->isoFormat('HH:mm / DD MMM YY') }}</td>
                                                <td>{{ $dataAppletter->workunit_name }}</td>
                                                <td>
                                                    <div class="mt-2" style="font-size: 10px;">
                                                        @if ($dataAppletter->appletter_purpose == 'penyimpanan')
                                                        <span class="bg-success text-white p-2 rounded">PENYIMPANAN</span>
                                                        @else
                                                        <span class="bg-danger text-white p-2 rounded">PENGELUARAN</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="mt-2 text-uppercase" style="font-size: 10px;">
                                                        @if ($dataAppletter->appletter_status == 'proses')
                                                        <span class="bg-warning text-white p-2 rounded">{{ $dataAppletter->appletter_status }}</span>
                                                        @else
                                                        <span class="bg-warning text-white p-2 rounded"><b>buat surat perintah</b></span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown">
                                                            <i class="fas fa-bars"></i>
                                                        </a>
                                                        <div class="dropdown-menu m-0">
                                                            @if($dataAppletter->appletter_status == 'diterima' && $dataAppletter->appletter_purpose == 'penyimpanan' && $dataAppletter->appletter_process == 'false')
                                                            <a class="dropdown-item" href="{{ url('unit-kerja/surat-perintah/penyimpanan/'. $dataAppletter->id_app_letter) }}">
                                                                <i class="fas fa-plus-square"></i> Buat Surat Perintah
                                                            </a>
                                                            @elseif($dataAppletter->appletter_status == 'diterima' && $dataAppletter->appletter_purpose == 'pengeluaran' && $dataAppletter->appletter_process == 'false')
                                                            <a class="dropdown-item" href="{{ url('unit-kerja/surat-perintah/pengeluaran/'. $dataAppletter->id_app_letter) }}">
                                                                <i class="fas fa-plus-square"></i> Buat Surat Perintah
                                                            </a>
                                                            @endif
                                                            <a class="dropdown-item" href="{{ url('unit-kerja/surat/detail-surat-pengajuan/'. $dataAppletter->id_app_letter) }}">
                                                                <i class="fas fa-info-circle"></i> Detail
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
               <h1 class="display-6 mb-5">Surat Permohonan Pengajuan</h1> -->

                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    $(function() {
        $("#table1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "searching": true,
            "info": true,
            "sort": true,
            "paging": true
        })
    })
</script>
@endsection

@endsection
