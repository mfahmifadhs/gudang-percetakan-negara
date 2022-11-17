@extends('v_admin_master.layout.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Master Barang</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Master Barang</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- <div class="col-md-12">
        <a href="{{ url('admin-master/barang/tambah-kategori/baru') }}" class="btn btn-primary btn-sm float-right">
          <i class="fas fa-plus-circle"></i> <br> Ketegori
        </a>
      </div> -->
      <div class="col-md-12 form-group">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
          <p style="color:white;margin: auto;">{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('failed'))
        <div class="alert alert-danger">
          <p style="color:white;margin: auto;">{{ $message }}</p>
        </div>
        @endif
      </div>
      <div class="col-md-12 form-group">
        <div class="card card-primary card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
              <li class="pt-2 px-3"><h3 class="card-title">MASTER BARANG</h3></li>
              <li class="nav-item">
                <a class="nav-link active" id="tabs-incoming-tab" data-toggle="pill" href="#tabs-incoming" role="tab"
              aria-controls="tabs-incoming" aria-selected="false">Barang Masuk</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tabs-pickup-tab" data-toggle="pill" href="#tabs-pickup" role="tab"
                aria-controls="tabs-pickup" aria-selected="false">Barang Keluar</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tabs-category-tab" data-toggle="pill" href="#tabs-category" role="tab"
                aria-controls="tabs-category" aria-selected="false">Kategori Barang</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
              <div class="tab-pane fade show active" id="tabs-incoming" role="tabpanel" aria-labelledby="tabs-incoming-tab">
                <table id="table-incoming" class="table table-bordered table-responsive text-center">
                  <thead>
                    <tr>
                      <th style="width: 12%;">Kode Barang</th>
                      <th style="width: 8%;">NUP</th>
                      <th style="width: 10%;">Jenis</th>
                      <th>Nama Barang</th>
                      <th style="width: 10%;">Jumlah</th>
                      <th style="width: 10%;">Lok. Penyimpanan</th>
                      <th style="width: 20%;">Unit Kerja</th>
                      <th style="width: 15%;">Tanggal Masuk</th>
                    </tr>
                  </thead>
                  <?php $no = 1;?>
                  <tbody>
                    @foreach($items as $dataItem)
                    <tr>
                      @if($dataItem->item_code == null)
                      <td>-</td>
                      @else
                      <td>{{ $dataItem->item_code }}</td>
                      @endif
                      @if($dataItem->item_code == null)
                      <td>-</td>
                      @else
                      <td>{{ $dataItem->in_item_nup }}</td>
                      @endif
                      <td>{{ $dataItem->item_category_name }}</td>
                      <td>{{ $dataItem->item_name }}</td>
                      <td>{{ $dataItem->item_qty.' '.$dataItem->item_unit }}</td>
                      <td>{{ $dataItem->slot_id }}</td>
                      <td>{{ $dataItem->workunit_name }}</td>
                      <td>{{ \Carbon\Carbon::parse($dataItem->order_dt)->isoFormat('DD MMMM Y') }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade" id="tabs-pickup" role="tabpanel" aria-labelledby="tabs-pickup-tab">
                <table id="table-pickup" class="table table-bordered table-responsive text-center">
                  <thead>
                    <tr>
                      <th style="width: 12%;">Kode Barang</th>
                      <th style="width: 8%;">NUP</th>
                      <th style="width: 10%;">Jenis</th>
                      <th>Nama Barang</th>
                      <th style="width: 10%;">Jumlah</th>
                      <th style="width: 10%;">Lok. Penyimpanan</th>
                      <th style="width: 20%;">Unit Kerja</th>
                      <th style="width: 15%;">Tanggal Masuk</th>
                    </tr>
                  </thead>
                  <?php $no = 1;?>
                  <tbody>
                    @foreach($itemExit as $dataItemExit)
                    <tr>
                      @if($dataItemExit->item_code == null)
                      <td>-</td>
                      @else
                      <td>{{ $dataItemExit->item_code }}</td>
                      @endif
                      @if($dataItemExit->item_code == null)
                      <td>-</td>
                      @else
                      <td>{{ $dataItemExit->item_nup }}</td>
                      @endif
                      <td>{{ $dataItemExit->item_category_name }}</td>
                      <td>{{ $dataItemExit->item_name }}</td>
                      <td>{{ $dataItemExit->item_qty.' '.$dataItemExit->item_unit }}</td>
                      <td>{{ $dataItemExit->slot_id }}</td>
                      <td>{{ $dataItemExit->workunit_name }}</td>
                      <td>{{ \Carbon\Carbon::parse($dataItemExit->order_dt)->isoFormat('DD MMMM Y') }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade" id="tabs-category" role="tabpanel" aria-labelledby="tabs-category-tab">
                <table id="table-category" class="table table-bordered table-responsive text-center">
                  <thead>
                    <tr>
                    <th style="width: 1%;">No</th>
                    <th style="width: 39%;">Jenis Barang</th>
                    <th>Keterangan</th>
                    <th style="width: 1%;"></th>
                    </tr>
                  </thead>
                  <?php $no = 1;?>
                  @foreach($itemCategory as $category)
                  <tbody>
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $category->item_category_name }}</td>
                      <td>{{ $category->item_category_description }}</td>
                      <td>
                        <a type="button" class="btn btn-primary" data-toggle="dropdown">
                          <i class="fas fa-bars"></i>
                        </a>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{ url('admin-master/barang/ubah-kategori/'. $category->id_item_category) }}">
                            Ubah
                          </a>
                          <!-- <a class="dropdown-item" href="{{ url('admin-master/barang/hapus-kategori/'. $category->id_item_category) }}"
                          onclick="return confirm('Yakin ingin menghapus data kategori ini ?')">
                            Hapus
                          </a> -->
                        </div>
                      </td>
                    </tr>
                  </tbody>
                  @endforeach
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
  $(function () {
    $("#table-incoming").DataTable({
      "responsive": true, "lengthChange": true  , "autoWidth": false ,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#table-incoming_wrapper .col-md-6:eq(0)');

    $("#table-pickup").DataTable({
      "responsive": true, "lengthChange": true  , "autoWidth": false ,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#table-pickup_wrapper .col-md-6:eq(0)');

    $("#table-category").DataTable({
      "responsive": true, "lengthChange": true  , "autoWidth": false ,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#table-category_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection

@endsection
