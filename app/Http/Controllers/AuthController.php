<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
use Session;
use DB;

class AuthController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'nip'       => 'required',
            'password'  => 'required',
        ]);
        $credentials = $request->only('nip', 'password');

        if (Auth::attempt($credentials)) {

            $user = User::where('nip', $request->nip)->first();
            if ($user->status_id == 0) {
                return redirect("login")->with('failed', 'Akun tidak aktif');
            }
            return redirect()->intended('dashboard')->with('success', 'Berhasil Masuk !');
        }

        return redirect("login")->with('failed', 'Username atau Password Salah !');
    }



    public function registration()
    {
        return view('registration');
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'full_name' => 'required',
            'nip'  => 'required',
            'password'  => 'required|min:6',
        ]);
        $data = $request->all();
        $check = $this->create($data);
        return redirect("dashboard")->with('Success', 'Berhasil Login !');
    }


    public function create(array $data)
    {
        return User::create([
            'id'        => $data['id'],
            'role_id'   => '3',
            'full_name' => $data['full_name'],
            'nip'  => $data['nip'],
            'password'  => Hash::make($data['password']),
            'status_id' => '1',
        ]);
    }


    public function dashboard()
    {
        return redirect(('dashboard'));
        // if(Auth::check() && Auth::user()->role_id == 1 && Auth::user()->status_id == 1)
        // {
        //     return redirect('admin-master/dashboard');
        // }
        // elseif (Auth::check() && Auth::user()->role_id == 2 && Auth::user()->status_id == 1)
        // {
        //     return redirect('tim-kerja/dashboard');
        // }
        // elseif (Auth::check() && Auth::user()->role_id == 3 && Auth::user()->status_id == 1)
        // {
        //     return redirect('unit-kerja/dashboard');
        // }
        // elseif (Auth::check() && Auth::user()->role_id == 4 && Auth::user()->status_id == 1)
        // {
        //     return redirect('petugas/dashboard');
        // }
        // else{
        //     return redirect("login")->with('failed', 'Anda tidak memiliki akses!');
        // }
    }


    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
