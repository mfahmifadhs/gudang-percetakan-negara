<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\WarehouseModel;
use App\Models\SlotModel;
use App\Models\RackModel;
use App\Models\OrderModel;
use App\Models\OrderDataModel;
use App\Models\OrderDetailModel;
use App\Models\ItemCategoryModel;
use App\Models\WorkunitModel;
use App\Models\User;

use DB;
use PDF;
use Auth;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function index()
    {
        return view('v_main.index');
    }


    public function Profile(Request $request, $aksi, $id)
    {
        if ($aksi == 'ubah') {
            $profile = User::where('id', Auth::user()->id)
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->first();
            return view('v_main.profil', compact('profile'));
        } elseif ($aksi == 'update') {
            if ($request->nip != null) {
                $cekUser    = Validator::make($request->all(), [
                    'nip'   => 'unique:users'
                ]);
                if ($cekUser->fails()) {
                    return redirect('main/profil/ubah/' . $id)->with('failed', 'Username sudah terdaftar');
                } else {

                    User::where('id', $id)
                        ->update([
                            'full_name'   => $request->full_name,
                            'workunit_id' => $request->workunit_id,
                            'nip'         => $request->nip,
                            'password'    => Hash::make($request->password),
                            'password_text' => $request->password
                        ]);
                }
            } else {
                User::where('id', $id)
                    ->update([
                        'full_name'   => $request->full_name,
                        'workunit_id' => $request->workunit_id,
                        'nip'         => $request->username_old,
                        'password'    => Hash::make($request->password),
                        'password_text' => $request->password
                    ]);
            }
            return redirect('main/profil/ubah/' . $id)->with('success', 'Berhasil menyimpan perubahan');
        }
    }

    public function warehouse(Request $request, $aksi)
    {
        if ($aksi == 'daftar') {
            //Daftar Seluruh Gudang
            $warehouses = DB::table('tbl_warehouses')
                ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
                ->orderBy('id_warehouse', 'ASC')
                ->get();

            return view('v_main.gudang', compact('warehouses'));
        }
    }
}
