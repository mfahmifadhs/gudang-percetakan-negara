@extends('Layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">Gudang Percetakan Negara</h1>
                <h5>Selamat Datang, {{ Auth::user()->pegawai->nama_pegawai  }}</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container-fluid">
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-bold">Prosedur Pengajuan Penyimpanan/Pengambilan Barang di Gudang Percetakan Negara</h6>
                        <h6 class="small">
                            1. Membuat pengajuan penyimpanan atau pengambilan barang, dengan mangupload surat permohonan yang sudah
                               dibuat melalui Aplikasi Srikandi. <br>
                            2. Menunggu persetujuan Ketua Tim Kerja Pegudangan Percetakan Negara. <br>
                            3. Melakukan pengiriman atau pengambilan barang. <br>
                            4. Proses Penapisan atau pengecekan oleh Petugas Gudang Percetakan Negara. <br>
                            5. Melakukan penempatan penyimpanan barang atau pengambilan barang. <br>
                            6. Menyerahkan Berita Acara oleh Petugas Gudang.
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-outline card-warning">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Pengajuan Terbaru</h3><br>
                        <small>Pengajuan yang sedang diproses</small>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="table-submission" class="table m-0" style="font-size: 14px;">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Unit Kerja</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($submission->where('status_proses_id', '!=', 4 )->take(5) as $i => $row)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td class="text-center">{{ \Carbon\carbon::parse($row->tanggal_pengajuan)->isoFormat('DD MMMM Y') }}</td>
                                        <td>{{ $row->unitkerja->nama_unit_kerja }}</td>
                                        <td>
                                            @if ($row->status_proses_id == 1)
                                            <span class="badge badge-warning">Menunggu Persetujuan</span>
                                            @endif

                                            @if ($row->status_proses_id == 2 && Auth::user()->role_id == 4)
                                            <span class="badge badge-warning">{{ $row->keterangan_proses }}</span>
                                            @endif

                                            @if ($row->status_proses_id == 2 && Auth::user()->role_id != 4)
                                            <span class="badge badge-warning">Proses Penapisan</span>
                                            @endif

                                            @if ($row->status_proses_id == 3)
                                            <span class="badge badge-warning">
                                                Proses {{ $row->jenis_pengajuan == 'masuk' ? 'Penyimpanan' : 'Pengeluaran' }}
                                            </span>
                                            @endif

                                            @if ($row->status_proses_id == 4)
                                            <span class="badge badge-success">Selesai</span>
                                            @endif

                                            @if ($row->status_pengajuan_id == 2)
                                            <span class="badge badge-danger">{{ $row->keterangan_proses }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $row->keterangan }}
                                        </td>
                                        <td class="text-center">
                                            <a type="button" class="btn btn-warning btn-sm" data-toggle="dropdown">
                                                <i class="fas fa-bars"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                @if (Auth::user()->role_id == 3)
                                                @if (!$row->status_pengajuan_id)
                                                <a class="dropdown-item btn" type="button" href="{{ route('submission.check', $row->id_pengajuan) }}">
                                                    <i class="fas fa-check-circle"></i> Verifikasi
                                                </a>
                                                @endif
                                                @endif

                                                @if (Auth::user()->role_id == 2)
                                                @if ($row->status_proses_id == 2)
                                                <a class="dropdown-item btn" type="button" href="{{ route('submission.filter', $row->id_pengajuan) }}">
                                                    <i c lass="fas fa-tasks"></i> Penapisan
                                                </a>
                                                @endif

                                                @if ($row->status_proses_id == 3)
                                                <a class="dropdown-item btn" type="button" href="{{ route('submission.process', $row->id_pengajuan) }}">
                                                    <i class="fas fa-dolly-flatbed"></i> Proses
                                                </a>
                                                @endif
                                                @endif

                                                <a class="dropdown-item btn" type="button" href="{{ route('submission.detail', $row->id_pengajuan) }}">
                                                    <i class="fas fa-info-circle"></i> Detail
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="card-footer clearfix">
                        <a href="{{ route('submission.show') }}" class="btn btn-sm btn-secondary float-right">Seluruh Pengajuan</a>
                    </div>

                </div>
            </div>
            <!-- <div class="col-md-4">
                <div class="card  card-outline card-warning">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Batas Waktu Penyimpanan</h3><br>
                        <small>Batas Waktu Penyimpanan Kurang dari 1 tahun</small>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="table-limit" class="table m-0 text-center" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Pengajuan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($submission as $row)
                                    @if (\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($row->batas_waktu)) < 365 && $row->batas_waktu != null)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $row->id_pengajuan }}</td>
                                            <td>{{ $row->batas_waktu }}</td>
                                            <td class="text-center">
                                                <a type="button" class="btn btn-warning btn-sm" href="{{ route('submission.detail', $row->id_pengajuan) }}">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#table-submission").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "info": false,
            "paging": false,
            "searching": false,
            "sort": false,
            "columnDefs": [{
                    "width": "5%",
                    "targets": 0
                },
                {
                    "width": "15%",
                    "targets": 1
                },
                {
                    "width": "30%",
                    "targets": 2
                },
            ]
        }).buttons().container().appendTo('#table-submission_wrapper .col-md-6:eq(0)')

        $("#table-limit").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "info": false,
            "paging": false,
            "searching": false,
            "sort": false,
            "columnDefs": [{
                    "width": "5%",
                    "targets": 0
                },
                {
                    "width": "25%",
                    "targets": 2
                },
            ]
        }).buttons().container().appendTo('#table-limit_wrapper .col-md-6:eq(0)')
    })
</script>
@endsection



@endsection
