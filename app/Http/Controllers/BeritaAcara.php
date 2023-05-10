<?php

namespace App\Http\Controllers;

use App\Model\Bast;
use App\Model\employeeModel;
use App\Model\mainunitModel;
use App\Model\statusModel;
use App\Model\storageDetailModel;
use App\Model\submissionModel;
use App\Model\SubmissionStaff;
use App\Model\workunitModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BeritaAcara extends Controller
{
    // File View

    public function Show($id) {
        $bast  = Bast::where('pengajuan_id', $id)->first();
        $staff = SubmissionStaff::where('pengajuan_id', $id)->first();
        $item  = storageDetailModel::where('pengajuan_id', $id)->join('t_pengajuan_detail', 't_pengajuan_detail.id_detail', 'pengajuan_detail_id')->get();
        return view('Pages/BeritaAcara/show', compact('bast','staff','item'));
    }

    public function Print($id) {
        $bast  = Bast::where('pengajuan_id', $id)->first();
        $staff = SubmissionStaff::where('pengajuan_id', $id)->first();
        $item  = storageDetailModel::where('pengajuan_id', $id)->join('t_pengajuan_detail', 't_pengajuan_detail.id_detail', 'pengajuan_detail_id')->get();

        return view('Pages/BeritaAcara/print', compact('bast','staff','item'));
    }

    public function Barcode($id) {
        dd($id);
    }
}
