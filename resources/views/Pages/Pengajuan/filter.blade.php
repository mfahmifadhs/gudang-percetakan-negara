@extends('Layout.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-capitalize">Gudang Percetakan Negara</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-capitalize">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('submission.show') }}">Daftar Pengajuan</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Content Header -->

<section class="content">
    <div class="container-fluid">
        @csrf
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Informasi Pengusul</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <form action="{{ route('submission.filter', $data->id_pengajuan) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-4">Tanggal</label>
                        <div class="col-md-10 col-8">:
                            {{ \Carbon\carbon::parse($data->tanggal_pengajuan)->isoFormat('DD MMMM Y') }}
                        </div>
                        <label class="col-md-2 col-4">Pengajuan</label>
                        <div class="col-md-10 col-8">:
                            {{ $data->jenis_pengajuan == 'masuk' ? 'Penyimpanan' : 'Pengeluaran' }}
                        </div>
                        <label class="col-md-2 col-4">Unit Kerja</label>
                        <div class="col-md-10 col-8">:
                            {{ $data->pegawai->workunit->nama_unit_kerja }}
                        </div>
                        <label class="col-md-2 col-4">Surat Pengajuan</label>
                        <div class="col-md-10 col-8">:
                            @if (!$data->surat_pengajuan)
                            Tidak ada file yang di upload
                            @else
                            <a href="{{ url('/surat/preview/'. $data->surat_pengajuan) }}" target="_blank">Lihat Surat</a>
                            @endif
                        </div>
                        <label class="col-md-2 col-4">Surat Perintah</label>
                        <div class="col-md-10 col-8">:
                            @if (!$data->surat_perintah)
                            Tidak ada file yang di upload
                            @else
                            <a href="{{ url('/surat/preview/'. $data->surat_perintah) }}" target="_blank">Lihat Surat</a>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-12">
                            Informasi Kedatangan <br>
                            <small class="text-danger"></small>
                        </label>
                        <div class="col-md-2 col-4">Tanggal {{ $data->jenis_pengajuan == 'masuk' ? 'Data' : 'Keluar' }}</div>:
                        <div class="col-md-8 col-7">
                            <input type="datetime-local" class="form-control select-border-bottom" name="tanggal_datang" required>
                        </div>
                        <div class="col-md-2 col-4">Nama Petugas</div>:
                        <div class="col-md-8 col-7">
                            <input type="text" class="form-control select-border-bottom" name="nama_petugas" required>
                        </div>
                        <div class="col-md-2 col-4">Jabatan</div>:
                        <div class="col-md-8 col-7">
                            <input type="text" class="form-control select-border-bottom" name="jabatan_petugas" required>
                        </div>
                        <div class="col-md-2 col-4">Nomor Mobil</div>:
                        <div class="col-md-8 col-7">
                            <input type="text" class="form-control select-border-bottom text-uppercase" name="nomor_mobil" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-12">
                            Informasi Barang <br>
                            <small class="text-danger"></small>
                        </label>
                        <div class="col-md-12">
                            @if ($data->jenis_pengajuan == 'masuk')
                            <input type="hidden" name="category" value="masuk">
                            <table class="table table-bordered table-responsive" style="font-size: 15px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</td>
                                        <th style="width: 15%;">Barang</td>
                                        <th style="width: 10%;" class="text-center">Pengajuan</td>
                                        <th style="width: 10%;" class="text-center">Diterima</td>
                                        <th style="width: 10%;" class="text-center">Satuan</td>
                                        <th>Keterangan</td>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($data->penyimpanan as $i => $row)
                                    <tr>
                                        <td class="pt-3 text-center">
                                            {{ $no++ }}
                                            <input type="hidden" name="status" value="true">
                                            <input type="hidden" name="id_barang[]" value="{{ $row->id_detail }}">
                                        </td>
                                        <td class="pt-3">{{ $row->nama_barang }}</td>
                                        <td class="pt-3 text-center">
                                            {{ $row->jumlah_pengajuan }}
                                        </td>
                                        <td class="pt-3 text-center">
                                            <input type="number" name="jumlah[]" class="form-control input-border-bottom text-center" value="{{ $row->jumlah_pengajuan }}">
                                        </td>
                                        <td class="pt-3 text-center">
                                            {{ $row->satuan }}
                                        </td>
                                        <td class="pt-3">{{ $row->keterangan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <input type="hidden" name="category" value="keluar">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" style="font-size: 15px;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th style="width: 25vh;">Barang</th>
                                            <th style="width: 15vh;">Permintaan</th>
                                            <th>Pengambilan</th>
                                            <th style="width: 15vh;">Stok</th>
                                            <th style="width: 15vh;">Satuan</th>
                                            <th colspan="2" style="width: 40vh;">Lokasi Penyimpanan</th>
                                        </tr>
                                    </thead>
                                    @php $no = 1; @endphp
                                    <tbody>
                                        @foreach ($data->pengambilan as $row)
                                        <tr>
                                            <td style="width: 0vh;">{{ $no++ }}</td>
                                            <td>
                                                <input type="text" class="form-control input-border-bottom text-left bg-default" style="width: 25vh;"
                                                value="{{ $row->palet->barang->nama_barang }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-border-bottom text-center bg-default" style="width: 15vh;"
                                                value="{{ $row->jumlah_pengajuan }}" readonly>
                                            </td>
                                            <td style="width: 20vh;">
                                                <input type="hidden" name="id_keluar[]" value="{{ $row->id_keluar }}">
                                                <input type="number" class="form-control input-border-bottom text-center" name="jumlah_keluar[]"
                                                value="{{ $row->jumlah_pengajuan }}" min="0" max="{{ (int) $row->palet->total_masuk - $row->palet->total_keluar }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-border-bottom text-center bg-default" style="width: 15vh;"
                                                value="{{ (int) $row->palet->total_masuk - $row->palet->total_keluar }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-border-bottom text-center bg-default" style="width: 15vh;"
                                                value="{{ $row->palet->barang->satuan }}" readonly>
                                            </td>
                                            <td style="width: 15vh;">
                                                <input type="text" class="form-control input-border-bottom text-center bg-default" style="width: 20vh;"
                                                value="{{ $row->palet->penyimpanan->gedung->nama_gedung }}" readonly>
                                            </td>
                                            <td style="width: 15vh;">
                                                <input type="text" class="form-control input-border-bottom text-center bg-default" style="width: 20vh;"
                                                value="{{ $row->palet->penyimpanan->kode_palet }}" readonly>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                        <label class="col-md-12">
                            Keterangan Ketidaksesuaian
                        </label>
                        <div class="col-md-12">
                            <textarea name="catatan" class="form-control" rows="2" placeholder="Keterangan Ketidaksesuaian"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('submission.show') }}" class="btn btn-default">
                            <i class="fas fa-arrow-circle-left fa-1x"></i> <b>Kembali</b>
                        </a>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Selesai Penapisan?')">
                            <i class="fas fa-save fa-1x"></i> <b>Simpan</b>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
