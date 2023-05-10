@extends('v_petugas.layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Detail Barang</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ url('petugas/dashboard') }}">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="{{ url('petugas/barang/daftar/masuk') }}">Daftar Barang</a></li>
               <li class="breadcrumb-item active">{{ $item->item_name }}</li>
            </ol>
         </div>
      </div>
   </div>
</section>
<!-- Content Header -->

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title">{{ $item->item_name }}</h3>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                           <div class="col-12 col-sm-4">
                              <div class="info-box bg-light">
                                 <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Total Barang Masuk</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ ($item->item_qty + $itemExit->total_exit).' '.$item->item_unit }}</span>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 col-sm-4">
                              <div class="info-box bg-light">
                                 <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Total Barang Keluar</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $itemExit->total_exit.' '.$item->item_unit }}</span>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 col-sm-4">
                              <div class="info-box bg-light">
                                 <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Stok Barang</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $item->item_qty.' '.$item->item_unit }}</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-12">
                              <h4>Lokasi Penyimpanan</h4>
                              <div class="post">
                                 <div class="user-block mt-4">
                                    <table id="table-1" class="table">
                                       <thead>
                                          <tr>
                                             <th>No</th>
                                             <th>Nama Barang</th>
                                             <th>Keterangan</th>
                                             <th>Jumlah</th>
                                             <th>Lokasi Penyimpanan</th>
                                          </tr>
                                       </thead>
                                       @php $no = 1; @endphp
                                       <tbody>
                                          @foreach($items as $dataItem)
                                          <tr>
                                             <td>{{ $no++ }}</td>
                                             <td>
                                                <a class="btn font-weight-bold p-0" data-toggle="modal" data-target="#qrcode{{$dataItem->slot_id}}">
                                                   {{ $dataItem->item_name }}
                                                </a>
                                             </td>
                                             <td>{{ $dataItem->item_description }}</td>
                                             <td>{{ $dataItem->total_item }}</td>
                                             <td>{{ $dataItem->slot_id }}</td>
                                          </tr>

                                          <div class="modal fade" id="qrcode{{$dataItem->slot_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                             <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">{{ $dataItem->item_name.' '.$dataItem->slot_id }}</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                         <span aria-hidden="true">&times;</span>
                                                      </button>
                                                   </div>
                                                   <form action="{{ url('petugas/print-qrcode/'. $item->id_item) }}">
                                                      <div class="modal-body">
                                                         @csrf
                                                         <label>Jumlah Cetak</label>
                                                         <input type="number" name="qty" value="{{ $dataItem->total_item }}" class="form-control">
                                                         <input type="hidden" name="slotid" value="{{ $dataItem->slot_id }}">
                                                      </div>
                                                      <div class="modal-footer">
                                                         <button type="submit" class="btn btn-primary" formtarget="_blank"><i class="fas fa-print"></i> Cetak</button>
                                                      </div>
                                                   </form>
                                                </div>
                                             </div>
                                          </div>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <h3 class="text-primary text-capitalize">{{ $item->item_name }}</h3>
                        <p class="text-muted text-capitalize">{{ $item->item_description }}</p>
                        <span>
                           {!! QrCode::size(100)->generate('http://127.0.0.1:8000/barang/'. $item->id_item) !!}
                        </span>
                        <br>
                        <div class="text-muted mt-2">
                           <p class="text-sm">Pemilik Barang
                              <b class="d-block">{{ $item->workunit_name }}</b>
                           </p>
                           <p class="text-sm">Tanggal Masuk
                              <b class="d-block">{{ \Carbon\Carbon::parse($item->order_dt)->isoFormat('DD MMMM Y') }}</b>
                           </p>
                        </div>

                        <h5 class="mt-5 text-muted">Surat Permohonan</h5>
                        <ul class="list-unstyled">
                           <li>
                              <a href="{{ asset('data_file/surat_permohonan/'. $item->appletter_file) }}" class="btn-link text-secondary" download>
                                 <i class="far fa-fw fa-file-word"></i>
                                 {{ $item->appletter_file }}
                              </a>
                           </li>
                        </ul>
                        <h5 class="mt-5 text-muted">Surat Perintah</h5>
                        <ul class="list-unstyled">
                           <li>
                              <a href="{{ asset('data_file/surat_perintah/'. $item->warr_file) }}" class="btn-link text-secondary" download>
                                 <i class="far fa-fw fa-file-word"></i>
                                 {{ $item->warr_file }}
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

@section('js')
<script>
   $(function() {
      $("#table-1").DataTable({
         "responsive": true,
         "lengthChange": true,
         "autoWidth": true,
         "searching": false,
      });
   });
</script>
@endsection

@endsection
