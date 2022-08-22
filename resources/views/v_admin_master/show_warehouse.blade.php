@extends('v_admin_master.layout.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Master Gudang</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Master Gudang</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
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
      </div>
      <div class="col-md-12">
        <div class="row">
          @foreach($warehouse as $warehouse)
          <div class="col-md-6 form-group">
            <div class="card" style="height: 100%;font-size: 14px;">
              <div class="card-header">
                <h3 class="card-title mt-2 font-weight-bold">{{ $warehouse->warehouse_name }}</h3>
                <div class="card-tools">
                  <a href="{{ url('admin-master/detail-warehouse/'.$warehouse->id_warehouse) }}" class="btn btn-default"
                  title="Cek Gudang">
                    <i class="fas fa-pallet"></i>
                  </a>
                  <a class="btn btn-default" type="button" data-toggle="modal" 
                  data-target="#edit-warehouse{{ $warehouse->id_warehouse }}" title="Ubah Informasi Gudang">
                    <i class="fas fa-edit"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 form-group text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/2271/2271068.png" style="height: 30vh;" 
                    class="img-thumbnail">
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Kode</label>
                        <p>{{ $warehouse->id_warehouse }}</p>
                      </div>
                      <div class="col-md-6">
                        <label>Model Penyimpanan</label>
                        <p>{{ $warehouse->warehouse_category }}</p>
                      </div>
                      <div class="col-md-6">
                        <label>Nama Gudang</label>
                        <p>{{ $warehouse->warehouse_name }}</p>
                      </div>
                      <div class="col-md-6">
                        <label>Status</label>
                        @if($warehouse->status_id == 1)
                        <p class="text-success font-weight-bold" readonly>Aktif</p>
                        @elseif($warehouse->status_id == 2)
                        <p class="text-danger font-weight-bold" readonly>Tidak Aktif</p>
                        @endif
                      </div>
                      <div class="col-md-12">
                        <label>Keterangan</label>
                        <p>{!! $warehouse->warehouse_description !!}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="edit-warehouse{{ $warehouse->id_warehouse }}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">{{ $warehouse->warehouse_name }}</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="font-size:14px;">
                  <form action="{{ url('admin-master/update-warehouse/'. $warehouse->id_warehouse) }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Kode Gudang</label>
                        <input type="text" class="form-control text-uppercase" name="id_warehouse" value="{{ $warehouse->id_warehouse }}">
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Model Penyimpanan</label>
                        <select class="form-control" name="warehouse_category">
                          <option value="{{ $warehouse->warehouse_category }}">{{ $warehouse->warehouse_category }}</option>
                          @if($warehouse->warehouse_category == 'Racking')
                          <option value="Palleting">Palleting</option>
                          <option value="Lainya">Lainya</option>
                          @elseif($warehouse->warehouse_category == 'Palleting')
                          <option value="Racking">Racking</option>
                          <option value="Lainya">Lainya</option>
                          @elseif($warehouse->warehouse_category == 'Lainya')
                          <option value="Palleting">Palleting</option>
                          <option value="Racking">Racking</option>
                          @endif
                        </select>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Nama Gudang</label>
                        <input type="text" class="form-control" name="warehouse_name" value="{{ $warehouse->warehouse_name }}">
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Status Gudang</label>
                        <select class="form-control" name="status_id">
                          <option value="{{ $warehouse->status_id }}">{{ $warehouse->status_name }}</option>
                          @if($warehouse->status_id == 1)
                          <option value="2">Tidak Aktif</option>
                          @else
                          <option value="1">Aktif</option>
                          @endif
                        </select>
                      </div>
                      <div class="col-md-12 form-group">
                        <textarea class="form-control summernote" name="warehouse_description">
                          {!! $warehouse->warehouse_description !!}
                        </textarea>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Data sudah benar ?')">
                      Ubah Informasi
                    </button>
                  </div>
                </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

@section('js')
<script>
  $(function () {
    // Summernote
    $('.summernote').summernote({
      height: 100

    }).on('summernote.change', function(we, contents, $editable) {
      $(this).html(contents);
    });
  });
</script>
@endsection

@endsection