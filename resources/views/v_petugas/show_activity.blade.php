@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daftar Pengiriman Barang</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('Petugas/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Daftar Pengiriman Barang</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- Content Header -->

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Barang Masuk</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th style="width: 1%">
                No
              </th>
              <th style="width: 25%">
                Unit Kerja
              </th>
              <th style="width: 20%">
                Petugas yang diperintahkan
              </th>
              <th>
                Jumlah
              </th>
              <th style="width: 20%">
                Tanggal
              </th>
              <th style="width: 22%">
              </th>
            </tr>
          </thead>
          <?php $no = 1;?>
          <tbody class="text-capitalize">
            @foreach($activity as $activity)
              <tr>
                <td>{{ $no++ }} </td>
                <td>{{ $activity->workunit_name }} </td>
                <td>{{ $activity->order_emp_name.' / '.$activity->order_emp_position }} </td>
                <td>{{ $activity->totalitem }} Barang</td>
                <td>{{ \Carbon\Carbon::parse($activity->order_dt)->isoFormat('DD MMMM Y') }} /
                    {{ $activity->order_tm }}</td>
                <td>
                  <a class="btn btn-primary btn-sm" rel="noopener" target="_blank" href="{{ url('petugas/cetak-bast/'.$activity->id_order) }}">
                    <i class="fas fa-file"></i>&nbsp; BAST
                  </a>
                  <a class="btn btn-primary btn-sm" href="#">
                    <i class="fas fa-box"></i>&nbsp; Barang
                  </a>
                  <a class="btn btn-primary btn-sm" href="{{ url('petugas/kelengkapan-barang/'. $activity->id_order) }}">
                    <i class="fas fa-edit"></i>&nbsp; Kelengkapan
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>



@endsection