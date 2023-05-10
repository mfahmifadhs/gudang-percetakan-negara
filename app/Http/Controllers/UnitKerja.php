<?php

namespace App\Http\Controllers;

use App\Model\mainunitModel;
use App\Model\workunitModel;
use Illuminate\Http\Request;

class UnitKerja extends Controller
{
    // File View

    public function Show() {
        $workunit = workunitModel::orderBy('id_unit_kerja','DESC')->get();

        return view('Pages/UnitKerja/show', compact('workunit'));
    }

    public function Create() {
        $mainunit = mainunitModel::orderBy('kode_unit_utama','ASC')->get();
        return view('Pages/UnitKerja/create', compact('mainunit'));
    }

    public function Edit($id) {
        $mainunit = mainunitModel::orderBy('kode_unit_utama','ASC')->get();
        $workunit = workunitModel::where('id_unit_kerja', $id)->first();

        return view('Pages/UnitKerja/edit', compact('mainunit','workunit'));
    }

    // Process

    public function Store(Request $request) {
        $workunit = new workunitModel();
        $workunit->unit_utama_id   = $request->unit_utama_id;
        $workunit->kode_unit_kerja = $request->kode_unit_kerja;
        $workunit->nama_unit_kerja = $request->nama_unit_kerja;
        $workunit->save();

        return redirect()->route('workunit.show')->with('success', 'Berhasil Menambah Baru');
    }

    public function Update(Request $request, $id) {
        workunitModel::where('id_unit_kerja', $id)->update([
            'unit_utama_id'   => $request->unit_utama_id,
            'kode_unit_kerja' => $request->kode_unit_kerja,
            'nama_unit_kerja' => $request->nama_unit_kerja
        ]);

        return redirect()->route('workunit.edit', $id)->with('success', 'Berhasil Memperbaharui');
    }

    public function Delete($id) {
        workunitModel::where('id_unit_kerja',$id)->delete();

        return redirect()->route('workunit.show')->with('success', 'Berhasil Menghapus');
    }
}
