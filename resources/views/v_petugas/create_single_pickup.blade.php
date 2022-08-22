@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Pengeluaran Barang</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('unit-kerja/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Pengeluaran Barang</li>
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
            <h3 class="card-title font-weight-bold">PENGELUARAN BARANG</h3>
            <div class="card-tools">
              <!-- action -->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ url('petugas/ambil-barang') }}" method="POST">
              @csrf 
              <div class="row">
                <!-- Informasi Pengirim -->
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title font-weight-bold mt-2">Informasi Unit Kerja</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-default" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Kode Pengambilan : </label>
                          <div class="input-group mb-3">
                            <input type="text" name="id_order" class="form-control" value="PBK-{{ \Carbon\Carbon::now()->isoFormat('DMYYhhmmss') }}" readonly>
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
                          <label>Petugas : </label>
                          <div class="input-group mb-3">
                            <input type="text" name="order_emp_name" class="form-control text-capitalize" 
                            placeholder="Nama petugas diperintahkan" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label>Jabatan : </label>
                          <div class="input-group mb-3">
                            <input type="text" name="order_emp_position" class="form-control text-capitalize" 
                            placeholder="Jabatan petugas yang diperintahkan" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label>Unit Kerja : </label>
                          <div class="input-group mb-3">
                            <select id="select2-workunit" name="id_workunit" class="form-control select2-mainunit" required>
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
                        <div class="col-md-12">
                          <label>Nomor Kendaraan : </label>
                          <div class="input-group mb-3">
                            <input type="text" name="order_license_vehicle" class="form-control text-uppercase" placeholder="Plat Nomor Kendaraan" onkeypress="return event.charCode != 32" required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="callout callout-info">
                    <h5 class="font-weight-bold text-primary"><i class="fas fa-info"></i> Catatan:</h5>
                    <li>Seluruh informasi pengambil barang <b>harus</b> diisi.
                    <li>Pastikan jumlah barang yang dikeluarkan tidak melebihi jumlah barang yang tersimpan.
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title font-weight-bold mt-2">Informasi Barang</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-default" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered ">
                          <thead>
                            <tr>
                              <td style="width: 40%;">Nama Barang</td>
                              <td style="width: 20%;">Lokasi Penyimpanan</td>
                              <td style="width: 15%;">Jumlah Barang</td>
                              <td style="width: 15%;">Jumlah Dikeluarkan</td>
                              <td style="width: 10%;">Satuan</td>
                              <td></td>
                            </tr>
                          </thead>
                          <tbody class="text-center item-add-more-0">
                            <tr>
                              <td class="pt-3">
                                <select id="select2-item" name="id_item[]" class="form-control detail-item data-item" data-target="0" required>
                                  <option value="">-- Pilih Barang --</option>
                                </select>
                              </td>
                              <td class="pt-3 pr-0"><span id="itemposition0"></span></td>
                              <td class="pt-3"><span id="itemqty0"></span></td>
                              <td class="pt-3"><span id="itemoutqty0"></span></td>
                              <td class="pt-3"><span id="itemunit0"></span></td>
                              <td class="p-3">
                                <a class="btn btn-primary btn-xs add-more-item" data-target="0">
                                  <i class="fas fa-plus"></i> Barang
                                  <input type="hidden" name="id_item_exit[]" value="OUT-{{ \Carbon\Carbon::now()->isoFormat('hhmmss') }}0">
                                </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
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

@section('js')
<!-- Menampilkan Unit Kerja -->
<script>
  $(function () {
    let i = 0;
    let CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
    let dataitem = [];

    $(document).on('change', '.data-item', function() {
      dataitem = $('.data-item').map(function() {
        return this.value
      }).get();
    });

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
    $('.select2-mainunit').change(function(){
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
    // Menampilkan Barang
    $( "#select2-item").select2({
      ajax: { 
        url: "{{ url('petugas/select2-item') }}",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          var workunit = $('#select2-workunit').val();
          return {
            _token: CSRF_TOKEN,
            workunit: workunit,
            item: dataitem,
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

    // Menampilkan Informasi Detail Barang
    $('.detail-item').change(function() {
      let itemcode = $(this).val();
      let target = $(this).data('target');
      console.log(itemcode);
      if (itemcode) {
        $.ajax({
          type: "GET",
          url: "/petugas/json-get-detail-item?itemcode=" + itemcode,
          dataType: 'JSON',
          success: function(res) {
            $("#itemposition"+ target).empty();
            $("#itemposition"+ target).empty();
            $("#itemqty" + target).empty();
            $("#itemoutqty" + target).empty();
            $("#itemunit" + target).empty();
            $("#slotid").empty();
            $.each(res, function(index, row) {
              console.log(row.slot_id);
              $("#itemposition" + target).append(
                '<input type="text" class="form-control" value="' + row.slot_id+"/"+ row.warehouse_name+ '" readonly>'
              );
              $("#itemoutqty" + target).append(
                '<input type="number" class="form-control" name="item_out_qty[0]" max="'+ row.in_item_qty +'" placeholder="Jumlah Barang Dikeluarkan" >'
              );
              $("#itemqty" + target).append(
                '<input type="text" class="form-control" name="item_in_qty[0]" value="' + row.in_item_qty + '" readonly>'
              );
              $("#itemunit" + target).append(
                '<input type="text" class="form-control" value="' + row.in_item_unit + '" readonly>'
              );
            });
          }
        });
      } else {

      }
    });

    // Tambah Item Section 1
    $(document).on('click', '.add-more-item', function() {
      ++i;
      let target      = $(this).data('target');
      $(".item-add-more-" + target).append(
        '<tr>' +
          '<td class="pt-3">' +
            '<select id="select2-item-more'+i+'" name="id_item['+i+']" class="form-control detail-item-more data-item" data-target="'+i+'" required>' +
              '<option value="">-- Pilih Barang --</option>' +
            '</select>' +
          '</td>' +
          '<td class="pt-3"><span id="itemposition'+i+'"></span></td>' +
          '<td class="pt-3"><span id="itemqty'+i+'"></span></td>' +
          '<td class="pt-3"><span id="itemoutqty'+i+'"></span></td>' +
          '<td class="pt-3"><span id="itemunit'+i+'"></span></td>' +
          '<td class="p-3">' +
            '<a id="remove-more-item" class="btn btn-danger btn-xs"><i class="fas fa-minus-circle"></i> Barang</a>' +
            '<input type="hidden" name="id_item_exit['+i+']" value="OUT-{{ \Carbon\Carbon::now()->isoFormat('hhmmss') }}'+i+'">' +
          '</td>' +
        '</tr>'
      );

      // Menampilkan Barang
      $( "#select2-item-more" + i).select2({
        ajax: { 
          url: "{{ url('petugas/select2-item') }}",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            var workunit = $('#select2-workunit').val();
            console.log(dataitem);
            return {
              _token: CSRF_TOKEN,
              workunit: workunit,
              item: dataitem,
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

      // Menampilkan Informasi Detail Barang
      $('.detail-item-more').change(function() {
        let itemcode = $(this).val();
        let target = $(this).data('target');
        console.log(target);
        if (itemcode) {
          $.ajax({
            type: "GET",
            url: "/petugas/json-get-detail-item?itemcode=" + itemcode,
            dataType: 'JSON',
            success: function(res) {
              $("#itemposition"+ target).empty();
              $("#itemqty" + target).empty();
              $("#itemoutqty" + target).empty();
              $("#itemunit" + target).empty();
              $("#slotid").empty();
              $.each(res, function(index, row) {
                console.log(row.slot_id);
                $("#itemposition" + target).append(
                  '<input type="text" class="form-control" value="' + row.slot_id+"/"+ row.warehouse_name+ '" readonly>'
                );
                $("#itemqty" + target).append(
                  '<input type="text" class="form-control" name="item_in_qty['+i+']" value="' + row.in_item_qty + '" readonly>'
                );
                $("#itemoutqty" + target).append(
                  '<input type="number" class="form-control" name="item_out_qty['+i+']" max="'+ row.in_item_qty +'" placeholder="Jumlah Barang Dikeluarkan" >'
                );
                $("#itemunit" + target).append(
                  '<input type="text" class="form-control" value="' + row.in_item_unit + '" readonly>'
                );
              });
            }
          });
        } else {

        }
      });
    });

    
    // Menghapus Item
    $(document).on('click', '#remove-more-item', function() {
      $(this).parents('tr').remove();
    });
  });
</script>
@endsection

@endsection