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
                        <div class="col-md-4 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <div id="konten-chart">
                                        <div id="piechart" style="height: 500px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <b>Tabel Usulan Penyimpanan / Pengeluaran Barang</b>
                                </div>
                                <div class="card-body">
                                    <table id="table1" class="table table-bordered table-striped text-capitalize text-center">
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
                                                <td>{{ $dataAppletter->appletter_purpose }} barang</td>
                                                <td>
                                                    <div class="mt-2">
                                                        @if ($dataAppletter->appletter_status == 'proses')
                                                        <span class="bg-warning text-white p-1 small rounded">{{ $dataAppletter->appletter_status }}</span>
                                                        @else
                                                        <span class="bg-success text-white p-1 small rounded">{{ $dataAppletter->appletter_status }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown">
                                                            <i class="fas fa-bars"></i>
                                                        </a>
                                                        <div class="dropdown-menu m-0">
                                                            <a class="dropdown-item" href="{{ url('tim-kerja/surat/detail-surat-pengajuan/'. $dataAppletter->id_app_letter) }}">
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
        });

        let chart
        let chartData = JSON.parse(`<?php echo $chartItem; ?>`)
        let dataChart = chartData.all
        google.charts.load('current', {
            'packages': ['corechart']
        })
        google.charts.setOnLoadCallback(function() {
            drawChart(dataChart)
        })

        function drawChart(dataChart) {

            chartData = [
                ['Unit Kerja', 'Jumlah Barang']
            ]
            dataChart.forEach(data => {
                chartData.push(data)
            })

            var data = google.visualization.arrayToDataTable(chartData);

            var options = {
                title: 'Total Barang Tersimpan di Gudang',
                is3D: false,
                height: 500,
                legend: {
                    'position': 'bottom',
                    'alignment': 'center',
                    'maxLines': '2'
                },
            }

            chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    });
</script>
@endsection

@endsection
