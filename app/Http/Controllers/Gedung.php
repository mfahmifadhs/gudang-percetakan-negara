<?php

namespace App\Http\Controllers;

use App\Model\statusModel;
use App\Model\warehouseCategoryModel;
use App\Model\warehouseModel;
use App\Model\warehouseStorageModel;
use Illuminate\Http\Request;

class Gedung extends Controller
{
    // File View

    public function Show() {
        $gedung = warehouseModel::orderBy('nama_gedung','ASC')->get();
        return view('Pages/Gedung/show', compact('gedung'));
    }

    public function Detail($id) {
        $gedung   = warehouseModel::where('id_gedung', $id)->first();

        return view('Pages/Gedung/detail', compact('gedung'));
    }

    public function Create() {
        $kategori = warehouseCategoryModel::get();
        $status   = statusModel::get();

        return view('Pages/Gedung/create', compact('kategori','status'));
    }

    public function Edit($id) {
        $gedung   = warehouseModel::where('id_gedung', $id)->first();
        $kategori = warehouseCategoryModel::get();
        $status   = statusModel::get();

        return view('Pages/Gedung/edit', compact('gedung','kategori','status'));
    }

    // Process

    public function Store(Request $request) {
        $gedung = new warehouseModel();
        $gedung->kode_gedung = strtoupper($request->kode_gedung);
        $gedung->kategori_id = $request->kategori_id;
        $gedung->nama_gedung = $request->nama_gedung;
        $gedung->keterangan  = $request->keterangan;
        $gedung->status_id   = $request->status_id;
        $gedung->save();

        return redirect()->route('warehouse.show')->with('success', 'Berhasil Menambah Baru');
    }

    public function Update(Request $request, $id) {
        warehouseModel::where('id_gedung', $id)->update([
            'kode_gedung' => $request->id_gedung,
            'kategori_id' => $request->kategori_id,
            'nama_gedung' => $request->nama_gedung,
            'keterangan'  => $request->keterangan,
            'status_id'   => $request->status_id,
        ]);

        return redirect()->route('warehouse.edit', $id)->with('success', 'Berhasil Memperbaharui');
    }

    public function Delete($id) {
        warehouseModel::where('id_gedung',$id)->delete();

        return redirect()->route('warehouse.show')->with('success', 'Berhasil Menghapus');
    }
}
