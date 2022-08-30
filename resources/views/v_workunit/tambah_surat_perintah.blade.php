@extends('v_main.layout.app')

@section('content')

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
      <div class="row g-5">
        <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
          <div class="h-100">
            <h1 class="display-6 mb-4">Surat Perintah</h1>
            <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">Informasi Pengirim</div>
            <div>
              <form action="{{ url('unit-kerja/surat/tambah-surat-perintah/penyimpanan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_warrent" value="{{ random_int(100000, 999999) }}">
                <input type="hidden" name="appletter_entry_id" value="{{ $appletter->appletter_entry_id }}">
                <input type="hidden" name="appletter_exit_id" value="{{ $appletter->appletter_exit_id }}">
                <div class="row g-4">
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="date" class="form-control" name="warr_dt" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}" required>
                      <label for="name">Tanggal</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control text-uppercase" name="warr_num" placeholder="Nomor surat" required>
                      <label for="name">Nomor Surat</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="warr_name" placeholder="Jenis Surat" required>
                      <label for="name">Nama petugas yang diperintahkan mengirim barang</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="warr_position" placeholder="Perihal" required>
                      <label for="name">Jabatan petugas yang diperintahkan mengirim barang</label>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">Informasi Barang</div>
                    <table class="table table-bordered table-responsive">
                      <thead>
                        <tr>
                          <th class="text-center">No</th>
                          <th>Kategori</th>
                          <th>Kode Barang</th>
                          <th>NUP</th>
                          <th>Nama Barang</th>
                          <th>Merk/Type</th>
                          <th>Jumlah</th>
                          <th>Satuan</th>
                        </tr>
                      </thead>
                      <?php $no = 1;?>
                      <tbody>
                        @foreach($item as $item)
                        <tr>
                          <td class="text-center">{{ $no++ }}</td>
                          <td>{{ $item->warr_item_category }}</td>
                          <td>{{ $item->warr_item_code }}</td>
                          <td>{{ $item->warr_item_nup }}</td>
                          <td>{{ $item->warr_item_name }}</td>
                          <td>{{ $item->warr_item_type }}</td>
                          <td>{{ $item->warr_item_qty }}</td>
                          <td>{{ $item->warr_item_unit }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                    <button type="submit" class="btn btn-primary py-2 px-3 me-3" onclick="return confirm('Apakah data sudah benar ?');">
                      Submit
                    </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

@section('js')
<script src="{{ asset('dist-main/js/card.js') }}"></script>
<script>
  $(function () {
    let i = 0;
    let j = 0;
    let x = 1;
    let dataslot      = [];
    let datawarehouse = [];
    let datacategory  = [];

    // Menyimpan data id pallet di dalam Array
    $(document).on('change', '.data-slot', function() {
      dataslot = $('.data-slot').map(function() {
        return this.value
      }).get();
    });

    $(document).on('change', '.data-warehouse', function() {
      datawarehouse = $('.warehouseData').map(function() {
        return this.value
      }).get();
    });

    $(document).on('change', '.data-itemcategory', function() {
      datacategory = $('.data-itemcategory').map(function() {
        return this.value
      }).get();
    });

    // Add More Section
    $("#add-more-section").click(function() {
      ++i;
      ++j;
      ++x;
      $.ajax({
        type: "GET",
        url: "/unit-kerja/json/more-pallet",
        dataType: 'JSON',
        success: function(res) {
          console.log(res);
          let optCategory = "";
          $.each(res.category, function(index, value) {
            optCategory += '<option value=' + value.id_item_category + '>' + value.item_category_name + '</option>'
          });

          $(".add-more-section").append(
           `<div class="col-md-12">
              <div class="card more-section mb-4">
                <div class="card-header">
                  <input type="hidden" name="id_order_data[]" value="DATA-{{ \Carbon\Carbon::now()->isoFormat('DMYYhhmmss') }}0">
                  <span style="float:left;">
                    <h6 class="card-title font-weight-bold mt-2">Informasi Barang `+ x +`</h6>
                  </span>
                  <span style="float:right;">
                    <a id="remove-more-section" class="btn btn-danger btn-xs"><i class="fas fa-times"></i> Hapus</a>
                    <button type="button" class="btn btn-primary" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </span>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <div class="form-floating">
                        <select name="category[`+i+`]" class="form-control" style="background-color: white;height:fit-content;">
                          <option value="">-- Pilih Jenis Barang --</option>
                          `+ optCategory +`
                        </select>
                        <label for="name">Jenis Barang</label>
                      </div>
                    </div>
                    <div class="col-md-3 form-group">
                      <div class="form-floating">
                        <input type="text" class="form-control" name="item_code[`+i+`]" placeholder="Perihal" required>
                        <label for="name">Kode Barang</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" name="nup[`+i+`]" placeholder="Perihal" required>
                        <label for="name">NUP</label>
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <div class="form-floating">
                        <input type="text" class="form-control" name="item_name[`+i+`]" placeholder="Perihal" required>
                        <label for="name">Nama Barang</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" name="type[`+i+`]" placeholder="Perihal" required>
                        <label for="name">Merk/Type</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" name="qty" placeholder="Perihal" required>
                        <label for="name">Jumlah Barang</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" name="unit" placeholder="Perihal" required>
                        <label for="name">Satuan</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>`
          )
        }
      });
    });

    // Menghapus Item
    $(document).on('click', '#remove-more-item', function() {
      $(this).parents('tr').remove();
    });
    // Menghapus Section
    $(document).on('click', '#remove-more-section', function() {
      $(this).parents('.more-section').remove();
    });
  });
</script>
@endsection

@endsection
