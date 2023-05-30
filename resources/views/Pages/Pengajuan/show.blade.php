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
                    <li class="breadcrumb-item active">Daftar Pengajuan</li>
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
        <span>
            Membuat Pengajuan <i class="fas fa-chevron-right"></i>
            Menunggu Persetujuan <i class="fas fa-chevron-right"></i>
            Penapisan <i class="fas fa-chevron-right"></i>
            Proses Penempatan/Pengambilan <i class="fas fa-chevron-right"></i>
            Cetak Berita Acara
        </span>
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Daftar Pengajuan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="table-show" class="table table-bordered table-striped" style="font-size: 15px;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Tanggal</th>
                            <th>Unit Kerja</th>
                            <th>Perihal</th>
                            <th>Keterangan</th>
                            <th style="width: 0%;" class="text-center">Total Barang</th>
                            <th style="width: 15%;" class="text-center">Proses <br> Pengajuan</th>
                            <th style="width: 0%;" class="text-center">Surat Pengajuan</th>
                            <th style="width: 0%;" class="text-center">Surat Perintah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody>
                        @foreach($submission as $row)
                        <tr>
                            <td class="pt-3 text-center">
                                @if($row->status_pengajuan_id == null)
                                <i class="fas fa-clock text-warning"></i>
                                @elseif($row->status_pengajuan_id == 1)
                                <i class="fas fa-check-circle text-green"></i>
                                @elseif($row->status_pengajuan_id == 2)
                                <i class="fas fa-times-circle text-red"></i>
                                @endif
                                {{ $no++ }}
                            </td>
                            <td class="pt-3">{{ \Carbon\carbon::parse($row->tanggal_pengajuan)->isoFormat('DD MM Y') }}</td>
                            <td class="pt-3">{{ $row->unitkerja->nama_unit_kerja }} </td>
                            <td class="pt-3">{{ $row->jenis_pengajuan == 'masuk' ? 'Penyimpanan' : 'Pengeluaran' }} </td>
                            <td class="pt-3">{{ $row->keterangan }} </td>
                            <td class="pt-3 text-center">
                                {{ $row->jenis_pengajuan == 'masuk' ? count($row->penyimpanan) : $row->riwayat->count() }}
                            </td>
                            <td class="pt-3 text-center">
                                @if ($row->status_proses_id == 1)
                                <span>Menunggu Persetujuan</span>
                                @endif

                                @if ($row->status_proses_id == 2 && Auth::user()->role_id == 4)
                                <span>Dapat Diproses {{ $row->keterangan_proses ? ','. $row->keterangan_proses : '' }}</span>
                                @endif

                                @if ($row->status_proses_id == 2 && Auth::user()->role_id != 4)
                                <span>Proses Penapisan</span>
                                @endif

                                @if ($row->status_proses_id == 3)
                                <span>Proses {{ $row->jenis_pengajuan == 'masuk' ? 'Penyimpanan' : 'Pengeluaran' }}</span>
                                @endif

                                @if ($row->status_proses_id == 4)
                                <span>Selesai</span>
                                @endif

                                @if ($row->status_pengajuan_id == 2)
                                <span class="text-danger">{{ $row->keterangan_proses }}</span>
                                @endif
                            </td>
                            <td class="pt-3 text-center">{{ $row->surat_pengajuan ? '✅' : '❌' }} </td>
                            <td class="pt-3 text-center">{{ $row->surat_perintah ? '✅' : '❌' }} </td>
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
                                            <i class="fas fa-tasks"></i> Penapisan
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

                                    @if (Auth::user()->pegawai->workunit->id_unit_kerja == $row->unitkerja->id_unit_kerja && Auth::user()->role_id == 4)
                                    <a class="dropdown-item btn" type="button" href="{{ route('submission.edit', $row->id_pengajuan) }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @endif

                                    @if (Auth::user()->role_id == 1)
                                    <a class="dropdown-item btn" type="button" href="{{ route('submission.delete', $row->id_pengajuan) }}" onclick="return confirm('Ingin Menghapus Data?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#table-show").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true,
            "columnDefs": [{
                "width": "5%",
                "targets": 0,

            }]
        }).buttons().container().appendTo('#table-show_wrapper .col-md-6:eq(0)')
    })
</script>
@endsection

@endsection
