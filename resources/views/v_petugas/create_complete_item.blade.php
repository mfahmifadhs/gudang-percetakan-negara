@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('unit-kerja/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active"></li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- Content Header -->

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 form-group">
        <div class="callout callout-info">
          <h5><i class="fas fa-info"></i> Note:</h5>
          Mohon untuk melengkapi seluruh informasi barang, jika informasi barang belum tersedia silahkan dikosongkan dan langkah ini dapat dilewati atau dilengkapi nanti.
        </div>
      </div>
      <div class="col-md-12 form-group">
        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">{{ $order->id_order.' / '.\Carbon\Carbon::parse($order->order_dt)->isoFormat('DD MMMM Y').' / '.$order->workunit_name }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <form action="{{ url('petugas/tambah-kelengkapan-barang/'. $order->id_order) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th style="width: 15%;">Nama Barang</th>
                      <th style="width: 13%">Kode Barang</th>
                      <th style="width: 7%;">NUP</th>
                      <th style="width: 11%;">Tahun Perolehan</th>
                      <th style="width: 11%;">Kondisi</th>
                      <th style="width: 25%;">Keterangan Distribusi</th>
                      <th style="width: 16%;">Upload Foto</th>
                      <th></th>
                    </tr>
                  </thead>
                  <?php $i = 0;$j = 0;$x = 0;$y = 0; ?>
                  <tbody>
                    @foreach($item as $item)
                    <tr>
                      <td class="pt-4">
                        <input type="hidden" name="id_item[{{$x;}}]" value="{{ $item->id_item_incoming }}">
                        <input type="hidden" name="image" value="">
                        <input type="text" class="form-control" name="item_name[]" value="{{ $item->in_item_name }}" readonly>
                      </td>
                      <td class="pt-4">
                        <input type="number" class="form-control" name="item_code[]" value="{{ $item->in_item_nup }}">
                      </td>
                      <td class="pt-4">
                        <input type="number" class="form-control" name="item_nup[]" value="{{ $item->in_item_code }}">
                      </td>
                      <td class="pt-4">
                        <input type="number" class="form-control" name="item_purchase[]" value="{{ $item->in_item_purchase }}">
                      </td>
                      <td class="pt-4">
                        <select class="form-control" name="item_condition[]">
                          <option value="2">Baik</option>
                          <option value="3">Rusak</option>
                          <option value="1">Baru</option>
                        </select>
                      </td>
                      <td class="pt-4">
                        <input type="text" name="item_description[]" class="form-control" value=" {{ $item->in_item_description }}">
                      </td>
                      <td class="pt-4">
                        <input type="file" class="form-control image" name="item_img[{{$x;}}]" data-target="{{ $i++ }}">
                      </td>
                      <td>
                        <img id="preview-image-before-upload{{ $j++ }}" src="{{ asset('dist/img/data-barang/'. $item->in_item_img) }}" style="max-height: 50px;">
                      </td>
                    </tr>
                  </tbody>
                    <?php $x++; ?>
                  @endforeach
                </table>
              </div>
              <div class="card-footer">
                <button  type="submit" class="btn btn-primary font-weight-bold float-left" 
                onclick="return confirm('Apaka Informasi Barang Sudah Benar ?')">Buat BAST</button>
                <a href="{{ url('petugas/dashboard') }}" class="btn btn-danger font-weight-bold float-right">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@section('js')
<script>

  $('.image').change(function(){
    let target = $(this).data('target');
    let reader = new FileReader();

    reader.onload = (e) => { 
      $('#preview-image-before-upload'+target).attr('src', e.target.result); 
    }

    reader.readAsDataURL(this.files[0]); 
    
  });
</script>
@endsection

@endsection