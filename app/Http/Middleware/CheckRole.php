<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if(Auth::user() == null){
            return redirect('/')->with('failed','Anda tidak memiliki akses!');
        } elseif ($role == 'admin-master' && auth()->user()->role_id != 1) {
            abort(403);
        } elseif ($role == 'admin-user' && auth()->user()->role_id != 2) {
            abort(403);
        } elseif ($role == 'unit-kerja' && auth()->user()->role_id != 3) {
            abort(403);
        } elseif ($role == 'petugas' && auth()->user()->role_id != 4) {
            abort(403);
        }

        return $next($request);
    }
}
