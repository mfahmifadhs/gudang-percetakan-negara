@extends('v_main.layout.app')

@section('content')

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
      <div class="row g-5">
        <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
          <div class="h-100">
            <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
            <h1 class="display-6 mb-4">Daftar Barang</h1>
            <div class="row">
              <div class="card card-outline card-primary">
                <div class="card-body">
                  <table id="table-1" class="table table-border text-capitalize" style="color: black;">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Unit Kerja</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Tahun Perolehan</th>
                        <th>Kondisi</th>
                      </tr>
                    </thead>
                    <?php $no = 1;?>
                    <tbody>
                      @foreach($item as $dataItem)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $dataItem->workunit_name }}</td>
                        <td>{{ $dataItem->item_name }}</td>
                        <td>{{ $dataItem->item_description }}</td>
                        <td>{{ $dataItem->item_qty }}</td>
                        <td>{{ $dataItem->item_unit }}</td>
                        <td>{{ $dataItem->item_purchase }}</td>
                        <td>{{ $dataItem->item_condition_name }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@section('js')
  <script>
    $(function () {
      $("#table-1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "pdf", "print"]
      }).buttons().container().appendTo('#table-1_wrapper .col-md-6:eq(0)');
    });
  </script>
@endsection

@endsection
