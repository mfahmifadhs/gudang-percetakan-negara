<?php

namespace App\Http\Controllers;

use App\Model\mainunitModel;
use App\Model\statusModel;
use App\Model\warehouseCategoryModel;
use App\Model\warehouseModel;
use App\Model\warehouseStorageModel;
use Illuminate\Http\Request;

class UnitUtama extends Controller
{
    // File View

    public function Show() {
        $mainunit = mainunitModel::orderBy('id_unit_utama','ASC')->get();

        return view('Pages/UnitUtama/show', compact('mainunit'));
    }

    public function Create() {
        return view('Pages/UnitUtama/create');
    }

    public function Edit($id) {
        $mainunit = mainunitModel::where('id_unit_utama', $id)->first();

        return view('Pages/UnitUtama/edit', compact('mainunit'));
    }

    // Process

    public function Store(Request $request) {
        $mainunit = new mainunitModel();
        $mainunit->kode_unit_utama = $request->kode_unit_utama;
        $mainunit->nama_unit_utama = $request->nama_unit_utama;
        $mainunit->save();

        return redirect()->route('mainunit.show')->with('success', 'Berhasil Menambah Baru');
    }

    public function Update(Request $request, $id) {
        mainunitModel::where('id_unit_utama', $id)->update([
            'kode_unit_utama' => $request->kode_unit_utama,
            'nama_unit_utama' => $request->nama_unit_utama
        ]);

        return redirect()->route('mainunit.edit', $id)->with('success', 'Berhasil Memperbaharui');
    }

    public function Delete($id) {
        mainunitModel::where('id_unit_utama',$id)->delete();

        return redirect()->route('mainunit.show')->with('success', 'Berhasil Menghapus');
    }
}
