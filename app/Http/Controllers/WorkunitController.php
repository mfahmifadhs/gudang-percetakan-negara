<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\AppLetterModel;
use App\Models\AppLetterEntryModel;
use App\Models\AppLetterExitModel;
use App\Models\ItemCategoryModel;
use App\Models\ItemConditionModel;
use App\Models\WarrentModel;
use App\Models\WarrentEntryModel;
use App\Models\WarrentExitModel;
use App\Models\ScreeningModel;
use App\Models\Warrent;
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
        $items = DB::table('tbl_items')
            ->join('tbl_orders', 'id_order', 'order_id')
            ->where('workunit_id', Auth::user()->workunit_id)
            ->get();

        $appletter  = DB::table('tbl_appletters')
            ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_appletters.workunit_id')
            ->join('tbl_mainunits', 'tbl_mainunits.id_mainunit', 'tbl_workunits.mainunit_id')
            ->orderBy('appletter_status', 'ASC')
            ->orderBy('appletter_date', 'DESC')
            ->where('workunit_id', Auth::user()->workunit_id)
            ->where('appletter_process', 'false')
            ->get();

        return view('v_workunit.index', compact('items', 'appletter'));
    }

    // =====================================
    //             SURAT PERINTAH
    // =====================================

    public function showWarrent(Request $request, $aksi, $id)
    {
        if ($aksi == 'daftar') {
            $warrent  = DB::table('tbl_warrents')
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->where('workunit_id', Auth::user()->workunit_id)
                ->orderBy('warr_date', 'DESC')
                ->get();

            return view('v_workunit.daftar_surat_perintah', compact('warrent'));
        } elseif ($aksi == 'detail') {
            $warrent    = DB::table('tbl_warrents')
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->join('tbl_mainunits', 'id_mainunit', 'mainunit_id')
                ->where('id_warrent', $id)
                ->first();
            if ($warrent->warr_purpose == 'penyimpanan') {
                $item   = DB::table('tbl_warrents_entry')
                    ->join('tbl_warrents', 'id_warrent', 'tbl_warrents_entry.warrent_id')
                    ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->where('tbl_warrents.id_warrent', $id)
                    ->get();
            } else {
                $item   = DB::table('tbl_warrents_exit')
                    ->join('tbl_warrents', 'id_warrent', 'warrent_id')
                    ->join('tbl_items', 'id_item', 'item_id')
                    ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->where('id_warrent', $id)
                    ->get();
            }
            return view('v_workunit.detail_surat_perintah', compact('warrent', 'item'));
        } elseif ($aksi == 'konfirmasi') {
            $warrent    = DB::table('tbl_warrents')
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->join('tbl_mainunits', 'id_mainunit', 'mainunit_id')
                ->where('id_warrent', $id)
                ->first();
            if ($warrent->warr_purpose == 'penyimpanan') {
                $item   = DB::table('tbl_items_screening')
                    ->join('tbl_warrents_entry', 'tbl_warrents_entry.id_warr_entry', 'tbl_items_screening.item_id')
                    ->join('tbl_warrents', 'id_warrent', 'tbl_warrents_entry.warrent_id')
                    ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->where('tbl_warrents.id_warrent', $id)
                    ->get();
            } else {
                $item   = DB::table('tbl_items_screening')
                    ->join('tbl_warrents', 'tbl_warrents.id_warrent', 'tbl_items_screening.warrent_id')
                    ->join('tbl_items', 'id_item', 'tbl_items_screening.item_id')
                    ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->where('tbl_warrents.id_warrent', $id)
                    ->get();
            }
            return view('v_workunit.detail_surat_perintah', compact('warrent', 'item'));
        } elseif ($aksi == 'penyimpanan') {
            $appletter  = DB::table('tbl_appletters')->join('tbl_workunits', 'id_workunit', 'workunit_id')->where('id_app_letter', $id)->first();
            $item       = DB::table('tbl_appletters_entry')->select(
                'tbl_items_category.*',
                'tbl_items_condition.*',
                'appletter_item_nup as item_nup',
                'appletter_item_name as item_name',
                'appletter_item_merktype as item_merktype',
                'appletter_item_exp as item_exp',
                'appletter_item_description as item_description',
                'appletter_item_qty as item_qty',
                'appletter_item_unit as item_unit',
                'item_category_id as item_category',
                'item_condition_id as item_condition',
            )
                ->join('tbl_appletters', 'id_app_letter', 'appletter_id')
                ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->where('appletter_id', $id)
                ->get();

            return view('v_workunit.tambah_surat_perintah', compact('aksi', 'appletter', 'item'));
        } elseif ($aksi == 'pengeluaran') {
            $appletter  = DB::table('tbl_appletters')->join('tbl_workunits', 'id_workunit', 'workunit_id')->first();
            $item       = DB::table('tbl_appletters_exit')->select(
                'tbl_items_category.*',
                'tbl_items_condition.*',
                'item_name as item_name',
                'item_merktype as item_merktype',
                'item_description as item_description',
                'item_pick as item_qty',
                'item_unit as item_unit',
                'item_id',
                'slot_id',
                'item_pick'
            )
                ->join('tbl_appletters', 'id_app_letter', 'appletter_id')
                ->join('tbl_items', 'id_item', 'item_id')
                ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->where('appletter_id', $id)
                ->get();

            return view('v_workunit.tambah_surat_perintah', compact('aksi', 'appletter', 'item'));
        } elseif ($aksi == 'proses') {
            if ($id == 'penyimpanan') {
                // Buat Surat Perintah Penyimpanan
                if ($request->upload_warr != null) {
                    $filename  = $request->upload_warr->getClientOriginalName();
                    $request->upload_warr->move('data_file/surat_perintah/', $filename);
                } else {
                    $filename = null;
                }

                $warrent   = new WarrentModel();
                $file      = $request->file('upload_warr');
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
                $idWarrEntry = $request->id_warr_entry;
                foreach ($idWarrEntry as $i => $warrEntry) {
                    $item        = new WarrentEntryModel();
                    $item->id_warr_entry           = $warrEntry;
                    $item->warrent_id              = $request->id_warrent;
                    $item->item_category_id        = $request->item_category_id[$i];
                    $item->warr_item_nup           = $request->item_nup[$i];
                    $item->warr_item_name          = $request->item_name[$i];
                    $item->warr_item_merktype      = $request->item_merktype[$i];
                    $item->warr_item_exp           = $request->item_exp[$i];
                    $item->warr_item_description   = $request->item_description[$i];
                    $item->warr_item_qty           = $request->item_qty[$i];
                    $item->warr_item_unit          = $request->item_unit[$i];
                    $item->item_condition_id       = $request->item_condition_id[$i];
                    $item->save();
                }
            } else {
                if ($request->upload_warr != null) {
                    $filename  = $request->upload_warr->getClientOriginalName();
                    $request->upload_warr->move('data_file/surat_perintah/', $filename);
                } else {
                    $filename = null;
                }
                // Buat Surat Perintah Pengeluaran
                $warrent   = new WarrentModel();
                $warrent->id_warrent         = $request->input('id_warrent');
                $warrent->appletter_id       = $request->input('appletter_id');
                $warrent->workunit_id        = Auth::user()->workunit_id;
                $warrent->warr_emp_name      = $request->input('warr_emp_name');
                $warrent->warr_emp_position  = $request->input('warr_emp_position');
                $warrent->warr_file          = $filename;
                $warrent->warr_purpose       = 'pengeluaran';
                $warrent->warr_total_item    = $request->input('total_item');
                $warrent->warr_date          = Carbon::now();
                $warrent->warr_status        = 'proses';
                $warrent->save();
                // Buat Surat Perintah Pengeluaran Barang
                $idWarrExit = $request->id_warr_exit;
                foreach ($idWarrExit as $i => $warrExit) {
                    $item                 = new WarrentExitModel();
                    $item->id_warr_exit   = $warrExit;
                    $item->warrent_id     = $request->id_warrent;
                    $item->item_id        = $request->item_id[$i];
                    $item->slot_id        = $request->slot_id[$i];
                    $item->warr_item_pick = $request->item_pick[$i];
                    $item->save();
                }
            }

            AppLetterModel::where('id_app_letter', $request->input('appletter_id'))->update([
                'appletter_process' => 'true'
            ]);

            return redirect('unit-kerja/surat-perintah/daftar/seluruh-surat-perintah')->with('success', 'Berhasil membuat surat perintah');
        } elseif ($aksi == 'konfirmasi-penapisan') {
            // Upadate status surat perintah
            WarrentModel::where('id_warrent', $id)->update(['warr_status' => 'proses barang']);

            // Update screening
            $idScreening = $request->id_screening;
            foreach ($idScreening as $i => $screening_id) {
                ScreeningModel::where('id_item_screening', $screening_id)
                    ->update([
                        'approve_workunit'          => $request->approve_workunit[$i],
                        'screening_notes_workunit'  => $request->screening_notes_workunit[$i]
                    ]);
            }

            return redirect('unit-kerja/surat-perintah/daftar/semua')->with('success', 'Berhasil mengkonfirmasi penapisan barang');
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

            return view('v_workunit.tambah_surat_pengajuan', compact('id', 'item_ctg', 'item_condition'));
        } elseif ($aksi == 'tambah-pengajuan') {
            // Buat Surat Pengajuan Penyimpanan
            if ($request->upload_spm != null) {
                $filename  = $request->upload_spm->getClientOriginalName();
                $request->upload_spm->move('data_file/surat_permohonan/', $filename);
            } elseif ($request->upload_warr != null) {
                $filename  = $request->upload_warr->getClientOriginalName();
                $request->upload_warr->move('data_file/surat_perintah/', $filename);
            } else {
                $filename = null;
            }

            if ($id == 'penyimpanan') {
                $dataArray['id_appletter']   = $request->id_appletter;
                $dataArray['purpose']        = $request->purpose;
                $dataArray['appletter_file'] = $filename;
                $dataArray['total_item']     = count($request->item_category_id);
                $letter[] = $dataArray;
                unset($dataArray);

                foreach ($request->item_category_id as $i => $itemcategoyid) {
                    $dataArray['item_category']           = $itemcategoyid;
                    $dataArray['appletter_item_name']        = $request->appletter_item_name[$i];
                    $dataArray['appletter_item_merktype']    = $request->appletter_item_merktype[$i];
                    $dataArray['appletter_item_qty']         = $request->appletter_item_qty[$i];
                    $dataArray['appletter_item_unit']        = $request->appletter_item_unit[$i];
                    $dataArray['appletter_item_description'] = $request->appletter_item_description[$i];
                    $dataArray['item_condition']          = $request->item_condition_id[$i];
                    $item[] = $dataArray;
                    unset($dataArray);
                }

                return view('v_workunit.preview_penyimpanan', compact('letter','item', 'id'));

            } elseif ($id == 'update-surat') {
                AppLetterModel::where('id_app_letter', $request->id_appletter)->update([
                    'appletter_file' => $filename
                ]);
                return redirect('unit-kerja/surat/detail-surat-pengajuan/' . $request->id_appletter)->with('success', 'Berhasil mengupload surat pengajuan');

            } elseif ($id == 'update-surat-perintah') {
                Warrent::where('id_warrent', $request->id_warrent)->update([
                    'warr_file' => $filename
                ]);
                return redirect('unit-kerja/surat-perintah/detail/' . $request->id_warrent)->with('success', 'Berhasil mengupload surat perintah');

            } else {
                if ($id == 'proses-simpan' && $request->filename != null) {
                    $filename = $request->filename;
                }
                $appletter = new AppLetterModel();
                $file      = $request->file('upload-spm');
                $appletter->id_app_letter           = $request->input('id_appletter');
                $appletter->workunit_id             = Auth::user()->workunit_id;
                $appletter->appletter_file          = $filename;
                $appletter->appletter_purpose       = $request->purpose;
                $appletter->appletter_total_item    = Count($request->id_item_code);
                $appletter->appletter_date          = Carbon::now();
                $appletter->appletter_status        = 'proses';
                $appletter->appletter_process       = 'false';
                $appletter->save();

                if ($id == 'proses-simpan') {
                    $idItem  = $request->id_item_code;
                    foreach ($idItem as $i => $category_id) {
                        $itemCtg = ItemCategoryModel::where('item_category_name', $category_id)->first();
                        $itemCondition = ItemConditionModel::where('item_condition_name', $request->item_condition_id[$i])->first();
                        $warrEntry    = new AppLetterEntryModel();
                        $warrEntry->id_appletter_entry           = 'spm_item_' . rand(1000, 9999) . $i;
                        $warrEntry->appletter_id                 = $request->id_appletter;
                        $warrEntry->item_category_id             = $itemCtg->id_item_category;
                        $warrEntry->appletter_item_name          = $request->appletter_item_name[$i];
                        $warrEntry->appletter_item_merktype      = $request->appletter_item_merktype[$i];
                        $warrEntry->appletter_item_nup           = $request->appletter_item_nup[$i];
                        $warrEntry->appletter_item_exp           = $request->appletter_item_exp[$i];
                        $warrEntry->appletter_item_qty           = $request->appletter_item_qty[$i];
                        $warrEntry->appletter_item_unit          = strtoupper($request->appletter_item_unit[$i]);
                        $warrEntry->appletter_item_description   = $request->appletter_item_description[$i];
                        $warrEntry->item_condition_id            = $itemCondition->id_item_condition;
                        $warrEntry->save();
                    }
                } else {
                    $idItem  = $request->id_item_code;
                    foreach ($idItem as $i => $item_code) {
                        $warrExit    = new AppLetterExitModel();
                        $warrExit->id_appletter_exit = 'spk_item_' . rand(1000, 9999) . $i;
                        $warrExit->appletter_id      = $request->id_appletter;
                        $warrExit->item_id           = $item_code;
                        $warrExit->slot_id           = $request->id_order_data[$i];
                        $warrExit->item_pick         = $request->item_pick[$i];
                        $warrExit->save();
                    }
                }

                return redirect('unit-kerja/surat/detail-surat-pengajuan/' . $request->id_appletter)->with('success', 'Berhasil membuat surat pengajuan');
            }

        } elseif ($aksi == 'detail-surat-pengajuan') {
            $bast = DB::table('tbl_warrents')
                ->join('tbl_appletters', 'id_app_letter', 'appletter_id')
                ->where('warr_status','selesai')
                ->where('id_app_letter', $id)
                ->count();

            $cek        = DB::table('tbl_appletters')->where('id_app_letter', $id)->first();
            $appletter  = DB::table('tbl_appletters')->where('id_app_letter', $id)->first();
            if ($cek->appletter_purpose == 'penyimpanan') {
                $item   = DB::table('tbl_appletters_entry')
                    ->join('tbl_appletters', 'id_app_letter', 'appletter_id')
                    ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->where('appletter_id', $id)
                    ->get();
            } else {
                $item   = DB::table('tbl_appletters_exit')
                    ->join('tbl_appletters', 'id_app_letter', 'appletter_id')
                    ->join('tbl_items', 'id_item', 'item_id')
                    ->join('tbl_items_category', 'id_item_category', 'item_category_id')
                    ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                    ->join('tbl_slots', 'id_slot', 'slot_id')
                    ->join('tbl_warehouses', 'id_warehouse', 'warehouse_id')
                    ->where('appletter_id', $id)
                    ->get();
            }
            return view('v_workunit.detail_surat_pengajuan', compact('bast','appletter', 'item'));
        } elseif ($aksi == 'daftar-surat-pengajuan') {
            // Daftar Surat Pengajuan
            $appletter = DB::table('tbl_appletters')
                ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_appletters.workunit_id')
                ->join('tbl_mainunits', 'tbl_mainunits.id_mainunit', 'tbl_workunits.mainunit_id')
                ->where('workunit_id', Auth::user()->workunit_id)
                ->orderBy('appletter_date', 'DESC')
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
            ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
            ->orderby('status_id', 'ASC')
            ->get();
        $model      = DB::table('tbl_warehouses')
            ->select('warehouse_category', DB::raw('count(id_warehouse) as totalwarehouse'))
            ->groupBy('warehouse_category')
            ->get();

        return view('v_workunit.show_warehouse', compact('warehouse', 'model'));
    }

    public function detailWarehouse(Request $request, $id)
    {
        $warehouse      = DB::table('tbl_warehouses')
            ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
            ->where('id_warehouse', $id)
            ->get();
        $slot             = DB::table('tbl_slots')
            ->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
            ->where('id_warehouse', $id)
            ->get();
        $warehouse09b   = DB::table('tbl_warehouses')
            ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
            ->where('id_warehouse', 'G09B')
            ->get();

        $warehouse05b   = DB::table('tbl_warehouses')
            ->join('tbl_status', 'tbl_status.id_status', 'tbl_warehouses.status_id')
            ->where('id_warehouse', 'G05B')
            ->get();
        $pallet         = DB::table('tbl_slots_names')
            ->join('tbl_slots', 'tbl_slots.id_slot', 'tbl_slots_names.pallet_id')
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

        return view(
            'v_workunit.detail_warehouse',
            compact(
                'warehouse',
                'slot',
                'warehouse09b',
                'warehouse05b',
                'pallet',
                'rack_pallet_one_lvl1',
                'rack_pallet_one_lvl2',
                'rack_pallet_two_lvl1',
                'rack_pallet_two_lvl2',
                'rack_pallet_three_lvl1',
                'rack_pallet_three_lvl2',
                'rack_pallet_four_lvl1',
                'rack_pallet_four_lvl2',
            )
        );
    }

    public function detailSlot($id)
    {
        $slot   = DB::table('tbl_slots')
            ->join('tbl_warehouses', 'tbl_warehouses.id_warehouse', 'tbl_slots.warehouse_id')
            ->where('id_slot', $id)
            ->get();
        return view('v_workunit.detail_slot', compact('slot'));
    }

    // =================================
    // 	            JSON
    // =================================

    public function showJson($aksi)
    {
        if ($aksi == 'more-pallet') {
            $category     = DB::table('tbl_items_category')->get();
            $array['category']     = $category;

            return response()->json($array);
        }
    }

    // =====================================
    //             DAFTAR BARANG
    // =====================================

    public function showItem(Request $request, $aksi, $id)
    {
        if ($aksi == 'daftar') {
            $item = DB::table('tbl_items')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->join('tbl_orders', 'id_order', 'order_id')
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->where('workunit_id', Auth::user()->workunit_id)
                ->get();

            return view('v_workunit.daftar_barang', compact('item'));
        } elseif ($aksi == 'detail') {
            $item = DB::table('tbl_items')
                ->join('tbl_items_condition', 'id_item_condition', 'item_condition_id')
                ->join('tbl_orders', 'id_order', 'order_id')
                ->join('tbl_workunits', 'id_workunit', 'workunit_id')
                ->where('id_item', $id)
                ->first();

            return view('v_workunit.detail_barang', compact('item'));
        }
    }


    public function getItem(Request $request, $id)
    {
        if ($id == 'daftar') {
            $result = DB::table('tbl_items')
                ->join('tbl_orders', 'id_order', 'order_id')
                ->where('item_category_id', $request->kategori)
                ->where('workunit_id', Auth::user()->workunit_id)
                ->where('item_qty', '!=', 0)
                ->orderBy('item_name','ASC')
                ->get();
        } elseif ($id == 'penyimpanan') {
            if ($request->data == ['']) {
                $slot = [];
            } else {
                foreach ($request->data as $data) {
                    if ($data != null) {
                        $slot[] = $data;
                    }
                }
            }

            $result = DB::table('tbl_orders_data')
                ->where('item_id', $request->idItem)
                ->orderBy('slot_id','ASC')
	            ->whereNotIn('slot_id', $slot)
                ->get();
        } else {
            $result = DB::table('tbl_orders_data')
                ->join('tbl_items', 'id_item', 'item_id')
                ->join('tbl_orders', 'id_order', 'tbl_items.order_id')
                ->join('tbl_slots', 'id_slot', 'slot_id')
                ->join('tbl_warehouses', 'id_warehouse', 'warehouse_id')
                ->where('slot_id', $request->idWarehouse)
                ->where('id_item', $request->idItem)
                ->get();
        }
        return response()->json($result);
    }
}
