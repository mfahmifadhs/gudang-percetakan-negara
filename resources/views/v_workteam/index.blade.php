@extends('v_main.layout.app')

@section('content')

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
      <div class="row g-5">
        <div class="col-lg-10 wow fadeInUp" data-wow-delay="0.5s">
          <div class="h-100">
            <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
            <h1 class="display-6 mb-5">Surat Permohonan Pengajuan</h1>
            <table id="table1" class="table table-bordered table-striped text-capitalize text-center">
              <thead style="color: black;">
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Unit Kerja</th>
                  <th>Tujuan</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <?php $no = 1;?>
              <tbody>
                @foreach($appletter as $appletter)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ \Carbon\Carbon::parse($appletter->appletter_date)->isoFormat('HH:mm / DD MMMM Y') }}</td>
                  <td>{{ $appletter->workunit_name }}</td>
                  <td>{{ $appletter->appletter_purpose }} barang</td>
                  <td>{{ $appletter->appletter_status }}</td>
                  <td>
                    <div class="dropdown">
                      <a href="#" class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown">
                        <i class="fas fa-bars"></i>
                      </a>
                      <div class="dropdown-menu m-0">
                        <a class="dropdown-item" href="{{ url('tim-kerja/surat/detail-surat-pengajuan/'. $appletter->id_app_letter) }}">
                          <i class="fas fa-info-circle"></i> Detail
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@section('js')
<script>
  $(function () {
    $("#table1").DataTable({
      "responsive": true, "lengthChange": false  , "autoWidth": false,
      "searching": false, "info": false, "sort": false, "paging": false
    });
  });
</script>
@endsection

@endsection
