@extends('v_main.layout.app')

@section('content')

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
      <div class="row g-5">
        <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
          <div class="h-100">
            <h1 class="display-6 mb-4">Surat Perintah Penyimpanan</h1>
            <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">Informasi Pengirim</div>
            <div>
              <form action="{{ url('unit-kerja/surat/tambah-pengajuan/penyimpanan') }}" method="POST">
                @csrf
                <input type="hidden" name="purpose" value="penyimpanan">
                <input type="hidden" name="id" value="{{ random_int(100000, 999999) }}">
                <div class="row g-4">
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="date" class="form-control" name="date" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}" required>
                      <label for="name">Tanggal Penyimpanan</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control text-uppercase" name="letter_num" placeholder="Nomor surat" required>
                      <label for="name">Nomor Surat</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="category" placeholder="Jenis Surat" required>
                      <label for="name">Nama petugas yang diperintahkan mengirim barang</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="regarding" placeholder="Perihal" required>
                      <label for="name">Jabatan petugas yang diperintahkan mengirim barang</label>
                    </div>
                  </div>
                  <div class="col-md-12 add-more-section">
                    <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">Informasi Barang</div>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill active" id="upload-tab" data-bs-toggle="pill" data-bs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="true">
                          Upload Barang
                        </button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill" id="insert-tab" data-bs-toggle="pill" data-bs-target="#insert" type="button" role="tab" aria-controls="insert" aria-selected="false">
                          Tambah Barang
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                        <div class="col-md-12 mb-4" data-wow-delay="0.3s">
                          <div class="causes-item d-flex flex-column bg-light border-top border-5 border-primary rounded-top overflow-hidden h-100">
                            <div class="text-center p-4 pt-4">

                              <p>Silahkan download format file <a href="">disini</a> dan upload file data barang yang telah diisi.</p>
                              <div class="form-floating">
                                <input type="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="category" placeholder="Jenis Surat" required>
                                <label for="name">Upload File (Format .xlxs)</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="insert" role="tabpanel" aria-labelledby="insert-tab">

                        <div class="col-md-12 mb-4" data-wow-delay="0.3s">
                          <div class="causes-item d-flex flex-column bg-light border-top border-5 border-primary rounded-top overflow-hidden h-100">
                            <div class="text-center p-4 pt-0">
                              <div class="d-inline-block bg-primary text-white rounded-bottom fs-5 pb-1 px-3 mb-4">
                                <small>Informasi Pengisian Data Barang</small>
                              </div>
                              <p>Seluruh informasi barang harus diisi. Jika barang bukan BMN, maka Kode BMN dan NUP dapat dikosongkan.</p>
                            </div>
                          </div>
                        </div>
                        <div class="card mb-4">
                          <div class="card-header">
                            <input type="hidden" name="id_order_data[]" value="DATA-{{ \Carbon\Carbon::now()->isoFormat('DMYYhhmmss') }}0">
                              <span style="float:left;">
                                <h6 class="card-title font-weight-bold mt-2">Informasi Barang 1</h6>
                              </span>
                              <span style="float:right;">
                                <a id="add-more-section" class="btn btn-primary btn-xs"><i class="fas fa-plus-square"></i> Tambah</a>
                                <button type="button" class="btn btn-primary" data-card-widget="collapse">
                                  <i class="fas fa-minus"></i>
                                </button>
                              </span>
                            </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                  <select name="category[]" class="form-control" style="background-color: white;height:fit-content;">
                                    <option value="">-- Pilih Jenis Barang --</option>
                                    @foreach($item_ctg as $item_ctg)
                                    <option value="{{ $item_ctg->id_item_category }}">{{ $item_ctg->item_category_name }}</option>
                                    @endforeach
                                  </select>
                                  <label for="name">Jenis Barang</label>
                                </div>
                              </div>
                              <div class="col-md-3 form-group">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="item_code[]" placeholder="Perihal" required>
                                  <label for="name">Kode Barang</label>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="nup[]" placeholder="Perihal" required>
                                  <label for="name">NUP</label>
                                </div>
                              </div>
                              <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="item_name[]" placeholder="Perihal" required>
                                  <label for="name">Nama Barang</label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="type[]" placeholder="Perihal" required>
                                  <label for="name">Merk/Type</label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="qty[]" placeholder="Perihal" required>
                                  <label for="name">Jumlah Barang</label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="unit[]" placeholder="Perihal" required>
                                  <label for="name">Satuan</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                    <button type="submit" class="btn btn-primary py-2 px-3 me-3" href="{{ url('unit-kerja/surat/tambah-pengajuan/penyimpanan') }}"
                    onclick="return confirm('Apakah data sudah benar ?');">
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
