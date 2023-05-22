<?php

namespace App\Http\Controllers;

use App\Model\Bast;
use App\Model\employeeModel;
use App\Model\statusCapacity;
use App\Model\statusModel;
use App\Model\storageDetailModel;
use App\Model\StorageHistory;
use App\Model\storageModel;
use App\Model\submissionModel;
use App\Model\submissionDetailModel;
use App\Model\SubmissionStaff;
use App\Model\warehouseCategoryModel;
use App\Model\warehouseModel;
use App\Model\warehouseStorageModel;
use App\Model\workunitModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Auth;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class Pengajuan extends Controller
{
    // File View

    public function Show()
    {
        if (Auth::user()->role_id == 4) {
            $submission = submissionModel::orderBy('status_pengajuan_id', 'ASC')
                ->orderBy('status_proses_id', 'ASC')
                ->orderBy('tanggal_pengajuan', 'DESC')
                ->where('user_id', Auth::user()->id)
                ->get();
        } else {
            $submission = submissionModel::orderBy('status_pengajuan_id', 'ASC')
                ->orderBy('status_proses_id', 'ASC')
                ->orderBy('tanggal_pengajuan', 'DESC')
                ->get();
        }

        return view('Pages/Pengajuan/show', compact('submission'));
    }

    public function Detail($id)
    {
        $data     = submissionModel::where('id_pengajuan', $id)->first();

        if ($data->penyimpanan->count() == $data->penyimpanan->where('jenis_barang_id', '441')->count()) {
            $catatan = 'NUP';
        } else if ($data->penyimpanan->count() == $data->penyimpanan->where('jenis_barang_id', '442')->count()) {
            $catatan = 'Masa Kadaluarsa';
        } else {
            $catatan = 'Catatan';
        }

        return view('Pages/Pengajuan/detail', compact('data', 'catatan'));
    }

    public function Barcode(Request $request, $id) {
        $item = submissionDetailModel::join('t_pengajuan','id_pengajuan','pengajuan_id')
                ->where('pengajuan_id', $id)
                ->get();

        $in_stock  = storageDetailModel::where('pengajuan_detail_id', $id)->sum('total_masuk');
        $out_stock = storageDetailModel::where('pengajuan_detail_id', $id)->sum('total_keluar');
        $stock     = $in_stock - $out_stock;
        $qty       = $request->qty;
        $position  = $request->position;

        return view('Pages/Pengajuan/barcode', compact('item','stock','qty','position'));
    }

    public function Create(Request $request, $category)
    {
        $item      = [];
        $workunit  = workunitModel::where('id_unit_kerja', Auth::user()->pegawai->unit_kerja_id)->get();
        $employee  = employeeModel::get();

        if ($category == 'pengambilan') {
            $item = storageDetailModel::where('unit_kerja_id', Auth::user()->pegawai->unit_kerja_id)
                ->join('t_pengajuan_detail', 't_pengajuan_detail.id_detail', 'pengajuan_detail_id')
                ->join('t_pengajuan', 'id_pengajuan', 'pengajuan_id')
                ->select('t_penyimpanan_detail.id_detail as stg_detail_id', 't_pengajuan_detail.id_detail as sub_detail_id',
                         't_pengajuan_detail.keterangan','t_pengajuan.*','t_pengajuan_detail.*','t_penyimpanan_detail.*')
                ->get();
        }

        return view('Pages/Pengajuan/create', compact('workunit', 'employee', 'category', 'item'));
    }

    public function Edit($id)
    {
        $submission = submissionModel::where('id_pengajuan', $id)->first();
        $workunit   = workunitModel::get();

        return view('Pages/Pengajuan/edit', compact('submission', 'workunit'));
    }

    public function Preview(Request $request, $category)
    {
        if ($category == 'edit') {

        } else {
            $category  = 'preview';
            $workunit  = workunitModel::where('id_unit_kerja', Auth::user()->pegawai->unit_kerja_id)->get();
            $employee  = employeeModel::get();
            $data      = $request->all();

            $suratPengajuan = $request->file('surat_pengajuan');
            $suratPerintah  = $request->file('surat_perintah');
            $file['surat_pengajuan'] = $suratPengajuan ? $request->surat_pengajuan : null;
            $file['surat_perintah']  = $suratPerintah ? $request->surat_perintah : null;
            $resFile = $file;

            $list_pengajuan  = submissionModel::count();
            $total_pengajuan = str_pad($list_pengajuan + 1, 4, 0, STR_PAD_LEFT);
            $id_pengajuan    = Carbon::now()->isoFormat('DDMMYY').$total_pengajuan;

            $create = new submissionModel();
            $create->id_pengajuan      = $id_pengajuan;
            $create->user_id           = Auth::user()->id;
            $create->pegawai_id        = Auth::user()->pegawai_id;
            $create->unit_kerja_id     = $request->unit_kerja_id;
            $create->jenis_pengajuan   = $request->jenis_pengajuan;
            $create->tanggal_pengajuan = $request->tanggal_pengajuan;
            $create->keterangan        = $request->keterangan;
            $create->status_proses_id  = 1;
            $create->created_at        = Carbon::now();
            $create->save();

            $submission = submissionModel::where('id_pengajuan', $id_pengajuan)->first();
            if (!$submission->surat_pengajuan && $request->surat_pengajuan) {
                $file  = $request->file('surat_pengajuan');
                $filename = $file->getClientOriginalName();
                $surat = $file->storeAs('public/files/surat_pengajuan', $filename);
                $surat_pengajuan = Crypt::encrypt($surat);
                submissionModel::where('id_pengajuan', $id_pengajuan)->update(['surat_pengajuan' => $surat_pengajuan]);
            }

            if (!$submission->surat_perintah && $request->surat_perintah) {
                $file  = $request->file('surat_perintah');
                $filename = $file->getClientOriginalName();
                $surat = $file->storePubliclyAs('public/files/surat_perintah', $filename);
                $surat_perintah = Crypt::encrypt($surat);

                submissionModel::where('id_pengajuan', $id_pengajuan)->update(['surat_perintah' => $surat_perintah]);
            }

            $resItem   = [];
            foreach ($request->file('file_barang') as $key => $file) {
                $fileArr = Excel::toArray([], $file);
                foreach ($fileArr as $dataKey => $fileData) {
                    $kodeForm = $fileArr[$dataKey][1][1];
                    if ($kodeForm == 101) {
                        $dataItem = [];
                        $arrItem  = array_slice($fileArr[$dataKey], 5);
                        foreach ($arrItem as $row) {
                            if (empty(array_filter($row))) {
                                continue;
                            }
                            $dataItem[] = [
                                'nama_barang' => $row[1],
                                'nup'         => $row[2],
                                'jumlah'      => $row[3],
                                'satuan'      => 'unit',
                                'kondisi'     => $row[4],
                                'deskripsi'   => $row[5],
                                'tahun'       => $row[6],
                                'keterangan'  => $row[7]
                            ];

                            $detail = new submissionDetailModel();
                            $detail->pengajuan_id       = $id_pengajuan;
                            $detail->jenis_barang_id    = 441;
                            $detail->nama_barang        = $row[1];
                            $detail->catatan            = $row[2];
                            $detail->keterangan         = $row[7];
                            $detail->deskripsi          = $row[5];
                            $detail->kondisi_barang     = $row[4];
                            $detail->tahun_perolehan    = $row[6];
                            $detail->jumlah_pengajuan   = $row[3];
                            $detail->satuan             = 'unit';
                            $detail->created_at         = Carbon::now();
                            $detail->save();
                        }
                        $resItem = $dataItem;
                    }

                    if ($kodeForm == 102) {
                        $dataItem = [];
                        $arrItem  = array_slice($fileArr[$dataKey], 5);
                        foreach ($arrItem as $row) {
                            if (empty(array_filter($row))) {
                                continue;
                            }
                            $dataItem[] = [
                                'nama_barang' => $row[1],
                                'jumlah'      => $row[2],
                                'satuan'      => $row[3],
                                'deskripsi'   => $row[4],
                                'tahun'       => $row[5],
                                'expired'     => $row[6],
                                'keterangan'  => $row[7]
                            ];

                            $detail = new submissionDetailModel();
                            $detail->pengajuan_id       = $id_pengajuan;
                            $detail->jenis_barang_id    = 442;
                            $detail->nama_barang        = $row[1];
                            $detail->catatan            = $row[2];
                            $detail->keterangan         = $row[7];
                            $detail->deskripsi          = $row[4];
                            $detail->kondisi_barang     = 'Baik';
                            $detail->tahun_perolehan    = $row[5];
                            $detail->jumlah_pengajuan   = $row[2];
                            $detail->satuan             = $row[3];
                            $detail->created_at         = Carbon::now();
                            $detail->save();
                        }
                        $resItem = $dataItem;
                    }
                    $dataArr['total_file']   = count($request->file('file_barang'));
                    $dataArr['kode_form']    = $kodeForm;
                    $dataArr['data_barang']  = $resItem;
                    $resArr[] = $dataArr;
                }
            }
        }

        $pengajuan = submissionModel::where('id_pengajuan', $id_pengajuan)->first();

        return redirect()->route('submission.detail', $id_pengajuan)->with('success', 'Berhasil Membuat Pengajuan');
    }

    // Process

    public function Store(Request $request, $category)
    {
        $id_pengajuan = $request->id_pengajuan;
        // $id_pengajuan = Carbon::now()->isoFormat('DMYYsmh');

        // $create = new submissionModel();
        // $create->id_pengajuan      = $id_pengajuan;
        // $create->user_id           = Auth::user()->id;
        // $create->pegawai_id        = Auth::user()->pegawai_id;
        // $create->unit_kerja_id     = $request->unit_kerja_id;
        // $create->jenis_pengajuan   = $request->jenis_pengajuan;
        // $create->tanggal_pengajuan = $request->tanggal_pengajuan;
        // $create->keterangan        = $request->keterangan;
        // $create->status_proses_id  = 1;
        // $create->created_at        = Carbon::now();
        // $create->save();

        $submission = submissionModel::where('id_pengajuan', $id_pengajuan)->first();
        if (!$submission->surat_pengajuan && $request->surat_pengajuan) {
            $file  = $request->file('surat_pengajuan');
            $filename = $file->getClientOriginalName();
            $surat = $file->storeAs('public/files/surat_pengajuan', $filename);
            $surat_pengajuan = Crypt::encrypt($surat);
            submissionModel::where('id_pengajuan', $id_pengajuan)->update(['surat_pengajuan' => $surat_pengajuan]);
        }

        if (!$submission->surat_perintah && $request->surat_perintah) {
            $file  = $request->file('surat_perintah');
            $filename = $file->getClientOriginalName();
            $surat = $file->storePubliclyAs('public/files/surat_perintah', $filename);
            $surat_perintah = Crypt::encrypt($surat);

            submissionModel::where('id_pengajuan', $id_pengajuan)->update(['surat_perintah' => $surat_perintah]);
        }

        if ($category == 'preview') {
            foreach ($request->jenis_barang as $i => $jenis_barang_id) {
                $detail = new submissionDetailModel();
                $detail->pengajuan_id       = $id_pengajuan;
                $detail->jenis_barang_id    = $jenis_barang_id;
                $detail->nama_barang        = $request->nama_barang[$i];
                $detail->catatan            = $request->catatan[$i];
                $detail->keterangan         = $request->keterangan_barang[$i];
                $detail->deskripsi          = $request->deskripsi[$i];
                $detail->kondisi_barang     = $request->kondisi[$i];
                $detail->tahun_perolehan    = $request->tahun_perolehan[$i];
                $detail->jumlah_pengajuan   = $request->jumlah[$i];
                $detail->satuan             = $request->satuan[$i];
                $detail->created_at         = Carbon::now();
                $detail->save();
            }


        } elseif ($category == 'pengambilan') {
            foreach ($request->penyimpanan_detail_id as $i => $detail_id) {
                if ($request->jumlah[$i] != 0) {
                    $riwayat = new StorageHistory();
                    $riwayat->pengajuan_id          = $id_pengajuan;
                    $riwayat->penyimpanan_detail_id = $detail_id;
                    $riwayat->jumlah                = $request->jumlah[$i];
                    $riwayat->kategori              = 'keluar';
                    $riwayat->created_at            = Carbon::now();
                    $riwayat->save();

                    $penyimpanan = storageDetailModel::where('id_detail', $detail_id)->first();
                    storageDetailModel::where('id_detail', $detail_id)->update([
                        'total_keluar' => (int) ($penyimpanan->total_keluar + $request->jumlah[$i])
                    ]);
                }

            }
        }
        return redirect()->route('submission.detail', $id_pengajuan)->with('success', 'Berhasil Membuat Pengajuan');

    }

    public function Update(Request $request, $id)
    {
        try {
            submissionModel::where('id_pengajuan', $id)->update([
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
                'keterangan'        => $request->keterangan,
            ]);

            foreach ($request->id_barang as $i => $id_barang) {
                submissionDetailModel::where('id_detail', $id_barang)->update([
                    'nama_barang'      => $request->nama_barang[$i],
                    'catatan'          => $request->catatan[$i],
                    'deskripsi'        => $request->deskripsi[$i],
                    'jumlah_pengajuan' => $request->jumlah[$i],
                    'satuan'           => $request->satuan[$i],
                    'keterangan'       => $request->keterangan_barang[$i],
                ]);
            }

            $submission = submissionModel::where('id_pengajuan', $id)->first();
            if (!$submission->surat_pengajuan && $request->surat_pengajuan) {
                $file  = $request->file('surat_pengajuan');
                $filename = $file->getClientOriginalName();
                $surat = $file->storeAs('public/files/surat_pengajuan', $filename);
                $surat_pengajuan = Crypt::encrypt($surat);
                submissionModel::where('id_pengajuan', $id)->update(['surat_pengajuan' => $surat_pengajuan]);
            }

            if (!$submission->surat_perintah && $request->surat_perintah) {
                $file  = $request->file('surat_perintah');
                dd($file);
                $filename = $file->getClientOriginalName();
                $surat = $file->storePubliclyAs('public/files/surat_perintah', $filename);
                $surat_perintah = Crypt::encrypt($surat);

                submissionModel::where('id_pengajuan', $id)->update(['surat_perintah' => $surat_perintah]);
            }

            return redirect()->route('submission.detail', $id)->with('success', 'Berhasil Memperbaharui');
        } catch (Exception $e) {
            return redirect()->route('submission.detail', $id)->with('failed', 'Terjadi kesalahan, mohon periksa kembali ukuran atau format file');
        }
    }

    public function Delete($id)
    {
        storageModel::where('id_penyimpanan', $id)->delete();

        return redirect()->route('storage.show')->with('success', 'Berhasil Menghapus');
    }

    // 1. PERSETUJUAN ========================

    public function Check($id)
    {
        $data = submissionModel::where('id_pengajuan', $id)->first();

        if ($data->penyimpanan->count() == $data->penyimpanan->where('jenis_barang_id', '441')->count()) {
            $catatan = 'NUP';
        } else if ($data->penyimpanan->count() == $data->penyimpanan->where('jenis_barang_id', '442')->count()) {
            $catatan = 'Masa Kadaluarsa';
        } else {
            $catatan = 'Catatan';
        }

        return view('Pages/Pengajuan/verify', compact('data','catatan'));
    }

    public function CheckStore(Request $request, $id)
    {
        if ($request->status == 'true') {
            submissionModel::where('id_pengajuan', $id)->update([
                'keterangan_proses'     => $request->catatan,
                'status_pengajuan_id'   => 1,
                'status_proses_id'      => 2
            ]);
        } else {
            submissionModel::where('id_pengajuan', $id)->update([
                'keterangan_proses'     => $request->catatan,
                'status_pengajuan_id'   => 2,
                'status_proses_id'      => null,
            ]);
        }

        if ($request->category == 'masuk') {
            $barang = $request->id_barang;
            foreach ($barang as $i => $id_barang)
            {
                submissionDetailModel::where('id_detail', $id_barang)->update([
                    'jumlah_disetujui'  => $request->status_barang[$i] ? $request->jumlah[$i] : 0,
                    'status'            => $request->status_barang[$i] ? 'true' : 'false',
                ]);
            }
        }

        return redirect()->route('submission.show')->with('success', 'Berhasil Melakukan Verifikasi');
    }

    // 2. PENAPISAN ========================

    public function Filter($id)
    {
        $data        = submissionModel::where('id_pengajuan', $id)->first();
        return view('Pages/Pengajuan/filter', compact('data'));
    }

    public function FilterStore(Request $request, $id)
    {
        submissionModel::where('id_pengajuan', $id)->update([
            'keterangan_ketidaksesuaian' => $request->catatan,
            'status_proses_id'  => 3
        ]);

        $staff = new SubmissionStaff();
        $staff->pengajuan_id = $id;
        $staff->nama_petugas = $request->nama_petugas;
        $staff->jabatan      = $request->jabatan_petugas;
        $staff->nomor_mobil  = strtoupper($request->nomor_mobil);
        $staff->created_at   = Carbon::parse($request->tanggal_datang)->isoFormat('YYYY-MM-DD hh:mm:ss');
        $staff->save();

        if ($request->category == 'masuk') {
            $barang = $request->id_barang;
            foreach ($barang as $i => $id_barang)
            {
                $detail = submissionDetailModel::where('id_detail', $id_barang)->first();
                if ($detail->jumlah_diterima == $request->jumlah[$i]) {
                    $penapisan = 'sesuai';
                } else {
                    $penapisan = 'tidak sesuai';
                }

                submissionDetailModel::where('id_detail', $id_barang)->update([
                    'jumlah_diterima'          => $request->jumlah[$i],
                    'keterangan_kesesuaian'    => $penapisan
                ]);
            }
        }

        return redirect()->route('submission.show')->with('success', 'Berhasil Melakukan Penapisan');

    }

    // 3. PROSES PENYIMPANAN / PENGAMBILAN ========================

    public function Process($id)
    {
        $data      = submissionModel::where('id_pengajuan', $id)->first();
        $warehouse = warehouseModel::where('status_id',1)->orderBy('nama_gedung','ASC')->get();
        return view('Pages/Pengajuan/process', compact('data','warehouse'));
    }

    public function ProcessStore(Request $request, $id)
    {
        if ($request->category == 'masuk') {
            $total_item = $request->slot_id;
            $total_item_count = count(array_filter($total_item));

            if ($request->warehouse_all_id == null && $total_item_count == null) {
                return back()->with('failed', 'Tidak ada lokasi penyimpanan yang dipilih');
            }

            if ($request->warehouse_all_id != null && $total_item_count != null) {
                // Penempatan barang
                $totals = [];
                foreach ($request->id_detail as $i => $id) {
                    if (!isset($totals[$i])) {
                        $totals[$i] = 0;
                    }
                    $totals[$i] += $request->qty[$i];
                }

                foreach ($totals as $i => $total) {
                    $item = submissionDetailModel::where('id_detail', $id)->first();

                    if ($item->jumlah_diterima != $total) {
                        return back()->with('failed', 'Penempatan barang tidak sesuai dengan jumlah, mohon periksa kembali');
                    }
                }
            }

            submissionModel::where('id_pengajuan', $id)->update([
                'batas_waktu'       => $request->batas_waktu,
                'status_proses_id'  => 4
            ]);

            $barang = $request->id_detail;
            foreach ($barang as $i => $pengajuan_detail_id)
            {
                $id_detail = storageDetailModel::insertGetId([
                    'penyimpanan_id'      => $request->slot_all_id ? $request->slot_all_id : $request->slot_id[$i],
                    'pengajuan_detail_id' => $pengajuan_detail_id,
                    'total_masuk'         => $request->qty[$i],
                    'created_at'          => Carbon::now()
                ]);

                $history    = new StorageHistory();
                $history->pengajuan_id          = $id;
                $history->penyimpanan_detail_id = $id_detail;
                $history->jumlah                = $request->qty[$i];
                $history->created_at            = Carbon::now();
                $history->save();
            }
        } else {
            submissionModel::where('id_pengajuan', $id)->update([
                'status_proses_id'  => 4
            ]);
        }

        $total_bast = Bast::count();
        $no_bast    = str_pad($total_bast + 1, 4, 0, STR_PAD_LEFT);
        $month      = Carbon::now()->isoFormat('MM/Y');
        $id_bast    = 'KR.02.04/2/'.$no_bast.'/'.$month;

        $bast = new Bast();
        $bast->id_berita_acara = Carbon::now()->isoFormat('DMYYsmh');
        $bast->pengajuan_id    = $id;
        $bast->nomor_surat     = $id_bast;
        $bast->created_at      = Carbon::now();
        $bast->save();

        return redirect()->route('submission.show')->with('success', 'Berhasil Memproses Barang');

    }

    // AJAX ========================

    public function GetSlotByWarehouse(Request $request)
    {
        $result = storageModel::where('gedung_id', $request->id_gedung)->get();
        return response()->json($result);
    }
}
