@extends('v_main.layout.app')

@section('content')

<div class="container-xxl py-5">
    <div class="container" style="margin-top: 150px;">
        <div class="text-center mx-auto" style="max-width: 700px;">
            <div class="d-inline-block rounded-pill bg-secondary text-primary py-1 px-3 mb-3">#GudangPercetakanNegara</div>
            <h1 class="display-6 mb-5">Gudang Percetakan Negara Kemenkes RI</h1>
        </div>
    </div>
</div>

<section class="content">
    <div class="container">
        <div class="row">
            @foreach($warehouses as $dataWarehouse)
            <div class="col-md-6 mb-4">
                <div class="card" style="height: 100%;">
                    <div class="card-header">
                        <h5 class="card-title mt-2">{{ $dataWarehouse->warehouse_name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row" style="font-size: 14px;">
                            <div class="col-md-5 form-group text-center">
                                <img src="https://cdn-icons-png.flaticon.com/512/2271/2271068.png" style="height: 20vh;" class="img-thumbnail mt-4">
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Kode</label>
                                        <p>{{ $dataWarehouse->id_warehouse }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Nama Gudang</label>
                                        <p>{{ $dataWarehouse->warehouse_name }}</p>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Keterangan</label>
                                        <p>{!! $dataWarehouse->warehouse_description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


@endsection
