@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Penyimpanan Barang</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('unit-kerja/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Penyimpanan Barang</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- Content Header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
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
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title font-weight-bold">PENGIRIMAN BARANG</h3>
            <div class="card-tools">
              <!-- action -->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ url('petugas/tambah-barang') }}" method="POST">
              @csrf
              <div class="row">
                <!-- Informasi Pengirim -->
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title font-weight-bold mt-2">Informasi Pengirim </h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-default" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Kode Penyimpanan : </label>
                          <div class="input-group mb-3">
                            <input type="text" name="id_order" class="form-control" value="PBM-{{ \Carbon\Carbon::now()->isoFormat('DMYYhhmmss') }}" readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label>Petugas Gudang : </label>
                          <div class="input-group mb-3">
                            <select class="form-control" name="adminuser_id" readonly>
                              <option value="{{ Auth::id(); }}">{{ Auth::user()->full_name }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label>Unit Kerja : </label>
                          <div class="input-group mb-3">
                            <select id="select2-workunit" name="id_workunit" class="form-control select2-workunit" required>
                              <option value="">-- Pilih Unit Kerja --</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label>Unit Utama :  </label>
                          <div class="input-group mb-3">
                            <select class="form-control" id="mainunit" name="mainunit_id" readonly>
                              <option value="">-- Unit Utama --</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label>Pengirim : </label>
                          <div class="input-group mb-3">
                            <input type="text" name="order_emp_name" class="form-control text-capitalize"
                            placeholder="Nama Petugas Yang Membawa Barang">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label>Jabatan : </label>
                          <div class="input-group mb-3">
                            <input type="text" name="order_emp_position" class="form-control text-capitalize"
                            placeholder="Jabatan Petugas Yang Membawa Barang">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label>Nomor Kendaraan : </label>
                          <div class="input-group mb-3">
                            <input type="text" name="order_license_vehicle" class="form-control text-uppercase" placeholder="Plat Nomor Kendaraan" onkeypress="return event.charCode != 32">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Catatan:</h5>
                    This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                  </div>
                </div>
                <!-- Data Barang -->
                <div class="col-md-12 add-more-section">
                  <div class="card">
                    <div class="card-header">
                      <input type="hidden" name="id_order_data[]" value="DATA-{{ \Carbon\Carbon::now()->isoFormat('DMYYhhmmss') }}0">
                      <h3 class="card-title font-weight-bold mt-2">[1] Penempatan Penyimpanan Barang </h3>
                      <div class="card-tools">
                        <a id="add-more-section" type="submit" class="btn btn-primary text-uppercase font-weight-bold">
                          <i class="fas fa-pallet"></i>
                        </a>
                        <button type="button" class="btn btn-default" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6 form-group">
                          <label>Batas Waktu Penyimpanan</label>
                          <input type="date" name="deadline[]" class="form-control"
                          value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-D') }}" min="<?= date('Y-m-d'); ?>"
                          placeholder="Batas Waktu Penyimpanan" required>
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Jenis Barang</label>
                          <select class="form-control data-itemcategory" name="itemcategory_id[]" required>
                            <option value="">-- Pilih Jenis Barang --</option>
                            @foreach($itemcategory as $itemcategory)
                            <option value="{{ $itemcategory->id_item_category }}">
                              {{ $itemcategory->item_category_name }}
                            </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Pilih Gudang</label>
                          <select class="form-control warehouse" data-target="0" required>
                            <option value="">-- Pilih Gudang --</option>
                            @foreach($warehouse as $warehouse)
                            <option value="{{ $warehouse->id_warehouse }}">
                              {{ $warehouse->warehouse_name }}
                            </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Pilih Slot</label>
                          <select class="form-control data-slot" id="slot_id-0" data-target="0"  name="slot_id[]" required>
                            <option value="">-- Pilih Slot --</option>
                          </select>
                        </div>
                        <div class="col-md-12 form-group">
                          <label>Data Barang</label>
                          <div class="table-responsive">
                            <table class="table table-bordered ">
                              <thead>
                                <tr>
                                  <td>Kode BMN</td>
                                  <td>NUP</td>
                                  <td>Nama Barang</td>
                                  <td>Merk/Type</td>
                                  <td>Jumlah</td>
                                  <td>Satuan</td>
                                  <td>Aksi</td>
                                </tr>
                              </thead>
                              <tbody class="text-center item-add-more-0">
                                <tr>
                                  <td class="pt-3"><input type="number" name="item_bmn[]" class="form-control"></td>
                                  <td class="pt-3"><input type="number" name="item_nup[]" class="form-control"></td>
                                  <td class="pt-3"><input type="text" name="item_name[]" class="form-control"></td>
                                  <td class="pt-3"><input type="text" name="item_merk[]" class="form-control"></td>
                                  <td class="pt-3"><input type="number" name="item_qty[]" class="form-control"></td>
                                  <td class="pt-3"><input type="texte" name="item_unit[]" class="form-control"></td>
                                  <td class="p-3">
                                    <a class="btn btn-primary btn-xs add-more-item" data-target="0">
                                      <i class="fas fa-plus"></i> Barang
                                    </a>
                                    <input type="hidden" name="order_data_id[]" value="DATA-{{ \Carbon\Carbon::now()->isoFormat('DMYYhhmmss') }}0">
                                    <input type="hidden" name="id_item_incoming[]" value="ITEM-{{ \Carbon\Carbon::now()->isoFormat('hhmmss') }}0">
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Submit -->
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary float-right font-weight-bold"
                  onclick="return confirm('Apaka Penempatan Barang Sudah Benar ?')">
                    SUBMIT
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Main content -->


@section('js')
<!-- Menampilkan Unit Kerja dan Unit Utama -->
<script>

  $(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    // Menampilkan Workunit
    $( "#select2-workunit" ).select2({
      ajax: {
        url: "{{ url('petugas/select2-workunit') }}",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            _token: CSRF_TOKEN,
            search: params.term // search term
          };
        },
        processResults: function (response) {
          return {
            results: response
          };
        },
        cache: true
      }
    });
    // Menampilkan Mainunit
    $('.select2-workunit').change(function(){
      var workunit = $(this).val();
      if(workunit){
        $.ajax({
          type:"GET",
          url:"/petugas/json-get-mainunit?workunit="+workunit,
          dataType: 'JSON',
          success:function(res){
            if(res){
              $("#mainunit").empty();
              $.each(res,function(mainunit_name,id_mainunit){
                $("#mainunit").append(
                  '<option value="'+id_mainunit+'">'+mainunit_name+'</option>'
                  );
              });
            }else{
             $("#mainunit").empty();
           }
         }
       });
      }else{
        $("#mainunit").empty();
      }
    });
  });
</script>

<!-- Proses Barang -->
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

    // Menampilkan Daftar Slot Gudang
    $(document).on('change', '.warehouse', function() {
      let warehouseid = $(this).val();
      let target      = $(this).data('target');
      console.log(dataslot);
      if (warehouseid) {
        $.ajax({
          type: "GET",
          url: "/petugas/json-get-slot?warehouseid=" + warehouseid,
          data: {
            "dataslot": dataslot
          },
          dataType: 'JSON',
          success: function(res) {
            if (res) {
              $("#slot_id-" + target).empty();
              $("#slot_id-" + target).append('<option value="">-- Pilih Pallet --</option>');
              $.each(res, function(id_slot, id_slot) {
                $("#slot_id-" + target).append(
                  '<option value="' + id_slot + '">' + id_slot + '</option>'
                );
              });
            } else {
              $("#slot_id-" + target).empty();
            }
          }
        });
      } else {
        $("#slot_id-" + target).empty();
      }
    });

    // Tambah Item Section 1
    $(document).on('click', '.add-more-item', function() {
      ++i;
      let target      = $(this).data('target');
      if (target == 0) {
        $(".item-add-more-" + target).append(
          '<tr>' +
            '<td class="pt-3"><input type="number" name="item_bmn['+i+']" class="form-control"></td>' +
            '<td class="pt-3"><input type="number" name="item_nup['+i+']" class="form-control"></td>' +
            '<td class="pt-3"><input type="text" name="item_name['+i+']" class="form-control"></td>' +
            '<td class="pt-3"><input type="text" name="item_merk['+i+']" class="form-control"></td>' +
            '<td class="pt-3"><input type="number" name="item_qty['+i+']" class="form-control"></td>' +
            '<td class="pt-3"><input type="text" name="item_unit['+i+']" class="form-control"></td>' +
            '<td class="p-3">' +
              '<a id="remove-more-item" class="btn btn-danger btn-xs"><i class="fas fa-minus-circle"></i> Barang</a>' +
              '<input type="hidden" name="order_data_id['+i+']" value="DATA-{{ \Carbon\Carbon::now()->isoFormat('DMYYhhmmss') }}0">' +
              '<input type="hidden" name="id_item_incoming['+i+']" value="ITEM-{{ \Carbon\Carbon::now()->isoFormat('hhmmss') }}'+i+'">' +
            '</td>' +
          '</tr>'
        );
      }else{
        $(".item-add-more-" + target).append(
          '<tr>' +
            '<td class="pt-3"><input type="number" name="item_bmn['+i+']" class="form-control"></td>' +
            '<td class="pt-3"><input type="number" name="item_nup['+i+']" class="form-control"></td>' +
            '<td class="pt-3"><input type="text" name="item_name['+i+']" class="form-control"></td>' +
            '<td class="pt-3"><input type="text" name="item_merk['+i+']" class="form-control"></td>' +
            '<td class="pt-3"><input type="number" name="item_qty['+i+']" class="form-control"></td>' +
            '<td class="pt-3"><input type="text" name="item_unit['+i+']" class="form-control"></td>' +
            '<td class="p-3">' +
              '<a id="remove-more-item" class="btn btn-danger btn-xs"><i class="fas fa-minus-circle"></i> Barang</a>' +
              '<input type="hidden" name="order_data_id['+i+']" value="DATA-{{ \Carbon\Carbon::now()->isoFormat('DMYYhhmmss') }}'+j+'">' +
              '<input type="hidden" name="id_item_incoming['+i+']" value="ITEM-{{ \Carbon\Carbon::now()->isoFormat('hhmmss') }}'+i+'">' +
            '</td>' +
          '</tr>'
        );
      }
    });

    $("#add-more-section").click(function() {
      ++i;
      ++j;
      ++x;
      $.ajax({
        type: "GET",
        url: "/petugas/json-get-warehouse",
        data: {
            "datacategory": datacategory
          },
        dataType: 'JSON',
        success: function(res) {
          let optCategory = "";
          let optWarehouse = "";
          $.each(res.category, function(index, value) {
            optCategory += '<option value=' + value.id_item_category + '>' + value.item_category_name + '</option>'
          });
          $.each(res.warehouse, function(index, value) {
            optWarehouse += '<option value=' + value.id_warehouse + '>' + value.warehouse_name + '</option>'
          });

          $(".add-more-section").append(
            '<div class="card more-section">'+
              '<div class="card-header">' +
                '<input type="hidden" name="id_order_data['+i+']" value="DATA-{{ \Carbon\Carbon::now()->isoFormat('DMYYhhmmss') }}'+j+'">' +
                '<h3 class="card-title font-weight-bold mt-2">['+x+'] Penempatan Penyimpanan Barang </h3>' +
                '<div class="card-tools">' +
                  '<a type="submit" class="btn btn-danger mr-1 remove-more-pallet">' +
                    '<i class="fas fa-times"></i>' +
                  '</a>' +
                  '<button type="button" class="btn btn-default" data-card-widget="collapse">' +
                    '<i class="fas fa-minus"></i>' +
                  '</button>' +
                '</div>' +
              '</div>' +
              '<div class="card-body">' +
                '<div class="row">' +
                  '<div class="col-md-6 form-group">' +
                    '<label>Batas Waktu Penyimpanan</label>' +
                    '<input type="date" name="deadline['+i+']" class="form-control"value="{{ \Carbon\Carbon::now()->isoFormat('Y-MM-D') }}" min="<?= date('Y-m-d'); ?>"placeholder="Batas Waktu Penyimpanan" required>' +
                  '</div>' +
                  '<div class="col-md-6 form-group">' +
                    '<label>Jenis Barang</label>' +
                    '<select class="form-control data-itemcategory" name="itemcategory_id['+i+']" required>' +
                      '<option value="">-- Pilih Jenis Barang</option>' +
                      optCategory +
                    '</select>' +
                  '</div>' +
                  '<div class="col-md-6 form-group">' +
                    '<label>Pilih Gudang</label>' +
                    '<select class="form-control warehouse" data-target="'+i+'" required>' +
                      '<option value="">-- Pilih Gudang --</option>' +
                      optWarehouse +
                    '</select>' +
                  '</div>' +
                  '<div class="col-md-6 form-group">' +
                    '<label>Pilih Slot</label>' +
                    '<select class="form-control data-slot" id="slot_id-'+i+'" data-target="'+i+'" name="slot_id['+i+']" required>' +
                      '<option value="">-- PILIH PALLET --</option>' +
                    '</select>' +
                  '</div>' +
                  '<div class="col-md-12 form-group">' +
                    '<label>Data Barang</label>' +
                    '<div class="table-responsive">' +
                      '<table class="table table-bordered table-2">' +
                        '<thead>' +
                          '<tr>' +
                            '<td>Kode BMN</td>' +
                            '<td>NUP</td>' +
                            '<td>Nama Barang</td>' +
                            '<td>Merk/Type</td>' +
                            '<td>Jumlah</td>' +
                            '<td>Satuan</td>' +
                            '<td>Aksi</td>' +
                          '</tr>' +
                        '</thead>' +
                        '<tbody class="text-center item-add-more-'+i+'">' +
                          '<tr>' +
                            '<td class="pt-3"><input type="number" name="item_bmn['+i+']" class="form-control"></td>' +
                            '<td class="pt-3"><input type="number" name="item_nup['+i+']" class="form-control"></td>' +
                            '<td class="pt-3"><input type="text" name="item_name['+i+']" class="form-control"></td>' +
                            '<td class="pt-3"><input type="text" name="item_merk['+i+']" class="form-control"></td>' +
                            '<td class="pt-3"><input type="number" name="item_qty['+i+']" class="form-control"></td>' +
                            '<td class="pt-3"><input type="text" name="item_unit['+i+']" class="form-control"></td>' +
                            '<td class="p-3">' +
                              '<a class="btn btn-primary btn-xs add-more-item" data-target="'+i+'" >' +
                                '<i class="fas fa-plus"></i> Barang' +
                              '</a>' +
                              '<input type="hidden" name="order_data_id['+i+']" value="DATA-{{ \Carbon\Carbon::now()->isoFormat('DMYYhhmmss') }}'+j+'">' +
                              '<input type="hidden" name="id_item_incoming['+i+']" value="ITEM-{{ \Carbon\Carbon::now()->isoFormat('hhmmss') }}'+i+'">' +
                            '</td>' +
                          '</tr>' +
                        '</tbody>' +
                      '</table>' +
                    '</div>' +
                  '</div>' +
                '</div>' +
              '</div>' +
            '</div>'
          );
        }
      });
    });

    // Menghapus Item
    $(document).on('click', '#remove-more-item', function() {
      $(this).parents('tr').remove();
    });
    // Menghapus Section
    $(document).on('click', '.remove-more-pallet', function() {
      $(this).parents('.more-section').remove();
    });
  });
</script>

<!-- Data Tabel -->
<script>
  $(function () {
    $("#table-1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,
      "searching": false, "info": false,"paging":false
    });
    $(".table-2").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,
      "searching": false, "info": false,"paging":false
    });
  });
</script>

@endsection

@endsection
