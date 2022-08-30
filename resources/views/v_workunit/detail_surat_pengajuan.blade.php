@extends('v_main.layout.app')

@section('content')

  <div class="container-xxl py-5">
    <div class="container" style="margin-top: 100px;">
      @if($appletter->appletter_status == 'proses')
      <a class="btn btn-outline-primary py-2 px-3 mb-4 disabled">
        Diproses
      </a>
      @elseif($appletter->appletter_status == 'ditolak')
      <a class="btn btn-outline-danger py-2 px-3 mb-4 disabled">
        Pengajuan Ditolak
      </a>
      @else
      <a class="btn btn-success-danger py-2 px-3 mb-4 disabled">
        Pengajuan Dterima
      </a>
      @endif
      <div class="card">
        <div class="card-header">
          <div class="row text-center mt-3">
            <div class="col-md-3"><img src="{{ asset('dist-main/img/logo-kemenkes-icon.png') }}"></div>
            <div class="col-md-6">
              <h5><b>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</b></h5>
              <h6 class="text-uppercase"><b>{{ $appletter->workunit_name.' '.$appletter->mainunit_name }}</b></h6>
              <p>Jl. H.R. Rasuna Said Blok X.5 Kav. 4-9, Blok A, 2nd Floor, Jakarta 12950<br>Telp.: (62-21) 5201587, 5201591 Fax. (62-21) 5201591</p>
            </div>
            <div class="col-md-3"><img src="{{ asset('dist-main/img/logo-germas.png') }}"></div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <p class="m-0">Nomor : <span class="text-uppercase"> {{ $appletter->appletter_num }} </span></p>
            <p class="m-0">Sifat <span style="margin-left: 17px;">:</span> <span class="text-uppercase"> {{ $appletter->appletter_ctg }} </span></p>
            <p class="m-0">Perihal    :  <span class="text-capitalize"> {{ $appletter->appletter_regarding }} </span></p>
          </div>
          <div class="row mt-4">
            <p class="text-capitalize">
                Yth. Kepala Biro Umum <br>
                {!! $appletter->appletter_text !!}
            </p>
            <div class="mt-2 text-capitalize">
              <p>Dengan ini kami ingin mengajukan untuk mengirimkan dan menyimpan barang berikut ke Kompleks Perkantoran dan Pergudangan Kementerian Kesehatan RI.	</p>
            </div>
          </div>
          <div class="row m-1">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td>No</td>
                <td>Kategori Barang</td>
                <td>Nama Barang</td>
                <td>Mark/Tipe</td>
                <td>Jumlah</td>
                <td>Satuan</td>
              </tr>
            </thead>
            <?php $no=1; ?>
            <tbody>
              @foreach($item as $item)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $item->warr_item_category }}</td>
                  <td>{{ $item->warr_item_name }}</td>
                  <td>{{ $item->warr_item_type }}</td>
                  <td>{{ $item->warr_item_qty }}</td>
                  <td>{{ $item->warr_item_unit }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          </div>
        </div>
        <div class="card-footer">
          <span style="float:left;">
            <a href="{{ url('/') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
          </span>
          <span style="float:right;">
            <a href="#" class="btn btn-primary"><i class="fas fa-print"></i> Cetak</a>
            <a href="#" class="btn btn-primary"><i class="fas fa-file-pdf"></i> Download PDF</a>
          </span>

        </div>
      </div>
    </div>
  </div>

@endsection
