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

<form action="{{ route('submission.process', $data->id_pengajuan) }}" method="POST">
    @csrf
    <section class="content">
        <div class="container-fluid">
            @csrf
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
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">Informasi Pengusul</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-4">Tanggal</label>
                        <div class="col-md-10 col-7">:
                            {{ \Carbon\carbon::parse($data->tanggal_pengajuan)->isoFormat('DD MMMM Y') }}
                        </div>
                        <label class="col-md-2 col-4">Pengajuan</label>
                        <div class="col-md-10 col-7">:
                            {{ $data->jenis_pengajuan == 'masuk' ? 'Penyimpanan' : 'Pengeluaran' }}
                        </div>
                        <label class="col-md-2 col-4">Unit Kerja</label>
                        <div class="col-md-10 col-7">:
                            {{ $data->pegawai->workunit->nama_unit_kerja }}
                        </div>
                        <label class="col-md-2 col-4">Surat Pengajuan</label>
                        <div class="col-md-10 col-7">:
                            @if (!$data->surat_pengajuan)
                            Tidak ada file yang di upload
                            @else
                            <a href="{{ url('/surat/preview/'. $data->surat_pengajuan) }}">
                                Lihat Surat
                            </a>
                            @endif
                        </div>
                        <label class="col-md-2 col-4">Surat Perintah</label>
                        <div class="col-md-10 col-7">:
                            @if (!$data->surat_perintah)
                            Tidak ada file yang di upload
                            @else
                            <a href="{{ url('/surat/preview/'. $data->surat_perinta) }}">
                                Lihat Surat
                            </a>
                            @endif
                        </div>

                        @if ($data->jenis_pengajuan == 'masuk')
                        <label class="col-md-2 col-4">Batas Waktu</label>&ensp;:
                        <div class="col-md-4 col-7">
                            <input type="date" class="form-control select-border-bottom" name="batas_waktu" required>
                        </div>
                        @endif
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
                                        <th>Barang</td>
                                        <th>Keterangan</td>
                                        <th style="width: 10%;" class="text-center">Jumlah</td>
                                        <th style="width: 10%;" class="text-center">Satuan</td>
                                        <th style="width: 8%;" class="text-center">
                                            Penempatan
                                        </th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($data->penyimpanan as $i => $row)
                                    <tr>
                                        <td class="pt-3 text-center">
                                            {{ $no++ }}
                                            <input type="hidden" name="status" value="true">
                                        </td>
                                        <td class="pt-3">{{ $row->nama_barang }}</td>
                                        <td class="pt-3">{{ $row->keterangan }}</td>
                                        <td class="pt-3 text-center">
                                            {{ $row->jumlah_diterima }}
                                        </td>
                                        <td class="pt-3 text-center">
                                            {{ $row->satuan }}
                                        </td>
                                        <td class="text-center">
                                            <a type="button" data-toggle="modal" onclick="showModal('{{ $row->id_detail }}')" class="btn btn-warning btn-sm">
                                                <i class="fas fa-dolly-flatbed"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5">
                                            Penempatan penyimpanan barang jika dalam satu lokasi yang sama.
                                        </td>
                                        <td class="text-center">
                                            <a type="button" data-toggle="modal" data-target="#placement-all" class="btn btn-warning btn-sm">
                                                <i class="fas fa-dolly-flatbed"></i>
                                            </a>
                                        </td>
                                    </tr>
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
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('submission.show') }}" class="btn btn-default">
                            <i class="fas fa-arrow-circle-left fa-1x"></i> <b>Kembali</b>
                        </a>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Apakah pengajuan ini disetujui?')">
                            <i class="fas fa-save fa-1x"></i> <b>Simpan</b>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($data->jenis_pengajuan == 'masuk')
    <!-- Modal Penempatan Slot -->
    @foreach ($data->penyimpanan as $i => $row)
    <div class="modal fade" id="placement-{{ $row->id_detail }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModal">Penempatan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="status" value="false">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-2 col-4">Barang</div>:
                        <div class="col-md-9 col-7">{{ $row->nama_barang }}</div>
                        <div class="col-md-2 col-4">Catatan</div>:
                        <div class="col-md-9 col-7">{{ $row->catatan }}</div>
                        <div class="col-md-2 col-4">Deskripsi</div>:
                        <div class="col-md-9 col-7">{{ $row->deskripsi }}</div>
                        <div class="col-md-2 col-4">Jumlah</div>:
                        <div class="col-md-9 col-7">{{ $row->jumlah_diterima.' '.$row->satuan }}</div>
                    </div>
                    <div>
                        <label>Lokasi Penyimpanan</label>
                        <div class=" table-responsive">
                            <table class="table table-bordered table-striped" id="table-placement-{{ $row->id_detail }}">
                                <thead>
                                    <tr>
                                        <td style="width: 0%;" class="text-center">No</td>
                                        <td style="width: 25%;">Gudang</td>
                                        <td style="width: 25%;">Palet</td>
                                        <td style="width: 15%;" class="text-center pr-4">Jumlah</td>
                                        <td style="width: 15%;" class="text-center pr-4">Satuan</td>
                                        <td>Kapasitas</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="custom">
                                            <select class="form-control select-border-bottom warehouse" id="warehouse-{{$i}}" name="warehouse_id[]" data-id="{{ $i }}"
                                            style="width: 20vh;">
                                                <option value="">-- Pilih Gedung --</option>
                                                @foreach ($warehouse as $wh)
                                                <option value="{{ $wh->id_gedung }}">
                                                    {{ $wh->nama_gedung }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control select-border-bottom slot" name="slot_id[]" data-id="{{ $i }}" style="width: 20vh;">
                                                <option value="">-- Pilih Slot --</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="hidden" id="total-{{ $row->id_detail }}" value="{{ $row->jumlah_diterima }}">
                                            <input type="number" name="qty[]" class="form-control select-border-bottom total text-center sisa-barang"
                                            id="qty-{{ $row->id_detail }}" value="{{ $row->jumlah_diterima }}" style="width: 15vh;">
                                            <input type="hidden" name="id_detail[]" class="id-detail" value="{{ $row->id_detail }}">
                                        </td>
                                        <td>
                                            <input type="text" class="text-center select-border-bottom satuan" id="satuan-{{ $row->id_detail }}"
                                            value="{{ $row->satuan }}" style="width: 15vh;" readonly>
                                        </td>
                                        <td>
                                            <select name="kapasitas_id[]" class="form-control select-border-bottom" style="width: 15vh;">
                                                <option value="2">Tersedia</option>
                                                <option value="3">Penuh</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="#" class="btn btn-success btn-sm btn-add-penyimpanan" data-id="{{ $row->id_detail }}">
                            <i class="fas fa-plus-circle"></i> Tambah Baris
                        </a>
                        <a href="#" class="btn btn-danger btn-sm btn-delete-row" data-id="{{ $row->id_detail }}" id="btn-hapus-{{ $row->id_detail }}">
                            <i class="fas fa-minus-circle"></i> Hapus Baris
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">Selesai</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Penempatan Semua -->
    <div class="modal fade" id="placement-all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModal">Penempatan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Lokasi Gudang</label>
                        <div class="col-md-6">
                            <select class="form-control select-border-bottom warehouse" name="warehouse_all_id" data-id="{{ $row->id_detail }}">
                                <option value="">-- Pilih Gedung --</option>
                                @foreach ($warehouse as $wh)
                                <option value="{{ $wh->id_gedung }}">
                                    {{ $wh->nama_gedung }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Lokasi Palet</label>
                        <div class="col-md-6">
                            <select class="form-control select-border-bottom slot" name="slot_all_id" data-id="{{ $row->id_detail }}">
                                <option value="">-- Pilih Slot --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Informasi Barang</label>
                        <div class="col-md-12">
                            <table class="table table-bordered" style="font-size: 15px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</td>
                                        <th>Nama Barang</td>
                                        <th>Catatan</td>
                                        <th>Keterangan</td>
                                        <th style="width: 10%;" class="text-center">Jumlah</td>
                                        <th style="width: 10%;" class="text-center">Satuan</td>
                                        <th style="width: 20%;">Rencana Penghapusan/Distribusi</td>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($data->penyimpanan as $i => $row)
                                    <tr>
                                        <td class="pt-3 text-center">
                                            {{ $no++ }}
                                            <input type="hidden" name="status" value="true">
                                        </td>
                                        <td class="pt-3">
                                            <input class="form-control input-border-bottom bg-white" value="{{ $row->nama_barang }}" readonly>
                                        </td>
                                        <td class="pt-3">
                                            <input class="form-control input-border-bottom bg-white" value="{{ $row->catatan }}" readonly>
                                        </td>
                                        <td class="pt-3">
                                            <input class="form-control input-border-bottom bg-white" value="{{ $row->deskripsi }}" readonly>
                                        </td>
                                        <td class="pt-3 text-center">
                                            <input class="form-control input-border-bottom bg-white text-center" value="{{ $row->jumlah_diterima }}" readonly>
                                        </td>
                                        <td class="pt-3 text-center">
                                            <input class="form-control input-border-bottom bg-white text-center" value="{{ $row->satuan }}" readonly>
                                        </td>
                                        <td class="pt-3">
                                            <input class="form-control input-border-bottom bg-white" value="{{ $row->keterangan }}" readonly>
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
    @endif

</form>

@section('js')
<script>
    $("#table-preview-101").DataTable({
        'paging': false,
        'info': false,
        'searching': false,
        'sorting': false
    });
    $("#table-preview-102").DataTable({
        'paging': false,
        'info': false,
        'searching': false,
        'sorting': false
    });

    function showModal(id_barang) {
        var modal_target = "#placement-" + id_barang;
        $(modal_target).modal('show');
    }

    // Menampilkan slot berdasarkan gedung
    $(document).on('change', '.warehouse', function() {
        var id_detail = $(this).data('id')
        var id_gedung = $(this).val()

        if (id_gedung != '') {
            $.ajax({
                url: '{{ route("submission.getSlotByWarehouse") }}',
                type: 'POST',
                data: {
                    id_gedung: id_gedung,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data) {
                    $('.slot[data-id="' + id_detail + '"]').html(
                        '<option value="">-- Pilih Slot --</option>'
                    )
                    $.each(data, function(index, slot) {
                        $('.slot[data-id="' + id_detail + '"]').append(
                            '<option value="' + slot.id_penyimpanan + '">' + slot.kode_palet + '</option>'
                        )
                    });
                },
                error: function() {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        } else {
            $slot.html('<option value="">-- Pilih Slot --</option>');
        }
    })

    $(document).ready(function() {
        $('.btn-add-penyimpanan').on('click', function(e) {

            e.preventDefault();
            var id_detail = $(this).data('id')
            var slot = $('.slot_id[' + id_detail + ']')
            var button = $('.btn-add-penyimpanan[' + id_detail + ']')
            var total = $('#total-' + id_detail).val()
            var qty = $('#qty-' + id_detail).val()
            var satuan = $('#satuan-' + id_detail).val()

            var totalQty = 0;
            $('#table-placement-' + id_detail + ' tbody tr').each(function() {
                var qty = $(this).find('input.total').val();
                totalQty += parseInt(qty)
            });

            var sisaBarang = total - totalQty

            if (total == qty || total == totalQty) {
                button.prop('disabled', true);
                alert('Tidak dapat menambahkan penyimpanan lagi.');
            } else if (!slot) {
                alert('Belum memilih lokasi penyimpanan')
            } else {
                var table = document.getElementById("table-placement-" + id_detail)
                var lastRow = table.rows[table.rows.length - 1]
                var newRow = lastRow.cloneNode(true)
                var inputs = newRow.querySelectorAll('input')
                var warehouseSelect = newRow.querySelector('.warehouse')
                var slotSelect = newRow.querySelector('.slot')

                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].value = 0
                }

                var rowNumber = parseInt(newRow.cells[0].textContent) + 1
                var dataId = id_detail + '[' + (rowNumber - 1) + ']';

                newRow.cells[0].textContent = rowNumber
                table.tBodies[0].appendChild(newRow)
                newRow.querySelector('.sisa-barang').value = sisaBarang;
                newRow.querySelector('.id-detail').value = id_detail;
                newRow.querySelector('.satuan').value = satuan;
                warehouseSelect.setAttribute('data-id', dataId);
                slotSelect.setAttribute('data-id', dataId);



            }
        })

        $('.btn-delete-row').on('click', function() {
            var id_detail = $(this).data('id')
            var table = document.getElementById("table-placement-" + id_detail)
            var btnHapus = document.getElementById("btn-hapus-" + id_detail)
            var lastRow = table.rows[table.rows.length - 1]

            if (table.rows.length - 1 > 1) {
                btnHapus.classList.remove('disabled') // hapus class disabled pada button hapus
                btnHapus.disabled = false // aktifkan button hapus
                lastRow.remove()
            }
        });
    })
</script>
@endsection

@endsection
