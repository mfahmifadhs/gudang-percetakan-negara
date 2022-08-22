@extends('v_workunit.layout.app')

@section('content')

@foreach($warehouse as $warehouse)
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12 form-group">
        <ol class="breadcrumb text-center">
          <li class="breadcrumb-item"><a href="{{ url('unit-kerja/dashboard') }}">Beranda</a></li>
          <li class="breadcrumb-item"><a href="{{ url('unit-kerja/menu-gudang') }}">Daftar Gudang</a></li>
          <li class="breadcrumb-item">{{ $warehouse->warehouse_name }}</li>
        </ol>
      </div>
      <div class="col-md-12 form-group">
        @if($warehouse->warehouse_category == 'Palleting')
        <div class="card">
          <div class="card-header">
            <h3 class="card-title" style="float:left;margin-top: 0.5vh;"><b>Gudang {{ $warehouse->id_warehouse }}</b></h3>
            <div class="card-tools text-uppercase">
              <a class="btn btn-default font-weight-bold disabled" style="font-size: 12px;">
                Kosong
              </a>
              <a class="btn btn-success font-weight-bold disabled" style="font-size: 12px;">
                Tersedia
              </a>
              <a class="btn btn-danger font-weight-bold disabled" style="font-size: 12px;">
                Penuh
              </a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @if($warehouse->id_warehouse == 'G09B')
            <div class="row"> 
              @foreach($warehouse09b as $warehouse09b)
              <div class="row"> 
                @foreach($pallet as $row)
                @if($row->slot_status == 'Penuh')
                <div class="col-xs-1-5" style="margin-bottom:3vh;">
                  <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-danger disabled" 
                    style="width:100%;">
                    {{ $row->pallet_name }}
                  </a>
                </div>
                @elseif($row->slot_status == 'Tersedia')
                <div class="col-xs-1-5" style="margin-bottom:3vh;">
                  <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-success disabled" 
                    style="width:100%;">
                    {{ $row->pallet_name }}
                  </a>
                </div>
                @elseif($row->slot_status == 'Kosong' && $row->pallet_id != '0')
                <div class="col-xs-1-5" style="margin-bottom:3vh;">
                  <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-default disabled" 
                    style="width:100%;">
                    {{ $row->pallet_name }}
                  </a>
                </div>
                @elseif($row->pallet_id == '0')
                <div class="col-xs-1-6" style="margin-bottom:3vh;">
                  <a href="" class="btn btn-warning disabled" style="width:100%;">JALUR MANUAL FORKLIFT</a>
                </div>
                @endif
                @endforeach
              </div>
              @endforeach
            </div>
            @endif
          </div>
        </div>
        <!-- Detail Slot Racking -->
        @elseif($warehouse->warehouse_category == 'Racking')
        <div class="card">
          <div class="card-header">
            <h3 class="card-title" style="float:left;margin-top: 0.5vh;"><b>Gudang {{ $warehouse->id_warehouse }}</b></h3>
            <div class="card-tools text-uppercase">
              <a class="btn btn-default font-weight-bold disabled" style="font-size: 12px;">
                Kosong
              </a>
              <a class="btn btn-success font-weight-bold disabled" style="font-size: 12px;">
                Tersedia
              </a>
              <a class="btn btn-danger font-weight-bold disabled" style="font-size: 12px;">
                Penuh
              </a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @if($warehouse->id_warehouse == 'G05B')
            <hr>
            <p>Kode Rak : <b>I</b></p>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <b>Tingkat 1</b>
                <hr>
                <div class="row">
                  @foreach($rack_pallet_one_lvl1 as $row)
                  @if($row->slot_status == 'Kosong')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-default disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Tersedia')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-success disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Penuh')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-danger disabled" 
                      style="width:100%;">
                      { $row->id_slot }}
                    </a>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
              <div class="col-md-6">
                <b>Tingkat 2</b>
                <hr>
                <div class="row" >
                  @foreach($rack_pallet_one_lvl2 as $row)
                  @if($row->slot_status == 'Kosong')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-default disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Tersedia')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-warning disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Penuh')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-danger disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
            </div>
            <hr>
            <p>Kode Rak : <b>II</b></p>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <b>Tingkat 1</b>
                <hr>
                <div class="row" >
                  @foreach($rack_pallet_two_lvl1 as $row)
                  @if($row->slot_status == 'Kosong')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-default disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Tersedia')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-warning disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Penuh')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-danger disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
              <div class="col-md-6">
                <b>Tingkat 2</b>
                <hr>
                <div class="row" >
                  @foreach($rack_pallet_two_lvl2 as $row)
                  @if($row->slot_status == 'Kosong')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-default disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Tersedia')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-warning disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Penuh')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-danger disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
            </div>
            <hr>
            <p>Kode Rak : <b>III</b></p>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <b>Tingkat 1</b>
                <hr>
                <div class="row" >
                  @foreach($rack_pallet_three_lvl1 as $row)
                  @if($row->slot_status == 'Kosong')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-default disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Tersedia')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-warning disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Penuh')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-danger disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
              <div class="col-md-6">
                <b>Tingkat 2</b>
                <hr>
                <div class="row" >
                  @foreach($rack_pallet_three_lvl2 as $row)
                  @if($row->slot_status == 'Kosong')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-default disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Tersedia')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-warning disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Penuh')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-danger disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
            </div>
            <hr>
            <p>Kode Rak : <b>IV</b></p>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <b>Tingkat 1</b>
                <hr>
                <div class="row" >
                  @foreach($rack_pallet_four_lvl1 as $row)
                  @if($row->slot_status == 'Kosong')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-default disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Tersedia')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-warning disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Penuh')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-danger disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
              <div class="col-md-6">
                <b>Tingkat 2</b>
                <hr>
                <div class="row" >
                  @foreach($rack_pallet_four_lvl2 as $row)
                  @if($row->slot_status == 'Kosong')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-default disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Tersedia')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-warning disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @elseif($row->slot_status == 'Penuh')
                  <div class="col-md-4" style="margin-bottom:5vh;">
                    <a href="{{ url('admin-master/detail-slot/'. $row->id_slot) }}" class="btn btn-danger disabled" 
                      style="width:100%;">
                      {{ $row->id_slot }}
                    </a>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        <!-- Detail Slot Lainya -->
        @else
        <div class="card">
          <div class="card-header">
            <h3 class="card-title" style="float:left;margin-top: 0.5vh;"><b>Gudang {{ $warehouse->id_warehouse }}</b></h3>
            <div class="card-tools text-uppercase">
              <a class="btn btn-default font-weight-bold disabled" style="font-size: 12px;">
                Kosong
              </a>
              <a class="btn btn-success font-weight-bold disabled" style="font-size: 12px;">
                Tersedia
              </a>
              <a class="btn btn-danger font-weight-bold disabled" style="font-size: 12px;">
                Penuh
              </a>
            </div>
          </div>
          @foreach($slot as $slot)
          <div class="card-body">
            <div class="col-md-12 text-center">
              @if($slot->slot_status == 'Tersedia')
              <a href="{{ url('unit-kerja/detail-slot/'. $slot->id_slot) }}" class="btn btn-success btn-lg disabled" 
                style="width:50%;">
                {{ $slot->id_slot }}
              </a>
              @elseif($slot->slot_status == 'Kosong')
              <a href="{{ url('unit-kerja/detail-slot/'. $slot->id_slot) }}" class="btn btn-default btn-lg disabled" 
                style="width:50%;">
                {{ $slot->id_slot }}
              </a>
              @elseif($slot->slot_status == 'Penuh')
              <a href="{{ url('unit-kerja/detail-slot/'. $slot->id_slot) }}" class="btn btn-danger btn-lg disabled" 
                style="width:50%;">
                {{ $slot->id_slot }}
              </a>
              @endif
            </div>
          </div>
          @endforeach
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endforeach

@endsection