@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
   <div class="container">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h4>Buat Penyimpanan Barang</h4>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ url('petugas/aktivitas/daftar/penyimpanan') }}">Daftar Penyimpanan</a></li>
               <li class="breadcrumb-item active">Penyimpanan Barang</li>
            </ol>
         </div>
      </div>
   </div>
</section>
<!-- Content Header -->

<!-- Main content -->
<section class="content">
   <div class="container">
      <div class="row">
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
            <form action="{{ url('petugas/aktivitas/proses/penyimpanan') }}" method="POST">
               @csrf
               <div class="row">
                  <!-- Informasi Pengirim -->
                  <div class="col-md-12">
                     <div class="card card-outline card-primary">
                        <div class="card-header">
                           <h3 class="card-title font-weight-bold mt-2">Form Penyimpanan Barang </h3>
                           <div class="card-tools">
                              <button type="button" class="btn btn-default" data-card-widget="collapse">
                                 <i class="fas fa-minus"></i>
                              </button>
                           </div>
                        </div>
                        <div class="card-body">
                           <div class="form-group row">
                              <label class="col-form-label col-md-2">ID Penyimpanan</label>
                              <div class="col-md-10">
                                 <input type="text" name="id_order" class="form-control" value="PBM_{{ \Carbon\Carbon::now()->isoFormat('DMYY').rand(000,999) }}" readonly>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-12 text-muted ">Informasi Pengusul</label>
                              <label class="col-form-label col-md-2">Tanggal Masuk</label>
                              <div class="col-md-10">
                                 <input type="date" class="form-control" name="order_dt" required>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-form-label col-md-2">Unit Kerja</label>
                              <div class="col-md-10">
                                 <select id="select2-workunit" name="id_workunit" class="form-control select2-workunit" required>
                                    <option value="">-- Pilih Unit Kerja --</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-form-label col-md-2">Unit Utama</label>
                              <div class="col-md-10">
                                 <select class="form-control" id="mainunit" name="mainunit_id" readonly>
                                    <option value="">-- Unit Utama --</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-form-label col-md-2">Nama Petugas</label>
                              <div class="col-md-10">
                                 <input type="text" name="order_emp_name" class="form-control text-capitalize" placeholder="Nama Petugas Yang Membawa Barang">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-form-label col-md-2">Jabatan</label>
                              <div class="col-md-10">
                                 <input type="text" name="order_emp_position" class="form-control text-capitalize" placeholder="Jabatan Petugas Yang Membawa Barang">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-form-label col-md-2">No. Kendaraan</label>
                              <div class="col-md-10">
                                 <input type="text" name="order_license_vehicle" class="form-control" placeholder="Nomor Mobil" onkeypress="return event.charCode != 32">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Data Barang -->
                  <div class="col-md-12" id="section-barang">
                     <div class="card card-primary">
                        <div class="card-header">
                           <h3 class="card-title font-weight-bold mt-2">[1] Informasi Barang </h3>
                           <div class="card-tools">
                              <a id="add-section" class="btn btn-dark text-uppercase font-weight-bold">
                                 <i class="fas fa-plus-circle"></i>
                              </a>
                           </div>
                        </div>
                        <div class="card-body">
                           <div class="form-group row">
                              <label class="col-form-label col-md-2">Jenis Barang</label>
                              <div class="col-md-10">
                                 <select class="form-control category list-category" name="item_category_id[]" required>
                                    <option value="">-- Pilih Jenis Barang --</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-form-label col-md-2">Nama Barang</label>
                              <div class="col-md-4">
                                 <input type="hidden" name="id_item[]" value="{{ \Carbon\Carbon::now()->isoFormat('DMYY').rand(0000,9999) }}">
                                 <input type="text" class="form-control" name="item_name[]" placeholder="nama barang (lengkap dengan merk / tipe)">
                              </div>
                              <label class="col-form-label col-md-2">Kondisi</label>
                              <div class="col-md-4">
                                 <select name="item_condition_id[]" class="form-control">
                                    <option value="1">Baik</option>
                                    <option value="2">Rusak Ringan</option>
                                    <option value="3">Rusak Berat</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-form-label col-md-2">Jumlah</label>
                              <div class="col-md-4">
                                 <input type="number" class="form-control" name="item_qty[]" value="1" placeholder="jumlah barang">
                              </div>
                              <label class="col-form-label col-md-2">Satuan</label>
                              <div class="col-md-4">
                                 <input type="text" class="form-control" name="item_unit[]" placeholder="satuan">
                              </div>
                           </div>
                           <div class="form-group row" id="bmn"></div>
                           <div class="form-group row">
                              <label class="col-form-label col-md-2">Keterangan</label>
                              <div class="col-md-10">
                                 <textarea name="item_description[]" class="form-control" rows="3" placeholder="contoh keterangan : 1 box @ isi 250 pcs"></textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Submit -->
                  <div class="col-md-12">
                     <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary font-weight-bold" onclick="return confirm('Apakah data sudah terisi dengan benar ?')">
                           <i class="fas fa-plus-circle"></i> SUBMIT
                        </button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
<!-- Main content -->


@section('js')
<!-- Menampilkan Unit Kerja dan Unit Utama -->
<script>
   $(function() {
      let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      // Menampilkan Workunit
      $("#select2-workunit").select2({
         ajax: {
            url: "{{ url('petugas/select2-workunit') }}",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function(params) {
               return {
                  _token: CSRF_TOKEN,
                  search: params.term // search term
               };
            },
            processResults: function(response) {
               return {
                  results: response
               };
            },
            cache: true
         }
      });
      // Menampilkan Mainunit
      $('.select2-workunit').change(function() {
         var workunit = $(this).val();
         if (workunit) {
            $.ajax({
               type: "GET",
               url: "/petugas/json-get-mainunit?workunit=" + workunit,
               dataType: 'JSON',
               success: function(res) {
                  if (res) {
                     $("#mainunit").empty();
                     $.each(res, function(mainunit_name, id_mainunit) {
                        $("#mainunit").append(
                           '<option value="' + id_mainunit + '">' + mainunit_name + '</option>'
                        );
                     });
                  } else {
                     $("#mainunit").empty();
                  }
               }
            });
         } else {
            $("#mainunit").empty();
         }
      });
   });
</script>

<!-- Proses Barang -->
<script>
   let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
   $(function() {
      let i = 0
      let no = 1

      $(document).on('change', '.category', function() {
         let kategori = $(this).val()
         $("#bmn").empty()
         if (kategori == 1) {
            $("#bmn").append(
               `<label class="col-form-label col-md-2">Nilai Perolehan</label>
                  <div class="col-md-4">
                     <input type="text" class="form-control" name="item_purchase[]" placeholder="nilai perolehan">
                  </div>
                  <label class="col-form-label col-md-2">NUP</label>
                  <div class="col-md-4">
                     <input type="number" class="form-control" name="item_nup[]" placeholder="nup barang">
                  </div>`
            )

         } else {
            $("#bmn").append(
               `<label class="col-form-label col-md-2" style="display:none;">Nilai Perolehan</label>
                  <div class="col-md-4">
                     <input type="hidden" class="form-control" name="item_purchase[]" value="">
                  </div>
                  <label class="col-form-label col-md-2" style="display:none;">NUP</label>
                  <div class="col-md-4">
                     <input type="hidden" class="form-control" name="item_nup[]" value="">
                  </div>`
            )
         }
      })

      $(".list-category").select2({
         ajax: {
            url: `{{ url('petugas/select2/list-category') }}`,
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function(params) {
               return {
                  _token: CSRF_TOKEN,
                  search: params.term // search term
               };
            },
            processResults: function(response) {
               return {
                  results: response
               };
            },
            cache: true
         }
      })

      // Menghapus Section
      $(document).on('click', '.remove-section', function() {
         $(this).parents('.more-section').remove();
      });

      // Add More Section
      $("#add-section").click(function() {
         ++i
         $("#section-barang").append(
            `<div class="card card-primary more-section">
               <div class="card-header">
                  <h3 class="card-title font-weight-bold mt-2">[` + (++no) + `] Informasi Barang </h3>
                  <div class="card-tools">
                     <a class="btn btn-dark text-uppercase font-weight-bold remove-section">
                        <i class="fas fa-minus-circle"></i>
                     </a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="form-group row">
                     <label class="col-form-label col-md-2">Jenis Barang</label>
                     <div class="col-md-10">
                        <select class="form-control category` + i + ` list-category` + i + `" name="item_category_id[]" required>
                           <option value="">-- Pilih Jenis Barang --</option>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-form-label col-md-2">Nama Barang</label>
                     <div class="col-md-4">
                        <input type="hidden" name="id_item[]" value="{{ \Carbon\Carbon::now()->isoFormat('DMYY').rand(0000,9999) }}">
                        <input type="text" class="form-control" name="item_name[]" placeholder="nama barang (lengkap dengan merk / tipe)">
                     </div>
                     <label class="col-form-label col-md-2">Kondisi</label>
                     <div class="col-md-4">
                        <select name="item_condition_id[]" class="form-control">
                           <option value="1">Baik</option>
                           <option value="2">Rusak Ringan</option>
                           <option value="3">Rusak Berat</option>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-form-label col-md-2">Jumlah</label>
                     <div class="col-md-4">
                        <input type="number" class="form-control" name="item_qty[]" value="1" placeholder="jumlah barang">
                     </div>
                     <label class="col-form-label col-md-2">Satuan</label>
                     <div class="col-md-4">
                        <input type="text" class="form-control" name="item_unit[]" placeholder="satuan">
                     </div>
                  </div>
                  <div class="form-group row" id="bmn` + i + `"></div>
                  <div class="form-group row">
                     <label class="col-form-label col-md-2">Keterangan</label>
                     <div class="col-md-10">
                        <textarea name="item_description[]" class="form-control" rows="3" placeholder="contoh keterangan : 1 box @ isi 250 pcs"></textarea>
                     </div>
                  </div>
                  </div>
                  </div>
               </div>
            </div>`
         )

         $(".list-category" + i).select2({
            ajax: {
               url: `{{ url('petugas/select2/list-category') }}`,
               type: "post",
               dataType: 'json',
               delay: 250,
               data: function(params) {
                  return {
                     _token: CSRF_TOKEN,
                     search: params.term // search term
                  };
               },
               processResults: function(response) {
                  return {
                     results: response
                  };
               },
               cache: true
            }
         })

         $(document).on('change', '.category' + i, function() {
            let kategori = $(this).val()
            $("#bmn" + i).empty()
            if (kategori == 1) {
               $("#bmn" + i).append(
                  `<label class="col-form-label col-md-2">Nilai Perolehan</label>
                  <div class="col-md-4">
                     <input type="text" class="form-control" name="item_purchase[]" placeholder="nilai perolehan">
                  </div>
                  <label class="col-form-label col-md-2">NUP</label>
                  <div class="col-md-4">
                     <input type="number" class="form-control" name="item_nup[]" placeholder="nup barang">
                  </div>`
               )

            } else {
               $("#bmn").append(
                  `<label class="col-form-label col-md-2" style="display:none;">Nilai Perolehan</label>
                  <div class="col-md-4">
                     <input type="hidden" class="form-control" name="item_purchase[]" value="">
                  </div>
                  <label class="col-form-label col-md-2" style="display:none;">NUP</label>
                  <div class="col-md-4">
                     <input type="hidden" class="form-control" name="item_nup[]" value="">
                  </div>`
               )
            }
         })
      })

   })
</script>

<!-- Data Tabel -->
<script>
   $(function() {
      $("#table-1").DataTable({
         "responsive": true,
         "lengthChange": true,
         "autoWidth": true,
         "searching": false,
         "info": false,
         "paging": false
      });
      $(".table-2").DataTable({
         "responsive": true,
         "lengthChange": true,
         "autoWidth": true,
         "searching": false,
         "info": false,
         "paging": false
      });
   });
</script>

@endsection

@endsection
