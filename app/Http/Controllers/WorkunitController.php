<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\AppLetterModel;
use App\Models\AppLetterEntryModel;
use App\Models\AppLetterExitModel;
use App\Models\WarrentModel;
use App\Models\WarrentEntryModel;
use App\Imports\ImportItem;
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

    // =====================================
    //             SURAT PERINTAH
    // =====================================

    public function showWarrent(Request $request, $aksi, $id)
    {
        if ($aksi == 'daftar') {
            $warrent  = DB::table('tbl_warrents')
                            ->join('tbl_workunits','id_workunit','workunit_id')
                            ->where('workunit_id', Auth::user()->workunit_id)
                            ->get();

            return view('v_workunit.daftar_surat_perintah', compact('warrent'));

        } elseif ($aksi == 'detail') {
            $warrent    = DB::table('tbl_warrents')
                            ->join('tbl_workunits','id_workunit','workunit_id')
                            ->join('tbl_mainunits','id_mainunit','mainunit_id')
                            ->where('id_warrent', $id)
                            ->first();
            if ($warrent->warr_purpose == 'penyimpanan') {
                $item   = DB::table('tbl_warrents_entry')
                            ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                            ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                            ->where('warrent_id', $id)
                            ->get();
            } else {

            }

            return view('v_workunit.detail_surat_perintah', compact('warrent','item'));

        } elseif ($aksi == 'penyimpanan') {
            $appletter  = DB::table('tbl_appletters')->join('tbl_workunits','id_workunit','workunit_id')->first();
            $item       = DB::table('tbl_appletters_detail')
                            ->join('tbl_appletters', 'id_app_letter', 'appletter_id')
                            ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                            ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                            ->where('appletter_id', $id)
                            ->get();

            return view('v_workunit.tambah_surat_perintah', compact('aksi','appletter','item'));
        } elseif ($aksi == 'pengeluaran') {

        } elseif ($aksi == 'proses') {
            if ($id == 'penyimpanan') {
                // Buat Surat Perintah Penyimpanan
                $warrent   = new WarrentModel();
                $file      = $request->file('upload_warr');
                $filename  = $request->upload_warr->getClientOriginalName();
                $request->upload_warr->move('data_file/surat_perintah/', $filename);
                $warrent->id_warrent         = $request->input('id_warrent');
                $warrent->appletter_id       = $request->input('appletter_id');
                $warrent->workunit_id        = Auth::user()->workunit_id;
                $warrent->warr_emp_name      = $request->input('warr_emp_name');
                $warrent->warr_emp_position  = $request->input('warr_emp_position');
                $warrent->warr_file          = $filename;
                $warrent->warr_purpose       = 'penyimpanan';
                $warrent->warr_total_item    = $request->input('total_item');
                $warrent->warr_date          = Carbon::now();
                $warrent->warr_status        = 'proses';
                $warrent->save();

                // Buat Surat Perintah Penyimpanan Barang
                $item        = new WarrentEntryModel();
                $idWarrEntry = $request->id_warr_entry;
                foreach($idWarrEntry as $i => $warrEntry) {
                    $item->id_warr_entry        = $warrEntry;
                    $item->warrent_id              = $request->id_warrent;
                    $item->item_category_id        = $request->item_category_id[$i];
                    $item->warr_item_code          = $request->item_code[$i];
                    $item->warr_item_nup           = $request->item_nup[$i];
                    $item->warr_item_name          = $request->item_name[$i];
                    $item->warr_item_description   = $request->item_description[$i];
                    $item->warr_item_qty           = $request->item_qty[$i];
                    $item->warr_item_unit          = $request->item_unit[$i];
                    $item->item_condition_id       = $request->item_condition_id[$i];
                    $item->save();
                }

                return redirect('unit-kerja/surat-perintah/daftar/seluruh-surat-perintah')->with('success','Berhasil membuat surat perintah');
            } else {

            }
        }
    }

    /*===============================================================
                            PEMBUATAN SURAT
    ===============================================================*/

    public function showLetter(Request $request, $aksi, $id)
    {
        if ($aksi == 'pengajuan') {
            $item_ctg       = DB::table('tbl_items_category')->get();
            $item_condition = DB::table('tbl_items_condition')->get();

            return view('v_workunit.tambah_surat_pengajuan', compact('id','item_ctg','item_condition'));

        }elseif($aksi == 'tambah-pengajuan'){
            // Buat Surat Pengajuan Penyimpanan
                $appletter = new AppLetterModel();
                $file      = $request->file('upload-spm');
                $filename  = $request->upload_spm->getClientOriginalName();
                $request->upload_spm->move('data_file/surat_permohonan/', $filename);
                $appletter->id_app_letter           = $request->input('id_appletter');
                $appletter->workunit_id             = Auth::user()->workunit_id;
                $appletter->appletter_file          = $filename;
                $appletter->appletter_purpose       = $request->purpose;
                $appletter->appletter_total_item    = $request->input('total_item');
                $appletter->appletter_date          = Carbon::now();
                $appletter->appletter_status        = 'proses';
                $appletter->save();

            if ($id == 'penyimpanan') {
                $idItem  = $request->item_category_id;
                foreach($idItem as $i => $category_id) {
                    $warrEntry    = new AppLetterEntryModel();
                    $warrEntry->id_appletter_entry           = $request->id_appletter_entry[$i];
                    $warrEntry->appletter_id                 = $request->id_appletter;
                    $warrEntry->item_category_id             = $category_id;
                    $warrEntry->appletter_item_name          = $request->appletter_item_name[$i];
                    $warrEntry->appletter_item_description   = $request->appletter_item_type[$i];
                    $warrEntry->appletter_item_qty           = $request->appletter_item_qty[$i];
                    $warrEntry->appletter_item_unit          = $request->appletter_item_unit[$i];
                    $warrEntry->item_condition_id            = $request->item_condition_id[$i];
                    $warrEntry->save();
                }
            } else {
                $idItem  = $request->id_item_code;
                foreach($idItem as $i => $item_code) {
                    $warrExit    = new AppLetterExitModel();
                    $warrExit->id_appletter_exit = 'spk_item_'.rand(1000, 9999);
                    $warrExit->appletter_id      = $request->id_appletter;
                    $warrExit->item_id           = $item_code;
                    $warrExit->item_pick         = $request->item_pick[$i];
                    $warrExit->save();
                }
            }

            return redirect('unit-kerja/surat/detail-surat-pengajuan/'. $request->id_appletter)->with('success','Berhasil membuat surat pengajuan');

        }elseif($aksi == 'detail-surat-pengajuan'){
            $cek        = DB::table('tbl_appletters')->where('id_app_letter', $id)->first();
            $appletter  = DB::table('tbl_appletters')->where('id_app_letter', $id)->first();
            if ($cek->appletter_purpose == 'penyimpanan') {
                $item   = DB::table('tbl_appletters_entry')
                            ->join('tbl_appletters', 'id_app_letter','appletter_id')
                            ->join('tbl_items_category', 'id_item_category','item_category_id')
                            ->join('tbl_items_condition', 'id_item_condition','item_condition_id')
                            ->where('appletter_id', $id)
                            ->get();
            } else {
                $item   = DB::table('tbl_appletters_exit')
                            ->join('tbl_appletters', 'id_app_letter','appletter_id')
                            ->join('tbl_items_incoming', 'id_item_incoming','item_id')
                            ->join('tbl_items_category', 'id_item_category','in_item_category')
                            ->join('tbl_items_condition', 'id_item_condition','in_item_condition')
                            ->where('appletter_id', $id)
                            ->get();
            }
            return view('v_workunit.detail_surat_pengajuan', compact('appletter','item'));

        }elseif($aksi == 'daftar-surat-pengajuan'){
            // Daftar Surat Pengajuan
            $appletter = DB::table('tbl_appletters')
                            ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_appletters.workunit_id')
                            ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                            ->where('workunit_id', Auth::user()->workunit_id)
                            ->get();
            return view('v_workunit.daftar_surat_pengajuan', compact('appletter'));

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

    public function getItem(Request $request, $id)
    {
        if ($id == 'daftar') {
            $result = DB::table('tbl_items_incoming')->join('tbl_orders_data','id_order_data','order_data_id')
                        ->join('tbl_orders','id_order','order_id')
                        ->join('tbl_slots','id_slot','slot_id')
                        ->join('tbl_warehouses','id_warehouse','warehouse_id')
                        ->where('in_item_category', $request->kategori)
                        ->get();
        } else {
            $result = DB::table('tbl_items_incoming')->join('tbl_orders_data','id_order_data','order_data_id')
                        ->join('tbl_orders','id_order','order_id')
                        ->join('tbl_slots','id_slot','slot_id')
                        ->join('tbl_warehouses','id_warehouse','warehouse_id')
                        ->where('id_item_incoming', $request->idItem)
                        ->get();
        }
        return response()->json($result);
    }

}
