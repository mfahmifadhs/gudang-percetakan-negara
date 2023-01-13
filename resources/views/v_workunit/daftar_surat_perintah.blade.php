@extends('v_main.layout.app')

@section('content')

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
        <div class="row g-5">
            <div class="col-lg-12">
                <div class="h-100">
                    <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
                    <h1 class="display-6 mb-4">Surat Perintah</h1>
                    <div class="row">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <table id="table-1" class="table text-center text-capitalize border" style="color: black;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Tujuan</th>
                                            <th>Pengirim/Jabatan</th>
                                            <th>Total Barang</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 1; ?>
                                    <tbody class="small">
                                        @foreach($warrent as $dataWarrent)
                                        <tr>
                                            <td class="pt-3">{{ $no++ }}</td>
                                            <td class="pt-3">{{ \Carbon\Carbon::parse($dataWarrent->warr_date)->isoFormat('DD MMMM Y') }}</td>
                                            <td class="pt-3">
                                                <div class="mt-1" style="font-size: 10px;">
                                                    @if ($dataWarrent->warr_purpose == 'penyimpanan')
                                                    <span class="bg-success text-white p-2 rounded">PENYIMPANAN</span>
                                                    @else
                                                    <span class="bg-danger text-white p-2 rounded">PENGELUARAN</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="pt-3">{{ $dataWarrent->warr_emp_name.'/'.$dataWarrent->warr_emp_position }}</td>
                                            <td>{{ $dataWarrent->warr_total_item }} barang</td>
                                            <td class="pt-3">
                                                <div class="mt-1" style="font-size: 10px;">
                                                    @if ($dataWarrent->warr_status == 'proses')
                                                    <span class="bg-warning text-white p-2 small rounded">PROSES</span>
                                                    @elseif($dataWarrent->warr_status == 'konfirmasi')
                                                    <span class="bg-warning text-white p-2 small rounded">MENUNGGU KONFIRMASI</span>
                                                    @else
                                                    <span class="bg-success text-white p-2 small rounded">SELESAI</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown">
                                                        <i class="fas fa-bars"></i>
                                                    </a>
                                                    <div class="dropdown-menu m-0">
                                                        @if($dataWarrent->warr_status == 'sudah diproses')
                                                        <a class="dropdown-item" href="{{ url('unit-kerja/surat/perintah/penyimpanan') }}">
                                                            <i class="fas fa-file"></i> Berita Acara Serah Terima
                                                        </a>
                                                        @elseif($dataWarrent->warr_status == 'konfirmasi')
                                                        <a class="dropdown-item" href="{{ url('unit-kerja/surat-perintah/konfirmasi/'. $dataWarrent->id_warrent) }}">
                                                            <i class="fas fa-clipboard-check"></i> Konfirmasi Penyimpanan
                                                        </a>
                                                        @else
                                                        <a class="dropdown-item" href="{{ url('unit-kerja/surat-perintah/detail/'. $dataWarrent->id_warrent) }}">
                                                            <i class="fas fa-info-circle"></i> Detail
                                                        </a>
                                                        @endif
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
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    $(function() {
        var currentdate = new Date();
        var datetime = "Tanggal: " + currentdate.getDate() + "/" +
            (currentdate.getMonth() + 1) + "/" +
            currentdate.getFullYear()
        $("#table-1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": [{
                    extend: 'pdf',
                    title: 'Daftar Surat Perintah',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    messageTop: datetime
                },
                {
                    extend: 'excel',
                    title: 'Daftar Surat Perintah',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    messageTop: datetime
                }
            ],
        }).buttons().container().appendTo('#table-1_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection

@endsection
