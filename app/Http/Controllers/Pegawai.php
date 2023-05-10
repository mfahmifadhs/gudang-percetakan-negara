<?php

namespace App\Http\Controllers;

use App\Model\employeeModel;
use App\Model\mainunitModel;
use App\Model\statusModel;
use App\Model\userModel;
use App\Model\workunitModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Pegawai extends Controller
{
    // File View

    public function Show() {
        $employee = employeeModel::get();

        return view('Pages/Pegawai/show', compact('employee'));
    }

    public function Create() {
        $workunit = workunitModel::orderBy('kode_unit_kerja','ASC')->get();
        $status   = statusModel::get();

        return view('Pages/Pegawai/create', compact('workunit','status'));
    }

    public function Edit($id) {
        $workunit = workunitModel::orderBy('kode_unit_kerja','ASC')->get();
        $employee = employeeModel::where('id_pegawai', $id)->first();
        $status   = statusModel::get();

        return view('Pages/Pegawai/edit', compact('workunit','employee','status'));
    }

    // Process

    public function Store(Request $request) {
        $id_pegawai  = Carbon::now()->format('mdis');
        $employee = new employeeModel();
        $employee->id_pegawai    = $id_pegawai;
        $employee->unit_kerja_id = $request->unit_kerja_id;
        $employee->nip           = $request->nip;
        $employee->nama_pegawai  = $request->nama_pegawai;
        $employee->jabatan       = $request->jabatan;
        $employee->status_id     = $request->status_id;
        $employee->save();

        return redirect()->route('employee.show')->with('success', 'Berhasil Menambah Baru');
    }

    public function Update(Request $request, $id) {
        employeeModel::where('id_pegawai', $id)->update([
            'unit_kerja_id' => $request->unit_kerja_id,
            'nip'           => $request->nip,
            'nama_pegawai'  => $request->nama_pegawai,
            'jabatan'       => $request->jabatan,
            'status_id'     => $request->status_id
        ]);

        userModel::where('pegawai_id', $id)->update([
            'nip'   => $request->nip
        ]);

        return redirect()->route('employee.edit', $id)->with('success', 'Berhasil Memperbaharui');
    }

    public function Delete($id) {
        employeeModel::where('id_pegawai',$id)->delete();

        return redirect()->route('employee.show')->with('success', 'Berhasil Menghapus');
    }
}
