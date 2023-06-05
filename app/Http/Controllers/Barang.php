<?php

namespace App\Http\Controllers;

use App\Model\statusModel;
use App\Model\storageDetailModel;
use App\Model\StorageHistory;
use App\Model\storageModel;
use App\Model\submissionDetailModel;
use App\Model\submissionModel;
use App\Model\warehouseCategoryModel;
use App\Model\warehouseModel;
use App\Model\warehouseStorageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Barang extends Controller
{
    // File View

    public function Show() {

        if (Auth::user()->role_id == 4) {
            $item = submissionDetailModel::join('t_pengajuan','id_pengajuan','pengajuan_id')
                ->where('user_id', Auth::user()->id)
                ->where('status_proses_id', 4)
                ->get();
        } else {
            $item = submissionDetailModel::join('t_pengajuan','id_pengajuan','pengajuan_id')
                ->where('status_proses_id', 4)
                ->get();
        }

        return view('Pages/Barang/show', compact('item'));
    }

    public function Detail($ctg, $id)
    {

        if ($ctg == 'masuk') {
            $item = submissionDetailModel::join('t_pengajuan','id_pengajuan','pengajuan_id')
                    ->where('id_detail', $id)
                    ->first();

            $in_stock  = storageDetailModel::where('pengajuan_detail_id', $id)->sum('total_masuk');
            $out_stock = storageDetailModel::where('pengajuan_detail_id', $id)->sum('total_keluar');
            $stock     = $in_stock - $out_stock;

            return view('pages.barang.masuk.detail', compact('item','stock'));

        } else {
            $item = StorageHistory::join('t_penyimpanan_detail','id_detail','penyimpanan_detail_id')
                ->join('t_pengajuan','id_pengajuan','pengajuan_id')
                ->where('id_riwayat', $id)
                ->first();

            $in_stock  = storageDetailModel::where('id_detail', $item->pengajuan_detail_id)->sum('total_masuk');
            $out_stock = storageDetailModel::where('id_detail', $item->pengajuan_detail_id)->sum('total_keluar');
            $stock     = $in_stock - $out_stock;

            return view('pages.barang.keluar.detail', compact('item','stock'));
        }
    }


    public function Scan($id) {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect('/');
        }
        $item = submissionDetailModel::join('t_pengajuan','id_pengajuan','pengajuan_id')
                ->where('id_detail', $id)
                ->first();

        $in_stock  = storageDetailModel::where('pengajuan_detail_id', $id)->sum('total_masuk');
        $out_stock = storageDetailModel::where('pengajuan_detail_id', $id)->sum('total_keluar');
        $stock     = $in_stock - $out_stock;

        return view('Pages/Barang/scan', compact('item','stock'));
    }

    public function Barcode(Request $request, $id) {
        $item = submissionDetailModel::join('t_pengajuan','id_pengajuan','pengajuan_id')
                ->where('id_detail', $id)
                ->first();

        $in_stock  = storageDetailModel::where('pengajuan_detail_id', $id)->sum('total_masuk');
        $out_stock = storageDetailModel::where('pengajuan_detail_id', $id)->sum('total_keluar');
        $stock     = $in_stock - $out_stock;
        $qty       = $request->qty;
        $position  = $request->position;

        return view('Pages/Barang/barcode', compact('item','stock','qty','position'));
    }

}
