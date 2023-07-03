<?php

namespace App\Http\Controllers;

use App\Model\submissionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function Show() {
        if (Auth::user()->role_id == 4) {
            $submission = submissionModel::orderBy('status_pengajuan_id', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->orderBy('status_proses_id', 'ASC')
                ->where('user_id', Auth::user()->id)
                ->get();
        } else {
            $submission = submissionModel::orderBy('status_pengajuan_id', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->orderBy('status_proses_id', 'ASC')
                ->get();
        }

        return view('Pages/dashboard', compact('submission'));
    }

    public function Detail() {

    }

    public function Create() {

    }

    public function Post() {

    }

    public function Edit() {

    }

    public function Update() {

    }

    public function Delete() {

    }
}
