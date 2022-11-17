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
use Carbon\Carbon;

class MainController extends Controller
{
    public function index()
    {
        return view('v_main.index');
    }

    public function warehouse(Request $request, $aksi)
    {
        if($aksi == 'daftar') {
            //Daftar Seluruh Gudang
            $warehouses = DB::table('tbl_warehouses')
                            ->join('tbl_status','tbl_status.id_status','tbl_warehouses.status_id')
                            ->orderBy('id_warehouse','ASC')
                            ->get();

            return view('v_main.gudang', compact('warehouses'));

        }
    }
}
