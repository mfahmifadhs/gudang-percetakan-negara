@extends('Layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">Gudang Percetakan Negara</h1>
                <h5>Selamat Datang, {{ Auth::user()->pegawai->nama_pegawai  }}</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p style="color:white;margin: auto;">{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('failed'))
        <div class="alert alert-danger">
            <p style="color:white;margin: auto;">{{ $message }}</p>
        </div>
        @endif
    </div>
</section>

@section('js')
<script>
    $(function() {
        $("#table-submission").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "info": false,
            "paging": false,
            "searching": false,
            "sort": false,
            "columnDefs": [{
                    "width": "5%",
                    "targets": 0
                },
                {
                    "width": "15%",
                    "targets": 1
                },
                {
                    "width": "30%",
                    "targets": 2
                },
            ]
        }).buttons().container().appendTo('#table-submission_wrapper .col-md-6:eq(0)')

        $("#table-limit").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "info": false,
            "paging": false,
            "searching": false,
            "sort": false,
            "columnDefs": [{
                    "width": "5%",
                    "targets": 0
                },
                {
                    "width": "25%",
                    "targets": 2
                },
            ]
        }).buttons().container().appendTo('#table-limit_wrapper .col-md-6:eq(0)')
    })
</script>
@endsection



@endsection

