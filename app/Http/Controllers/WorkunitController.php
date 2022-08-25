<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AppLetterModel;
use App\Models\SlotModel;
use App\Models\RackModel;
use App\Models\OrderModel;
use App\Models\OrderDataModel;
use App\Models\OrderDetailModel;
use App\Models\ItemCategoryModel;
use App\Models\WorkunitModel;
use App\Models\User;

use DB;
use Auth;
use Hash;
use Str;
use PDF;
use Validator;
use Carbon\Carbon;


class WorkunitController extends Controller
{

	public function index()
	{
		return view('v_main.index');
	}

    /*===============================================================
                            PEMBUATAN SURAT
    ===============================================================*/

    public function showLetter(Request $request, $aksi, $id)
    {
        if ($aksi == 'pengajuan' ) {
            // Buat surat pengajuan
            return view('v_workunit.tambah_surat_pengajuan');

        }elseif($aksi == 'tambah-pengajuan'){
            // Tambah Surat Pengajuan
            $appletter = new AppLetterModel();

            $appletter->id_app_letter       = $request->input('id');
            $appletter->workunit_id         = Auth::user()->workunit_id;
            $appletter->appletter_purpose   = $request->input('purpose');
            $appletter->appletter_num       = strtolower($request->input('letter_num'));
            $appletter->appletter_ctg       = strtolower($request->input('category'));
            $appletter->appletter_regarding = strtolower($request->input('regarding'));
            $appletter->appletter_text      = $request->input('text');
            $appletter->appletter_date      = $request->input('date');
            $appletter->appletter_status    = 'proses';
            $appletter->save();

            return redirect('unit-kerja/surat/detail-surat-pengajuan/'. $request->id)->with('success','Berhasil membuat surat pengajuan');

        }elseif($aksi == 'detail-surat-pengajuan'){
            $appletter = DB::table('tbl_appletters')
                            ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_appletters.workunit_id')
                            ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                            ->where('id_app_letter', $id)->first();
            return view('v_workunit.detail_surat_pengajuan', compact('appletter'));

        }elseif($aksi == 'daftar-surat-pengajuan'){
            // Daftar Surat Pengajuan
            $appletter = DB::table('tbl_appletters')
                            ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_appletters.workunit_id')
                            ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                            ->where('workunit_id', Auth::user()->workunit_id)
                            ->get();
            return view('v_workunit.daftar_surat_pengajuan', compact('appletter'));

        }elseif($aksi == 'perintah'){
            if($id == 'penyimpanan'){
                $item_ctg = DB::table('tbl_items_category')->get();
                return view('v_workunit.tambah_surat_perintah_penyimpanan', compact('item_ctg'));
            }else{
                return view('tambah_surat_perintah_pengeluaran');
            }
        }
    }


	// =================================
	// 			  Warehouse
	// =================================

	public function showWarehouse()
	{
		$warehouse  = DB::table('tbl_warehouses')
                        ->join('tbl_status','tbl_status.id_status','tbl_warehouses.status_id')
                        ->orderby('status_id', 'ASC')
                        ->get();
        $model      = DB::table('tbl_warehouses')
                        ->select('warehouse_category',DB::raw('count(id_warehouse) as totalwarehouse'))
                        ->groupBy('warehouse_category')
                        ->get();

		return view('v_workunit.show_warehouse', compact('warehouse','model'));
	}

	public function detailWarehouse(Request $request, $id)
    {
        $warehouse      = DB::table('tbl_warehouses')
                            ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
                            ->where('id_warehouse', $id)
                            ->get();
        $slot 			= DB::table('tbl_slots')
        					->join('tbl_warehouses','tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
        					->where('id_warehouse', $id)
        					->get();
        $warehouse09b   = DB::table('tbl_warehouses')
                            ->join('tbl_status','tbl_status.id_status','tbl_warehouses.status_id')
                            ->where('id_warehouse', 'G09B')
                            ->get();

        $warehouse05b   = DB::table('tbl_warehouses')
                            ->join('tbl_status','tbl_status.id_status','tbl_warehouses.status_id')
                            ->where('id_warehouse', 'G05B')
                            ->get();
        $pallet         = DB::table('tbl_slots_names')
                            ->join('tbl_slots','tbl_slots.id_slot','tbl_slots_names.pallet_id')
                            ->get();

        // SELECT RACK

        $rack_pallet_one_lvl1   = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'I')
                                    ->where('rack_level', 'Bawah')
                                    ->get();
        $rack_pallet_one_lvl2   = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'I')
                                    ->where('rack_level', 'Atas')
                                    ->get();
        $rack_pallet_two_lvl1   = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'II')
                                    ->where('rack_level', 'Bawah')
                                    ->get();
        $rack_pallet_two_lvl2   = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'II')
                                    ->where('rack_level', 'Atas')
                                    ->get();
        $rack_pallet_three_lvl1 = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'III')
                                    ->where('rack_level', 'Bawah')
                                    ->get();
        $rack_pallet_three_lvl2 = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'III')
                                    ->where('rack_level', 'Atas')
                                    ->get();

        $rack_pallet_four_lvl1  = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'IV')
                                    ->where('rack_level', 'Bawah')
                                    ->get();
        $rack_pallet_four_lvl2  = DB::table('tbl_rack_details')
                                    ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_rack_details.id_slot_rack')
                                    ->where('rack_id', 'IV')
                                    ->where('rack_level', 'Atas')
                                    ->get();

        return view('v_workunit.detail_warehouse',
            compact('warehouse','slot','warehouse09b','warehouse05b','pallet', 'rack_pallet_one_lvl1','rack_pallet_one_lvl2',
                'rack_pallet_two_lvl1','rack_pallet_two_lvl2','rack_pallet_three_lvl1','rack_pallet_three_lvl2',
                'rack_pallet_four_lvl1','rack_pallet_four_lvl2',));
    }

    public function detailSlot($id)
    {
        $slot   = DB::table('tbl_slots')
                    ->join('tbl_warehouses','tbl_warehouses.id_warehouse','tbl_slots.warehouse_id')
                    ->where('id_slot', $id)
                    ->get();
        return view('v_workunit.detail_slot', compact('slot'));
    }

    // =================================
	// 	  Warrent (Surat Perintah)
	// =================================

	public function showWarrent()
	{
		$warrent  = DB::table('tbl_warrents')
                        ->where('workunit_id', Auth::user()->workunit_id)
                        ->get();

		return view('v_workunit.show_warrent', compact('warrent'));
	}

    // =================================
	// 	            JSON
	// =================================

    public function showJson($aksi)
    {
        if($aksi == 'more-pallet')
        {
            $category 	= DB::table('tbl_items_category')->get();
	        $array['category'] 	= $category;

	        return response()->json($array);
        }
    }

}
