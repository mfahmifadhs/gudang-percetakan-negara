<?php

namespace App\Http\Controllers;

use App\Model\statusModel;
use App\Model\warehouseCategoryModel;
use App\Model\warehouseModel;
use App\Model\warehouseStorageModel;
use Illuminate\Http\Request;

class ModelPenyimpanan extends Controller
{
    // File View

    public function Show() {
        $model = warehouseStorageModel::orderBy('nama_model','ASC')->get();
        return view('Pages/ModelPenyimpanan/show', compact('model'));
    }

    public function Create() {
        return view('Pages/ModelPenyimpanan/create');
    }

    public function Edit($id) {
        $model = warehouseStorageModel::where('id_model', $id)->first();
        return view('Pages/ModelPenyimpanan/edit', compact('model'));
    }

    // Process

    public function Store(Request $request) {
        $model = new warehouseStorageModel();
        $model->nama_model = $request->nama_model;
        $model->keterangan = $request->keterangan;
        $model->save();

        return redirect()->route('storageModel.show')->with('success', 'Berhasil Menambah Baru');
    }

    public function Update(Request $request, $id) {
        warehouseStorageModel::where('id_model', $id)->update([
            'nama_model' => $request->nama_model,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('storageModel.edit', $id)->with('success', 'Berhasil Memperbaharui');
    }

    public function Delete($id) {
        warehouseStorageModel::where('id_model',$id)->delete();

        return redirect()->route('storageModel.show')->with('success', 'Berhasil Menghapus');
    }
}
