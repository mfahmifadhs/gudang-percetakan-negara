@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daftar Barang Masuk</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('Petugas/dashboard') }}">Dashboard</a></li>
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
            <!-- <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Friends</b> <a class="float-right">13,287</a>
              </li>
            </ul> -->

            <a href="#" class="btn btn-primary btn-block">
              <i class="fas fa-search"></i> <b>Cari Barang</b>
            </a>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      <!-- /.col -->
      <div class="col-md-9 form-group">
        <div class="row">
          @foreach($items as $item)
          <div class="col-md-4 form-group">
            <div class="card card-primary card-outline" style="height:100%;">
              <div class="card-header">
                <h3 class="card-title font-weight-bold" style="font-size: 14px;">{{ $item->workunit_name }}</h3>
              </div>
              <div class="card-body">
                <div class="row" style="font-size: 14px;text-transform: capitalize;">
                  <div class="col-md-12 form-group text-center">
                    <img src="{{ asset('dist/img/data-barang/'. $item->in_item_img) }}" class="img-thumbnail" style="max-height:120px;">
                  </div>
                  <div class="col-md-12 form-group">
                    <hr>
                  </div>
                  <div class="col-md-6">
                    <label>Gudang:</label>
                    <p>{{ $item->warehouse_name }}</p>
                  </div>
                  <div class="col-md-6">
                    <label>Slot:</label>
                    <p>{{ $item->id_slot }}</p>
                  </div>
                  <div class="col-md-6">
                    <label>Kode BMN:</label>
                    <p>{{ $item->in_item_code }}</p>
                  </div>
                  <div class="col-md-6">
                    <label>NUP:</label>
                    <p>{{ $item->in_item_nup }}</p>
                  </div>
                  <div class="col-md-6">
                    <label>Nama Barang:</label>
                    <p>{{ $item->in_item_name }}</p>
                  </div>
                  <div class="col-md-6">
                    <label>Merk/Jenis:</label>
                    <p>{{ $item->in_item_merk }}</p>
                  </div>
                  <div class="col-md-6">
                    <label>Jumlah Barang:</label>
                    <p>
                      @if($item->order_category == 'Pengiriman')
                        {{ $item->in_item_qty }}
                      @else
                        {{ $item->ex_item_qty }}
                      @endif
                    </p>
                  </div>
                  <div class="col-md-6">
                    <label>Satuan:</label>
                    <p>{{ $item->in_item_unit }}</p>
                  </div>
                  <div class="col-md-6">
                    <label>Tahun Perolehan:</label>
                    <p>{{ $item->in_item_purchase }}</p>
                  </div>
                  <div class="col-md-6">
                    <label>Kondisi:</label>
                    <p>{{ $item->item_condition_name }}</p>
                  </div>
                </div>
              </div>
              <div class="card-footer text-center">
                <a type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#qr-code{{ $item->id_item_incoming }}">
                  <i class="fas fa-qrcode"></i> <span class="ml-1 mb-2">Qr Code</span>
                </a>
                <a type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#qr-code{{ $item->id_item_incoming }}">
                  <i class="fas fa-edit"></i> <span class="ml-1 mb-2">Ubah</span>
                </a>
              </div>
            </div>
          </div>
          <!-- =====================================
                      MODAL GENERATE CODE
          ========================================== -->
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
          <div class="col-md-12 form-group">
            {{ $items->links("pagination::bootstrap-4") }}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



@endsection