<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\AppLetterModel;
use App\Models\AppLetterDetailModel;
use App\Models\WarrentModel;
use App\Models\WarrentItemModel;
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

    /*===============================================================
                            PEMBUATAN SURAT
    ===============================================================*/

    public function showLetter(Request $request, $aksi, $id)
    {
        if ($aksi == 'pengajuan' && $id == 'penyimpanan') {
            // Buat surat pengajuan
            $item_ctg       = DB::table('tbl_items_category')->get();
            $item_condition = DB::table('tbl_items_condition')->get();
            return view('v_workunit.tambah_surat_pengajuan_penyimpanan', compact('item_ctg','item_condition'));

        }elseif($aksi == 'tambah-pengajuan' && $id == 'penyimpanan'){
            // Buat Surat Pengajuan Penyimpanan
            $appletter = new AppLetterModel();
            $file      = $request->file('upload-spm');
            $filename  = $request->upload_spm->getClientOriginalName();
            $request->upload_spm->move('data_file/surat_permohonan/', $filename);
            $appletter->id_app_letter           = $request->input('id_appletter');
            $appletter->workunit_id             = Auth::user()->workunit_id;
            $appletter->appletter_file          = $filename;
            $appletter->appletter_purpose       = 'penyimpanan';
            $appletter->appletter_total_item    = $request->input('total_item');
            $appletter->appletter_date          = Carbon::now();
            $appletter->appletter_status        = 'proses';
            $appletter->save();

            $item   = new AppLetterDetailModel();
            $idItem = $request->id_appletter_detail;
            foreach($idItem as $i => $detail) {
                $item->id_appletter_detail          = $detail;
                $item->appletter_id                 = $request->id_appletter;
                $item->item_category_id             = $request->item_category_id[$i];
                $item->appletter_item_name          = $request->appletter_item_name[$i];
                $item->appletter_item_description   = $request->appletter_item_type[$i];
                $item->appletter_item_qty           = $request->appletter_item_qty[$i];
                $item->appletter_item_unit          = $request->appletter_item_unit[$i];
                $item->item_condition_id            = $request->item_condition_id[$i];
                $item->save();
            }

            return redirect('unit-kerja/surat/detail-surat-pengajuan/'. $request->id_appletter)->with('success','Berhasil membuat surat pengajuan');

        }elseif($aksi == 'detail-surat-pengajuan'){
            $appletter  = DB::table('tbl_appletters')->first();
            $item       = DB::table('tbl_appletters_detail')
                            ->join('tbl_appletters', 'id_app_letter','appletter_id')
                            ->join('tbl_items_category', 'id_item_category','item_category_id')
                            ->join('tbl_items_condition', 'id_item_condition','item_condition_id')
                            ->get();
            return view('v_workunit.detail_surat_pengajuan', compact('appletter','item'));

        }elseif($aksi == 'daftar-surat-pengajuan'){
            // Daftar Surat Pengajuan
            $appletter = DB::table('tbl_appletters')
                            ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_appletters.workunit_id')
                            ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                            ->where('workunit_id', Auth::user()->workunit_id)
                            ->get();
            return view('v_workunit.daftar_surat_pengajuan', compact('appletter'));

        }elseif($aksi == 'perintah-penyimpanan'){
            // Tambah surat perintah penyimpanan
            $appletter = DB::table('tbl_warrents_items')
                            ->join('tbl_appletters','tbl_appletters.id_app_letter','tbl_warrents_items.appletter_entry_id')
                            ->where('appletter_entry_id', $id)
                            ->first();

            $item      = DB::table('tbl_warrents_items')->where('appletter_entry_id', $id)->get();
            return view('v_workunit.tambah_surat_perintah', compact('item','appletter'));

        }elseif($aksi == 'perintah-pengeluaran'){
            // Tambah surat perintah pengeluaran
            $item = DB::table('tbl_warrents_items')->where('appletter_exit_id', $id)->get();
            return view('v_workunit.tambah_surat_perintah', compact('item'));

        }elseif($aksi == 'tambah-surat-perintah'){
            // Proses surat perintah penyimpanan barang
            if($request->appletter_exit_id == null){
                $category = 'penyimpanan';
            }else{
                $category = 'pengeluaran';
            }

            $warrent = new WarrentModel();
            $warrent->id_warrent        = $request->input('id_warrent');
            $warrent->warr_num          = strtolower($request->input('warr_num'));
            $warrent->workunit_id       = Auth::user()->workunit_id;
            $warrent->warr_name         = strtolower($request->input('warr_name'));
            $warrent->warr_position     = strtolower($request->input('warr_position'));
            $warrent->warr_category     = 'penyimpanan';
            $warrent->warr_status       = 'diproses';
            $warrent->warr_total_item   = $request->input('total_item');
            $warrent->warr_dt           = $request->input('warr_dt');
            $warrent->warr_tm           = Carbon::now();
            $warrent->save();

            WarrentItemModel::where('appletter_entry_id', $request->appletter_entry_id)->update([ 'warrent_entry_id' => $request->id_warrent ]);

            return redirect('unit-kerja/surat/detail-surat-perintah-penyimpanan/'. $request->id_warrent)->with('success','Berhasil membuat surat perintah penyimpanan barang');


        }elseif($aksi == 'detail-surat-perintah-penyimpanan'){
            $warrent = WarrentModel::with(['entryitem'])->where('id_warrent', $id)->get();
            return view('v_workunit.detail_surat_perintah', compact('warrent'));
        }elseif($aksi == 'daftar-surat-perintah'){
            // Daftar Surat Perintah
            $warrent = DB::table('tbl_warrents')->where('workunit_id', Auth::user()->workunit_id)->get();
            return view('v_workunit.daftar_surat_perintah', compact('warrent'));
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
