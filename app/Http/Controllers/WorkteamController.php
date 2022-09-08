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
        if($aksi == 'detail-surat-pengajuan'){
            $appletter  = DB::table('tbl_appletters')->first();
            $item       = DB::table('tbl_appletters_detail')
                            ->join('tbl_appletters', 'id_app_letter','appletter_id')
                            ->join('tbl_items_category', 'id_item_category','item_category_id')
                            ->join('tbl_items_condition', 'id_item_condition','item_condition_id')
                            ->get();
            return view('v_workteam.detail_surat_pengajuan', compact('appletter','item'));

        }elseif($aksi == 'pengajuan-diterima'){
            dd($request->all());
            // Proses surat pengajuan diterima
            AppLetterModel::where('id_app_letter', $id)->update([ 'appletter_status' => 'diterima' ]);
            return redirect('tim-kerja/surat/detail-surat-pengajuan/'. $id)->with('success','Surat Pengajuan Diterima');
        }elseif($aksi == 'pengajuan-ditolak'){
            // Proses surat pengajuan ditolak
            AppLetterModel::where('id_app_letter', $id)->update([ 'appletter_status' => 'ditolak' ]);
            return redirect('tim-kerja/surat/detail-surat-pengajuan/'. $id)->with('failed','Surat Pengajuan Ditolak');
        }elseif($aksi == 'daftar-surat-pengajuan'){
            // Daftar Surat Pengajuan
            $appletter = DB::table('tbl_appletters')
                            ->join('tbl_workunits','tbl_workunits.id_workunit','tbl_appletters.workunit_id')
                            ->join('tbl_mainunits','tbl_mainunits.id_mainunit','tbl_workunits.mainunit_id')
                            ->where('workunit_id', Auth::user()->workunit_id)
                            ->get();
            return view('v_workunit.daftar_surat_pengajuan', compact('appletter'));

        }elseif($aksi == 'detail-surat-perintah-penyimpanan'){
            $warrent = WarrentModel::with(['entryitem'])->where('id_warrent', $id)->get();
            return view('v_workunit.detail_surat_perintah', compact('warrent'));
        }elseif($aksi == 'daftar-surat-perintah'){
            // Daftar Surat Perintah
            $warrent = DB::table('tbl_warrents')->where('workunit_id', Auth::user()->workunit_id)->get();
            return view('v_workunit.daftar_surat_perintah', compact('warrent'));
        }
    }

}
