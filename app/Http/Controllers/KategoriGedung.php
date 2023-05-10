<?php

namespace App\Http\Controllers;

use App\Model\statusModel;
use App\Model\warehouseCategoryModel;
use App\Model\warehouseModel;
use App\Model\warehouseStorageModel;
use Illuminate\Http\Request;

class KategoriGedung extends Controller
{
    // File View

    public function Show() {
        $kategori = warehouseCategoryModel::orderBy('nama_kategori','ASC')->get();
        return view('Pages/KategoriGedung/show', compact('kategori'));
    }

    public function Create() {
        return view('Pages/KategoriGedung/create');
    }

    public function Edit($id) {
        $kategori = warehouseCategoryModel::where('id_kategori', $id)->first();

        return view('Pages/KategoriGedung/edit', compact('kategori'));
    }

    // Process

    public function Store(Request $request) {
        $kategori = new warehouseCategoryModel();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->keterangan    = $request->keterangan;
        $kategori->save();

        return redirect()->route('warehouseCategory.show')->with('success', 'Berhasil Menambah Baru');
    }

    public function Update(Request $request, $id) {
        warehouseCategoryModel::where('id_kategori', $id)->update([
            'nama_kategori' => $request->nama_kategori,
            'keterangan'    => $request->keterangan
        ]);

        return redirect()->route('warehouseCategory.edit', $id)->with('success', 'Berhasil Memperbaharui');
    }

    public function Delete($id) {
        warehouseCategoryModel::where('id_kategori',$id)->delete();

        return redirect()->route('warehouseCategory.show')->with('success', 'Berhasil Menghapus');
    }
}
