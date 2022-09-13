@extends('v_main.layout.app')

@section('content')

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
      <div class="row g-5">
        <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
          <div class="h-100">
            <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
            <h1 class="display-6 mb-4">Surat Pengajuan</h1>
            <div class="row">
              <div class="card card-outline card-primary">
                <div class="card-body">
                  <table id="table-1" class="table table-bordered table-striped table-responsive text-center text-capitalize" style="color: black;">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Tujuan</th>
                        <th>Total Barang</th>
                        <th>Status Pengajuan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <?php $no = 1;?>
                    <tbody>
                      @foreach($appletter as $appletter)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($appletter->appletter_date)->isoFormat('HH:mm / DD MMMM Y') }}</td>
                        <td>{{ $appletter->appletter_purpose }}</td>
                        <td>{{ $appletter->appletter_total_item }} barang</td>
                        <td>{{ $appletter->appletter_status }}</td>
                        <td>
                          <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown">
                              <i class="fas fa-bars"></i>
                            </a>
                            <div class="dropdown-menu m-0">
                              @if($appletter->appletter_status == 'diterima' && $appletter->appletter_purpose == 'penyimpanan')
                              <a class="dropdown-item" href="{{ url('unit-kerja/surat-perintah/penyimpanan/'. $appletter->id_app_letter) }}">
                                Buat Surat Perintah
                              </a>
                              @elseif($appletter->appletter_status == 'diterima' && $appletter->appletter_purpose == 'pengeluaran')
                              <a class="dropdown-item" href="{{ url('unit-kerja/surat-perintah/pengeluaran/'. $appletter->id_app_letter) }}">
                                Buat Surat Perintah
                              </a>
                              @endif
                              <a class="dropdown-item" href="{{ url('unit-kerja/surat/detail-surat-pengajuan/'. $appletter->id_app_letter) }}">
                                Detail
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
