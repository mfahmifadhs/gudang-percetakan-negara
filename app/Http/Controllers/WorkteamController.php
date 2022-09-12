<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\AppLetterModel;
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


class WorkteamController extends Controller
{

	public function index()
	{
        $appletter = DB::table('tbl_appletters')
                        ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_appletters.workunit_id')
                        ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                        ->orderBy('appletter_status','ASC')
                        ->get();
		return view('v_workteam.index', compact('appletter'));
	}

    // =====================================
    //              SURAT-SURAT
    // =====================================

    public function showLetter(Request $request, $aksi, $id)
    {
        if ($aksi == 'detail-surat-pengajuan') {
            $appletter  = DB::table('tbl_appletters')->join('tbl_workunits','id_workunit','workunit_id')->first();
            $cek        = DB::table('tbl_appletters')->where('id_app_letter', $id)->first();
            if ($cek->appletter_purpose == 'penyimpanan') {
                $item   = DB::table('tbl_appletters_entry')
                            ->join('tbl_appletters', 'id_app_letter','appletter_id')
                            ->join('tbl_items_category', 'id_item_category','item_category_id')
                            ->join('tbl_items_condition', 'id_item_condition','item_condition_id')
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

            return view('v_workteam.detail_surat_pengajuan', compact('appletter', 'item'));

            // Proses surat pengajuan ditolak
            AppLetterModel::where('id_app_letter', $id)->update(['appletter_status' => 'ditolak']);
            return redirect('tim-kerja/surat/detail-surat-pengajuan/' . $id)->with('failed', 'Surat Pengajuan Ditolak');
        } elseif ($aksi == 'daftar-surat-pengajuan') {
            // Daftar Surat Pengajuan
            $appletter = DB::table('tbl_appletters')
            ->join('tbl_workunits', 'tbl_workunits.id_workunit', 'tbl_appletters.workunit_id')
            ->join('tbl_mainunits', 'tbl_mainunits.id_mainunit', 'tbl_workunits.mainunit_id')
            ->where('workunit_id', Auth::user()->workunit_id)
                ->get();
            return view('v_workunit.daftar_surat_pengajuan', compact('appletter'));
        } elseif ($aksi == 'detail-surat-perintah-penyimpanan') {
            $warrent = WarrentModel::with(['entryitem'])->where('id_warrent', $id)->get();
            return view('v_workunit.detail_surat_perintah', compact('warrent'));
        } elseif ($aksi == 'daftar-surat-perintah') {
            // Daftar Surat Perintah
            $warrent = DB::table('tbl_warrents')->where('workunit_id', Auth::user()->workunit_id)->get();
            return view('v_workunit.daftar_surat_perintah', compact('warrent'));
        } elseif ($aksi == 'validasi-surat-pengajuan') {
            $appletter  = DB::table('tbl_appletters')->where('id_app_letter', $id)->update([
                    'appletter_status' => $request->appletter_status,
                    'appletter_note'   => $request->appletter_note
                ]);

            if ($request->ctg == 'penyimpanan') {
                $idEntry = $request->appletter_id;
                foreach($idEntry as $i => $itemEntry) {
                    DB::table('tbl_appletters_entry')->where('id_appletter_entry', $itemEntry)->update([
                        'appletter_item_status' => $request->appletter_item_status[$i]
                    ]);
                }
            } else {

            }

            return redirect('tim-kerja/dashboard')->with('success', 'Berhasil melakukan validasi surat permohonan');
        }
    }

    // =====================================
    //             DAFTAR BARANG
    // =====================================

    public function showItem(Request $request, $aksi, $id)
    {
        if ($aksi == 'daftar') {
            $item = DB::table('tbl_items_incoming')
                        ->join('tbl_items_condition','id_item_condition','in_item_condition')
                        ->join('tbl_orders_data','id_order_data','order_data_id')
                        ->join('tbl_slots','id_slot','slot_id')
                        ->join('tbl_warehouses','id_warehouse','warehouse_id')
                        ->join('tbl_orders','id_order','order_id')
                        ->join('tbl_workunits','id_workunit','workunit_id')
                        ->get();

            return view('v_workteam.daftar_barang', compact('item'));
        }
    }

}
