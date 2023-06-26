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
                        <label class="col-md-2 col-4">Tanggal Pengajuan</label>
                        <div class="col-md-10 col-8">:
                            {{ \Carbon\carbon::parse($data->tanggal_pengajuan)->isoFormat('DD MMMM Y') }}
                        </div>
                        <label class="col-md-2 col-4">Jenis Pengajuan</label>
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
                        <div class="col-md-2 col-4">Tanggal Datang</div>:
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
                            <table class="table table-bordered" style="font-size: 15px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Barang</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">Kondisi</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Satuan</th>
                                        <th class="text-center" colspan="2">Lokasi Penyimpanan</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($data->riwayat as $row)
                                    <tr>
                                        <td class="text-center">
                                            {{ $no++ }}
                                        </td>
                                        <td>{{ $row->detailPenyimpanan->barang->nama_barang }}</td>
                                        <td>{{ $row->detailPenyimpanan->barang->catatan }}</td>
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
