<?php

namespace App\Http\Controllers;

use App\Model\employeeModel;
use App\Model\roleModel;
use App\Model\userModel;
use App\Model\workunitModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

class User extends Controller
{

    public function Show()
    {
        $user = userModel::get();

        return view('Pages/User/show', compact('user'));
    }

    public function Create()
    {
        $role = roleModel::get();
        $employee = employeeModel::orderBy('nama_pegawai', 'ASC')->get();

        return view('Pages/User/create', compact('role', 'employee'));
    }

    public function Edit($id)
    {
        $role     = roleModel::get();
        $employee = employeeModel::get();
        $user     = userModel::where('id', $id)->first();

        return view('Pages/User/edit', compact('role', 'employee', 'user'));
    }

    // Process

    public function Store(Request $request)
    {
        $employee  = employeeModel::where('id_pegawai', $request->pegawai_id)->first();

        $id_user  = Carbon::now()->format('mdis');
        $create   = new userModel();
        $create->id            = $id_user;
        $create->role_id       = $request->role_id;
        $create->pegawai_id    = $request->pegawai_id;
        $create->nip           = $employee->nip;
        $create->password      = Hash::make($request->password);
        $create->password_text = $request->password;
        $create->status_id     = $request->status_id;
        $create->save();

        return redirect()->route('user.show')->with('success', 'Berhasil Menambah Baru');
    }

    public function Update(Request $request, $id)
    {
        $employee  = employeeModel::where('id_pegawai', $request->pegawai_id)->first();

        userModel::where('id', $id)->update([
            'role_id'       => $request->role_id,
            'pegawai_id'    => $request->pegawai_id,
            'nip'           => $employee->nip,
            'password'      => Hash::make($request->password),
            'password_text' => $request->password,
            'status_id'     => $request->status_id
        ]);

        employeeModel::where('id_pegawai', $request->pegawai_id)->update([
            'nip' => $employee->nip
        ]);

        return redirect()->route('user.edit', $id)->with('success', 'Berhasil Memperbaharui');
    }

    public function Delete($id)
    {
        userModel::where('id', $id)->delete();

        return redirect()->route('user.show')->with('success', 'Berhasil Menghapus');
    }
}
