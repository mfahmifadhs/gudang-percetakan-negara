<?php

namespace App\Http\Controllers;

use App\Model\statusCapacity;
use App\Model\statusModel;
use App\Model\storageDetailModel;
use App\Model\storageModel;
use App\Model\warehouseCategoryModel;
use App\Model\warehouseModel;
use App\Model\warehouseStorageModel;
use Illuminate\Http\Request;

class Penyimpanan extends Controller
{
    // File View

    public function Show() {
        $storage = storageModel::orderBy('gedung_id','ASC')->get();

        return view('Pages/Penyimpanan/show', compact('storage'));
    }

    public function Detail($id) {
        $storage = storageModel::where('id_penyimpanan', $id)->first();

        return view('Pages/Penyimpanan/detail', compact('storage'));
    }

    public function Create() {
        $gedung    = warehouseModel::orderBy('nama_gedung', 'ASC')->get();
        $model     = warehouseStorageModel::get();
        $kapasitas = statusCapacity::get();

        return view('Pages/Penyimpanan/create', compact('gedung','model','kapasitas'));
    }

    public function Edit($id) {
        $gedung    = warehouseModel::orderBy('nama_gedung', 'ASC')->get();
        $model     = warehouseStorageModel::get();
        $kapasitas = statusCapacity::get();
        $storage   = storageModel::where('id_penyimpanan', $id)->first();

        return view('Pages/Penyimpanan/edit', compact('gedung','model','kapasitas','storage'));
    }

    // Process

    public function Store(Request $request) {
        $storage = new storageModel();
        $storage->gedung_id             = $request->gedung_id;
        $storage->model_id              = $request->model_id;
        $storage->kode_palet            = $request->kode_palet;
        $storage->keterangan            = $request->keterangan;
        $storage->status_kapasitas_id   = $request->status_kapasitas_id;
        $storage->save();

        return redirect()->route('storage.show')->with('success', 'Berhasil Menambah Baru');
    }

    public function Update(Request $request, $id) {
        storageModel::where('id_penyimpanan', $id)->update([
            'gedung_id'           => $request->gedung_id,
            'model_id'            => $request->model_id,
            'kode_palet'          => $request->kode_palet,
            'keterangan'          => $request->keterangan,
            'status_kapasitas_id' => $request->status_kapasitas_id,
        ]);

        return redirect()->route('storage.edit', $id)->with('success', 'Berhasil Memperbaharui');
    }

    public function Delete($id) {
        storageModel::where('id_penyimpanan',$id)->delete();

        return redirect()->route('storage.show')->with('success', 'Berhasil Menghapus');
    }
}
