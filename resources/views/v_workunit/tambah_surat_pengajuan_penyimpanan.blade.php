@extends('v_main.layout.app')

@section('content')

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
      <div class="row g-5">
        <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
          <div class="h-100">
            <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
            <h1 class="display-6 mb-4">Surat Pengajuan Penyimpanan</h1>
            <div>
              <form action="{{ url('unit-kerja/surat/tambah-pengajuan/penyimpanan') }}" method="POST">
                @csrf
                <input type="hidden" name="purpose" value="penyimpanan">
                <input type="hidden" name="id" value="{{ random_int(100000, 999999) }}">
                <div class="row g-4">
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="date" class="form-control" name="date" value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-DD') }}" required>
                      <label for="name">Tanggal</label>
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
                      <label for="name">Jenis Surat (Biasa/Penting)</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="regarding" placeholder="Perihal" required>
                      <label for="name">Perihal</label>
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
                              <p>Silahkan download format file <a href="{{ asset('format_data_barang.xlsx') }}" download>disini</a> dan upload file data barang yang telah diisi.</p>
                              <div class="form-floating">
                                <input type="file" class="form-control" name="upload" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="category" placeholder="Jenis Surat">
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
                                  <input type="text" class="form-control" name="item_code[]" placeholder="Perihal">
                                  <label for="name">Kode Barang</label>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="nup[]" placeholder="Perihal">
                                  <label for="name">NUP</label>
                                </div>
                              </div>
                              <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="item_name[]" placeholder="Perihal">
                                  <label for="name">Nama Barang</label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="type[]" placeholder="Perihal">
                                  <label for="name">Merk/Type</label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="qty[]" placeholder="Perihal">
                                  <label for="name">Jumlah Barang</label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-floating">
                                  <input type="text" class="form-control" name="unit[]" placeholder="Perihal">
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
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote({
        placeholder: 'Maksud atau tujuan',
        height: 140,
        toolbar: [
            ['style', ['bold', 'italic']],
            ['para', ['ul', 'ol']],
        ]
      });
  });
</script>
@endsection

@endsection
