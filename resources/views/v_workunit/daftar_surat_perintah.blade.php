@extends('v_main.layout.app')

@section('content')

  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
      <div class="row g-5">
        <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
          <div class="h-100">
            <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
            <h1 class="display-6 mb-4">Surat Perintah</h1>
            <div class="row">
              <div class="card card-outline card-primary">
                <div class="card-body">
                  <table id="table-1" class="table table-bordered table-striped table-responsive text-center">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Surat Perintah</th>
                        <th>Tujuan</th>
                        <th>Pengirim/Jabatan</th>
                        <th>Total Barang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <?php $no = 1;?>
                    <tbody>
                      @foreach($warrent as $dataWarrent)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($dataWarrent->warr_date)->isoFormat('DD/MM/YYYY') }}</td>
                        <td>
                            <a href="{{ asset('data_file/surat_perintah/'. $dataWarrent->warr_file) }}" download>
                                {{ $dataWarrent->warr_file }}
                            </a>
                        </td>
                        <td>{{ $dataWarrent->warr_purpose }}</td>
                        <td>{{ $dataWarrent->warr_emp_name.'/'.$dataWarrent->warr_emp_position }}</td>
                        <td>{{ $dataWarrent->warr_total_item }} barang</td>
                        <td>
                            @if($dataWarrent->warr_status == 'proses')
                              <b>proses</b>
                            @elseif($dataWarrent->warr_status == 'konfirmasi')
                              <b>menunggu konfirmasi</b>
                            @else
                              <b>selesai</b>
                            @endif
                        </td>
                        <td>
                          <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown">
                              <i class="fas fa-bars"></i>
                            </a>
                            <div class="dropdown-menu m-0">
                              @if($dataWarrent->warr_status == 'sudah diproses')
                              <a class="dropdown-item" href="{{ url('unit-kerja/surat/perintah/penyimpanan') }}">
                                Berita Acara Serah Terima
                              </a>
                              @elseif($dataWarrent->warr_status == 'konfirmasi')
                              <a class="dropdown-item" href="{{ url('unit-kerja/surat-perintah/konfirmasi/'. $dataWarrent->id_warrent) }}">
                                Konfirmasi Penyimpanan
                              </a>
                              @else
                              <a class="dropdown-item" href="{{ url('unit-kerja/surat-perintah/detail/'. $dataWarrent->id_warrent) }}">
                                Detail
                              </a>
                              @endif
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
