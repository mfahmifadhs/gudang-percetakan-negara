<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $bast->id_pengajuan }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dist/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<style>
    @media print {
        .pagebreak {
            page-break-after: always;
        }

        .table-data {
            border: 1px solid;
            font-size: 20px;
        }

        .table-data th,
        .table-data td {
            border: 1px solid;
        }

        .table-data thead th,
        .table-data thead td {
            border: 1px solid;
        }
    }

    .divTable {
        border-top: 1px solid;
        border-left: 1px solid;
        border-right: 1px solid;
        font-size: 21px;
    }

    .divThead {
        border-bottom: 1px solid;
        font-weight: bold;
    }

    .divTbody {
        border-bottom: 1px solid;
        text-transform: capitalize;
    }

    .divTheadtd {
        border-right: 1px solid;
    }

    .divTbodytd {
        border-right: 1px solid;
        padding: 10px;
    }
</style>

<body style="font-family: Arial;">
    <div class="">
        <div class="row">
            <div class="col-md-2">
                <h2 class="page-header ml-4">
                    <img src="{{ asset('dist/img/logo-kemenkes-icon.png') }}">
                </h2>
            </div>
            <div class="col-md-8 text-center">
                <h2 class="page-header">
                    <h5 style="font-size: 24px;text-transform:uppercase;"><b>kementerian kesehatan republik indonesia</b></h5>
                    <h5 style="font-size: 24px;text-transform:uppercase;"><b>sekretariat jenderal</b></h5>
                    <p style="font-size: 18px;"><i>
                            Jl. H.R. Rasuna Said Blok X.5 Kav. 4-9, Jakarta 12950 <br>
                            Telepon : (021) 5201590</i>
                    </p>
                </h2>
            </div>
            <div class="col-md-2">
                <h2 class="page-header">
                    <img src="{{ asset('dist/img/logo-germas.png') }}" style="width: 128px; height: 128px;">
                </h2>
            </div>
            <div class="col-md-12" style="margin-top: -11px;">
                <hr style="border-width: medium;border-color: black;">
                <hr style="border-width: 1px;border-color: black;margin-top: -11px;">
            </div>
        </div>
        <div class="row" style="font-size: 20px;">
            <div class="col-md-12 form-group">
                <div class="form-group row mb-3 text-center">
                    <div class="col-md-12 text-uppercase">
                        berita acara serah terima <br>
                        nomor surat : {{ $bast->nomor_surat }}
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        Pada Hari Ini, Tanggal {{ \Carbon\Carbon::parse($bast->created_at)->isoFormat('DD MMMM Y') }} bertempat di
                        Gudang Percetakan Negara Kementerian Kesehatan Republik Indonesia, kami yang bertanda tangan dibawah Ini:
                    </div>
                </div>
                <div class="form-group row mb-0 py-3">
                    <div class="col-md-2"><span class="ml-5">Nama</span></div>
                    <div class="col-md-10">: Nurhuda</div>
                    <div class="col-md-2"><span class="ml-5">Jabatan</span></div>
                    <div class="col-md-10">: Pengelola Gudang Percetakan Negara
                    </div>
                    <div class="col-md-2"><span class="ml-5">Unit Kerja</span></div>
                    <div class="col-md-10">: Biro Umum</div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        Dalam Berita Acara ini bertindak untuk dan atas nama Biro Umum Sekretariat Jenderal, Pengelola Gudang Percetakan Negara
                        selaku yang menyerahkan, yang selanjutnya disebut <b>PIHAK PERTAMA</b>.
                    </div>
                </div>
                <div class="form-group row mb-0 py-3">
                    <div class="col-md-2"><span class="ml-5">Nama</span></div>
                    <div class="col-md-10">: {{ $staff->nama_petugas }}</div>
                    <div class="col-md-2"><span class="ml-5">Jabatan</span></div>
                    <div class="col-md-10">: {{ $staff->jabatan }}
                    </div>
                    <div class="col-md-2"><span class="ml-5">Unit Kerja</span></div>
                    <div class="col-md-10">: {{ $bast->pengajuan->unitkerja->nama_unit_kerja }}</div>
                </div>
                <div class="form-group row mb-0 text-justify">
                    <div class="col-md-12">
                        Dalam Berita Acara ini bertindak untuk dan atas nama {{ $bast->pengajuan->unitkerja->nama_unit_kerja }}
                        Selaku Penerima, yang selanjutnya disebut <b>PIHAK KEDUA</b>.
                    </div>
                </div>
                @if ($bast->pengajuan->jenis_pengajuan == 'masuk')
                <div class="form-group row mb-0 text-justify">
                    <div class="col-md-12 mt-4">
                        Bahwa <b>PIHAK PERTAMA</b> telah menyerahkan/menerima barang dari/kepada <b>PIHAK KEDUA</b>
                        dengan batas waktu penyimpanan sampai dengan {{ \Carbon\Carbon::parse($bast->pengajuan->batas_waktu)->isoFormat('DD MMMM Y') }} dan
                        rincian sebagai berikut:
                    </div>
                </div>
                @else
                <div class="form-group row mb-0 text-justify">
                    <div class="col-md-12 mt-4">
                        Bahwa <b>PIHAK PERTAMA</b> telah menyerahkan barang dari/kepada <b>PIHAK KEDUA</b>
                        dengan rincian sebagai berikut:
                    </div>
                </div>
                @endif
            </div>
            <div class="col-12 table-responsiv mb-5">
                @if ($bast->pengajuan->jenis_pengajuan == 'masuk')
                <table class="table table-bordered m-0 text-center">
                    <thead>
                        <tr>
                            <th style="width: 0%;">No</th>
                            <th style="width: 20%;">Nama Barang</th>
                            <th style="width: 20%;">Keterangan</th>
                            <th style="width: 10%;">Jumlah</th>
                            <th style="width: 15%;">Kode Palet</th>
                            <th style="width: 15%;">Nama Gedung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($item as $no => $row)
                        <tr>
                            <td>{{ $no + 1 }}</td>
                            <td>{{ $row->nama_barang }}</td>
                            <td>{{ $row->deskripsi }}</td>
                            <td>{{ $row->total_masuk.' '.$row->satuan }}</td>
                            <td>{{ $row->penyimpanan->kode_palet }}</td>
                            <td>{{ $row->penyimpanan->gedung->nama_gedung }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ( $item->count() >= 8 ) <div class="pagebreak"></div> @endif
                @else
                <table class="table table-bordered" style="font-size: 18px;">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Barang</th>
                            <th>Merek/Tipe</th>
                            <th class="text-center">Kondisi</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-center" colspan="2">Lokasi Penyimpanan</th>
                        </tr>
                    </thead>
                    @php $no = 1; @endphp
                    <tbody>
                        @foreach ($bast->pengajuan->riwayat as $row)
                        <tr>
                            <td class="text-center">
                                {{ $no++ }}
                            </td>
                            <td>{{ $row->detailPenyimpanan->barang->nama_barang }}</td>
                            <td>{{ $row->detailPenyimpanan->barang->deskripsi }}</td>
                            <td class="text-center">{{ $row->detailPenyimpanan->barang->kondisi_barang }}</td>
                            <td class="text-center">{{ $row->jumlah }}</td>
                            <td class="text-center">{{ $row->detailPenyimpanan->barang->satuan }}</td>
                            <td class="text-center">
                                {{ $row->detailPenyimpanan->penyimpanan->gedung->nama_gedung }}
                            </td>
                            <td class="text-center">
                                {{ $row->detailPenyimpanan->penyimpanan->kode_palet }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- @if ( $bast->pengajuan->riwayat->count() >= 8 ) <div class="pagebreak"></div> @endif -->
                @endif
            </div>
            <div class="col-md-12">
                <div class="row text-center">
                    <label class="col-sm-6">Yang Menyerahkan, <br> Pengelola Gudang</label>
                    <label class="col-sm-6">Yang Menerima, <br> {{ $bast->pengajuan->unitkerja->nama_unit_kerja }}</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row text-center">
                    <label class="col-sm-6" style="margin-bottom: 10%;">
                        <!-- {!! QrCode::size(100)->generate('https://gudangpn.kemkes.go.id/verif/berita-acara/'. $bast->id_pengajuan) !!} -->
                    </label>
                    <label class="col-sm-6" style="margin-bottom: 10%;">
                        <!-- {!! QrCode::size(100)->generate('https://gudangpn.kemkes.go.id/verif/berita-acara/'. $bast->id_pengajuan) !!} -->
                    </label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row text-center">
                    <label class="col-sm-6">Nurhuda</label>
                    <label class="col-sm-6">{{ $staff->nama_petugas }}</label>
                </div>
            </div>
        </div>
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
