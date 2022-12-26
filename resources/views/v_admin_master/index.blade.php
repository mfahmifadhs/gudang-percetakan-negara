@extends('v_admin_master.layout.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Selamat Datang, <b>{{ Auth::user()->full_name }}</b></h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Total Administrasi -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <img src="https://cdn-icons-png.flaticon.com/512/3638/3638928.png" width="70">

                    <div class="info-box-content">
                        <span class="info-box-text">Total Barang Masuk</span>
                        <span class="info-box-number">
                            {{ $totalItemEntry }}
                            <small>barang</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/3638/3638928.png" width="70">

                    <div class="info-box-content">
                        <span class="info-box-text">Total Barang Keluar</span>
                        <span class="info-box-number">
                            {{ $totalItemExit }}
                            <small>barang</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/3091/3091609.png" width="70">

                    <div class="info-box-content">
                        <span class="info-box-text">Total Penyimpanan</span>
                        <span class="info-box-number">
                            {{ $totalDelivery }}
                            <small>penyimpanan</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/3091/3091609.png" width="70">

                    <div class="info-box-content">
                        <span class="info-box-text">Total Pengeluaran</span>
                        <span class="info-box-number">
                            {{ $totalPickup }}
                            <small>pengambilan</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>
        <!-- Grafik -->
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-outline card-primary text-center" style="height: 100%;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <select id="" class="form-control" name="workunit">
                                    <option value="">-- Pilih Unit Kerja --</option>
                                    @foreach($workunit as $dataWorkunit)
                                    <option value="{{ $dataWorkunit->id_workunit }}">{{ $dataWorkunit->workunit_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <select id="" class="form-control" name="item_category">
                                    <option value="">-- Pilih Jenis Barang --</option>
                                    @foreach($itemCategory as $dataItemCategory)
                                    <option value="{{ $dataItemCategory->id_item_category }}">{{ $dataItemCategory->item_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <select id="" class="form-control" name="warehouse">
                                    <option value="">-- Pilih Gudang --</option>
                                    @foreach($warehouse as $dataWarehouse)
                                    <option value="{{ $dataWarehouse->id_warehouse }}">{{ $dataWarehouse->warehouse_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group float-right">
                                <div class="row">
                                    <a id="searchChartData" class="btn btn-primary ml-2" value="1">
                                        <i class="fas fa-search"></i> Cari
                                    </a>
                                    <a href="{{ url('super-user/aadb/dashboard') }}" class="btn btn-danger ml-2">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="konten-statistik">
                        <div class="row">
                            <div class="col-md-4">
                                <div id="konten-chart">
                                    <div id="piechart" style="height: 500px;"></div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="table">
                                    <table id="table-barang" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Unit Kerja</th>
                                                <th>Jenis Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Barang</th>
                                                <th>Gudang</th>
                                            </tr>
                                        </thead>
                                        <tbody id="daftar-barang">
                                            @php $no = 1; $googleChartData1 = json_decode($chartItem) @endphp
                                            @foreach ($googleChartData1->items as $dataItem)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $dataItem->workunit_name }}</td>
                                                <td>{{ $dataItem->item_category_name }}</td>
                                                <td>{{ $dataItem->item_name }}</td>
                                                <td>{{ $dataItem->item_qty.' '.$dataItem->item_unit }}</td>
                                                <td>{{ $dataItem->warehouse_id }}</td>
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
</section>

@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    $(function() {
        $("#table-barang").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "info": true,
            "paging": true,
            "searching": true,
            pageLength: 5,
            lengthMenu: [
                [5, 10, 25, -1],
                [5, 10, 25, 'Semua']
            ]
        })
    })

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
            ['Jenis Barang', 'Jumlah']
        ]
        console.log(dataChart)
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

    $('body').on('click', '#searchChartData', function() {
        let workunit = $('select[name="workunit"').val()
        let item_category = $('select[name="item_category"').val()
        let warehouse = $('select[name="warehouse"').val()
        let url = ''
        if (workunit || item_category || warehouse) {
            url = '<?= url("/admin-master/grafic?workunit='+workunit+'&item_category='+item_category+'&warehouse='+warehouse+'") ?>'
        } else {
            url = '<?= url("/admin-master/grafik") ?>'
        }
        jQuery.ajax({
            url: url,
            type: "GET",
            success: function(res) {
                if (res.message == 'success') {
                    let no = 1
                    $('.notif-tidak-ditemukan').remove();
                    $('#konten-chart').show();
                    let data = JSON.parse(res.data)
                    let dataTable = JSON.parse(res.dataTable)
                    drawChart(data)
                    $("#daftar-barang").empty()
                    $.each(dataTable, function(index, row) {
                        $("#daftar-barang").append(
                            `<tr>
                                <td>` + no++ + `</td>
                                <td>` + row.workunit_name + `</td>
                                <td>` + row.item_category_name + `</td>
                                <td>` + row.item_name + `</td>
                                <td>` + row.item_qty + `</td>
                                <td>` + row.warehouse_name + `</td>
                            </tr>`
                        )
                    })
                } else {
                    $('.notif-tidak-ditemukan').remove();
                    $('#konten-chart').hide();
                    var html = '';
                    html += '<div class="notif-tidak-ditemukan">'
                    html += '<div class="card bg-secondary py-4">'
                    html += '<div class="card-body text-white">'
                    html += '<h5 class="mb-4 font-weight-bold text-center">'
                    html += 'Data tidak dapat ditemukan'
                    html += '</h5>'
                    html += '</div>'
                    html += '</div>'
                    html += '</div>'
                    $('#konten-statistik').append(html);
                    $("#daftar-barang").empty()
                }
            },
        })
    })
</script>
@endsection

@endsection
