@extends('v_petugas.layout.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">{{ $warehouse->warehouse_name }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('petugas/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ url('petugas/gudang/daftar/semua') }}">Master Gudang</a></li>
          <li class="breadcrumb-item">{{ $warehouse->warehouse_name }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <!-- Detail Slot Palleting -->
    @if($warehouse->warehouse_category == 'Palleting')
    <div class="card">
      <div class="card-header">
        <h3 class="card-title" style="float:left;margin-top: 0.5vh;"><b>Gudang {{ $warehouse->id_warehouse }}</b></h3>
        <div class="card-tools text-uppercase">
          <a class="btn btn-default font-weight-bold disabled" style="font-size: 12px;">
            kosong
          </a>
          <a class="btn btn-success font-weight-bold disabled" style="font-size: 12px;">
            tersedia
          </a>
          <a class="btn btn-danger font-weight-bold disabled" style="font-size: 12px;">
            penuh
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
              @if($row->slot_status == 'penuh')
              <div class="col-xs-1-5" style="margin-bottom:3vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-danger" style="width:100%;">
                  {{ $row->pallet_name }}
                </a>
              </div>
              @elseif($row->slot_status == 'tersedia')
              <div class="col-xs-1-5" style="margin-bottom:3vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-success" style="width:100%;">
                  {{ $row->pallet_name }}
                </a>
              </div>
              @elseif($row->slot_status == 'kosong' && $row->pallet_id != '0')
              <div class="col-xs-1-5" style="margin-bottom:3vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-default" style="width:100%;">
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
            kosong
          </a>
          <a class="btn btn-success font-weight-bold disabled" style="font-size: 12px;">
            tersedia
          </a>
          <a class="btn btn-danger font-weight-bold disabled" style="font-size: 12px;">
            penuh
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
              @if($row->slot_status == 'kosong')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-default" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'tersedia')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-success" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'penuh')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-danger" style="width:100%;">
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
              @foreach($rack_pallet_one_lvl2 as $row)
              @if($row->slot_status == 'kosong')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-default" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'tersedia')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-success" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'penuh')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-danger" style="width:100%;">
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
              @if($row->slot_status == 'kosong')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-default" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'tersedia')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-success" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'penuh')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-danger" style="width:100%;">
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
              @if($row->slot_status == 'kosong')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-default" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'tersedia')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-success" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'penuh')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-danger" style="width:100%;">
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
              @if($row->slot_status == 'kosong')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-default" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'tersedia')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-success" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'penuh')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-danger" style="width:100%;">
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
              @if($row->slot_status == 'kosong')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-default" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'tersedia')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-success" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'penuh')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-danger" style="width:100%;">
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
              @if($row->slot_status == 'kosong')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-default" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'tersedia')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-success" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'penuh')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-danger" style="width:100%;">
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
              @if($row->slot_status == 'kosong')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-default" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'tersedia')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-success" style="width:100%;">
                  {{ $row->id_slot }}
                </a>
              </div>
              @elseif($row->slot_status == 'penuh')
              <div class="col-md-4" style="margin-bottom:5vh;">
                <a href="{{ url('petugas/gudang/slot/'. $row->id_slot) }}" class="btn btn-danger" style="width:100%;">
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
    @else
    <div class="card">
      <div class="card-header">
        <h3 class="card-title" style="float:left;margin-top: 0.5vh;"><b>Gudang {{ $warehouse->id_warehouse }}</b></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <a href="{{ url('petugas/gudang/slot/'. $slot->id_slot) }}">
          <img src="https://cdn-icons-png.flaticon.com/512/2897/2897821.png" width="200" class="img-thumbnail">
        </a>
      </div>
    </div>
    @endif
  </div>
</section>

@endsection
